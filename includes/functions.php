<?php

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

function avatar_tone(string $letter): string
{
    $tones = [
        "A" => "coral",
        "L" => "sky",
        "R" => "amber",
        "S" => "sky",
    ];

    return $tones[$letter] ?? "";
}

function find_post_by_id(array $posts, int $id): array
{
    foreach ($posts as $post) {
        if ($post["id"] === $id) {
            return $post;
        }
    }

    return $posts[0];
}

function render_thumb(array $post, int $selectedId): void
{
    $active = $post["id"] === $selectedId ? "active" : "";
    $href = "index.php?post=" . e((string) $post["id"]);

    echo '<a class="thumb-card ' . $active . '" href="' . $href . '">';

    if ($post["type"] === "image") {
        echo '<div class="thumb-image" style="background-image:url(\'' . e($post["image"]) . '\')"></div>';
    } else {
        echo '<div class="thumb-text-bg">TEXT</div>';
    }

    echo '<div class="thumb-body">';
    echo '<strong>' . e($post["title"]) . '</strong>';
    echo '<span>' . e($post["store"]) . '</span>';
    echo '</div>';
    echo '</a>';
}

function render_post_row(array $post): void
{
    $href = "post_detail.php?id=" . e((string) $post["id"]);

    echo '<a class="post-row" href="' . $href . '">';

    if ($post["type"] === "image") {
        echo '<div class="post-row-image" style="background-image:url(\'' . e($post["image"]) . '\')"></div>';
    } else {
        echo '<div class="post-row-image text-mini-card"><strong>TEXT</strong></div>';
    }

    echo '<div class="post-row-content">';
    echo '<span>' . e($post["store"]) . ' • ' . e($post["distance"]) . '</span>';
    echo '<h3>' . e($post["title"]) . '</h3>';
    echo '<p>' . e($post["description"]) . '</p>';
    echo '<div class="tag-row">';
    echo '<span class="tiny-pill green">' . e($post["saving"]) . '</span>';
    echo '<span class="tiny-pill">' . e($post["expires"]) . '</span>';
    echo '</div>';
    echo '</div>';
    echo '</a>';
}
