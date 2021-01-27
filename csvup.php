<?php
    require_once("csv.php");
    $csv = new csv();

    //import file 
    if(isset($_POST['submit'])){
        $csv->import($_FILES['file_name']['tmp_name']);
    }

    //export file
    if(isset($_POST['export'])){
        $csv->export();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Csv File Upload</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="file_name"><br><br>
        <input type="submit" name="submit" value="Import">  <br><br>
    </form>

    <form action="" method="post">
        <input type="submit" name="export" value="Export">
    </form>
</body>
</html>