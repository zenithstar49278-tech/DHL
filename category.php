<?php include 'config.php'; 
$cat = $_GET['cat'] ?? 'world';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>⚡ FlashPoint News - <?php echo ucfirst($cat); ?></title>
    <style>
        /* Premium Jet Black Theme with Color Hunt Palette */
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;500&display=swap');
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: #121212;
            color: #EEEEEE;
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
        .category-section {
            margin: 40px;
        }
        .articles {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }
        .article {
            background: #1a1a1a;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0,0,0,0.5);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .article:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 25px rgba(185,55,93,0.3);
        }
        .article img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 20px;
            filter: brightness(0.85);
            transition: filter 0.3s ease, transform 0.3s ease;
        }
        .article:hover img {
            filter: brightness(1);
            transform: scale(1.05);
        }
        .article h3 {
            margin: 0 0 15px;
            font-family: 'Playfair Display', serif;
            font-size: 2em;
            color: #B9375D;
        }
        .article p {
            color: #E7D3D3;
            font-size: 1.1em;
        }
        .article a {
            color: #D25D5D;
            text-decoration: none;
            font-weight: 600;
        }
        .article a:hover {
            color: #EEEEEE;
            text-decoration: underline;
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
            .articles { grid-template-columns: 1fr; }
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

    <section class="category-section">
        <h2><?php echo ucfirst($cat); ?> News</h2>
        <div class="articles">
            <?php
            $stmt = $pdo->prepare("SELECT * FROM articles WHERE category=? ORDER BY date DESC");
            $stmt->execute([$cat]);
            while ($article = $stmt->fetch()) {
                echo "<div class='article'>";
                echo "<img src='{$article['image']}' alt='{$article['title']}'>";
                echo "<h3>{$article['title']}</h3>";
                echo "<p>" . substr($article['content'], 0, 150) . "...</p>";
                echo "<a href='#' onclick=\"window.location.href='article.php?id={$article['id']}'; return false;\">Read Full Article</a>";
                echo "</div>";
            }
            ?>
        </div>
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
