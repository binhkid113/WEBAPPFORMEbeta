<?php
/**
 * Data Access Layer & Helper Functions
 * This file provides database helper functions used across the application
 */

require_once __DIR__ . '/db.php';

/**
 * Get database connection (alias for getDB())
 */
function db() {
    return getDB();
}

/**
 * Redirect to another page
 */
function redirect_to($page) {
    header("Location: " . $page);
    exit;
}

/**
 * Generate error message for auth/database errors
 */
function auth_error_message($error) {
    if ($error instanceof PDOException) {
        // Database error
        if ($error->getCode() === '23000') {
            return "Duplicate entry detected. Please use a different username or email.";
        }
        return "Database error occurred. Please try again later.";
    }
    
    // Generic error
    return "An unexpected error occurred. Please try again.";
}

/**
 * Get all posts with user and store info
 */
function getAllPosts($limit = 20, $offset = 0) {
    $db = db();
    $stmt = $db->prepare("
        SELECT 
            p.*,
            u.username,
            u.avatar,
            s.name as store_name,
            s.area,
            s.nearest_station
        FROM posts p
        LEFT JOIN users u ON p.user_id = u.id
        LEFT JOIN stores s ON p.store_id = s.id
        ORDER BY p.created_at DESC
        LIMIT ? OFFSET ?
    ");
    $stmt->execute([$limit, $offset]);
    return $stmt->fetchAll();
}

/**
 * Get single post by ID
 */
function getPostById($id) {
    $db = db();
    $stmt = $db->prepare("
        SELECT 
            p.*,
            u.username,
            u.avatar,
            s.name as store_name,
            s.area,
            s.nearest_station,
            s.latitude,
            s.longitude
        FROM posts p
        LEFT JOIN users u ON p.user_id = u.id
        LEFT JOIN stores s ON p.store_id = s.id
        WHERE p.id = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

/**
 * Get comments for a post
 */
function getCommentsByPostId($postId) {
    $db = db();
    $stmt = $db->prepare("
        SELECT 
            c.*,
            u.username,
            u.avatar
        FROM comments c
        LEFT JOIN users u ON c.user_id = u.id
        WHERE c.post_id = ?
        ORDER BY c.created_at ASC
    ");
    $stmt->execute([$postId]);
    return $stmt->fetchAll();
}

/**
 * Get all stores
 */
function getAllStores($limit = 50) {
    $db = db();
    $stmt = $db->prepare("
        SELECT 
            s.*,
            u.username as owner_username
        FROM stores s
        LEFT JOIN users u ON s.user_id = u.id
        ORDER BY s.created_at DESC
        LIMIT ?
    ");
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}

/**
 * Get store by ID
 */
function getStoreById($id) {
    $db = db();
    $stmt = $db->prepare("
        SELECT 
            s.*,
            u.username as owner_username
        FROM stores s
        LEFT JOIN users u ON s.user_id = u.id
        WHERE s.id = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

/**
 * Get all tags
 */
function getAllTags() {
    $db = db();
    $stmt = $db->query("SELECT * FROM tags ORDER BY name ASC");
    return $stmt->fetchAll();
}

/**
 * Check if user has liked a post
 */
function hasUserLikedPost($userId, $postId) {
    $db = db();
    $stmt = $db->prepare("SELECT id FROM likes WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$userId, $postId]);
    return $stmt->fetch() !== false;
}

/**
 * Check if user has bookmarked a post
 */
function hasUserBookmarkedPost($userId, $postId) {
    $db = db();
    $stmt = $db->prepare("SELECT id FROM bookmarks WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$userId, $postId]);
    return $stmt->fetch() !== false;
}

/**
 * Get unread notification count for user
 */
function getUnreadNotificationCount($userId) {
    $db = db();
    $stmt = $db->prepare("SELECT COUNT(*) as count FROM notifications WHERE user_id = ? AND is_read = 0");
    $stmt->execute([$userId]);
    $result = $stmt->fetch();
    return $result['count'] ?? 0;
}

/**
 * Search posts by keyword
 */
function searchPosts($keyword, $limit = 20) {
    $db = db();
    $searchTerm = "%{$keyword}%";
    $stmt = $db->prepare("
        SELECT 
            p.*,
            u.username,
            u.avatar,
            s.name as store_name
        FROM posts p
        LEFT JOIN users u ON p.user_id = u.id
        LEFT JOIN stores s ON p.store_id = s.id
        WHERE p.title LIKE ? OR p.description LIKE ?
        ORDER BY p.created_at DESC
        LIMIT ?
    ");
    $stmt->execute([$searchTerm, $searchTerm, $limit]);
    return $stmt->fetchAll();
}

/**
 * Get posts by user ID
 */
function getPostsByUserId($userId, $limit = 20) {
    $db = db();
    $stmt = $db->prepare("
        SELECT 
            p.*,
            s.name as store_name
        FROM posts p
        LEFT JOIN stores s ON p.store_id = s.id
        WHERE p.user_id = ?
        ORDER BY p.created_at DESC
        LIMIT ?
    ");
    $stmt->execute([$userId, $limit]);
    return $stmt->fetchAll();
}

/**
 * Get user's bookmarked posts
 */
function getBookmarkedPosts($userId, $limit = 20) {
    $db = db();
    $stmt = $db->prepare("
        SELECT 
            p.*,
            u.username,
            s.name as store_name,
            b.created_at as bookmarked_at
        FROM bookmarks b
        JOIN posts p ON b.post_id = p.id
        LEFT JOIN users u ON p.user_id = u.id
        LEFT JOIN stores s ON p.store_id = s.id
        WHERE b.user_id = ?
        ORDER BY b.created_at DESC
        LIMIT ?
    ");
    $stmt->execute([$userId, $limit]);
    return $stmt->fetchAll();
}
