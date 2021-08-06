<?php
require "config/db.php";

$user_id = $_GET['user_id'];
$sql = "SELECT * FROM todos WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);

$array = [];

while ($row = mysqli_fetch_assoc($result)) {
    array_push($array, $row);
}

echo json_encode(array(
    "status" => 1,
    "todos" => $array
));