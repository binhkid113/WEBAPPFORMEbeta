<?php

require_once __DIR__ . "/db.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function current_user(): ?array
{
    if (empty($_SESSION["user_id"])) {
        return null;
    }

    try {
        $stmt = db()->prepare("SELECT id, username, email, avatar, created_at FROM users WHERE id = ?");
        $stmt->execute([$_SESSION["user_id"]]);
        $user = $stmt->fetch();
        return $user ?: null;
    } catch (Throwable $e) {
        return null;
    }
}

function redirect_to(string $url): void
{
    header("Location: " . $url);
    exit;
}

function auth_error_message(Throwable $error): string
{
    if (str_contains($error->getMessage(), "SQLSTATE")) {
        return "Database is not available. Please check MAMP and import database.sql.";
    }

    return "Something went wrong. Please try again.";
}

function csrf_token(): string
{
    if (empty($_SESSION["csrf_token"])) {
        $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
    }

    return $_SESSION["csrf_token"];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES, "UTF-8") . '" />';
}

function verify_csrf(): bool
{
    $token = $_POST["csrf_token"] ?? "";
    return $token !== "" && hash_equals($_SESSION["csrf_token"] ?? "", $token);
}
