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

function load_db_posts(): array
{
    try {
        $stmt = db()->query(
            "SELECT posts.*, users.username, users.avatar AS user_avatar
             FROM posts
             JOIN users ON users.id = posts.user_id
             ORDER BY posts.created_at DESC
             LIMIT 20"
        );
        $rows = $stmt->fetchAll();

        if (!$rows) {
            return [];
        }

        return array_map(function ($row) {
            $likesStmt = db()->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ?");
            $likesStmt->execute([$row["id"]]);
            $likeCount = (int) $likesStmt->fetchColumn();

            $commentsStmt = db()->prepare("SELECT COUNT(*) FROM comments WHERE post_id = ?");
            $commentsStmt->execute([$row["id"]]);
            $commentCount = (int) $commentsStmt->fetchColumn();

            $avatar = $row["user_avatar"] ?? strtoupper(substr($row["username"], 0, 1));
            $age = time_ago($row["created_at"]);

            return [
                "id"          => (int) $row["id"],
                "type"        => $row["type"] ?: "text",
                "title"       => $row["title"],
                "description" => $row["description"] ?? "",
                "store"       => $row["store_name"] ?? "",
                "distance"    => "",
                "time"        => $age,
                "expires"     => $row["expires"] ?? "Active",
                "saving"      => $row["saving"] ?? "",
                "image"       => $row["image_path"] ?? "",
                "author"      => $row["username"],
                "avatar"      => $avatar,
                "badge"       => "",
                "likes"       => $likeCount,
                "comments"    => $commentCount,
                "viewers"     => 0,
                "tags"        => $row["tag"] ? [$row["tag"]] : [],
                "comments_list" => load_comments_for_post((int) $row["id"]),
            ];
        }, $rows);
    } catch (Throwable $e) {
        return [];
    }
}

function load_comments_for_post(int $postId): array
{
    try {
        $stmt = db()->prepare(
            "SELECT comments.body, users.username AS name
             FROM comments
             JOIN users ON users.id = comments.user_id
             WHERE comments.post_id = ?
             ORDER BY comments.created_at ASC
             LIMIT 20"
        );
        $stmt->execute([$postId]);
        $rows = $stmt->fetchAll();

        return array_map(function ($row) {
            return ["name" => $row["name"], "copy" => $row["body"]];
        }, $rows);
    } catch (Throwable $e) {
        return [];
    }
}

function filter_mock_posts(array $posts, string $query): array
{
    if ($query === "") {
        return $posts;
    }

    $q = strtolower($query);

    return array_values(array_filter($posts, function ($post) use ($q) {
        $haystack = strtolower(
            $post["title"] . " " .
            $post["description"] . " " .
            $post["store"] . " " .
            implode(" ", $post["tags"] ?? [])
        );
        return str_contains($haystack, $q);
    }));
}

function time_ago(string $datetime): string
{
    $now = time();
    $then = strtotime($datetime);
    $diff = $now - $then;

    if ($diff < 60) {
        return "Just now";
    }
    if ($diff < 3600) {
        $m = (int) floor($diff / 60);
        return $m . " min ago";
    }
    if ($diff < 86400) {
        $h = (int) floor($diff / 3600);
        return $h . " hr ago";
    }
    if ($diff < 172800) {
        return "Yesterday";
    }

    $d = (int) floor($diff / 86400);
    return $d . " days ago";
}
