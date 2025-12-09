<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request.");
}

$first = trim($_POST['first_name'] ?? '');
$last  = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$pass1 = $_POST['password'] ?? '';
$pass2 = $_POST['password2'] ?? '';

if (!$first || !$last || !$email || !$pass1 || !$pass2) {
    die("All fields are required.");
}

if ($pass1 !== $pass2) {
    die("Passwords do not match.");
}

$hashedPassword = password_hash($pass1, PASSWORD_DEFAULT);

$file = "registrations.csv";

$row = [
    date("Y-m-d H:i:s"),
    $first,
    $last,
    $email,
    $hashedPassword
];

$fp = fopen($file, "a");
if (!$fp) {
    die("Unable to open file.");
}
fputcsv($fp, $row);
fclose($fp);

echo "Registration successful. Thank you, $first!";
?>
