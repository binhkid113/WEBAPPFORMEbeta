<?php
require_once __DIR__ . "/includes/data.php";
require_once __DIR__ . "/includes/functions.php";

$currentPage = "create";
$pageTitle = "Otoku Circle - Create Post";

require_once __DIR__ . "/includes/header.php";
?>

<div class="screen">
  <div class="screen-heading">
    <div>
      <h2>Create a post</h2>
      <p>Post a photo, write a text tip, or combine both. Keep it simple for new arrivals.</p>
    </div>
  </div>

  <form class="form-panel" action="#" method="post" enctype="multipart/form-data">
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
      <input id="post-title" name="title" type="text" placeholder="Example: 50% off salmon at AEON" />
    </div>

    <div class="field">
      <label for="post-body">Description in English</label>
      <textarea id="post-body" name="description" placeholder="Explain what the kanji sign means, where the shelf is, and when the deal ends."></textarea>
    </div>

    <div class="form-grid">
      <div class="field">
        <label for="store-name">Place name</label>
        <input id="store-name" name="store_name" type="text" placeholder="AEON Takamatsu" />
      </div>
      <div class="field">
        <label for="saving">Estimated saving</label>
        <input id="saving" name="saving" type="text" placeholder="¥480" />
      </div>
    </div>

    <div class="form-grid">
      <div class="field">
        <label for="tag">Useful tag</label>
        <select id="tag" name="tag">
          <option>#kanji-help</option>
          <option>#halal</option>
          <option>#vegetarian</option>
          <option>#night-deal</option>
          <option>#beginner</option>
        </select>
      </div>
      <div class="field">
        <label for="expires">Deal status</label>
        <select id="expires" name="expires">
          <option>Ends tonight</option>
          <option>Today only</option>
          <option>This week</option>
          <option>Useful daily tip</option>
        </select>
      </div>
    </div>

    <p class="form-help">
      Clear posts help new arrivals shop with more confidence.
      If this place is not listed yet, you can <a href="create_store.php">add it as a community place</a>.
    </p>

    <div class="button-row">
      <a class="ghost-button" href="index.php"><span data-lucide="x"></span> Cancel</a>
      <button class="primary-button" type="submit"><span data-lucide="send"></span> Publish preview</button>
    </div>
  </form>
</div>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
