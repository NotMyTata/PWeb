<?php
session_start();
include('../config.php');

if(!isset($_SESSION['current_id'])){
    die('Unknown user');
} else {
    $user_id = $_SESSION['current_id'];
    $sql = "SELECT * FROM blogger br JOIN blog b ON (br.id = b.author_id) WHERE br.id = '$user_id'";
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
    <style>
        .card{
            align-items: start;
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
        .blog-img img{
            height: 100px;
            width: 100px;
        }
        main .left-side, main .right-side{
            width: 50%;
        }
        @media (max-width: 375px){
            header .logo{
                display: none;
            }
        }
        @media (max-width: 768px) {
            main{
                flex-direction: column;
            }
            main .left-side, main .right-side{
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header class="py-2 px-4 shadow">
        <nav class="navbar">
            <a href='#'>
                <img class="logo" src="../images/ic_logo.svg" height="30">
            </a>

            <div class="d-flex">
                <p class="h4 me-4"><a href='home_page.php' class="text-decoration-none text-active">Home</a></p>
                <p class="h4"><a href='../explore/explore_page.php' class="text-decoration-none text-inactive">Explore</a></p>
            </div>

            <div class="d-flex">
                <img class="me-1" src="../images/ic_profile.svg" height="30">
                <a class="text-decoration-none text-black" href="../login/logout.php">Log out</a>
            </div>
        </nav>
    </header>


    <main class="d-flex">
        <div class="left-side p-4 h-100">
            <div class="your-blogs">
                <div class="d-flex justify-content-between py-2">
                    <p class="h4">Your Blogs</p>
                    <a class="btn btn-primary" href="blog_editor_page.html">Make Blog</a>
                </div>   
                <?php 
                while($blog = mysqli_fetch_array($result)){
                    $author_id = $blog['author_id'];
                    $blog_id = $blog['id'];
                    $sql = "SELECT * FROM blog b JOIN liked_blog lb ON (b.id = lb.blog_id) WHERE b.id = '$blog_id'";
                    $data = mysqli_query($db, $sql);
                    $likes = mysqli_num_rows($data);

                    echo "<div class='mb-3 card'>
                    <table class='text-start'>
                    <tr>
                        <td class='blog-img' rowspan='2'>
                            <img src='../images/thumbnail/user_blog/$author_id/".$blog['thumbnail']."'
                        </td>
                        <td class='blog-title'>
                            <a href='../blog_page.php?id=".$blog['id']."'>".$blog['title']."</a>
                        </td>
                    </tr>
                    <tr>
                        <td class='blog-desc'>
                            <div class='d-flex flex-wrap'>
                            ".($blog['published'] == 1? 'Published' : 'Drafted') ."
                            <div class='mx-2 align-items-baseline'><img class='me-1' src='../images/ic_date.svg' height='10'>". $blog['posted_date']."</div>
                            <div class='mx-2 align-items-baseline'><img class='me-1' src='../images/ic_tag.svg' height='10'>".$blog['tag']."</div>
                            <div class='mx-2 align-items-baseline'><img class='me-1' src='../images/ic_like.svg' height='10'>".$likes."</div>
                            <div class='mx-2 align-items-baseline'><img class='me-1' src='../images/ic_view.svg' height='10'>".$blog['views']."</div> 
                            <a class='mx-2' href='blog_editor_edit_page.php?id=".$blog['id']."'>Edit</a>
                            <a href='delete_blog.php?id=".$blog['id']."'>Delete</a>
                            </div>
                        </td>
                    </tr>
                    </table>
                    </div>";
                }
                ?>
            </div>
        </div>


        <div class="right-side p-4 h-100">
            <div class="your-statistics h-50 w-100 py-2">
                <p class="h4">Your Statistics</p>
                <table class="table table-striped-columns">
                    <!--TODO connect this with db & php-->
                    <tbody>
                        <tr>
                            <td>Total Blogs</td>
                            <?php
                            echo "<td>";
                            $sql = "SELECT * FROM blogger br JOIN blog b ON (br.id = b.author_id) WHERE br.id = '$user_id'";
                            $result = mysqli_query($db, $sql);
                            $count = mysqli_num_rows($result);
                            echo $count;
                            echo "</td>";
                            ?>

                            <td>Majority Tag</td>
                            <?php
                            echo "<td>";
                            $sql = "SELECT b.tag, COUNT(*) as total FROM blogger br JOIN blog b ON (br.id = b.author_id) 
                            WHERE br.id = '$user_id' GROUP BY b.tag ORDER BY total DESC LIMIT 1";
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
                            $sql = "SELECT * FROM blogger br JOIN blog b ON (br.id = b.author_id) JOIN liked_blog lb ON (b.id = lb.blog_id) WHERE br.id = '$user_id'";
                            $result = mysqli_query($db, $sql);
                            $count = mysqli_num_rows($result);
                            echo $count;
                            echo "</td>";
                            ?>

                            <td>Most Liked</td>
                            <?php
                            echo "<td>";
                            $sql = "SELECT COUNT(*) as total, blog_id FROM liked_blog JOIN blog b ON (blog_id = b.id) WHERE author_id = '$user_id' GROUP BY blog_id ORDER BY total DESC LIMIT 1";
                            $result = mysqli_query($db, $sql);
                            $exist = mysqli_num_rows($result);
                            if($exist){
                                $count = mysqli_fetch_array($result);
                                echo $count['total'];
                            } else {
                                echo 0;
                            }
                            echo "</td>";
                            ?>
                        </tr>
                        <tr>
                            <td>Total Views</td>
                            <?php
                            echo "<td>";
                            $sql = "SELECT views FROM blog b WHERE b.author_id ='$user_id'";
                            $result = mysqli_query($db, $sql);
                            if(mysqli_num_rows($result) > 0){
                                $count = 0;
                                while($row = mysqli_fetch_array($result)){
                                    $count += $row['views'];
                                }
                                echo $count;
                            } else {
                                echo 0;
                            }
                            echo "</td>";
                            ?>

                            <td>Most Viewed</td>
                            <?php
                            echo "<td>";
                            $sql = "SELECT b.views as highest FROM blog b WHERE b.author_id='$user_id' ORDER BY highest DESC LIMIT 1";
                            $result = mysqli_query($db, $sql);
                            if(mysqli_num_rows($result) > 0){
                                $count = mysqli_fetch_array( $result);
                                echo $count['highest'];
                            } else {
                                echo 0;
                            }
                            echo "</td>";
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
    
            
            <div class="your-liked-blogs h-50 w-100 py-2">
                <p class="h4">Your Liked Blogs</p>
                <?php 
                $sql = "SELECT * FROM liked_blog JOIN blog ON (blog_id = id) WHERE user_id = '$user_id' ORDER BY title ASC";
                $result = mysqli_query($db, $sql);
                while($blog = mysqli_fetch_array($result)){
                    $author_id = $blog['author_id'];
                    $blog_id = $blog['id'];
                    $sql = "SELECT * FROM blog b JOIN liked_blog lb ON (b.id = lb.blog_id) WHERE b.id = '$blog_id'";
                    $query = mysqli_query($db, $sql);
                    $likes = mysqli_num_rows($query);
                    
                    $sql = "SELECT * FROM blogger br JOIN blog b ON (br.id = b.author_id) WHERE b.id = '$blog_id'";
                    $query = mysqli_query($db, $sql);
                    $blogger = mysqli_fetch_array($query);

                    echo "<div class='mb-3 card'>
                    <table class='text-start'>
                    <tr>
                        <td class='blog-img' rowspan='2'>
                            <img src='../images/thumbnail/user_blog/$author_id/".$blog['thumbnail']."'>
                        </td>
                        <td class='blog-title'>
                            <a href='../blog_page.php?id=".$blog['id']."'>".$blog['title']."</a>
                        </td>
                    </tr>
                    <tr>
                        <td class='blog-desc'>
                            <div class='d-flex flex-wrap'>
                            <div class='mx-2 align-items-baseline'><img class='me-1' src='../images/ic_profile.svg' height='10'>".$blogger['username']."</div>
                            <div class='mx-2 align-items-baseline'><img class='me-1' src='../images/ic_date.svg' height='10'>". $blog['posted_date']."</div>
                            <div class='mx-2 align-items-baseline'><img class='me-1' src='../images/ic_tag.svg' height='10'>".$blog['tag']."</div>
                            <div class='mx-2 align-items-baseline'><img class='me-1' src='../images/ic_like.svg' height='10'>$likes</div>
                            <div class='mx-2 align-items-baseline'><img class='me-1' src='../images/ic_view.svg' height='10'>".$blog['views']."</div>
                            </div>
                        </td>
                    </tr>
                    </table>
                    </div>";
                }
                ?>
            </div>
        </div>
    </main>
</body>
</html>

