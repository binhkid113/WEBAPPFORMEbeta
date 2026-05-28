<?php
require_once __DIR__ . "/includes/data.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/includes/auth.php";

$currentPage = "detail";
$pageTitle = "Otoku Circle - Post Detail";
$postId = isset($_GET["id"]) ? (int) $_GET["id"] : 1;
$currentUser = current_user();
$commentErrors = [];

$dbPosts = load_db_posts();
$allPosts = $dbPosts ?: $posts;
$post = find_post_by_id($allPosts, $postId);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["comment_body"])) {
    if (!verify_csrf()) {
        $commentErrors[] = "Invalid form submission. Please try again.";
    }

    $commentBody = trim($_POST["comment_body"] ?? "");

    if (!$currentUser) {
        $commentErrors[] = "Please log in to comment.";
    } elseif ($commentBody === "") {
        $commentErrors[] = "Comment cannot be empty.";
    } else {
        try {
            $stmt = db()->prepare("INSERT INTO comments (post_id, user_id, body) VALUES (?, ?, ?)");
            $stmt->execute([$postId, $currentUser["id"], $commentBody]);
            redirect_to("post_detail.php?id=" . $postId);
        } catch (Throwable $error) {
            $commentErrors[] = auth_error_message($error);
        }
    }

    $dbPosts = load_db_posts();
    $allPosts = $dbPosts ?: $posts;
    $post = find_post_by_id($allPosts, $postId);
}

require_once __DIR__ . "/includes/header.php";
?>

<div class="screen">
  <div class="screen-heading">
    <div>
      <a class="ghost-button" href="index.php?post=<?= e((string) $post["id"]) ?>">
        <span data-lucide="arrow-left"></span> Back
      </a>
    </div>
    <span class="status-pill"><?= e($post["expires"]) ?></span>
  </div>

  <?php if ($post["type"] === "image" && !empty($post["image"])) : ?>
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
      <small><?= e($post["badge"] ?? "") ?></small>
    </div>
    <h2><?= e($post["title"]) ?></h2>
    <p class="hero-desc"><?= e($post["description"]) ?></p>
    <?php if (!empty($post["saving"])) : ?>
      <span class="saving-chip"><?= e($post["saving"]) ?></span>
    <?php endif; ?>
    <div class="meta-line">
      <span data-lucide="store"></span>
      <span><?= e($post["store"]) ?></span>
      <?php if (!empty($post["distance"])) : ?>
        <span>•</span>
        <span><?= e($post["distance"]) ?></span>
      <?php endif; ?>
      <span>•</span>
      <span><?= e($post["time"]) ?></span>
    </div>
    <div class="tag-row">
      <?php foreach ($post["tags"] ?? [] as $tag) : ?>
        <span class="tiny-pill"><?= e($tag) ?></span>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="panel">
    <div class="panel-title">
      <h3>Comments</h3>
      <small><?= e((string) ($post["comments"] ?? count($post["comments_list"] ?? []))) ?> total</small>
    </div>
    <div class="comment-box">
      <?php foreach ($post["comments_list"] ?? [] as $comment) : ?>
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

    <?php if ($commentErrors) : ?>
      <div class="alert error" style="margin-top: 10px;">
        <?php foreach ($commentErrors as $err) : ?>
          <p><?= e($err) ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if ($currentUser) : ?>
      <form class="form-panel" action="post_detail.php?id=<?= e((string) $postId) ?>" method="post" style="margin-top: 10px;">
        <?= csrf_field() ?>
        <div class="field">
          <label for="comment-body">Add a comment</label>
          <textarea id="comment-body" name="comment_body" placeholder="Share a tip or useful note..."></textarea>
        </div>
        <button class="primary-button" type="submit"><span data-lucide="message-circle"></span> Post comment</button>
      </form>
    <?php else : ?>
      <p class="form-help" style="margin-top: 10px;"><a href="login.php">Log in</a> to leave a comment.</p>
    <?php endif; ?>
  </section>
</div>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
