<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Point of Sales</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('asset') }}/images/favicon.png">
    
    <!-- Quixlab CSS -->
    <link href="{{ asset('asset') }}/dist/css/style.css" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        .auth-wrapper {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .auth-form.card {
            width: 100%;
            max-width: 500px;
        }
    </style>
</head>

<body class="bg-primary">

    <div class="auth-wrapper">
        <div class="auth-form card p-5 shadow-lg">
            <div class="text-center mb-4">
                <h3 class="text-primary">Login to your account</h3>
            </div>

            @if (session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Logout Berhasil!',
                            text: '{{ session('success') }}',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    });
                </script>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control @error('user_nama') is-invalid @enderror"
                        name="user_nama" placeholder="Enter your username"
                        value="{{ old('user_nama') }}">
                    @error('user_nama')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control @error('user_pass') is-invalid @enderror"
                        name="user_pass" placeholder="Enter your password">
                    @error('user_pass')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Core Scripts -->
    <script src="{{ asset('asset') }}/dist/plugins/common/common.min.js"></script>
    <script src="{{ asset('asset') }}/dist/js/custom.min.js"></script>
    <script src="{{ asset('asset') }}/dist/js/settings.js"></script>
    <script src="{{ asset('asset') }}/dist/js/gleek.js"></script>
    <script src="{{ asset('asset') }}/dist/js/styleSwitcher.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
