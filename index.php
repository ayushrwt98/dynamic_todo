<?php
require "config/db.php";
if (isset($_POST['email'])) {
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
    $hash = md5($password);
    $sql = "SELECT * FROM `users` WHERE `email`='$email' AND `hash`='$hash'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    if ($user) {
        $_SESSION['email'] = $user['email'];
        $_SESSION['user_id'] = $user['id'];
    } else {
        $error = "Invalid email or password!";
    }
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM todos WHERE user_id = $user_id";
    $result = mysqli_query($conn, $sql);
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
        <?php if (!isset($_SESSION['email'])) { ?>
        <div class="row">
            <form class="col-4 ml-auto mr-auto mt-4" method="POST">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email"
                        name="email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"
                        name="password">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <p>Don't have an account? <a href="register.php" class="btn btn-secondary">Register here</a></p>

            </form>
        </div>
        <?php } else { ?>
        <header class="mt-5">
            <form method="POST" id="todo-form">
                <div class="input-group mb-3">
                    <input type="hidden" name="user_id" id="user_id" value="<?= $_SESSION['user_id'] ?>" />
                    <input type="text" name="todo" class="form-control" placeholder="Enter a todo">
                    <span class="input-group-text">
                        <button class="btn btn-primary">Add Todo</button>
                    </span>
                </div>
            </form>
        </header>
        <main>
            <ul class="list-group" id="todo-list">
                Loading...
            </ul>
        </main>
        <?php } ?>
    </div>

    <script type="text/javascript" src="assets/main.js"></script>
</body>

</html>