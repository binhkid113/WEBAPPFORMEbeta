<?php
require_once __DIR__ . "/includes/data.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/includes/auth.php";

$currentPage = "auth";
$pageTitle = "Otoku Circle - Login";
$errors = [];
$email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Enter a valid email address.";
    }

    if ($password === "") {
        $errors[] = "Enter your password.";
    }

    if (!$errors) {
        try {
            $stmt = db()->prepare("SELECT id, password_hash FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if (!$user || !password_verify($password, $user["password_hash"])) {
                $errors[] = "Email or password is incorrect.";
            } else {
                $_SESSION["user_id"] = $user["id"];
                redirect_to("profile.php");
            }
        } catch (Throwable $error) {
            $errors[] = auth_error_message($error);
        }
    }
}

require_once __DIR__ . "/includes/header.php";
?>

<div class="screen auth-screen">
  <div class="auth-card">
    <div class="auth-hero">
      <span class="status-pill"><span data-lucide="lock-keyhole"></span> Welcome back</span>
      <h2>Log in to keep your saved deals</h2>
      <p>Use your account to post tips, comment, bookmark deals, and build trust in the community.</p>
    </div>

    <?php if ($errors) : ?>
      <div class="alert error">
        <?php foreach ($errors as $error) : ?>
          <p><?= e($error) ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form class="form-panel auth-form" action="login.php" method="post">
      <div class="field">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="<?= e($email) ?>" placeholder="you@example.com" autocomplete="email" />
      </div>
      <div class="field">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" placeholder="Your password" autocomplete="current-password" />
      </div>
      <button class="primary-button" type="submit"><span data-lucide="log-in"></span> Log in</button>
    </form>

    <p class="auth-switch">New to Otoku Circle? <a href="register.php">Create an account</a></p>
  </div>
</div>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
