<?php
require_once __DIR__ . "/includes/data.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/includes/auth.php";

$currentPage = "profile";
$pageTitle = "Otoku Circle - Settings";
$currentUser = current_user();
$success = "";
$errors = [];

$languages = [
    "en" => "English",
    "ja" => "日本語 (Japanese)",
    "vi" => "Tiếng Việt (Vietnamese)",
    "zh" => "中文 (Chinese)",
    "ko" => "한국어 (Korean)",
    "pt" => "Português (Portuguese)",
    "es" => "Español (Spanish)",
];

$currentLang       = $_SESSION["settings_lang"] ?? "en";


if ($_SERVER["REQUEST_METHOD"] === "POST" && $currentUser) {
    if (!verify_csrf()) {
        $errors[] = "Invalid form submission. Please try again.";
    }

    if (!$errors) {
        $_SESSION["settings_lang"]           = $_POST["language"] ?? "en";
        $currentLang = $_SESSION["settings_lang"];

        $success = "Settings saved successfully.";
    }
}

require_once __DIR__ . "/includes/header.php";
?>

<div class="screen">
  <div class="settings-header">
    <a class="ghost-button" href="profile.php">
      <span data-lucide="arrow-left"></span> Back
    </a>
    <h2><span data-lucide="settings"></span> Settings</h2>
  </div>

  <?php if (!$currentUser) : ?>
    <div class="alert error">
      <p>Please <a href="login.php">log in</a> to change settings.</p>
    </div>
  <?php else : ?>

    <?php if ($success) : ?>
      <div class="alert success">
        <p><?= e($success) ?></p>
      </div>
    <?php endif; ?>

    <?php if ($errors) : ?>
      <div class="alert error">
        <?php foreach ($errors as $err) : ?>
          <p><?= e($err) ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form method="post" action="settings.php">
      <?= csrf_field() ?>

      <!-- Language -->
      <section class="settings-group">
        <div class="settings-group-title">
          <span data-lucide="globe" class="settings-icon"></span>
          <h3>Language</h3>
        </div>
        <p class="settings-desc">Choose your preferred display language.</p>
        <div class="field">
          <select name="language" id="language">
            <?php foreach ($languages as $code => $label) : ?>
              <option value="<?= e($code) ?>" <?= $currentLang === $code ? "selected" : "" ?>>
                <?= e($label) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </section>

      <!-- Appearance -->
      <section class="settings-group">
        <div class="settings-group-title">
          <span data-lucide="palette" class="settings-icon"></span>
          <h3>Appearance</h3>
        </div>
        <p class="settings-desc">Toggle between dark and light mode.</p>
        <div class="settings-row">
          <div class="settings-row-label">
            <span data-lucide="sun-moon"></span>
            <span>Dark / Light mode</span>
          </div>
          <button class="toggle-theme-btn" type="button" data-action="toggle-theme">
            <span class="toggle-track">
              <span class="toggle-thumb"></span>
            </span>
          </button>
        </div>
      </section>

      <!-- Account -->
      <section class="settings-group">
        <div class="settings-group-title">
          <span data-lucide="shield" class="settings-icon"></span>
          <h3>Account</h3>
        </div>

        <a class="settings-row clickable" href="profile.php">
          <div class="settings-row-label">
            <span data-lucide="user"></span>
            <span>Edit profile</span>
          </div>
          <span data-lucide="chevron-right" class="settings-chevron"></span>
        </a>

        <a class="settings-row clickable" href="logout.php">
          <div class="settings-row-label">
            <span data-lucide="log-out"></span>
            <span>Log out</span>
          </div>
          <span data-lucide="chevron-right" class="settings-chevron"></span>
        </a>
      </section>

      <!-- About -->
      <section class="settings-group">
        <div class="settings-group-title">
          <span data-lucide="info" class="settings-icon"></span>
          <h3>About</h3>
        </div>

        <div class="settings-row">
          <div class="settings-row-label">
            <span data-lucide="code"></span>
            <span>Version</span>
          </div>
          <span class="settings-value">1.0.0</span>
        </div>

        <div class="settings-row">
          <div class="settings-row-label">
            <span data-lucide="heart"></span>
            <span>Made for</span>
          </div>
          <span class="settings-value">Foreigners in Japan</span>
        </div>
      </section>

      <div class="button-row">
        <button class="primary-button" type="submit">
          <span data-lucide="check"></span> Save settings
        </button>
      </div>
    </form>

  <?php endif; ?>
</div>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
