<?php 
include 'config.php'; 
$id = $_GET['id'] ?? 0;
if ($id == 0) die('Invalid ID');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['user'] ?? 'Anonymous';
    $comment = $_POST['comment'] ?? '';
    if (!empty($comment)) {
        $stmt = $pdo->prepare("INSERT INTO comments (article_id, user_name, comment) VALUES (?, ?, ?)");
        $stmt->execute([$id, $user, $comment]);
    }
}

$stmt = $pdo->prepare("SELECT * FROM articles WHERE id=?");
$stmt->execute([$id]);
$article = $stmt->fetch();
if (!$article) die('Article not found');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $article['title']; ?> - ⚡ FlashPoint News</title>
    <style>
        /* Premium Jet Black Theme with Color Hunt Palette */
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;500&display=swap');
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: #121212;
            color: #EEEEEE;
            line-height: 1.9;
        }
        header {
            background: linear-gradient(90deg, #000000, #1a1a1a);
            color: #E7D3D3;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.6);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        header h1 {
            margin: 0;
            font-family: 'Playfair Display', serif;
            font-size: 3.5em;
            font-weight: 700;
            letter-spacing: 2px;
            color: #B9375D;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        nav ul li {
            margin: 0 20px;
        }
        nav ul li a {
            color: #D25D5D;
            text-decoration: none;
            font-weight: 500;
            font-size: 1.1em;
            transition: color 0.3s ease, transform 0.3s ease;
        }
        nav ul li a:hover {
            color: #E7D3D3;
            transform: scale(1.1);
        }
        .search-bar {
            display: flex;
            align-items: center;
            background: #1f1f1f;
            border-radius: 25px;
            padding: 5px;
            border: 1px solid #B9375D;
        }
        .search-bar input {
            background: transparent;
            border: none;
            color: #EEEEEE;
            padding: 10px;
            outline: none;
            width: 220px;
        }
        .search-bar button {
            background: #B9375D;
            color: #EEEEEE;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .search-bar button:hover {
            background: #D25D5D;
        }
        .article-content {
            max-width: 1000px;
            margin: 50px auto;
            padding: 40px;
            background: #1a1a1a;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.7);
        }
        .article-content img {
            width: 100%;
            height: 600px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 30px;
            filter: brightness(0.85);
            transition: filter 0.3s ease, transform 0.3s ease;
        }
        .article-content img:hover {
            filter: brightness(1);
            transform: scale(1.05);
        }
        .article-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3em;
            color: #B9375D;
            margin-bottom: 20px;
        }
        .meta {
            font-style: italic;
            color: #E7D3D3;
            margin-bottom: 30px;
            font-size: 1.1em;
        }
        .related {
            max-width: 1000px;
            margin: 50px auto;
        }
        .related h3 {
            font-family: 'Playfair Display', serif;
            border-bottom: 4px solid #D25D5D;
            padding-bottom: 15px;
            color: #B9375D;
            font-size: 2em;
        }
        .related-article {
            margin-bottom: 20px;
            background: #242424;
            padding: 15px;
            border-radius: 10px;
        }
        .related-article a {
            color: #D25D5D;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.3em;
        }
        .related-article a:hover {
            color: #EEEEEE;
        }
        .comments {
            max-width: 1000px;
            margin: 50px auto;
        }
        .comments h3 {
            font-family: 'Playfair Display', serif;
            border-bottom: 4px solid #D25D5D;
            padding-bottom: 15px;
            color: #B9375D;
            font-size: 2em;
        }
        .comment {
            background: #242424;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            color: #E7D3D3;
        }
        form {
            margin-top: 30px;
            background: #1f1f1f;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #B9375D;
        }
        form input, form textarea {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #333333;
            background: #282828;
            color: #EEEEEE;
            border-radius: 8px;
            font-family: 'Roboto', sans-serif;
        }
        form button {
            background: #B9375D;
            color: #EEEEEE;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s ease;
        }
        form button:hover {
            background: #D25D5D;
        }
        footer {
            background: #000000;
            color: #E7D3D3;
            text-align: center;
            padding: 20px;
            font-size: 1em;
            border-top: 2px solid #B9375D;
        }
        @media (max-width: 768px) {
            .article-content { padding: 20px; }
            .article-content img { height: 400px; }
            header { flex-direction: column; padding: 15px; }
            nav ul { flex-direction: column; text-align: center; }
            nav ul li { margin: 15px 0; }
            .search-bar input { width: 150px; }
        }
    </style>
</head>
<body>
    <header>
        <h1>⚡ FlashPoint News</h1>
        <nav>
            <ul>
                <li><a href="#" onclick="window.location.href='index.php'; return false;">Home</a></li>
                <li><a href="#" onclick="window.location.href='category.php?cat=world'; return false;">World</a></li>
                <li><a href="#" onclick="window.location.href='category.php?cat=sports'; return false;">Sports</a></li>
                <li><a href="#" onclick="window.location.href='category.php?cat=technology'; return false;">Technology</a></li>
                <li><a href="#" onclick="window.location.href='category.php?cat=entertainment'; return false;">Entertainment</a></li>
            </ul>
        </nav>
        <form class="search-bar" onsubmit="searchNews(); return false;">
            <input type="text" id="search-input" placeholder="Search FlashPoint News...">
            <button type="submit">Search</button>
        </form>
    </header>

    <section class="article-content">
        <h1><?php echo $article['title']; ?></h1>
        <div class="meta">By <?php echo $article['author']; ?> | <?php echo $article['date']; ?></div>
        <img src="<?php echo $article['image']; ?>" alt="<?php echo $article['title']; ?>">
        <p><?php echo nl2br($article['content']); ?></p>
    </section>

    <section class="related">
        <h3>Related Stories</h3>
        <?php
        $stmt = $pdo->prepare("SELECT * FROM articles WHERE category=? AND id != ? ORDER BY date DESC LIMIT 3");
        $stmt->execute([$article['category'], $id]);
        while ($rel = $stmt->fetch()) {
            echo "<div class='related-article'>";
            echo "<a href='#' onclick=\"window.location.href='article.php?id={$rel['id']}'; return false;\">{$rel['title']}</a>";
            echo "</div>";
        }
        ?>
    </section>

    <section class="comments">
        <h3>Comments</h3>
        <?php
        $stmt = $pdo->prepare("SELECT * FROM comments WHERE article_id=? ORDER BY date DESC");
        $stmt->execute([$id]);
        while ($comment = $stmt->fetch()) {
            echo "<div class='comment'>";
            echo "<strong>{$comment['user_name']}</strong> - {$comment['date']}<br>";
            echo $comment['comment'];
            echo "</div>";
        }
        ?>
        <form method="POST">
            <input type="text" name="user" placeholder="Your Name" required>
            <textarea name="comment" placeholder="Your Comment" required></textarea>
            <button type="submit">Post Comment</button>
        </form>
    </section>

    <footer>&copy; 2025 ⚡ FlashPoint News - All Rights Reserved</footer>

    <script>
        function searchNews() {
            const query = document.getElementById('search-input').value;
            window.location.href = `search.php?q=${encodeURIComponent(query)}`;
        }
    </script>
</body>
</html>
