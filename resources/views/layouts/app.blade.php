<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'FoodShare')
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f7f6;
            color: #333;

            display: flex;
            flex-direction: column;

            min-height: 100vh;
        }


        /*
        |--------------------------------------------------------------------------
        | NAVBAR
        |--------------------------------------------------------------------------
        */

        .navbar {
            min-height: 65px;

            background: #2e7d32;
            color: white;

            padding: 0 35px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 20px;
        }

        .navbar-brand {
            color: white;

            font-size: 22px;
            font-weight: bold;

            text-decoration: none;

            white-space: nowrap;
        }

        .navbar-menu {
            display: flex;
            align-items: center;

            gap: 3px;

            flex-wrap: wrap;
        }

        .navbar-menu a {
            color: white;

            text-decoration: none;

            padding: 20px 12px;

            font-size: 14px;

            border-bottom: 4px solid transparent;
        }

        .navbar-menu a:hover {
            background: #256428;
        }

        .navbar-menu a.active {
            background: #1b5e20;

            border-bottom-color: white;

            font-weight: bold;
        }

        .user-info {
            display: flex;
            flex-direction: column;

            padding: 5px 10px;

            font-size: 13px;
        }

        .user-role {
            font-size: 11px;
            color: #c8e6c9;
        }


        /*
        |--------------------------------------------------------------------------
        | CONTENT
        |--------------------------------------------------------------------------
        */

        .main-content {
            flex: 1;

            width: 92%;
            max-width: 1250px;

            margin: 30px auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 15px;

            flex-wrap: wrap;

            margin-bottom: 25px;
        }

        .page-header h1 {
            color: #2e7d32;

            margin: 0 0 5px;
        }

        .page-header p {
            margin: 0;

            color: #666;
        }


        /*
        |--------------------------------------------------------------------------
        | CARD
        |--------------------------------------------------------------------------
        */

        .card {
            background: white;

            border-radius: 10px;

            padding: 25px;

            box-shadow:
                0 2px 10px rgba(0,0,0,0.08);

            margin-bottom: 20px;
        }


        /*
        |--------------------------------------------------------------------------
        | FORM
        |--------------------------------------------------------------------------
        */

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;

            margin-bottom: 7px;

            font-weight: bold;
        }

        .form-control {
            display: block;

            width: 100%;

            padding: 11px 12px;

            border: 1px solid #ccc;
            border-radius: 6px;

            background: white;

            font-size: 14px;

            transition:
                border-color .2s,
                box-shadow .2s;
        }

        .form-control:focus {
            outline: none;

            border-color: #2e7d32;

            box-shadow:
                0 0 0 3px rgba(46,125,50,.12);
        }

        textarea.form-control {
            min-height: 110px;
            resize: vertical;
        }

        .is-invalid {
            border-color: #c62828 !important;
        }

        .field-error {
            color: #c62828;

            font-size: 13px;

            margin-top: 6px;
        }

        .form-help {
            color: #777;

            font-size: 12px;

            margin-top: 5px;

            display: block;
        }


        /*
        |--------------------------------------------------------------------------
        | BUTTON
        |--------------------------------------------------------------------------
        */

        .btn {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            min-height: 38px;

            padding: 9px 15px;

            border: none;
            border-radius: 6px;

            text-decoration: none;

            font-size: 14px;
            font-weight: bold;

            cursor: pointer;

            transition:
                background .2s,
                opacity .2s;
        }

        .btn-primary {
            background: #2e7d32;
            color: white;
        }

        .btn-primary:hover {
            background: #1b5e20;
        }

        .btn-blue {
            background: #1565c0;
            color: white;
        }

        .btn-blue:hover {
            background: #0d47a1;
        }

        .btn-warning {
            background: #f9a825;
            color: white;
        }

        .btn-danger {
            background: #c62828;
            color: white;
        }

        .btn-success {
            background: #2e7d32;
            color: white;
        }

        .btn-secondary {
            background: #607d8b;
            color: white;
        }

        .btn:disabled,
        .btn.loading {
            opacity: .55;

            cursor: not-allowed;
        }

        .btn-logout {
            background: #c62828;
            color: white;

            border: none;
            border-radius: 5px;

            padding: 9px 14px;

            font-weight: bold;

            cursor: pointer;
        }


        /*
        |--------------------------------------------------------------------------
        | LOADING
        |--------------------------------------------------------------------------
        */

        .spinner {
            display: inline-block;

            width: 15px;
            height: 15px;

            margin-right: 7px;

            border: 2px solid rgba(255,255,255,.4);
            border-top-color: white;
            border-radius: 50%;

            animation: putar .7s linear infinite;
        }

        @keyframes putar {

            to {
                transform: rotate(360deg);
            }

        }


        /*
        |--------------------------------------------------------------------------
        | ALERT / NOTIFICATION
        |--------------------------------------------------------------------------
        */

        .alert {
            padding: 14px 16px;

            border-radius: 7px;

            margin-bottom: 20px;

            border: 1px solid transparent;
        }

        .alert-success {
            background: #e8f5e9;
            color: #1b5e20;

            border-color: #a5d6a7;
        }

        .alert-error {
            background: #ffebee;
            color: #b71c1c;

            border-color: #ef9a9a;
        }

        .alert-warning {
            background: #fff8e1;
            color: #8d6e00;

            border-color: #ffe082;
        }


        /*
        |--------------------------------------------------------------------------
        | BADGE STATUS
        |--------------------------------------------------------------------------
        */

        .badge {
            display: inline-block;

            padding: 6px 10px;

            border-radius: 999px;

            font-size: 12px;
            font-weight: bold;

            white-space: nowrap;
        }

        .badge-menunggu {
            background: #fff3cd;
            color: #856404;
        }

        .badge-disetujui {
            background: #d4edda;
            color: #155724;
        }

        .badge-ditolak {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-tersedia {
            background: #d4edda;
            color: #155724;
        }

        .badge-tidak-tersedia {
            background: #eeeeee;
            color: #555;
        }


        /*
        |--------------------------------------------------------------------------
        | TABLE
        |--------------------------------------------------------------------------
        */

        .table-responsive {
            width: 100%;

            overflow-x: auto;

            -webkit-overflow-scrolling: touch;
        }

        .table {
            width: 100%;

            min-width: 750px;

            border-collapse: collapse;

            background: white;
        }

        .table th {
            background: #2e7d32;
            color: white;

            text-align: left;

            padding: 12px;

            white-space: nowrap;
        }

        .table td {
            padding: 12px;

            border-bottom: 1px solid #e5e5e5;

            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: #f7faf7;
        }

        .table-actions {
            display: flex;

            gap: 6px;

            flex-wrap: wrap;
        }


        /*
        |--------------------------------------------------------------------------
        | EMPTY STATE
        |--------------------------------------------------------------------------
        */

        .empty-state {
            text-align: center;

            padding: 40px 20px;

            color: #777;
        }

        .empty-state-title {
            color: #444;

            font-size: 18px;
            font-weight: bold;

            margin-bottom: 7px;
        }


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        .dashboard-grid {
            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 20px;
        }

        .stat-number {
            font-size: 34px;
            font-weight: bold;

            color: #2e7d32;

            margin: 10px 0;
        }


        /*
        |--------------------------------------------------------------------------
        | FOOTER
        |--------------------------------------------------------------------------
        */

        .footer {
            margin-top: auto;

            padding: 18px;

            background: #263238;
            color: #ddd;

            text-align: center;

            font-size: 13px;
        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 768px) {

            .navbar {
                padding: 15px 18px;

                flex-direction: column;

                align-items: flex-start;
            }

            .navbar-menu {
                width: 100%;

                display: flex;
                align-items: stretch;

                gap: 4px;
            }

            .navbar-menu a {
                padding: 10px 8px;
            }

            .user-info {
                padding-left: 8px;
            }

            .main-content {
                width: 94%;

                margin: 20px auto;
            }

            .card {
                padding: 18px;
            }

            .page-header {
                align-items: flex-start;

                flex-direction: column;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .btn {
                min-height: 42px;
            }

            .table {
                min-width: 700px;
            }

        }


        @media (max-width: 480px) {

            .navbar-menu {
                flex-direction: column;
            }

            .navbar-menu a {
                width: 100%;

                border-bottom: none;
                border-left: 4px solid transparent;
            }

            .navbar-menu a.active {
                border-left-color: white;
                border-bottom: none;
            }

            .form-actions {
                display: flex;

                flex-direction: column;

                gap: 8px;
            }

            .form-actions .btn {
                width: 100%;
            }

        }

    </style>


    @stack('styles')

</head>


<body>

    @include('partials.navbar')


    <main class="main-content">


        {{-- NOTIFIKASI GLOBAL --}}

        @if (session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

        @endif


        @if (session('error'))

            <div class="alert alert-error">

                {{ session('error') }}

            </div>

        @endif


        @yield('content')

    </main>


    @include('partials.footer')


    @stack('scripts')

</body>
</html>