<?php
require "config/db.php";

$todo = mysqli_real_escape_string($conn, trim($_POST['todo']));
$id = mysqli_real_escape_string($conn, trim($_POST['user_id']));

$sql = "INSERT INTO `todos`(`user_id`, `todo`) VALUES ($id, '$todo')";
$result = mysqli_query($conn, $sql);



if ($result) {
    $sql = "SELECT * FROM `todos` WHERE  `id` = " . mysqli_insert_id($conn);
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    echo json_encode(array(
        "status" => 1,
        "message" => "Added successfully!",
        "data" => $row
    ));
} else {
    echo json_encode(array(
        "status" => 0,
        "message" => "Something went wrong!"
    ));
}