<?php
require "config/db.php";

$id = mysqli_real_escape_string($conn, trim($_GET['id']));

$sql = "UPDATE `todos` SET `completed`=1 WHERE `id` = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo json_encode(array(
        "status" => 1,
        "message" => "Completed successfully!"
    ));
} else {
    echo json_encode(array(
        "status" => 0,
        "message" => "Something went wrong!"
    ));
}