<?php

session_start();
include('config.php');
$blog_id = $_GET['id'];

// Increment current blog's views
$sql = "UPDATE blog SET views = views+1 WHERE id='$blog_id'";
$result = mysqli_query($db, $sql);

$sql = "SELECT * FROM blog WHERE id = '$blog_id'";
$result = mysqli_query($db, $sql);
$blog = mysqli_fetch_array($result);

$author_id = $blog['author_id'];
$sql = "SELECT * FROM blogger br JOIN blog b ON (br.id = b.author_id) WHERE br.id='$author_id'";
$result = mysqli_query($db, $sql);
$blogger = mysqli_fetch_array($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $blog['title'] ?></title>
    <link href="bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="images/ic_logo.svg">
</head>
<body class="p-4 d-flex flex-column align-items-center justify-content-center">
    <header class="d-flex align-items-center justify-content-between w-100">
        <div>
            <a class="text-decoration-none text-black" href="javascript:window.history.length > 1 ? history.back() : window.location='home_page.html'">
                <img src="images/ic_arrow.svg" height="10">
                Return
            </a>
        </div>
        <div>
        <?php
        $user_id = $_SESSION['current_id'];

        $sql = "SELECT * FROM blog WHERE author_id='$user_id' AND id='$blog_id'";
        $result = mysqli_query($db, $sql);

        if(mysqli_num_rows($result) == 0){
            $sql = "SELECT * FROM liked_blog WHERE user_id='$user_id' AND blog_id='$blog_id'";
            $result = mysqli_query($db, $sql);
            
            if(mysqli_num_rows($result) == 0){
                echo "<a class='btn btn-outline-primary' href='like_blog.php?id=".$blog['id']."&type=1'>Like Blog</a>";
            } else {
                echo "<a class='btn btn-outline-primary' href='like_blog.php?id=".$blog['id']."&type=0'>Unlike Blog</a>";
            }
        }
        ?>
        <a class="btn btn-outline-primary" href="blog_pdf.php?id=<?php echo $blog['id'] ?>">Download PDF</a>
        </div>
    </header>
    <main class="text-center py-2 px-4">
        <p class="h1"><?php echo $blog['title'] ?></p>
        <p class="h5"><?php echo 
        "<img class='ms-3 me-1' src='images/ic_profile.svg' height='10'>".$blogger['username'].
        "<img class='ms-3 me-1' src='images/ic_date.svg' height='10'>".$blog['posted_date'].
        "<img class='ms-3 me-1' src='images/ic_tag.svg' height='10'>".$blog['tag'] ?>
        <p class="mt-4 text-start"><?php echo $blog['content'] ?></p>
    </main>
</body>
</html>