<?php
require_once __DIR__ . "/includes/data.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/includes/auth.php";

$currentPage = "create";
$pageTitle = "Otoku Circle - Create Post";
$errors = [];
$currentUser = current_user();
$values = [
    "title"       => "",
    "description" => "",
    "store_name"  => "",
    "saving"      => "",
    "tag"         => "#kanji-help",
    "expires"     => "Ends tonight",
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!verify_csrf()) {
        $errors[] = "Invalid form submission. Please try again.";
    }

    foreach ($values as $key => $default) {
        $values[$key] = trim($_POST[$key] ?? $default);
    }

    if (!$currentUser) {
        $errors[] = "Please log in before creating a post.";
    }

    if ($values["title"] === "") {
        $errors[] = "Post title is required.";
    }

    if ($values["description"] === "") {
        $errors[] = "Description is required.";
    }

    $imagePath = null;
    $postType = "text";

    if (!empty($_FILES["image"]["name"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $allowed = ["image/jpeg", "image/png", "image/gif", "image/webp"];
        $mime = mime_content_type($_FILES["image"]["tmp_name"]);

        if (!in_array($mime, $allowed, true)) {
            $errors[] = "Only JPEG, PNG, GIF, or WebP images are allowed.";
        } elseif ($_FILES["image"]["size"] > 5 * 1024 * 1024) {
            $errors[] = "Image must be smaller than 5 MB.";
        } else {
            $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $filename = uniqid("post_", true) . "." . strtolower($ext);
            $destination = __DIR__ . "/uploads/" . $filename;

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $destination)) {
                $imagePath = "uploads/" . $filename;
                $postType = "image";
            } else {
                $errors[] = "Failed to save the uploaded image.";
            }
        }
    }

    if (!$errors && $currentUser) {
        try {
            $stmt = db()->prepare(
                "INSERT INTO posts (user_id, title, description, store_name, saving, tag, expires, image_path, type)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([
                $currentUser["id"],
                $values["title"],
                $values["description"],
                $values["store_name"],
                $values["saving"],
                $values["tag"],
                $values["expires"],
                $imagePath,
                $postType,
            ]);

            redirect_to("index.php");
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
      <h2>Create a post</h2>
      <p>Post a photo, write a text tip, or combine both. Keep it simple for new arrivals.</p>
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
      <p class="panel-copy">Only logged-in users can create posts, so each tip has a clear author.</p>
      <a class="primary-button" href="login.php"><span data-lucide="log-in"></span> Log in</a>
    </div>
  <?php endif; ?>

  <form class="form-panel" action="create.php" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <label class="upload-zone" for="post-image">
      <div>
        <span data-lucide="image-plus"></span>
        <strong>Add product or sale photo</strong>
        <span>Photos help others understand kanji labels, sale stickers, and shelf locations.</span>
      </div>
      <input id="post-image" class="visually-hidden" type="file" name="image" accept="image/*" />
    </label>

    <div class="field">
      <label for="post-title">Post title</label>
      <input id="post-title" name="title" type="text" value="<?= e($values["title"]) ?>" placeholder="Example: 50% off salmon at AEON" />
    </div>

    <div class="field">
      <label for="post-body">Description in English</label>
      <textarea id="post-body" name="description" placeholder="Explain what the kanji sign means, where the shelf is, and when the deal ends."><?= e($values["description"]) ?></textarea>
    </div>

    <div class="form-grid">
      <div class="field">
        <label for="store-name">Place name</label>
        <input id="store-name" name="store_name" type="text" value="<?= e($values["store_name"]) ?>" placeholder="AEON Takamatsu" />
      </div>
      <div class="field">
        <label for="saving">Estimated saving</label>
        <input id="saving" name="saving" type="text" value="<?= e($values["saving"]) ?>" placeholder="¥480" />
      </div>
    </div>

    <div class="form-grid">
      <div class="field">
        <label for="tag">Useful tag</label>
        <select id="tag" name="tag">
          <?php foreach (["#kanji-help", "#halal", "#vegetarian", "#night-deal", "#beginner"] as $option) : ?>
            <option <?= $values["tag"] === $option ? "selected" : "" ?>><?= e($option) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field">
        <label for="expires">Deal status</label>
        <select id="expires" name="expires">
          <?php foreach (["Ends tonight", "Today only", "This week", "Useful daily tip"] as $option) : ?>
            <option <?= $values["expires"] === $option ? "selected" : "" ?>><?= e($option) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <p class="form-help">
      Clear posts help new arrivals shop with more confidence.
      If this place is not listed yet, you can <a href="create_store.php">add it as a community place</a>.
    </p>

    <div class="button-row">
      <a class="ghost-button" href="index.php"><span data-lucide="x"></span> Cancel</a>
      <button class="primary-button" type="submit"><span data-lucide="send"></span> Publish post</button>
    </div>
  </form>
</div>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
