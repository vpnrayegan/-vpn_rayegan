<?php
// ========== R A B O T   B Y   @Cod_Arshiya =========
// ========== Pv : @Cod_Arshiya =======================
// ========== Channel : @Cod_Arshiya0 ================

// ---------------- CONFIG ----------------
$token = "8318890363:AAHX_EkENbLOhJyekG6iOmEKcWmuyqpro3Y"; // 🔁 توکن ربات رو اینجا بذار
$admin_id = 5248834593;     // 🔁 آیدی عددی تلگرام مدیر

$api = "https://api.telegram.org/bot$token/";

// ----------------- GET UPDATES --------------
$update = json_decode(file_get_contents("php://input"), true);

$message = $update['message'] ?? $update['edited_message'];
if (!$message) exit;

$chat_id = $message['chat']['id'];
$text = $message['text'] ?? '';
$user_id = $message['from']['id'];
$username = $message['from']['username'] ?? null;
$first_name = $message['from']['first_name'] ?? '';

// ----------------- COMMAND: /start --------------
if ($text == '/start') {
    sendMessage($chat_id, "سلام $first_name 🌟\n\nپیام خودتو بفرست تا برای ادمین ارسال بشه ✉️");
    exit;
}

// ----------------- FROM ADMIN REPLY ----------------
if ($chat_id == $admin_id && isset($message['reply_to_message'])) {
    if (preg_match("/^From: (\d+)/", $message['reply_to_message']['text'], $m)) {
        $target_id = $m[1];
        sendMessage($target_id, "📬 پاسخ مدیر:\n$text");
        sendMessage($admin_id, "✅ پیامت به کاربر ارسال شد.");
        exit;
    }
}

// ----------------- FROM USER TO ADMIN ----------------
if ($chat_id != $admin_id) {
    // ساختن اطلاعات فرستنده
    $uid_text = "From: $user_id";
    $uid_text .= $username ? " | Username: @$username" : " | Username: ❌ ندارد";
    $uid_text .= "\nName: $first_name";

    $full_message = "$uid_text\n\n✉️ پیام:\n$text";

    sendMessage($admin_id, $full_message);
    sendMessage($chat_id, "✅ پیام شما با موفقیت برای ادمین ارسال شد.");
    exit;
}