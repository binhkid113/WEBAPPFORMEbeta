<?php
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/includes/auth.php";

$checks = [];

function add_check(&$checks, $label, $ok, $message)
{
    $checks[] = [
        "label" => $label,
        "ok" => $ok,
        "message" => $message
    ];
}

add_check($checks, "PHP version", version_compare(PHP_VERSION, "8.0.0", ">="), "Current PHP: " . PHP_VERSION);

try {
    $pdo = db();
    add_check($checks, "Database connection", true, "Connected to MySQL database.");

    foreach (["users", "stores"] as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE " . $pdo->quote($table));
        $exists = (bool) $stmt->fetch();
        add_check(
            $checks,
            "Table: " . $table,
            $exists,
            $exists ? "Ready." : "Missing. Import database.sql in phpMyAdmin."
        );
    }
} catch (Throwable $error) {
    add_check($checks, "Database connection", false, "Not connected. Check MAMP MySQL and includes/config.php.");
}

$currentPage = "setup";
$pageTitle = "Otoku Circle - Setup Check";

require_once __DIR__ . "/includes/header.php";
?>

<div class="screen">
  <div class="screen-heading">
    <div>
      <h2>Setup check</h2>
      <p>Use this page after importing the database in phpMyAdmin.</p>
    </div>
  </div>

  <section class="panel">
    <div class="panel-title">
      <h3>MAMP status</h3>
      <small>Local test</small>
    </div>
    <div class="check-list">
      <?php foreach ($checks as $check) : ?>
        <div class="check-item <?= $check["ok"] ? "ok" : "fail" ?>">
          <span data-lucide="<?= $check["ok"] ? "check-circle-2" : "circle-alert" ?>"></span>
          <div>
            <strong><?= e($check["label"]) ?></strong>
            <p><?= e($check["message"]) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <div class="button-row">
    <a class="ghost-button" href="index.php"><span data-lucide="home"></span> Home</a>
    <a class="primary-button" href="register.php"><span data-lucide="user-plus"></span> Test register</a>
  </div>
</div>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
