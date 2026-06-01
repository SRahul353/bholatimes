<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EPaper extends Model
{
    protected $table = 'epapers';

    protected $fillable = [
        'title',
        'publish_date',
        'page_number',
        'image',
        'layout_data',
        'pages_data',
        'total_pages',
    ];

    protected $casts = [
        'publish_date' => 'date',
        'layout_data' => 'array',
        'pages_data' => 'array',
    ];

    /**
     * Get layout data for a specific page.
     */
    public function getPageLayout(int $pageNumber): array
    {
        $data = $this->pages_data ?? [];
        return $data[(string)$pageNumber] ?? [];
    }

    /**
     * Set layout data for a specific page.
     */
    public function setPageLayout(int $pageNumber, array $grid): void
    {
        $data = $this->pages_data ?? [];
        $data[(string)$pageNumber] = $grid;
        $this->pages_data = $data;
    }

}
