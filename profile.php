<?php
require_once __DIR__ . "/includes/data.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/includes/auth.php";

$currentPage = "profile";
$pageTitle = "Otoku Circle - Profile";
$user = current_user();
$displayName = $user["username"] ?? "Guest";
$displayAvatar = $user["avatar"] ?? "?";
$displayEmail = $user["email"] ?? "Log in to see your profile";

$postCount = 0;
$totalSaved = "¥0";
$helpfulVotes = 0;
$savedPosts = [];

if ($user) {
    try {
        $stmt = db()->prepare("SELECT COUNT(*) FROM posts WHERE user_id = ?");
        $stmt->execute([$user["id"]]);
        $postCount = (int) $stmt->fetchColumn();

        $stmt = db()->prepare("SELECT COUNT(*) FROM likes WHERE post_id IN (SELECT id FROM posts WHERE user_id = ?)");
        $stmt->execute([$user["id"]]);
        $helpfulVotes = (int) $stmt->fetchColumn();

        $stmt = db()->prepare(
            "SELECT posts.*, users.username, users.avatar AS user_avatar
             FROM bookmarks
             JOIN posts ON posts.id = bookmarks.post_id
             JOIN users ON users.id = posts.user_id
             WHERE bookmarks.user_id = ?
             ORDER BY bookmarks.created_at DESC
             LIMIT 10"
        );
        $stmt->execute([$user["id"]]);
        $bookmarkedRows = $stmt->fetchAll();

        $savedPosts = array_map(function ($row) {
            return [
                "id"          => (int) $row["id"],
                "type"        => $row["type"] ?: "text",
                "title"       => $row["title"],
                "description" => $row["description"] ?? "",
                "store"       => $row["store_name"] ?? "",
                "distance"    => "",
                "time"        => time_ago($row["created_at"]),
                "expires"     => $row["expires"] ?? "Active",
                "saving"      => $row["saving"] ?? "",
                "image"       => $row["image_path"] ?? "",
                "author"      => $row["username"],
                "avatar"      => $row["user_avatar"] ?? strtoupper(substr($row["username"], 0, 1)),
                "tags"        => $row["tag"] ? [$row["tag"]] : [],
            ];
        }, $bookmarkedRows);
    } catch (Throwable $e) {
        $savedPosts = [];
    }
}

if (!$savedPosts) {
    $savedPosts = array_slice($posts, 0, 3);
}

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
      <div><strong><?= e((string) $postCount) ?></strong><span>Posts</span></div>
      <div><strong><?= e($totalSaved) ?></strong><span>Total saved</span></div>
      <div><strong><?= e((string) $helpfulVotes) ?></strong><span>Helpful votes</span></div>
    </div>
    <div class="tag-row">
      <span class="tiny-pill green">Trusted helper</span>
      <span class="tiny-pill">#kanji-help</span>
      <span class="tiny-pill">#budget-life</span>
    </div>
    <div class="button-row">
      <?php if ($user) : ?>
        <a class="ghost-button" href="settings.php"><span data-lucide="settings"></span> Settings</a>
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
      <?php foreach ($savedPosts as $post) : ?>
        <?php render_post_row($post); ?>
      <?php endforeach; ?>
    </div>
  </section>
</div>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
