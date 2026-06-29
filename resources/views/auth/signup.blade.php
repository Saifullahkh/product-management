<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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

        .signup-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .signup-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 450px;
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

        .text-muted-custom {
            color: var(--text-muted);
        }
    </style>
</head>
<body>

<div class="container signup-container">
    <div class="signup-card">
        
        <div class="text-center mb-4">
            <h3 class="fw-bold m-0" style="color: var(--text-main);">Create an Account</h3>
            <p class="small text-muted-custom mt-1">Get started with your dashboard access</p>
        </div>

        <form action="{{ route('users-store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" id="name" name="name" class="form-control rounded-3" placeholder="John Doe" value="{{ old('name') }}" >
                @error('name')
                    <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-control rounded-3" placeholder="name@example.com" value="{{ old('email') }}" >
                @error('email')
                    <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control rounded-3" placeholder="password" >
                @error('password')
                    <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control rounded-3" placeholder="confirm password" >
                @error('password_confirmation')
                    <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary-custom w-100 rounded-3 mb-3">
                Sign Up
            </button>

            <div class="text-center">
                <p class="small text-muted-custom m-0">Already have an account? <a href="{{ route('login') }}" style="color: var(--primary-color); text-decoration: none;" class="fw-semibold">Log In</a></p>
            </div>

        </form>
    </div>
</div>

</body>
</html>