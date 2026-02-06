<?php
// === DEMO: Multiple Vulnerability Types ===

// 1. XSS - Cross-Site Scripting
echo $_GET['name'];

// 2. Command Injection
$file = $_GET['file'];
system("cat " . $file);

// 3. Path Traversal / File Inclusion
include($_GET['page'] . ".php");

// 4. Hardcoded Credentials
$api_key = "sk-1234567890abcdef";
$secret = "mysupersecretpassword";

// 5. Insecure Deserialization
$data = unserialize($_POST['data']);

// 6. Eval Injection
eval($_GET['code']);
