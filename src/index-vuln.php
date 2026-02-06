<?php
$password = "admin123";

$id = $_GET['id'];
$conn = mysqli_connect("localhost","root","","test");

mysqli_query($conn,"SELECT * FROM users WHERE id=$id");
