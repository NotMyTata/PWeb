<?php

session_start();
include("../config.php");

$id = $_SESSION['current_id'];
$active_tag = 'All';
$active_search = '';
if(isset($_GET['tag'])){
    $query_tag = $_GET['tag'];
    $query_search = $_GET['searchbox'];
    if($query_tag != 'All' && $query_search != ''){
        $sql = "SELECT * FROM blog b WHERE b.author_id != '$id' AND b.tag = '$query_tag' AND b.title LIKE '%$query_search%'";
    } else if($query_tag != 'All' && $query_search == ''){
        $sql = "SELECT * FROM blog b WHERE b.author_id != '$id' AND b.tag = '$query_tag'";
    } else if($query_tag == 'All' && $query_search != ''){
        $sql = "SELECT * FROM blog b WHERE b.author_id != '$id' AND b.title LIKE '%$query_search%'";
    } else {
        $sql = "SELECT * FROM blog b WHERE b.author_id != '$id'";
    }
    $active_tag = $query_tag;
    $active_search = $query_search;
} else {
    $sql = "SELECT * FROM blog b WHERE b.author_id != '$id'";
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
</head>
<body>
    <header class="py-2 px-4 shadow">
        <nav class="navbar">
            <a href='../home/home_page.html'>
                <img src="../images/ic_logo.svg" height="30">
            </a>

            <div class="d-flex">
                <p class="h4 me-4"><a href='../home/home_page.php' class="text-decoration-none text-inactive">Home</a></p>
                <p class="h4"><a href='#' class="text-decoration-none text-active">Explore</a></p>
            </div>

            <div class="d-flex">
                <img class="me-1" src="../images/ic_profile.svg" height="30">
                <a class="text-decoration-none text-black" href="../login/logout.php">Log out</a>
            </div>
        </nav>
    </header>
    <main class="d-flex flex-column justify-content-center align-items-center">
        <!--TODO add search logic-->
        <form action="explore_page.php" method="get" class="search-filter py-4">
            <p class="h6">Found queries: <?php echo mysqli_num_rows($result) ?></p>
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
            <div class="d-flex justify-content-between py-2">
                <button class="btn btn-outline-primary" type="reset">Reset</button>
                <button class="btn btn-primary" type="submit" name="search">Search</button>
            </div>
        </form>


        <div class="query-blogs">
            <?php

            while($blog = mysqli_fetch_array($result)){
                echo "<div class='py-2 px-4 mb-3 card'>
                <table class='text-start' cellpadding='6'>
                <tr>
                    <td rowspan='2'>
                        <img src='../images/thumbnail/".$blog['thumbnail']."' width='100' height='100'>
                    </td>
                    <td>
                        <p class='h4'><a href='../blog_page.php?id=".$blog['id']."'>".$blog['title']."</a></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>". $blog['posted_date']." | ".$blog['tag']." | Liked: 12 | Views: ".$blog['views']."</p>
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

