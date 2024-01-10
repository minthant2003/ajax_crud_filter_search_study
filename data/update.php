<?php
    include '../db_config.php';

    $id = $_POST['id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $major = $_POST['major'];

    $sql = "UPDATE students SET Name=?, Age=?, Major=? WHERE Student_ID=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sisi', $name, $age, $major, $id);
    mysqli_stmt_execute($stmt);

    mysqli_close($conn);
?>