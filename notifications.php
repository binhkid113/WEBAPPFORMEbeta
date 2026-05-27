<?php
require_once __DIR__ . "/includes/data.php";
require_once __DIR__ . "/includes/functions.php";

$currentPage = "notifications";
$pageTitle = "Otoku Circle - Notifications";

require_once __DIR__ . "/includes/header.php";
?>

<div class="screen">
  <div class="screen-heading">
    <div>
      <h2>Notifications</h2>
      <p>Keep users returning with likes, comments, and nearby deal alerts.</p>
    </div>
  </div>

  <div class="notification-list">
    <?php foreach ($notifications as $item) : ?>
      <article class="notification-item <?= $item["unread"] ? "unread" : "" ?>">
        <span class="icon-button"><span data-lucide="<?= e($item["icon"]) ?>"></span></span>
        <div class="notification-copy">
          <strong><?= e($item["title"]) ?></strong>
          <p><?= e($item["copy"]) ?></p>
        </div>
        <span class="tiny-pill"><?= e($item["time"]) ?></span>
      </article>
    <?php endforeach; ?>
  </div>
</div>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
