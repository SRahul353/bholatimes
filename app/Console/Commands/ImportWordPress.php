<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;

class ImportWordPress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wp:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import posts, categories, tags, and users from the wordpress database connection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Starting WordPress data migration...");

        // Disable query log to prevent memory leaks
        DB::connection()->disableQueryLog();
        DB::connection('wordpress')->disableQueryLog();

        // Clean target tables for a completely fresh import
        $this->info("Cleaning up Laravel target tables for a fresh, warning-free import...");
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('category_post')->truncate();
        DB::table('post_tag')->truncate();
        DB::table('posts')->truncate();
        Category::truncate();
        Tag::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Users Migration
        $this->importUsers();

        // 2. Categories Migration
        $this->importCategories();

        // 3. Tags Migration
        $this->importTags();

        // 4. Posts & Pivot Migration
        $this->importPosts();

        $this->newLine();
        $this->info("Congratulations! WordPress data migration completed successfully.");
        return Command::SUCCESS;
    }

    /**
     * Migrate WordPress Users
     */
    protected function importUsers()
    {
        $this->info("Migrating users...");

        try {
            $wpUsers = DB::connection('wordpress')->table('users')->get();
        } catch (\Exception $e) {
            $this->error("Failed to query wordpress 'users' table. Check if 'wp_load-sql' was run. Error: " . $e->getMessage());
            return;
        }

        $bar = $this->output->createProgressBar($wpUsers->count());
        $bar->start();

        foreach ($wpUsers as $wpUser) {
            // Check if email already exists in Laravel users
            $email = !empty($wpUser->user_email) ? $wpUser->user_email : $wpUser->user_login . '@example.com';
            
            // Protect admin password from being overwritten with WP phpass hash
            $password = $wpUser->user_pass;
            if ($email === 'admin@bholatimes24.com') {
                $password = \Illuminate\Support\Facades\Hash::make('admin123');
            }
            
            DB::table('users')->updateOrInsert(
                ['id' => $wpUser->ID],
                [
                    'name' => $wpUser->display_name ?: $wpUser->user_login,
                    'email' => $email,
                    'email_verified_at' => now(),
                    'password' => $password, // Protected hash
                    'created_at' => $wpUser->user_registered,
                    'updated_at' => $wpUser->user_registered,
                ]
            );
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Users migrated: " . $wpUsers->count());
    }

    /**
     * Migrate WordPress Categories
     */
    protected function importCategories()
    {
        $this->info("Migrating categories...");

        try {
            $wpCategories = DB::connection('wordpress')->table('terms')
                ->join('term_taxonomy', 'terms.term_id', '=', 'term_taxonomy.term_id')
                ->where('term_taxonomy.taxonomy', 'category')
                ->select('terms.term_id', 'terms.name', 'terms.slug', 'term_taxonomy.description')
                ->get();
        } catch (\Exception $e) {
            $this->error("Failed to query wordpress categories. Error: " . $e->getMessage());
            return;
        }

        $bar = $this->output->createProgressBar($wpCategories->count());
        $bar->start();

        foreach ($wpCategories as $wpCat) {
            // Standardize slug
            $slug = $wpCat->slug ?: Str::slug($wpCat->name);
            if (empty($slug)) {
                $slug = 'category-' . $wpCat->term_id;
            }

            // Uniqueness check for category slugs to prevent unique constraint failures
            $existing = DB::table('categories')->where('slug', $slug)->where('id', '!=', $wpCat->term_id)->exists();
            if ($existing) {
                $slug = $slug . '-' . $wpCat->term_id;
            }

            Category::updateOrCreate(
                ['id' => $wpCat->term_id],
                [
                    'name' => $wpCat->name,
                    'slug' => $slug,
                    'description' => $wpCat->description ?: null,
                ]
            );
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Categories migrated: " . $wpCategories->count());
    }

    /**
     * Migrate WordPress Tags
     */
    protected function importTags()
    {
        $this->info("Migrating tags...");

        try {
            $wpTags = DB::connection('wordpress')->table('terms')
                ->join('term_taxonomy', 'terms.term_id', '=', 'term_taxonomy.term_id')
                ->where('term_taxonomy.taxonomy', 'post_tag')
                ->select('terms.term_id', 'terms.name', 'terms.slug')
                ->get();
        } catch (\Exception $e) {
            $this->error("Failed to query wordpress tags. Error: " . $e->getMessage());
            return;
        }

        $bar = $this->output->createProgressBar($wpTags->count());
        $bar->start();

        foreach ($wpTags as $wpTag) {
            $slug = $wpTag->slug ?: Str::slug($wpTag->name);
            if (empty($slug)) {
                $slug = 'tag-' . $wpTag->term_id;
            }

            // Uniqueness check for tag slugs to prevent unique constraint failures
            $existing = DB::table('tags')->where('slug', $slug)->where('id', '!=', $wpTag->term_id)->exists();
            if ($existing) {
                $slug = $slug . '-' . $wpTag->term_id;
            }

            Tag::updateOrCreate(
                ['id' => $wpTag->term_id],
                [
                    'name' => $wpTag->name,
                    'slug' => $slug,
                ]
            );
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Tags migrated: " . $wpTags->count());
    }

    /**
     * Migrate WordPress Posts and relationships
     */
    protected function importPosts()
    {
        $this->info("Migrating posts (this might take a while)...");

        try {
            $wpPosts = DB::connection('wordpress')->table('posts')
                ->where('post_type', 'post')
                ->where('post_status', 'publish')
                ->get();
        } catch (\Exception $e) {
            $this->error("Failed to query wordpress posts. Error: " . $e->getMessage());
            return;
        }

        $bar = $this->output->createProgressBar($wpPosts->count());
        $bar->start();

        $postCount = 0;
        foreach ($wpPosts as $wpPost) {
            // 1. Resolve featured image url
            $featuredImage = $this->getFeaturedImage($wpPost->ID);

            // 2. Clear out any potential slug duplicate issues
            $slug = $wpPost->post_name ?: Str::slug($wpPost->post_title);
            if (empty($slug)) {
                $slug = 'post-' . $wpPost->ID;
            }
            
            // Check slug uniqueness
            $existing = DB::table('posts')->where('slug', $slug)->where('id', '!=', $wpPost->ID)->exists();
            if ($existing) {
                $slug = $slug . '-' . $wpPost->ID;
            }

            // 3. Create or update the post
            $post = Post::updateOrCreate(
                ['id' => $wpPost->ID],
                [
                    'title' => $wpPost->post_title ?: 'Untitled',
                    'slug' => $slug,
                    'content' => $wpPost->post_content ?: '',
                    'excerpt' => $wpPost->post_excerpt ?: null,
                    'featured_image' => $featuredImage,
                    'status' => 'publish',
                    'views_count' => 0, // WP doesn't track this by default unless using a plugin, default to 0
                    'user_id' => $wpPost->post_author ?: null,
                    'created_at' => $wpPost->post_date,
                    'updated_at' => $wpPost->post_modified,
                ]
            );

            // 4. Map relationships (Categories & Tags)
            $this->syncRelationships($wpPost->ID, $post);

            $postCount++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Posts migrated successfully: " . $postCount);
    }

    /**
     * Resolve the featured image for a given post ID
     */
    protected function getFeaturedImage($postId)
    {
        // WordPress stores featured image as the ID of the attachment in postmeta with key '_thumbnail_id'
        $meta = DB::connection('wordpress')->table('postmeta')
            ->where('post_id', $postId)
            ->where('meta_key', '_thumbnail_id')
            ->first();

        if (!$meta) {
            return null;
        }

        $thumbnailId = $meta->meta_value;

        // Query the attachment post
        $attachment = DB::connection('wordpress')->table('posts')
            ->where('ID', $thumbnailId)
            ->where('post_type', 'attachment')
            ->first();

        if (!$attachment) {
            return null;
        }

        // Clean domain and make it root-relative
        // e.g. "https://www.bholatimes24.com/wp-content/uploads/2023/10/img.jpg" -> "/wp-content/uploads/2023/10/img.jpg"
        $path = $attachment->guid;
        $path = preg_replace('/https?:\/\/[^\/]+/', '', $path);
        
        // Ensure it starts with a slash
        if ($path && !str_starts_with($path, '/')) {
            $path = '/' . $path;
        }

        return $path;
    }

    /**
     * Sync categories and tags for the imported post
     */
    protected function syncRelationships($wpPostId, Post $post)
    {
        // In WP, relationships are stored in term_relationships matching object_id to term_taxonomy_id
        $relationships = DB::connection('wordpress')->table('term_relationships')
            ->join('term_taxonomy', 'term_relationships.term_taxonomy_id', '=', 'term_taxonomy.term_taxonomy_id')
            ->where('term_relationships.object_id', $wpPostId)
            ->select('term_taxonomy.term_id', 'term_taxonomy.taxonomy')
            ->get();

        $categoryIds = [];
        $tagIds = [];

        foreach ($relationships as $rel) {
            if ($rel->taxonomy === 'category') {
                $categoryIds[] = $rel->term_id;
            } elseif ($rel->taxonomy === 'post_tag') {
                $tagIds[] = $rel->term_id;
            }
        }

        // Sync in Laravel, filtering to ensure IDs actually exist in Laravel database to prevent foreign key errors
        if (!empty($categoryIds)) {
            $existingCatIds = Category::whereIn('id', $categoryIds)->pluck('id')->toArray();
            $post->categories()->sync($existingCatIds);
        } else {
            $post->categories()->detach();
        }

        if (!empty($tagIds)) {
            $existingTagIds = Tag::whereIn('id', $tagIds)->pluck('id')->toArray();
            $post->tags()->sync($existingTagIds);
        } else {
            $post->tags()->detach();
        }
    }
}
