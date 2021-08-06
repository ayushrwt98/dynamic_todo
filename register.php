<?php
require "config/db.php";

if (
    isset($_POST['email'])
    && isset($_POST['password'])
    && isset($_POST['confirm_password'])
) {
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
    $confirm_password = mysqli_real_escape_string($conn, trim($_POST['confirm_password']));

    $sql = "SELECT email FROM users WHERE email='" . $email . "';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_fetch_assoc($result)) {
        $error = "Email already registered!";
    } else if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        $hash = md5($password);
        $sql = "INSERT INTO `users`(`email`, `hash`) VALUES ('$email', '$hash');";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = mysqli_insert_id($conn);
            header('Location: ./');
            exit;
        } else {
            $error = "Something went wrong! Try again.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Bhai Ka Todo</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <form class="col-4 ml-auto mr-auto mt-4" method="POST">
                <p class="text-danger"><?php if (isset($error)) echo $error; ?></p>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        placeholder="Enter email" name="email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"
                        name="password">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword2">Confirm Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password"
                        name="confirm_password">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <p>Don't have an account? <a href="register.php" class="btn btn-secondary">Register here</a></p>

            </form>
        </div>

    </div>

</body>

</html>