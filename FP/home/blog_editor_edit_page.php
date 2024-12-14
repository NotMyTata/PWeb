<?php
session_start();
include("../config.php");

$id = $_SESSION['current_id'];
$blog_id = $_GET['id'];
$sql = "SELECT * FROM blog WHERE id = '$blog_id'";
$result = mysqli_query($db, $sql);
$blog = mysqli_fetch_array($result);

if($blog['author_id'] != $id){
    header('Location: home_page.php?status=failed');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Editor</title>
    <link href="../bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../styles.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../images/ic_logo.svg">
</head>
<body class="d-flex justify-content-center align-items-center">
    <main class="p-4">
        <p class="h2 text-center">Blog Editor</p>
        <form action="process_blog.php" method="post" class="card p-3">
            <input type="hidden" name="id" value="<?php echo $blog_id ?>">
            <div>
                <label class="form-label" for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" maxlength="50" value="<?php echo $blog['title'] ?>" required>
            </div>
            <div class="py-2">
                <label class="form-label" for="thumbnail">Thumbnail</label>
                <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept=".png, .jpg, .jpeg">
            </div>
            <div class="py-2">
                <label class="form-label" for="tag">Tag</label>
                <select class="form-select" id="tag" name="tag" required>
                <?php $tag = $blog['tag'] ?>
                    <option value="Food" <?php echo ($tag == 'Food')? "selected" : "" ?>>Food</option>
                    <option value="Travel" <?php echo ($tag == 'Travel')? "selected" : "" ?>>Travel</option>
                    <option value="Sport" <?php echo ($tag == 'Sport')? "selected" : "" ?>>Sport</option>
                    <option value="Tech" <?php echo ($tag == 'Tech')? "selected" : "" ?>>Tech</option>
                    <option value="Game" <?php echo ($tag == 'Game')? "selected" : "" ?>>Game</option>
                    <option value="Life" <?php echo ($tag == 'Life')? "selected" : "" ?>>Life</option>
                </select>
            </div>
            <div class="py-2">
                <div>
                    <label class="form-label" for="content">Content</label>
                    <textarea class="form-control" id="content" name="content" maxlength="10000" required><?php echo $blog['content'] ?></textarea>
                </div>
                <div>
                    <input type="checkbox" name="publish" value="publish" <?php echo $blog['published']? "checked" : "" ?>>
                    <label for="publish">Publish Blog</label>
                </div>
            </div>
            <div class="d-flex justify-content-between py-2">
                <a href="home_page.php" class="btn btn-outline-primary">Cancel</a>
                <button type="submit" class="btn btn-primary" name="edit" value="edit">Edit</button>
            </div>
        </form>
    </main>
</body>
</html>