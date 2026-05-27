<?php
require_once __DIR__ . "/includes/data.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/includes/auth.php";

$currentPage = "auth";
$pageTitle = "Otoku Circle - Register";
$errors = [];
$username = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $passwordConfirm = $_POST["password_confirm"] ?? "";

    if ($username === "" || strlen($username) < 2 || strlen($username) > 50) {
        $errors[] = "Username must be between 2 and 50 characters.";
    }

    if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Enter a valid email address.";
    }

    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters.";
    }

    if ($password !== $passwordConfirm) {
        $errors[] = "Passwords do not match.";
    }

    if (!$errors) {
        try {
            $stmt = db()->prepare(
                "INSERT INTO users (username, email, password_hash, avatar) VALUES (?, ?, ?, ?)"
            );
            $stmt->execute([
                $username,
                $email,
                password_hash($password, PASSWORD_DEFAULT),
                strtoupper(substr($username, 0, 1))
            ]);

            $_SESSION["user_id"] = db()->lastInsertId();
            redirect_to("profile.php");
        } catch (PDOException $error) {
            if ($error->getCode() === "23000") {
                $errors[] = "Username or email is already registered.";
            } else {
                $errors[] = auth_error_message($error);
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
      <span class="status-pill"><span data-lucide="badge-plus"></span> Join the circle</span>
      <h2>Create your shopping helper account</h2>
      <p>Start posting simple English deal tips for foreigners who are still learning life in Japan.</p>
    </div>

    <?php if ($errors) : ?>
      <div class="alert error">
        <?php foreach ($errors as $error) : ?>
          <p><?= e($error) ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form class="form-panel auth-form" action="register.php" method="post">
      <div class="field">
        <label for="username">Username</label>
        <input id="username" name="username" type="text" value="<?= e($username) ?>" placeholder="Minh" autocomplete="username" />
      </div>
      <div class="field">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="<?= e($email) ?>" placeholder="you@example.com" autocomplete="email" />
      </div>
      <div class="field">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" placeholder="At least 8 characters" autocomplete="new-password" />
      </div>
      <div class="field">
        <label for="password-confirm">Confirm password</label>
        <input id="password-confirm" name="password_confirm" type="password" placeholder="Repeat password" autocomplete="new-password" />
      </div>
      <button class="primary-button" type="submit"><span data-lucide="user-plus"></span> Create account</button>
    </form>

    <p class="auth-switch">Already have an account? <a href="login.php">Log in</a></p>
  </div>
</div>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
