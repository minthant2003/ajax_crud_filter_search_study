<?php
    include '../db_config.php';

    $name = $_POST['name'];
    $age = $_POST['age'];
    $major = $_POST['major'];

    $sql = "INSERT INTO students(Name, Age, Major) VALUES(?,?,?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sis', $name, $age, $major);
    mysqli_stmt_execute($stmt);

    mysqli_close($conn);
?>