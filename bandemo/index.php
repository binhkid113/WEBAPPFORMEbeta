<?php
/**
 * DEMO CROWDSOURCING DATA - BANDemo
 * Hiển thị dữ liệu do người dùng upload thay vì lấy từ API siêu thị
 * 
 * File này chỉ để demo, không ảnh hưởng đến file cũ
 */

// Mock data: Dữ liệu giả lập như thể đã có người dùng upload
$mock_posts = [
    [
        'id' => 1,
        'user_id' => 1,
        'username' => 'TokyoLife',
        'store_name' => 'Aeon Mall Makuhari',
        'store_chain' => 'Aeon',
        'description' => 'Huge sale on fresh fruits! Apples only 98 yen per piece. Valid until Sunday.',
        'image_url' => 'https://placehold.co/600x400/ff6b6b/white?text=Aeon+Flyer+50%25+OFF',
        'latitude' => 35.6472,
        'longitude' => 140.0344,
        'address' => '1 Chome-4-1 Toyosuna, Koto City, Tokyo',
        'likes' => 24,
        'comments_count' => 5,
        'created_at' => '2 hours ago',
        'tags' => ['Fruits', 'Fresh Food', 'Weekend Sale']
    ],
    [
        'id' => 2,
        'user_id' => 2,
        'username' => 'OsakaFoodie',
        'store_name' => 'Ito Yokado Umeda',
        'store_chain' => 'Ito Yokado',
        'description' => 'Bento boxes half price after 7 PM! Great deal for dinner.',
        'image_url' => 'https://placehold.co/600x400/4ecdc4/white?text=Bento+50%25+OFF+After+7PM',
        'latitude' => 34.7024,
        'longitude' => 135.4959,
        'address' => '1-1-3 Shibata, Kita Ward, Osaka',
        'likes' => 42,
        'comments_count' => 12,
        'created_at' => '4 hours ago',
        'tags' => ['Bento', 'Evening Deal', 'Dinner']
    ],
    [
        'id' => 3,
        'user_id' => 3,
        'username' => 'KyotoExplorer',
        'store_name' => 'Life Supermarket Kawaramachi',
        'store_chain' => 'Life',
        'description' => 'Imported cheese and wine on sale! Perfect for weekend party.',
        'image_url' => 'https://placehold.co/600x400/ffe66d/black?text=Wine+%26+Cheese+Sale',
        'latitude' => 35.0047,
        'longitude' => 135.7681,
        'address' => 'Nakagyo Ward, Kyoto',
        'likes' => 18,
        'comments_count' => 3,
        'created_at' => '6 hours ago',
        'tags' => ['Imported', 'Wine', 'Cheese', 'Party']
    ],
    [
        'id' => 4,
        'user_id' => 4,
        'username' => 'YokatoMom',
        'store_name' => 'Summit Store Minato Mirai',
        'store_chain' => 'Summit',
        'description' => 'Baby products bundle deal! Buy 3 get 1 free on diapers and baby food.',
        'image_url' => 'https://placehold.co/600x400/95e1d3/black?text=Baby+Products+Buy3Get1',
        'latitude' => 35.4546,
        'longitude' => 139.6317,
        'address' => '2-2-1 Minatomirai, Nishi Ward, Yokohama',
        'likes' => 56,
        'comments_count' => 18,
        'created_at' => '8 hours ago',
        'tags' => ['Baby', 'Bundle Deal', 'Family']
    ],
    [
        'id' => 5,
        'user_id' => 5,
        'username' => 'SapporoSnow',
        'store_name' => 'Seicomart Susukino',
        'store_chain' => 'Seicomart',
        'description' => 'Hot sweets (chukai) fresh from store! Limited quantity every evening.',
        'image_url' => 'https://placehold.co/600x400/ff9ff3/black?text=Fresh+Chukai+Sweets',
        'latitude' => 43.0554,
        'longitude' => 141.3524,
        'address' => 'Minami 4 Jo Nishi, Chuo Ward, Sapporo',
        'likes' => 31,
        'comments_count' => 7,
        'created_at' => '1 day ago',
        'tags' => ['Sweets', 'Fresh', 'Limited', 'Hokkaido']
    ]
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otoku Circle - Crowdsourcing Demo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        .info-box {
            background: rgba(255,255,255,0.95);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .info-box h2 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        .info-box ul {
            list-style: none;
            padding-left: 0;
        }

        .info-box li {
            padding: 8px 0;
            color: #333;
            display: flex;
            align-items: center;
        }

        .info-box li i {
            margin-right: 10px;
            color: #667eea;
        }

        .posts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .post-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
        }

        .post-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            position: relative;
        }

        .post-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ff6b6b;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
        }

        .post-content {
            padding: 20px;
        }

        .store-info {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }

        .store-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 12px;
            font-size: 1.2rem;
        }

        .store-details h3 {
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 3px;
        }

        .store-details p {
            color: #666;
            font-size: 0.85rem;
        }

        .post-description {
            color: #555;
            line-height: 1.5;
            margin-bottom: 15px;
            font-size: 0.95rem;
        }

        .tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 15px;
        }

        .tag {
            background: #f0f0f0;
            color: #666;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.75rem;
        }

        .post-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .post-stats {
            display: flex;
            gap: 15px;
        }

        .stat {
            display: flex;
            align-items: center;
            color: #666;
            font-size: 0.9rem;
        }

        .stat i {
            margin-right: 5px;
        }

        .stat.likes { color: #ff6b6b; }
        .stat.comments { color: #4ecdc4; }

        .post-time {
            color: #999;
            font-size: 0.85rem;
        }

        .cta-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .cta-section h2 {
            color: #667eea;
            margin-bottom: 15px;
        }

        .cta-section p {
            color: #666;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .btn-demo {
            display: inline-block;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 15px 40px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-demo:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }

        .comparison {
            margin-top: 40px;
            background: rgba(255,255,255,0.95);
            border-radius: 15px;
            padding: 25px;
        }

        .comparison h2 {
            color: #667eea;
            margin-bottom: 20px;
            text-align: center;
        }

        .comparison-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .comparison-item {
            padding: 20px;
            border-radius: 10px;
        }

        .comparison-item.old {
            background: #ffe5e5;
            border-left: 4px solid #ff6b6b;
        }

        .comparison-item.new {
            background: #e5ffea;
            border-left: 4px solid #4ecdc4;
        }

        .comparison-item h3 {
            margin-bottom: 15px;
            font-size: 1.2rem;
        }

        .comparison-item.old h3 { color: #c0392b; }
        .comparison-item.new h3 { color: #27ae60; }

        .comparison-item ul {
            list-style: none;
        }

        .comparison-item li {
            padding: 8px 0;
            display: flex;
            align-items: center;
        }

        .comparison-item li i {
            margin-right: 10px;
        }

        .old li i { color: #e74c3c; }
        .new li i { color: #2ecc71; }

        @media (max-width: 768px) {
            .posts-grid {
                grid-template-columns: 1fr;
            }
            
            .comparison-grid {
                grid-template-columns: 1fr;
            }
            
            .header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1><i class="fas fa-users"></i> Otoku Circle - Crowdsourcing Demo</h1>
            <p>Dữ liệu do cộng đồng người dùng đóng góp - Không cần xin phép siêu thị</p>
        </div>

        <!-- Info Box -->
        <div class="info-box">
            <h2><i class="fas fa-lightbulb"></i> Ý Tưởng Crowdsourcing</h2>
            <ul>
                <li><i class="fas fa-check-circle"></i> <strong>User-generated content:</strong> Người dùng tự chụp ảnh flyer và upload lên</li>
                <li><i class="fas fa-check-circle"></i> <strong>Không phụ thuộc bên thứ 3:</strong> Không cần API hay sự cho phép từ siêu thị</li>
                <li><i class="fas fa-check-circle"></i> <strong>Cộng đồng phát triển:</strong> Càng nhiều người dùng, càng nhiều dữ liệu giá trị</li>
                <li><i class="fas fa-check-circle"></i> <strong>Real-time updates:</strong> Thông tin mới nhất từ chính người mua hàng</li>
                <li><i class="fas fa-check-circle"></i> <strong>Phù hợp demo tốt nghiệp:</strong> Thể hiện tư duy sản phẩm hiện đại</li>
            </ul>
        </div>

        <!-- Posts Grid -->
        <div class="posts-grid">
            <?php foreach ($mock_posts as $post): ?>
            <div class="post-card">
                <div style="position: relative;">
                    <img src="<?php echo htmlspecialchars($post['image_url']); ?>" 
                         alt="<?php echo htmlspecialchars($post['store_name']); ?>" 
                         class="post-image">
                    <span class="post-badge">
                        <i class="fas fa-fire"></i> Hot Deal
                    </span>
                </div>
                
                <div class="post-content">
                    <div class="store-info">
                        <div class="store-icon">
                            <i class="fas fa-store"></i>
                        </div>
                        <div class="store-details">
                            <h3><?php echo htmlspecialchars($post['store_name']); ?></h3>
                            <p><?php echo htmlspecialchars($post['store_chain']); ?> • <?php echo htmlspecialchars($post['address']); ?></p>
                        </div>
                    </div>
                    
                    <p class="post-description">
                        <?php echo htmlspecialchars($post['description']); ?>
                    </p>
                    
                    <div class="tags">
                        <?php foreach ($post['tags'] as $tag): ?>
                        <span class="tag"><?php echo htmlspecialchars($tag); ?></span>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="post-meta">
                        <div class="post-stats">
                            <span class="stat likes">
                                <i class="fas fa-heart"></i> <?php echo $post['likes']; ?>
                            </span>
                            <span class="stat comments">
                                <i class="fas fa-comment"></i> <?php echo $post['comments_count']; ?>
                            </span>
                        </div>
                        <span class="post-time">
                            <i class="far fa-clock"></i> <?php echo $post['created_at']; ?>
                        </span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- CTA Section -->
        <div class="cta-section">
            <h2><i class="fas fa-camera"></i> Bạn Thấy Ưu Đãi Nào Thú Vị?</h2>
            <p>
                Hãy chụp ảnh flyer giảm giá và chia sẻ với cộng đồng! 
                Mỗi bài đăng của bạn giúp tiết kiệm tiền cho hàng trăm người khác.
            </p>
            <a href="#" class="btn-demo">
                <i class="fas fa-plus-circle"></i> Upload Deal Ngay
            </a>
        </div>

        <!-- Comparison Section -->
        <div class="comparison">
            <h2><i class="fas fa-exchange-alt"></i> So Sánh Hai Phương Pháp</h2>
            <div class="comparison-grid">
                <div class="comparison-item old">
                    <h3><i class="fas fa-times-circle"></i> Cách Cũ (Lấy từ API Siêu Thị)</h3>
                    <ul>
                        <li><i class="fas fa-times"></i> Cần sự cho phép chính thức</li>
                        <li><i class="fas fa-times"></i> Phụ thuộc vào API bên thứ 3</li>
                        <li><i class="fas fa-times"></i> Khó triển khai cho demo</li>
                        <li><i class="fas fa-times"></i> Dữ liệu có thể không cập nhật</li>
                        <li><i class="fas fa-times"></i> Vấn đề pháp lý phức tạp</li>
                    </ul>
                </div>
                
                <div class="comparison-item new">
                    <h3><i class="fas fa-check-circle"></i> Cách Mới (Crowdsourcing)</h3>
                    <ul>
                        <li><i class="fas fa-check"></i> Không cần xin phép ai cả</li>
                        <li><i class="fas fa-check"></i> Hoàn toàn tự chủ dữ liệu</li>
                        <li><i class="fas fa-check"></i> Dễ triển khai, phù hợp demo</li>
                        <li><i class="fas fa-check"></i> Dữ liệu real-time từ người dùng</li>
                        <li><i class="fas fa-check"></i> Xây dựng cộng đồng bền vững</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
