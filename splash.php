<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Login and Register</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet"/>
    <link rel="stylesheet" href="splash.css">
    <script src='main.js'></script>
</head>
<body>
    <div class="container" id="container">
        <div class="form-container register-container">
            <form method="POST" action="process.php">
                <h1>Register</h1>
                <input type="text" placeholder="Username" name="Username">
                <input type="password" placeholder="Password" name="Password">
                <input type="password" placeholder="Confirm Password">
                <button onclick="submit">Register</button>
		    <input type="hidden" name="signupsave" value="0">
            </form>
        </div>
        <div class="form-container login-container">
            <form method="POST" action="process.php">
                <h1>Login</h1>
                <div>
                    <input type="text" placeholder="Username" name="Username">
                    <input type="password" placeholder="Password" name="Password">
                    <div class="content">
                    <div class="checkbox">
                    </div>
                </div>
                    <div>
                        <button onclick="submit">Login</button>
                        </div>
                    </div>
		        <input type="hidden" name="signinchecker" value="1">
                </form>
            </div>
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-left">
                        <h1 class="title">Hello <br> Friends</h1>
                        <p>if You have an account, login here and have fun</p>
                        <button onclick="submit" class="ghost" id="login">Login
                             <i class="lni lni-arrow-left login"></i>
                        </button>
                    </div>
                    <div class="overlay-panel overlay-right">
                        <h1 class="title">Start your <br> journey now</h1>
                        <p>if you don't have an account yet, join us and start your journey.</p>
                        <button class="ghost" id="register">Register
                            <i class="lni lni-arrow-right register"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <script src="splash.js"></script>
</body>
</html>