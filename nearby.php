<?php
require_once __DIR__ . "/includes/data.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/includes/auth.php";

$currentPage = "nearby";
$pageTitle = "Otoku Circle - Community Places";
$communityStores = $stores;

try {
    $stmt = db()->query(
        "SELECT stores.*, users.username
         FROM stores
         JOIN users ON users.id = stores.user_id
         ORDER BY stores.created_at DESC"
    );
    $savedStores = $stmt->fetchAll();

    if ($savedStores) {
        $communityStores = array_map(function ($store) {
            return [
                "name" => $store["name"],
                "area" => $store["area"] ?: "Unknown area",
                "station" => $store["nearest_station"] ?: "Landmark not added",
                "deals" => "Community place",
                "distance" => "",
                "pin" => strtoupper(substr($store["name"], 0, 1)),
                "tone" => "",
                "created_by" => $store["username"],
                "note" => $store["visit_note"] ?: "No note added yet.",
                "verified" => $store["visited_at_label"] ?: "User visited"
            ];
        }, $savedStores);
    }
} catch (Throwable $error) {
    $communityStores = $stores;
}

require_once __DIR__ . "/includes/header.php";
?>

<div class="screen">
  <div class="screen-heading">
    <div>
      <h2>Community places</h2>
      <p>Stores are created by users after they visit. This is community information, not official supermarket data.</p>
    </div>
    <a class="status-pill" href="create_store.php"><span data-lucide="plus"></span> Add place</a>
  </div>

  <section class="map-panel">
    <div class="map-canvas">
      <div class="map-route"></div>
      <button class="pin mint" style="left: 18%; top: 24%;" data-label="A" type="button" aria-label="AEON pin"></button>
      <button class="pin sky" style="left: 64%; top: 35%;" data-label="M" type="button" aria-label="Marunaka pin"></button>
      <button class="pin amber" style="left: 42%; top: 64%;" data-label="Y" type="button" aria-label="YouMe Town pin"></button>
      <button class="pin" style="left: 75%; top: 68%;" data-label="F" type="button" aria-label="Fuji Grand pin"></button>
    </div>
    <div class="store-list">
      <?php foreach ($communityStores as $store) : ?>
        <div class="store-card community-store-card">
          <div>
            <strong><?= e($store["name"]) ?></strong>
            <span><?= e($store["area"]) ?> - <?= e($store["station"]) ?></span>
            <p><?= e($store["note"]) ?></p>
            <div class="tag-row">
              <span class="tiny-pill green"><?= e($store["verified"]) ?></span>
              <span class="tiny-pill">Added by <?= e($store["created_by"]) ?></span>
              <span class="tiny-pill"><?= e($store["deals"]) ?></span>
            </div>
          </div>
          <span class="tiny-pill green"><?= e($store["pin"]) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="panel">
    <div class="panel-title">
      <h3>How place data works</h3>
      <small>UGC model</small>
    </div>
    <p class="panel-copy">
      The app does not collect official store data. Users add practical notes from real visits,
      and posts gradually build a useful place list for the community.
    </p>
  </section>

  <section class="post-list">
    <?php foreach (array_slice($posts, 0, 3) as $post) : ?>
      <?php render_post_row($post); ?>
    <?php endforeach; ?>
  </section>
</div>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
