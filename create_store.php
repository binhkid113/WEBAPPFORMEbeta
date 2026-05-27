<?php
require_once __DIR__ . "/includes/data.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/includes/auth.php";

$currentPage = "nearby";
$pageTitle = "Otoku Circle - Add Community Place";
$errors = [];
$success = false;
$currentUser = current_user();
$values = [
    "store_name" => "",
    "area" => "",
    "station" => "",
    "visit_note" => "",
    "visited_at" => "Today",
    "help_tag" => "#kanji-help"
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach ($values as $key => $default) {
        $values[$key] = trim($_POST[$key] ?? $default);
    }

    if (!$currentUser) {
        $errors[] = "Please log in before adding a community place.";
    }

    if ($values["store_name"] === "") {
        $errors[] = "Place name is required.";
    }

    if ($values["area"] === "") {
        $errors[] = "Area or city is required.";
    }

    if ($values["visit_note"] === "") {
        $errors[] = "Add a short note from your visit.";
    }

    if (!$errors) {
        try {
            $stmt = db()->prepare(
                "INSERT INTO stores (user_id, name, area, nearest_station, visit_note, visited_at_label, help_tag)
                 VALUES (?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([
                $currentUser["id"],
                $values["store_name"],
                $values["area"],
                $values["station"],
                $values["visit_note"],
                $values["visited_at"],
                $values["help_tag"]
            ]);

            redirect_to("nearby.php");
        } catch (Throwable $error) {
            $errors[] = auth_error_message($error);
        }
    }
}

require_once __DIR__ . "/includes/header.php";
?>

<div class="screen">
  <div class="screen-heading">
    <div>
      <h2>Add a place you visited</h2>
      <p>Only add practical information from your own shopping experience. No official store data is required.</p>
    </div>
  </div>

  <?php if ($errors) : ?>
    <div class="alert error">
      <?php foreach ($errors as $error) : ?>
        <p><?= e($error) ?></p>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?php if (!$currentUser) : ?>
    <div class="panel">
      <div class="panel-title">
        <h3>Login required</h3>
        <small>Community trust</small>
      </div>
      <p class="panel-copy">Only logged-in users can add places, so each store note has a clear author.</p>
      <a class="primary-button" href="login.php"><span data-lucide="log-in"></span> Log in</a>
    </div>
  <?php endif; ?>

  <form class="form-panel" action="create_store.php" method="post">
    <div class="field">
      <label for="store-name">Place name</label>
      <input id="store-name" name="store_name" type="text" value="<?= e($values["store_name"]) ?>" placeholder="Example: AEON Takamatsu" />
    </div>

    <div class="form-grid">
      <div class="field">
        <label for="area">Area / city</label>
        <input id="area" name="area" type="text" value="<?= e($values["area"]) ?>" placeholder="Takamatsu" />
      </div>
      <div class="field">
        <label for="station">Nearest station or landmark</label>
        <input id="station" name="station" type="text" value="<?= e($values["station"]) ?>" placeholder="Near Takamatsu Station" />
      </div>
    </div>

    <div class="field">
      <label for="visit-note">What should foreigners know?</label>
      <textarea id="visit-note" name="visit_note" placeholder="Example: Bento discounts usually start after 7 PM. Fish corner has red 50% stickers."><?= e($values["visit_note"]) ?></textarea>
    </div>

    <div class="form-grid">
      <div class="field">
        <label for="visited-at">When did you visit?</label>
        <select id="visited-at" name="visited_at">
          <?php foreach (["Today", "Yesterday", "This week", "This month"] as $option) : ?>
            <option <?= $values["visited_at"] === $option ? "selected" : "" ?>><?= e($option) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field">
        <label for="help-tag">Helpful for</label>
        <select id="help-tag" name="help_tag">
          <?php foreach (["#kanji-help", "#night-deal", "#halal", "#vegetarian", "#budget-life"] as $option) : ?>
            <option <?= $values["help_tag"] === $option ? "selected" : "" ?>><?= e($option) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <p class="form-help">This place is saved as community-created information, not as official supermarket data.</p>

    <div class="button-row">
      <a class="ghost-button" href="nearby.php"><span data-lucide="arrow-left"></span> Back</a>
      <button class="primary-button" type="submit"><span data-lucide="map-pin-plus"></span> Add place</button>
    </div>
  </form>
</div>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
