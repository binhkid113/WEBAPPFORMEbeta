<?php
require_once __DIR__ . "/includes/data.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/includes/auth.php";

$currentPage = "profile";
$pageTitle = "Otoku Circle - Profile";
$user = current_user();
$displayName = $user["username"] ?? "Minh Nguyen";
$displayAvatar = $user["avatar"] ?? "M";
$displayEmail = $user["email"] ?? "New in Japan • Takamatsu • English/Vietnamese";

require_once __DIR__ . "/includes/header.php";
?>

<div class="screen">
  <section class="profile-hero">
    <div class="profile-top">
      <div class="profile-avatar"><?= e($displayAvatar) ?></div>
      <div>
        <h2><?= e($displayName) ?></h2>
        <p><?= e($displayEmail) ?></p>
      </div>
    </div>
    <div class="profile-stats">
      <div><strong>24</strong><span>Posts</span></div>
      <div><strong>¥12,840</strong><span>Total saved</span></div>
      <div><strong>148</strong><span>Helpful votes</span></div>
    </div>
    <div class="tag-row">
      <span class="tiny-pill green">Trusted helper</span>
      <span class="tiny-pill">#kanji-help</span>
      <span class="tiny-pill">#budget-life</span>
    </div>
    <div class="button-row">
      <?php if ($user) : ?>
        <a class="ghost-button" href="logout.php"><span data-lucide="log-out"></span> Log out</a>
      <?php else : ?>
        <a class="primary-button" href="login.php"><span data-lucide="log-in"></span> Log in</a>
        <a class="ghost-button" href="register.php"><span data-lucide="user-plus"></span> Register</a>
      <?php endif; ?>
    </div>
  </section>

  <section class="panel">
    <div class="panel-title">
      <h3>Saved posts</h3>
      <small>Useful later</small>
    </div>
    <div class="post-list">
      <?php foreach (array_slice($posts, 0, 3) as $post) : ?>
        <?php render_post_row($post); ?>
      <?php endforeach; ?>
    </div>
  </section>
</div>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
