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
$currentNearby     = $_SESSION["settings_nearby"] ?? "3";
$currentNotifLikes = $_SESSION["settings_notif_likes"] ?? "1";
$currentNotifComments = $_SESSION["settings_notif_comments"] ?? "1";
$currentNotifDeals = $_SESSION["settings_notif_deals"] ?? "1";

if ($_SERVER["REQUEST_METHOD"] === "POST" && $currentUser) {
    if (!verify_csrf()) {
        $errors[] = "Invalid form submission. Please try again.";
    }

    if (!$errors) {
        $_SESSION["settings_lang"]           = $_POST["language"] ?? "en";
        $_SESSION["settings_nearby"]         = $_POST["nearby_range"] ?? "3";
        $_SESSION["settings_notif_likes"]    = isset($_POST["notif_likes"]) ? "1" : "0";
        $_SESSION["settings_notif_comments"] = isset($_POST["notif_comments"]) ? "1" : "0";
        $_SESSION["settings_notif_deals"]    = isset($_POST["notif_deals"]) ? "1" : "0";

        $currentLang           = $_SESSION["settings_lang"];
        $currentNearby         = $_SESSION["settings_nearby"];
        $currentNotifLikes     = $_SESSION["settings_notif_likes"];
        $currentNotifComments  = $_SESSION["settings_notif_comments"];
        $currentNotifDeals     = $_SESSION["settings_notif_deals"];

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

      <!-- Nearby range -->
      <section class="settings-group">
        <div class="settings-group-title">
          <span data-lucide="map-pin" class="settings-icon"></span>
          <h3>Nearby range</h3>
        </div>
        <p class="settings-desc">Set how far deals should be to appear in your feed.</p>
        <div class="field">
          <select name="nearby_range" id="nearby_range">
            <option value="1" <?= $currentNearby === "1" ? "selected" : "" ?>>1 km</option>
            <option value="2" <?= $currentNearby === "2" ? "selected" : "" ?>>2 km</option>
            <option value="3" <?= $currentNearby === "3" ? "selected" : "" ?>>3 km</option>
            <option value="5" <?= $currentNearby === "5" ? "selected" : "" ?>>5 km</option>
            <option value="10" <?= $currentNearby === "10" ? "selected" : "" ?>>10 km</option>
          </select>
        </div>
      </section>

      <!-- Notifications -->
      <section class="settings-group">
        <div class="settings-group-title">
          <span data-lucide="bell" class="settings-icon"></span>
          <h3>Notifications</h3>
        </div>
        <p class="settings-desc">Choose which notifications you want to receive.</p>

        <label class="settings-row clickable">
          <div class="settings-row-label">
            <span data-lucide="heart"></span>
            <span>Likes on my posts</span>
          </div>
          <input type="checkbox" name="notif_likes" class="toggle-checkbox" <?= $currentNotifLikes === "1" ? "checked" : "" ?> />
          <span class="toggle-track">
            <span class="toggle-thumb"></span>
          </span>
        </label>

        <label class="settings-row clickable">
          <div class="settings-row-label">
            <span data-lucide="message-circle"></span>
            <span>Comments on my posts</span>
          </div>
          <input type="checkbox" name="notif_comments" class="toggle-checkbox" <?= $currentNotifComments === "1" ? "checked" : "" ?> />
          <span class="toggle-track">
            <span class="toggle-thumb"></span>
          </span>
        </label>

        <label class="settings-row clickable">
          <div class="settings-row-label">
            <span data-lucide="tag"></span>
            <span>New deals nearby</span>
          </div>
          <input type="checkbox" name="notif_deals" class="toggle-checkbox" <?= $currentNotifDeals === "1" ? "checked" : "" ?> />
          <span class="toggle-track">
            <span class="toggle-thumb"></span>
          </span>
        </label>
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
