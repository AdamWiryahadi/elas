<x-admin-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.manageuser') }}">User Management</a></li>
                        <li class="breadcrumb-item active">Create User</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6"> <!-- Removed offset to align left -->
                    <div class="card"> <!-- Removed card-primary to follow AdminLTE v4 -->
                        <div class="card-header">
                            <h3 class="card-title">Register a New User</h3>
                        </div>
                        <form action="{{ route('admin.storeuser') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required>
                                </div>
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <div class="dropdown-wrapper">
                                        <select name="role" id="role" class="form-control custom-dropdown">
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select>
                                        <span class="dropdown-icon">
                                            <i class="fas fa-chevron-right"></i> <!-- Changed to '>' icon -->
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" required>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-dark">Create User</button> <!-- Changed to dark button -->
                            </div>
                        </form>
                    </div>
                </div> <!-- End col-md-6 -->
            </div>
        </div>
    </div>
</x-admin-layout>

<style>
    .dropdown-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .custom-dropdown {
        width: 100%;
        padding-right: 30px; /* Ensure text doesn't overlap icon */
        cursor: pointer;
    }

    .dropdown-icon {
        position: absolute;
        right: 10px;
        pointer-events: none; /* Allows clicking the dropdown itself */
        transition: transform 0.3s ease-in-out;
    }

    .rotate {
        transform: rotate(90deg); /* Changed rotation to match '>' */
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dropdown = document.getElementById("role");
        const icon = document.querySelector(".dropdown-icon i");

        dropdown.addEventListener("click", function () {
            icon.classList.toggle("rotate"); // Rotate on click
        });
    });
</script>
