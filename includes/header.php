<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($pageTitle ?? APP_NAME); ?></title>
    <link rel="stylesheet" href="/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Flash message styles */
        .flash-message {
            padding: 12px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .flash-message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .flash-message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .flash-message.warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }
        .flash-message.info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="/index.php" class="logo">
                <i class="fas fa-shopping-bag"></i>
                Otoku Circle
            </a>
            
            <div class="nav-links">
                <?php if (isLoggedIn()): ?>
                    <a href="/search.php"><i class="fas fa-search"></i> Search</a>
                    <a href="/nearby.php"><i class="fas fa-map-marker-alt"></i> Nearby</a>
                    <a href="/notifications.php">
                        <i class="fas fa-bell"></i>
                        <?php 
                        // Show notification count (to be implemented)
                        // $unreadCount = getUnreadNotificationCount();
                        // if ($unreadCount > 0): ?>
                        <!-- <span class="badge"><?php echo $unreadCount; ?></span> -->
                        <?php // endif; ?>
                    </a>
                    <a href="/create.php" class="btn-primary"><i class="fas fa-plus"></i> Post Deal</a>
                    
                    <div class="user-menu">
                        <a href="/profile.php" class="user-avatar">
                            <?php 
                            $currentUser = getCurrentUser();
                            if ($currentUser && $currentUser['avatar']): 
                            ?>
                                <img src="<?php echo e($currentUser['avatar']); ?>" alt="Avatar">
                            <?php else: ?>
                                <i class="fas fa-user"></i>
                            <?php endif; ?>
                        </a>
                        <a href="/logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i></a>
                    </div>
                <?php else: ?>
                    <a href="/login.php" class="btn-secondary">Login</a>
                    <a href="/register.php" class="btn-primary">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="container">
        <?php 
        $flash = getFlashMessage();
        if ($flash['message']): 
        ?>
            <div class="flash-message <?php echo e($flash['type']); ?>">
                <?php if ($flash['type'] === 'success'): ?>
                    <i class="fas fa-check-circle"></i>
                <?php elseif ($flash['type'] === 'error'): ?>
                    <i class="fas fa-exclamation-circle"></i>
                <?php elseif ($flash['type'] === 'warning'): ?>
                    <i class="fas fa-exclamation-triangle"></i>
                <?php else: ?>
                    <i class="fas fa-info-circle"></i>
                <?php endif; ?>
                <?php echo e($flash['message']); ?>
            </div>
        <?php endif; ?>
