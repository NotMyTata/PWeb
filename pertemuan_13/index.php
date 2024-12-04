<?php include("config.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        main > *{
            margin-top: 5%;
        }
    </style>
</head>
<body class="d-flex flex-column justify-content-center align-items-center px-2 py-4">
    <main class="text-center">
        <p class="h2">Fuzzy High Active Students List</p>
        <table class="table table-striped shadow">
            <thead class="fw-bold">
                <tr>
                    <td scope="col">ID</td>
                    <td scope="col">Full Name</td>
                    <td scope="col">Gender</td>
                    <td scope="col">Date of Birth</td>
                    <td scope="col">School Email</td>
                    <td scope="col">Phone Number</td>
                    <td scope="col">Action</td>
                </tr>
            </thead>
            <tbody>
                <?php
                
                $sql = "SELECT * FROM student";
                $query = mysqli_query($db, $sql);

                while($student = mysqli_fetch_array($query) ){
                    echo "<tr>";

                    echo "<td>".$student["sid"]."</td>";
                    echo "<td>".$student["fname"]."</td>";
                    echo "<td>".$student["gender"]."</td>";
                    echo "<td>".$student["dob"]."</td>";
                    echo "<td>".$student["smail"]."</td>";
                    echo "<td>".$student["pnum"]."</td>";
                    echo "<td><a href='#'>Edit</a></td>";

                    echo "</tr>";
                }

                ?>
            </tbody>
        </table>
        <a href="fhasl-pdf.php" target="_blank" class="btn btn-primary">Download PDF</a>
    </main>
</body>
</html>