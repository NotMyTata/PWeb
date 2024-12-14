<?php

session_start();
include("../config.php");

$id = $_SESSION['current_id'];

$active_tag = 'All';
$active_search = '';

if(isset($_GET['reset'])){
    $active_tag = 'All';
    $active_search = '';
}
else if(isset($_GET['search'])){
    $active_tag = $_GET['tag'];
    $active_search = $_GET['searchbox'];
}

if($active_tag != 'All' && $active_search == ''){
    $sql = "SELECT * FROM blog b WHERE b.published = true AND b.author_id != '$id' AND b.tag = '$active_tag' ORDER BY b.posted_date DESC";
} else if($active_tag == 'All' && $active_search != '') {
    $sql = "SELECT * FROM blog b WHERE b.published = true AND b.author_id != '$id' AND b.title LIKE '%$active_search%' ORDER BY b.posted_date DESC";
}else if ($active_tag != 'All' && $active_search != ''){
    $sql = "SELECT * FROM blog b WHERE b.published = true AND b.author_id != '$id' AND b.tag = '$active_tag' AND b.title LIKE '%$active_search%' ORDER BY b.posted_date DESC";
}else {
    $sql = "SELECT * FROM blog b WHERE b.published = true AND b.author_id != '$id' ORDER BY b.posted_date DESC";
}
$result = mysqli_query($db, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore</title>
    <link href="../bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../styles.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../images/ic_logo.svg">
    <style>
        .card{
            align-items: start;
            width: 600px;
        }
        .blog-title, .blog-desc{
            padding-left: 10px;
        }
        a{
            text-decoration: none;
        }
        .blog-title a{
            font-size: x-large;
            font-weight: bold;
        }
        .blog-title{
            vertical-align: bottom;
        }
        .blog-desc{
            vertical-align: top;
        }
    </style>
</head>
<body>
    <header class="py-2 px-4 shadow">
        <nav class="navbar">
            <a href='../home/home_page.html'>
                <img src="../images/ic_logo.svg" height="30">
            </a>

            <div class="d-flex">
                <p class="h4 me-4"><a href='../home/home_page.php' class="text-decoration-none text-inactive">Home</a></p>
                <p class="h4"><a href='explore_page.php' class="text-decoration-none text-active">Explore</a></p>
            </div>

            <div class="d-flex">
                <img class="me-1" src="../images/ic_profile.svg" height="30">
                <a class="text-decoration-none text-black" href="../login/logout.php">Log out</a>
            </div>
        </nav>
    </header>
    <main class="d-flex flex-column justify-content-center align-items-center px-4">
        <!--TODO add search logic-->
        <form action="explore_page.php" method="get" class="search-filter py-4">
        <p class="h3 text-center">Filter Blogs</p>
        <div class="form-row d-flex py-2">
                <div class="form-group col-md-4 me-2">
                    <select class="form-select" id="tag" name="tag" required>
                        <option value="All" <?php echo ($active_tag == 'All'? 'selected' : '') ?>>All</option>
                        <option value="Food" <?php echo ($active_tag == 'Food'? 'selected' : '') ?>>Food</option>
                        <option value="Travel" <?php echo ($active_tag == 'Travel'? 'selected' : '') ?>>Travel</option>
                        <option value="Sport" <?php echo ($active_tag == 'Sport'? 'selected' : '') ?>>Sport</option>
                        <option value="Tech" <?php echo ($active_tag == 'Tech'? 'selected' : '') ?>>Tech</option>
                        <option value="Game" <?php echo ($active_tag == 'Game'? 'selected' : '') ?>>Game</option>
                        <option value="Life" <?php echo ($active_tag == 'Life'? 'selected' : '') ?>>Life</option>
                    </select>
                </div>
                <div class="form-group col-md-8">
                    <input class="form-control" type="search" id="searchbox" name="searchbox" placeholder="Search here..." value="<?php echo $active_search?>">
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2">
                <button class="btn btn-outline-primary" type="submit" name="reset">Reset</button>
                <p class="h6">Found queries: <?php echo mysqli_num_rows($result) ?></p>
                <button class="btn btn-primary" type="submit" name="search">Search</button>
            </div>
        </form>


        <div class="d-flex justify-content-center flex-wrap query-blogs w-100">
            <?php

            while($blog = mysqli_fetch_array($result)){
                $author_id = $blog['author_id'];
                $sql = "SELECT * FROM blogger WHERE id = '$author_id'";
                $query = mysqli_query($db, $sql);
                $blogger = mysqli_fetch_array($query);

                $blog_id = $blog['id'];
                $sql = "SELECT * FROM liked_blog WHERE blog_id='$blog_id'";
                $query = mysqli_query($db, $sql);
                $likes = mysqli_num_rows($query);

                echo "<div class='me-4 mb-4 card'>
                <table class='text-start'>
                <tr>
                    <td rowspan='2'>
                        <img src='../images/thumbnail/".$blog['thumbnail']."' width='100' height='100'>
                    </td>
                    <td class='blog-title'>
                        <a href='../blog_page.php?id=".$blog['id']."'>".$blog['title']."</a>
                    </td>
                </tr>
                <tr>
                    <td class='blog-desc'>
                        <a>
                        <img class='ms-2 me-1' src='../images/ic_profile.svg' height='10'>".$blogger['username']."  
                        <img class='ms-2 me-1' src='../images/ic_date.svg' height='10'>". $blog['posted_date']." 
                        <img class='ms-2 me-1' src='../images/ic_tag.svg' height='10'>".$blog['tag']." 
                        <img class='ms-2 me-1' src='../images/ic_like.svg' height='10'>$likes
                        <img class='ms-2 me-1' src='../images/ic_view.svg' height='10'>".$blog['views']."
                        </a>
                    </td>
                </tr>
                </table>
                </div>";
            }
            
            ?>
        </div>
    </main>
</body>
</html>

