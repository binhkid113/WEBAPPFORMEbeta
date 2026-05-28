<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$currentPage = $currentPage ?? "home";
$pageTitle   = $pageTitle ?? "Otoku Circle";
$currentUser = $currentUser ?? (function_exists("current_user") ? current_user() : null);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= e($pageTitle) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800;900&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://images.unsplash.com" />
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>
    <div class="app-layout">
      <aside class="context-panel" aria-label="Project context">
        <div class="brand-lockup">
          <div class="brand-mark">O</div>
          <div>
            <p class="eyebrow">Community deals</p>
            <h1>Otoku Circle</h1>
          </div>
        </div>
        <p class="context-copy">
          A small English forum for foreigners in Japan to share supermarket discounts,
          useful product notes, and real shopping tips without needing to read every kanji sign.
        </p>
        <div class="mini-stat-grid">
          <div>
            <strong>28</strong>
            <span>Deals today</span>
          </div>
          <div>
            <strong>4</strong>
            <span>Languages</span>
          </div>
          <div>
            <strong>3 km</strong>
            <span>Nearby range</span>
          </div>
        </div>
        <div class="design-note">
          <span data-lucide="sparkles"></span>
          <p>Fresh deal tips from people who shop nearby and understand the same daily problems.</p>
        </div>
      </aside>

      <main class="phone-shell" aria-label="Otoku Circle web app">
        <header class="app-header">
          <?php if ($currentUser) : ?>
            <a class="icon-button" href="profile.php" aria-label="Open profile">
              <span class="avatar small"><?= e($currentUser["avatar"] ?? "U") ?></span>
            </a>
          <?php else : ?>
            <a class="icon-button" href="profile.php" aria-label="Open profile">
              <span class="avatar small">?</span>
            </a>
          <?php endif; ?>
          <div class="header-title">
            <span>Otoku Circle</span>
            <small>English deals near you</small>
          </div>
          <div class="header-actions">
            <button class="icon-button" type="button" data-action="toggle-theme" aria-label="Toggle theme">
              <span data-lucide="sun-moon"></span>
            </button>
            <?php if ($currentUser) : ?>
              <a class="icon-button notification-dot" href="notifications.php" aria-label="Open notifications">
                <span data-lucide="bell"></span>
              </a>
            <?php else : ?>
              <a class="auth-link" href="login.php">Log in</a>
            <?php endif; ?>
          </div>
        </header>

        <section class="screen-root" aria-live="polite">
