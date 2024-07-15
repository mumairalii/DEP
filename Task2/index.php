<?php
include 'config.php';

// Fetch all posts
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>My Blog</h1>
        <a href="create.php" class="btn">Create New Post</a>
        
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="post">
                <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                <p class="meta">Posted on <?php echo $row['created_at']; ?></p>
                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn">Edit</a>
                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
