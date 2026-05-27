<?php
require_once __DIR__ . "/includes/data.php";
require_once __DIR__ . "/includes/functions.php";

$currentPage = "detail";
$pageTitle = "Otoku Circle - Post Detail";
$postId = isset($_GET["id"]) ? (int) $_GET["id"] : 1;
$post = find_post_by_id($posts, $postId);

require_once __DIR__ . "/includes/header.php";
?>

<div class="screen">
  <div class="screen-heading">
    <div>
      <a class="ghost-button" href="index.php?post=<?= e($post["id"]) ?>">
        <span data-lucide="arrow-left"></span> Back
      </a>
    </div>
    <span class="status-pill"><?= e($post["expires"]) ?></span>
  </div>

  <?php if ($post["type"] === "image") : ?>
    <div class="detail-image" style="background-image:url('<?= e($post["image"]) ?>')"></div>
  <?php else : ?>
    <div class="detail-text-card">
      <h2><?= e($post["title"]) ?></h2>
      <p><?= e($post["description"]) ?></p>
    </div>
  <?php endif; ?>

  <section class="detail-body">
    <div class="author-line">
      <span class="avatar small <?= e(avatar_tone($post["avatar"])) ?>"><?= e($post["avatar"]) ?></span>
      <span><?= e($post["author"]) ?></span>
      <small><?= e($post["badge"]) ?></small>
    </div>
    <h2><?= e($post["title"]) ?></h2>
    <p class="hero-desc"><?= e($post["description"]) ?></p>
    <span class="saving-chip"><?= e($post["saving"]) ?></span>
    <div class="meta-line">
      <span data-lucide="store"></span>
      <span><?= e($post["store"]) ?></span>
      <span>•</span>
      <span><?= e($post["distance"]) ?></span>
      <span>•</span>
      <span><?= e($post["time"]) ?></span>
    </div>
    <div class="tag-row">
      <?php foreach ($post["tags"] as $tag) : ?>
        <span class="tiny-pill"><?= e($tag) ?></span>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="panel">
    <div class="panel-title">
      <h3>Comments</h3>
      <small><?= e($post["comments"]) ?> total</small>
    </div>
    <div class="comment-box">
      <?php foreach ($post["comments_list"] as $comment) : ?>
        <?php $initial = strtoupper(substr($comment["name"], 0, 1)); ?>
        <div class="comment-line">
          <span class="avatar small <?= e(avatar_tone($initial)) ?>"><?= e($initial) ?></span>
          <div>
            <strong><?= e($comment["name"]) ?></strong>
            <p><?= e($comment["copy"]) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
</div>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
