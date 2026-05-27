<?php
require_once __DIR__ . "/includes/data.php";
require_once __DIR__ . "/includes/functions.php";

$currentPage = "search";
$pageTitle = "Otoku Circle - Search";
$query = $_GET["q"] ?? "";

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
      <a class="chip" href="search.php?q=<?= e(urlencode($tag)) ?>"><?= e($tag) ?></a>
    <?php endforeach; ?>
  </div>

  <section class="post-list">
    <?php foreach ($posts as $post) : ?>
      <?php render_post_row($post); ?>
    <?php endforeach; ?>
  </section>
</div>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
