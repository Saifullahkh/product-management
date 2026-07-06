<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --body-bg: #f8fafc;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        body {
            background-color: var(--body-bg);
            color: var(--text-main);
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
        }

        .form-label {
            color: var(--text-main);
            font-size: 0.875rem;
            font-weight: 600;
        }

        .form-control {
            border-color: var(--border-color);
            padding: 0.625rem 0.875rem;
            font-size: 0.95rem;
            color: var(--text-main);
            background-color: #ffffff;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #ffffff;
            padding: 0.625rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-primary-custom:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            color: #ffffff;
        }

         .btn-social {
            background-color: #ffffff;
            border-color: var(--primary-hover);
            color: #1e293b;
             padding: 0.625rem;
            font-weight: 600;
        }

        .btn-social:hover{
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #ffffff;
        }

        .text-muted-custom {
            color: var(--text-muted);
        }
    </style>
</head>

<body>

    <div class="container login-container">
        <div class="login-card">

            <div class="text-center mb-4">
                <h3 class="fw-bold m-0" style="color: var(--text-main);">Welcome Back</h3>
                <p class="small text-muted-custom mt-1">Please enter your details to sign in</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger rounded-3 small p-2 text-center" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('users-login') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control rounded-3"
                        placeholder="name@example.com" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="password" class="form-label mb-0">Password</label>
                    </div>
                    <input type="password" id="password" name="password" class="form-control rounded-3"
                        placeholder="password" required>
                    @error('password')
                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary-custom w-100 rounded-3 mb-3">
                    Log In
                </button>

                <!-- OR Divider Line -->
                <div class="d-flex align-items-center mb-3">
                    <hr class="flex-grow-1 border-secondary-subtle my-0">
                    <span class="mx-3 text-secondary small fw-bold">OR</span>
                    <hr class="flex-grow-1 border-secondary-subtle my-0">
                </div>

                <!-- Google Sign-In Button -->
                <a href="" class="btn btn-social w-100 rounded-3 mb-3 d-flex align-items-center justify-content-center gap-2">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQKXZFRxjJ3Su_OlLiCYHzVq7p5rKPgBZTnnF1mYIx1BR0dL2sa1_6spdug&s=10" alt="Google Logo" style=" height: 20px;">
                    <span>Sign in with Google</span>
                </a>

                <div class="text-center">
                    <p class="small text-muted-custom m-0">Don't have an account? <a href="{{ route('signup') }}"
                            style="color: var(--primary-color); text-decoration: none;" class="fw-semibold">Sign Up</a>
                    </p>
                </div>

            </form>
        </div>
    </div>

</body>

</html>