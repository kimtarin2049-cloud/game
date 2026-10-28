<!DOCTYPE html>
<html lang="th">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Login</title>


    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">


    <style>

        body {
            margin: 0;
            min-height: 100vh;

            background: linear-gradient(
                135deg,
                #212529,
                #495057
            );

            display: flex;
            align-items: center;
            justify-content: center;
        }


        .login-box {

            width: 100%;
            max-width: 420px;

            background: white;

            padding: 40px;

            border-radius: 20px;

            box-shadow:
                0 10px 30px
                rgba(0,0,0,0.25);
        }


        .login-icon {

            width: 80px;
            height: 80px;

            background: #212529;

            color: white;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 35px;

            margin: 0 auto 20px;
        }


        .login-title {

            text-align: center;

            font-weight: bold;

            font-size: 28px;

            margin-bottom: 5px;
        }


        .login-subtitle {

            text-align: center;

            color: #777;

            margin-bottom: 30px;
        }


        .form-control {

            height: 48px;

            border-radius: 10px;
        }


        .btn-login {

            width: 100%;

            height: 48px;

            border-radius: 10px;

            font-weight: bold;

            font-size: 16px;
        }


        .back-button {

            display: block;

            text-align: center;

            margin-top: 20px;

            text-decoration: none;

            color: #555;
        }


        .back-button:hover {

            color: #000;

        }

    </style>

</head>


<body>
@if ($errors->has('username'))
            <div class="alert alert-danger mt-3">
                {{ $errors->first('username') }}
            </div>
        @endif

<div class="login-box">


    <!-- Icon -->

    <div class="login-icon">

        🔐

    </div>


    <!-- Title -->

    <div class="login-title">

        Admin Login

    </div>


    <div class="login-subtitle">

        เข้าสู่ระบบสำหรับผู้ดูแลระบบ

    </div>



    <!-- Login Form -->

    <form action="{{ url('/L') }}"
          method="POST">

        @csrf


        <!-- Username -->

        <div class="mb-3">

            <label class="form-label">

                Username

            </label>

            <input
                type="text"
                name="name"
                class="form-control"
                placeholder="กรอก Username"
                required>

        </div>



        <!-- Password -->

        <div class="mb-4">

            <label class="form-label">

                Password

            </label>

            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="กรอก Password"
                required>

        </div>



        <!-- Login Button -->

        <button
            type="submit"
            class="btn btn-dark btn-login">

            🔑 Login

        </button>

    </form>



    <!-- Back -->

    <a
        href="{{ url('/') }}"
        class="back-button">

        ← กลับไปหน้าเกม

    </a>


</div>


</body>

</html>