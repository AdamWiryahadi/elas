<x-admin-layout>
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-user"></i> My Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">My Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf

                <!-- Profile Section -->
                <div class="card mb-4">
                    <div class="card-header text-black">Profile Information</div>
                    <div class="card-body row">

                        <div class="form-group col-md-6">
                            <label>ID:</label>
                            <input type="text" class="form-control" value="{{ $user->id }}" disabled>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Role:</label>
                            <input type="text" class="form-control" value="{{ $user->role }}" disabled>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Name:</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                            </div>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Email:</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                            </div>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Quota (days):</label>
                            <input type="text" class="form-control" value="{{ $user->quota }}" disabled>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Created At:</label>
                            <input type="text" class="form-control" value="{{ $user->created_at->format('Y-m-d H:i') }}" disabled>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Updated At:</label>
                            <input type="text" class="form-control" value="{{ $user->updated_at->format('Y-m-d H:i') }}" disabled>
                        </div>
                    </div>
                </div>

                <!-- Password Section -->
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white d-flex align-items-center justify-content-between">
                        <span class="me-auto fw-bold">Password Update</span>
                        <button type="button" class="btn btn-sm btn-light ms-auto" onclick="togglePasswordSection()" id="toggle-icon-btn">
                            <i class="fas fa-chevron-down" id="toggle-icon"></i>
                        </button>
                    </div>
                    <div class="card-body" id="password-section" style="display: none;">
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" name="password" id="password" class="form-control" autocomplete="new-password" oninput="checkStrength(this.value)">
                            <small id="strength-feedback" class="form-text text-muted"></small>
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" autocomplete="new-password">
                        </div>
                    </div>
                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SweetAlert & Password JS -->
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false,
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false,
            });
        @endif

        function togglePasswordSection() {
            const section = document.getElementById('password-section');
            section.style.display = section.style.display === 'none' ? 'block' : 'none';
        }

        function checkStrength(password) {
            const feedback = document.getElementById('strength-feedback');
            if (password.length === 0) {
                feedback.textContent = '';
                return;
            }

            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            switch (strength) {
                case 0:
                case 1:
                    feedback.textContent = 'Weak';
                    feedback.className = 'form-text text-danger';
                    break;
                case 2:
                case 3:
                    feedback.textContent = 'Medium';
                    feedback.className = 'form-text text-warning';
                    break;
                case 4:
                    feedback.textContent = 'Strong';
                    feedback.className = 'form-text text-success';
                    break;
            }
        }

        function togglePasswordSection() {
            const section = document.getElementById('password-section');
            const icon = document.getElementById('toggle-icon');
            section.style.display = section.style.display === 'none' ? 'block' : 'none';
            icon.classList.toggle('fa-chevron-down');
            icon.classList.toggle('fa-chevron-up');
        }
    </script>
</x-admin-layout>
