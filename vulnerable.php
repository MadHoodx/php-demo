<?php
$conn = new mysqli("localhost","root","","test");

$id = $_GET['id'];   // ❌ ไม่ sanitize
$sql = "SELECT * FROM users WHERE id = $id";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()){
    echo $row["username"];
}
