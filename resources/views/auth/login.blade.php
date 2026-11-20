<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - FoodShare</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;

            display: flex;
            justify-content: center;
            align-items: center;

            min-height: 100vh;
        }

        .login-container {
            width: 100%;
            max-width: 430px;

            background-color: white;

            padding: 35px;

            border-radius: 12px;

            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .login-container h1 {
            margin: 0;

            text-align: center;

            color: #2e7d32;
        }

        .subtitle {
            text-align: center;

            color: #666;

            margin-top: 8px;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;

            margin-bottom: 7px;

            font-weight: bold;

            color: #333;
        }

        input {
            width: 100%;

            padding: 12px;

            border: 1px solid #ccc;
            border-radius: 6px;

            font-size: 14px;
        }

        input:focus {
            outline: none;

            border-color: #2e7d32;
        }

        .btn-login {
            width: 100%;

            padding: 12px;

            border: none;
            border-radius: 6px;

            background-color: #2e7d32;
            color: white;

            font-size: 16px;
            font-weight: bold;

            cursor: pointer;
        }

        .btn-login:hover {
            background-color: #256428;
        }

        .register-link {
            margin-top: 20px;

            text-align: center;
        }

        .register-link a {
            color: #2e7d32;

            text-decoration: none;

            font-weight: bold;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .alert-error {
            background-color: #ffebee;

            color: #c62828;

            padding: 12px;

            border-radius: 6px;

            margin-bottom: 20px;
        }

        .alert-error ul {
            margin: 0;

            padding-left: 20px;
        }

        .success-message {
            background-color: #e8f5e9;

            color: #2e7d32;

            padding: 12px;

            border-radius: 6px;

            margin-bottom: 20px;
        }

        .error-text {
            color: #c62828;

            font-size: 13px;

            margin-top: 5px;
        }
    </style>
</head>

<body>

<div class="login-container">

    <h1>FoodShare</h1>

    <p class="subtitle">
        Silakan login ke akun Anda
    </p>


    {{-- Pesan sukses --}}
    @if (session('success'))

        <div class="success-message">
            {{ session('success') }}
        </div>

    @endif


    {{-- Menampilkan semua error --}}
    @if ($errors->any())

        <div class="alert-error">

            <strong>Login gagal!</strong>

            <ul>

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- Form Login --}}
    <form
        method="POST"
        action="{{ route('login.process') }}"
    >

        {{-- CSRF Laravel --}}
        @csrf


        {{-- Email --}}
        <div class="form-group">

            <label for="email">
                Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Masukkan email"
                required
                autofocus
            >

            @error('email')

                <div class="error-text">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- Password --}}
        <div class="form-group">

            <label for="password">
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Masukkan password"
                required
            >

            @error('password')

                <div class="error-text">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- Tombol Login --}}
        <button
            type="submit"
            class="btn-login"
        >
            Login
        </button>

    </form>


    {{-- Link Register --}}
    <div class="register-link">

        Belum mempunyai akun?

        <a href="{{ route('register') }}">
            Daftar di sini
        </a>

    </div>

</div>

</body>
</html>