<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            background: linear-gradient(140deg, #8894ff, #5560ff);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 380px;
            background: #ffffff;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.15);
        }

        .login-box h3 {
            font-weight: 700;
            color: #5560ff;
        }
    </style>
</head>

<body>

<div class="login-box">
    <h3 class="text-center mb-4">Inventory Login</h3>

    <form method="POST">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control">
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button class="btn btn-primary w-100 mt-2">Login</button>
    </form>
</div>

</body>
</html>
