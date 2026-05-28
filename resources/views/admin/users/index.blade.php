@extends('layouts.admin')

@section('title', 'ইউজার লিস্ট | অ্যাডমিন প্যানেল')
@section('header_title', 'ইউজার লিস্ট')

@section('styles')
<style>
    .user-split {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
    }

    @media (min-width: 1024px) {
        .user-split {
            grid-template-columns: 1.8fr 1fr;
        }
    }

    /* Modal Styling */
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 200;
        animation: fadeIn 0.3s ease;
    }

    .modal.show {
        display: flex;
    }

    .modal-content {
        background-color: var(--content-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 32px;
        width: 100%;
        max-width: 460px;
        box-shadow: var(--shadow);
        position: relative;
    }

    .modal-close-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        background: none;
        border: none;
        color: var(--text-sub);
        font-size: 1.3rem;
        cursor: pointer;
    }

    .modal-close-btn:hover {
        color: #ffffff;
    }
</style>
@endsection

@section('content')

    <!-- Display Error if Self-deletion tried -->
    @if(session('error'))
        <div class="alert alert-danger" style="background-color: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-xmark"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="user-split">
        <!-- Left Users Table List -->
        <div class="admin-card">
            <h3 class="card-title" style="margin-bottom: 20px;">
                <i class="fa-solid fa-users-gear"></i>
                <span>সকল ইউজার অ্যাকাউন্টস (মোট: {{ count($users) }}জন)</span>
            </h3>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>নাম</th>
                            <th>ইমেইল</th>
                            <th>পদবী (Role)</th>
                            <th>তৈরির তারিখ</th>
                            <th style="width: 100px;">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td style="font-weight: 600;">{{ $user->name }}</td>
                                <td style="font-family: 'Outfit', sans-serif; color: var(--text-sub);">
                                    {{ $user->email }}
                                </td>
                                <td>
                                    @if($user->role === 'super_admin')
                                        <span class="badge badge-danger"><i class="fa-solid fa-crown"></i> Super Admin</span>
                                    @elseif($user->role === 'admin')
                                        <span class="badge badge-success"><i class="fa-solid fa-user-shield"></i> Admin</span>
                                    @else
                                        <span class="badge badge-warning"><i class="fa-solid fa-user-pen"></i> Editor</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at ? $user->created_at->format('d M, Y') : 'N/A' }}</td>
                                <td>
                                    <div class="action-flex">
                                        <button type="button" class="action-btn action-edit" title="সম্পাদনা" onclick="openEditModal({{ json_encode($user) }})">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        
                                        @if($user->id !== Auth::id())
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে ইউজার অ্যাকাউন্টটি মুছে ফেলতে চান?');" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn action-delete" title="মুছে ফেলুন"><i class="fa-solid fa-trash-can"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Create User Form -->
        <div class="admin-card" style="height: fit-content;">
            <h3 class="card-title" style="margin-bottom: 20px;">
                <i class="fa-solid fa-user-plus"></i>
                <span>নতুন ইউজার তৈরি করুন</span>
            </h3>

            @if($errors->any())
                <div class="alert alert-danger" style="background-color: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; padding: 10px; border-radius: 6px; font-size: 0.85rem; margin-bottom: 20px;">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label">পুরো নাম</label>
                    <input type="text" name="name" id="name" required placeholder="ইউজারের নাম লিখুন..." class="form-control">
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">ইমেইল ঠিকানা</label>
                    <input type="email" name="email" id="email" required placeholder="user@example.com" class="form-control">
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">লগইন পাসওয়ার্ড</label>
                    <input type="password" name="password" id="password" required placeholder="••••••" class="form-control">
                    <span class="form-text">পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।</span>
                </div>

                <!-- Role -->
                <div class="form-group">
                    <label for="role" class="form-label">পদবী (Role Assign)</label>
                    <select name="role" id="role" class="form-control">
                        <option value="editor">এডিটর (Editor - শুধুমাত্র খবর CRUD করতে পারবে)</option>
                        <option value="admin">অ্যাডমিন (Admin - খবর + ক্যাটাগরি + ই-পেপার পরিচালনা)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 10px;">
                    <i class="fa-solid fa-user-check"></i>
                    <span>ইউজার তৈরি করুন</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal" id="editUserModal">
        <div class="modal-content">
            <button class="modal-close-btn" onclick="closeEditModal()"><i class="fa-solid fa-xmark"></i></button>
            
            <h3 class="card-title" style="margin-bottom: 24px;">
                <i class="fa-solid fa-user-pen"></i>
                <span>ইউজার অ্যাকাউন্ট সম্পাদন</span>
            </h3>

            <form id="editForm" action="" method="POST">
                @csrf
                @method('PUT')

                <!-- Edit Name -->
                <div class="form-group">
                    <label for="edit_name" class="form-label">ইউজারের পুরো নাম</label>
                    <input type="text" name="name" id="edit_name" required class="form-control">
                </div>

                <!-- Edit Email -->
                <div class="form-group">
                    <label for="edit_email" class="form-label">ইমেইল ঠিকানা</label>
                    <input type="email" name="email" id="edit_email" required class="form-control">
                </div>

                <!-- Edit Password (Optional) -->
                <div class="form-group">
                    <label for="edit_password" class="form-label">নতুন পাসওয়ার্ড (ঐচ্ছিক)</label>
                    <input type="password" name="password" id="edit_password" placeholder="খালি রাখলে পাসওয়ার্ড পরিবর্তন হবে না..." class="form-control">
                </div>

                <!-- Edit Role -->
                <div class="form-group" id="editRoleGroup">
                    <label for="edit_role" class="form-label">পদবী (Role Change)</label>
                    <select name="role" id="edit_role" class="form-control">
                        <option value="editor">এডিটর (Editor)</option>
                        <option value="admin">অ্যাডমিন (Admin)</option>
                        <option value="super_admin">সুপার অ্যাডমিন (Super Admin)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 16px;">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>পরিবর্তন সংরক্ষণ করুন</span>
                </button>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    const modal = document.getElementById('editUserModal');
    const editForm = document.getElementById('editForm');
    const editName = document.getElementById('edit_name');
    const editEmail = document.getElementById('edit_email');
    const editRole = document.getElementById('edit_role');
    const editRoleGroup = document.getElementById('editRoleGroup');
    const currentUserId = {{ Auth::id() }};

    function openEditModal(user) {
        // Set form action dynamically
        editForm.action = `/admin/users/${user.id}`;
        
        // Populate inputs
        editName.value = user.name;
        editEmail.value = user.email;
        editRole.value = user.role;

        // Hide role select if editing yourself (to prevent changing your own super_admin role!)
        if (user.id === currentUserId) {
            editRoleGroup.style.display = 'none';
        } else {
            editRoleGroup.style.display = 'block';
        }

        // Show Modal
        modal.classList.add('show');
    }

    function closeEditModal() {
        modal.classList.remove('show');
    }

    // Close modal when clicking outside content area
    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeEditModal();
        }
    });
</script>
@endsection
