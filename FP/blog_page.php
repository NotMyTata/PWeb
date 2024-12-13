<?php

include('config.php');
$blog_id = $_GET['id'];

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
    <header>
        <a class="btn btn-outline-primary" href="#">Like Blog</a>
        <a class="btn btn-outline-primary" href="blog_pdf.php?id=<?php echo $blog['id'] ?>">Download PDF</a>
    </header>
    <main class="text-center py-2 px-4">
        <p class="h1"><?php echo $blog['title'] ?></p>
        <p class="h5"><?php echo $blogger['username']." | ".$blog['posted_date']." | ".$blog['tag'] ?>
        <p class="mt-4 text-start"><?php echo $blog['content'] ?></p>
    </main>
</body>
</html>