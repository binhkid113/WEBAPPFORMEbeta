<?php
require_once __DIR__ . "/includes/data.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/includes/auth.php";

$currentPage = "home";
$pageTitle = "Otoku Circle - Home";

$dbPosts = load_db_posts();
$allPosts = $dbPosts ?: $posts;

$selectedId = isset($_GET["post"]) ? (int) $_GET["post"] : ($allPosts[0]["id"] ?? 1);
$selectedPost = find_post_by_id($allPosts, $selectedId);

require_once __DIR__ . "/includes/header.php";
?>

<div class="screen">
  <div class="screen-heading">
    <div>
      <h2>Deals from people near you</h2>
      <p>Photos, text tips, and quick notes from foreigners living in Japan.</p>
    </div>
    <span class="status-pill"><span data-lucide="map-pin"></span> Takamatsu</span>
  </div>

  <div class="chip-row">
    <?php foreach (["All", "Near me", "Text tips", "Photos", "Ending soon"] as $filter) : ?>
      <a class="chip <?= $filter === "All" ? "active" : "" ?>" href="search.php?tag=<?= e(urlencode($filter)) ?>"><?= e($filter) ?></a>
    <?php endforeach; ?>
  </div>

  <a
    class="hero-post <?= $selectedPost["type"] === "image" ? "image" : "text-only" ?>"
    href="post_detail.php?id=<?= e((string) $selectedPost["id"]) ?>"
    <?php if ($selectedPost["type"] === "image" && !empty($selectedPost["image"])) : ?>
      style="background-image:url('<?= e($selectedPost["image"]) ?>')"
    <?php endif; ?>
    aria-label="Open featured post"
  >
    <div class="hero-content">
      <div class="hero-top">
        <span class="deal-badge"><?= e($selectedPost["expires"]) ?></span>
        <span class="viewer-badge"><?= e((string) ($selectedPost["viewers"] ?? 0)) ?> viewing</span>
      </div>
      <div class="hero-bottom">
        <div class="author-line">
          <span class="avatar small <?= e(avatar_tone($selectedPost["avatar"])) ?>"><?= e($selectedPost["avatar"]) ?></span>
          <span><?= e($selectedPost["author"]) ?></span>
          <small><?= e($selectedPost["badge"] ?? "") ?></small>
        </div>
        <div>
          <h3 class="hero-title"><?= e($selectedPost["title"]) ?></h3>
          <p class="hero-desc"><?= e($selectedPost["description"]) ?></p>
        </div>
        <span class="saving-chip"><?= e($selectedPost["saving"] ?? "") ?></span>
        <div class="meta-line">
          <span data-lucide="store"></span>
          <span><?= e($selectedPost["store"]) ?></span>
          <span>•</span>
          <span><?= e($selectedPost["distance"] ?? "") ?></span>
          <span>•</span>
          <span><?= e($selectedPost["time"]) ?></span>
        </div>
        <div class="social-line">
          <span data-lucide="heart"></span><span><?= e((string) ($selectedPost["likes"] ?? 0)) ?></span>
          <span data-lucide="message-circle"></span><span><?= e((string) ($selectedPost["comments"] ?? 0)) ?></span>
          <span><?= e(implode(" ", array_slice($selectedPost["tags"] ?? [], 0, 2))) ?></span>
        </div>
      </div>
    </div>
  </a>

  <div class="thumb-grid">
    <?php foreach ($allPosts as $post) : ?>
      <?php render_thumb($post, $selectedPost["id"]); ?>
    <?php endforeach; ?>
  </div>

  <section class="panel">
    <div class="panel-title">
      <h3>Top helpers this week</h3>
      <small>Community trust</small>
    </div>
    <div class="leaderboard">
      <?php foreach ($leaders as $index => $leader) : ?>
        <div class="leader-row">
          <span class="rank"><?= e((string) ($index + 1)) ?></span>
          <div>
            <strong><?= e($leader["name"]) ?></strong>
            <span><?= e($leader["value"]) ?></span>
          </div>
          <span class="badge"><?= e($leader["badge"]) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
</div>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
