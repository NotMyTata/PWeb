<?php
session_start();
include('../config.php');

if(!isset($_SESSION['current_id'])){
    die('Unknown user');
} else {
    $id = $_SESSION['current_id'];
    $sql = "SELECT * FROM blogger br JOIN blog b ON (br.id = b.author_id) WHERE br.id = '$id'";
    $result = mysqli_query($db, $sql);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="../bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../styles.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../images/ic_logo.svg">
</head>
<body>
    <header class="py-2 px-4 shadow">
        <nav class="navbar">
            <a href='#'>
                <img src="../images/ic_logo.svg" height="30">
            </a>

            <div class="d-flex">
                <p class="h4 me-4"><a href='#' class="text-decoration-none text-active">Home</a></p>
                <p class="h4"><a href='../explore/explore_page.php' class="text-decoration-none text-inactive">Explore</a></p>
            </div>

            <div class="d-flex">
                <img class="me-1" src="../images/ic_profile.svg" height="30">
                <a class="text-decoration-none text-black" href="../login/logout.php">Log out</a>
            </div>
        </nav>
    </header>


    <main class="d-flex">
        <div class="left-side p-4 h-100 w-50">
            <div class="your-blogs">
                <div class="d-flex justify-content-between py-2">
                    <p class="h4">Your Blogs</p>
                    <a class="btn btn-primary" href="blog_editor_page.html">Make Blog</a>
                </div>   
                <?php 
                while($blog = mysqli_fetch_array($result)){
                    echo "<div class='card'>
                    <table class='text-start'>
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
                            <p>".($blog['published'] == 1? 'Published' : 'Drafted') ." | ". $blog['posted_date']." | ".$blog['tag']." | Liked: 12 | Views: ".$blog['views']." | <a href='blog_editor_edit_page.php?id=".$blog['id']."'>Edit</a> | <a href='delete_blog.php?id=".$blog['id']."'>Delete</a></p>
                        </td>
                    </tr>
                    </table>
                    </div>";
                }
                ?>
            </div>
        </div>


        <div class="right-side p-4 h-50 w-50">
            <div class="your-statistics h-50 w-100 py-2">
                <p class="h4">Your Statistics</p>
                <table class="table table-striped-columns">
                    <!--TODO connect this with db & php-->
                    <tbody>
                        <tr>
                            <td>Total Blogs</td>
                            <?php

                            echo "<td>";
                            
                            $sql = "SELECT * FROM blogger br JOIN blog b ON (br.id = b.author_id) WHERE br.id = '$id'";
                            $result = mysqli_query($db, $sql);

                            $count = mysqli_num_rows($result);
                            echo $count;

                            echo "</td>";
                            ?>
                            <td>Majority Tag</td>
                            <?php

                            echo "<td>";
                            
                            $sql = "SELECT b.tag, COUNT(*) as total FROM blogger br JOIN blog b ON (br.id = b.author_id) 
                            WHERE br.id = '$id' GROUP BY b.tag ORDER BY total DESC LIMIT 1";
                            $result = mysqli_query($db, $sql);

                            if(mysqli_num_rows($result) > 0){
                                $row = mysqli_fetch_array($result);
                                echo $row['tag'];
                            } else {
                                echo 'None';
                            }

                            echo "</td>";

                            ?>
                        </tr>
                        <tr>
                            <td>Total Likes</td>
                            <?php

                            echo "<td>";
                            
                            $sql = "SELECT * FROM blogger br JOIN blog b ON (br.id = b.author_id) JOIN liked_blog lb ON (b.id = lb.blog_id) WHERE br.id = '$id'";
                            $result = mysqli_query($db, $sql);

                            $count = mysqli_num_rows($result);
                            echo $count;

                            echo "</td>";
                            ?>
                            <td>Most Liked Blog</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>Total Views</td>
                            <td>0</td>
                            <td>Most Viewed Blog</td>
                            <td>0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
    
            
            <div class="your-liked-blogs h-50 w-100 py-2">
                <p class="h4">Your Liked Blogs</p>
            </div>
        </div>
    </main>
</body>
</html>

