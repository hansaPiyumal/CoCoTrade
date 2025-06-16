<?php
    require_once 'connection/connection.php';
?>
<?php
    session_start();
    
    if(isset($_POST['login'])){
        $mail = mysqli_real_escape_string($connection,$_POST['mail']);
        $pswd = mysqli_real_escape_string($connection,$_POST['pswd']);

        $sql = "SELECT * FROM users WHERE mail='{$mail}'";
        $result_set = mysqli_query($connection, $sql);

        if($result_set && mysqli_num_rows($result_set) == 1){
            $row = mysqli_fetch_assoc($result_set);
            $hashedPassword = $row['pswd'];

            if(password_verify($pswd,$hashedPassword)){
                $_SESSION['userid'] = $row['userid'];
                $_SESSION['fname'] = $row['fname'];
                header("Location: index.php");
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Login</title>
    <style>
        form {
            margin-top: 160px;
            margin-left: 40px;
            width: 75%;
        }
        .montserrat-brand {
            font-family: "Montserrat", sans-serif;
            font-optical-sizing: auto;
            font-weight: 900;
            font-style: normal;
            font-size: 50px;
        }
        .blue-box {
            background-color:rgb(6, 146, 53);
            border-radius: 20px;
            padding: 50px;
            margin: 40px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="blue-box">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="text-center montserrat-brand" style="margin-top: 150px;font-size:80px">C<span style="color:orange">O</span>C<span style="color:orange">O</span></h1>
                    <h1 class="text-center montserrat-brand" style="font-size:80px; color:whi">TRADE</h1>
                    <p class="text-center" style="font-size:large;color:rgb(0, 0, 0)">Bringing the Market to You</p><br><br>
                    <p class="text-center">Don't have an account? <a style="text-decoration: none;color:black" href="signup.php">Create an account</a></p>
                </div>
                <div class="col-md-6">
                    <form action="login.php" method="post">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" name="mail" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" name="pswd" class="form-control" id="exampleInputPassword1">
                        </div>
                        <button name="login" type="submit" class="btn" style="background-color: orange; color: black;">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>