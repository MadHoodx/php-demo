<?php
$password = getenv("DB_PASSWORD");

$id = $_GET['id'];
$conn = mysqli_connect("localhost","root","","test");

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i",$id);
$stmt->execute();
