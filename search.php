<?php
require_once __DIR__ . "/includes/data.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/includes/auth.php";

$currentPage = "search";
$pageTitle = "Otoku Circle - Search";
$query = trim($_GET["q"] ?? $_GET["tag"] ?? "");
$results = [];

if ($query !== "") {
    try {
        $searchTerm = "%" . $query . "%";
        $stmt = db()->prepare(
            "SELECT posts.*, users.username, users.avatar AS user_avatar
             FROM posts
             JOIN users ON users.id = posts.user_id
             WHERE posts.title LIKE ?
                OR posts.description LIKE ?
                OR posts.store_name LIKE ?
                OR posts.tag LIKE ?
             ORDER BY posts.created_at DESC
             LIMIT 30"
        );
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        $rows = $stmt->fetchAll();

        $results = array_map(function ($row) {
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
        }, $rows);
    } catch (Throwable $e) {
        $results = [];
    }
}

if (!$results) {
    $results = filter_mock_posts($posts, $query);
}

require_once __DIR__ . "/includes/header.php";
?>

<div class="screen">
  <div class="screen-heading">
    <div>
      <h2>Search deals</h2>
      <p>Find food, shops, tags, or kanji-help posts.</p>
    </div>
  </div>

  <form class="search-box" action="search.php" method="get">
    <span data-lucide="search"></span>
    <input type="search" name="q" value="<?= e($query) ?>" placeholder="Search milk, bento, halal, AEON..." />
  </form>

  <div class="chip-row">
    <?php foreach (["#kanji-help", "#halal", "#vegetarian", "#night-deal", "#beginner"] as $tag) : ?>
      <a class="chip <?= $query === $tag ? "active" : "" ?>" href="search.php?q=<?= e(urlencode($tag)) ?>"><?= e($tag) ?></a>
    <?php endforeach; ?>
  </div>

  <?php if ($query !== "" && empty($results)) : ?>
    <div class="empty-note">No results found for "<?= e($query) ?>".</div>
  <?php endif; ?>

  <section class="post-list">
    <?php foreach ($results as $post) : ?>
      <?php render_post_row($post); ?>
    <?php endforeach; ?>
  </section>
</div>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
