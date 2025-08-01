<?php
    require_once 'connection/connection.php';
?>
<?php
    if(isset($_POST['signup'])){
        $mail = mysqli_real_escape_string($connection,$_POST['mail']);
        $fname = mysqli_real_escape_string($connection,$_POST['fname']);
        $lname = mysqli_real_escape_string($connection,$_POST['lname']);

        if($_POST['cpswd'] == $_POST['pswd']){
            $pswd = password_hash($_POST['pswd'],PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (fname,lname,mail,pswd) VALUES('{$fname}','{$lname}','{$mail}','{$pswd}')";
            $result = mysqli_query($connection,$sql);

            if($result){
                header("Location: login.php");
            }else{
                echo "<script>alert('Not created');</script>";
            }
        }else{
            echo "<script>alert('Password fields are not same');</script>";
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
    <title>Sign Up</title>
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
        .video-background {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1;
            object-fit: cover;
        }
        .content-overlay {
            position: relative;
            z-index: 1;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 20px;
            padding: 50px;
            margin: 40px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .text-white {
            color: white !important;
        }
        .text-orange {
            color: orange !important;
        }
    </style>
</head>
<body>
    <!-- Video Background -->
    <video autoplay muted loop id="myVideo" class="video-background">
        <source src="images/vid.mp4" type="video/mp4">
    </video>

    <div class="container-fluid">
        <div class="content-overlay">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="text-center montserrat-brand" style="margin-top: 150px;font-size:80px">C<span class="text-orange">O</span>C<span class="text-orange">O</span></h1>
                    <h1 class="text-center montserrat-brand text-white" style="font-size:80px">TRADE</h1>
                    <br>
                    <p class="text-center text-white" style="font-size:large">Bringing the Market to You</p><br><br>
                    <p class="text-center text-white">Have an account? <a style="text-decoration: none;color:orange" href="login.php">Login</a></p>
                </div>
                <div class="col-md-6">
                    <form action="signup.php" method="post">
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label text-white">Email address</label>
                          <input type="email" name="mail" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                          <div id="emailHelp" class="form-text text-white">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputFullname1" class="form-label text-white">First Name</label>
                            <input type="text" name="fname" id="exampleInputFullname1" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputFullname1" class="form-label text-white">Last Name</label>
                            <input type="text" name="lname" id="exampleInputFullname1" class="form-control">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label text-white">Password</label>
                          <input type="password" name="pswd" class="form-control" id="examplePassword1">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label text-white">Confirm Password</label>
                          <input type="password" class="form-control" name="cpswd" id="exampleConfirmPassword1">
                        </div>
                        <button name="signup" type="submit" class="btn" style="background-color: orange;color: black;">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>