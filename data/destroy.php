<?php
    include '../db_config.php';

    $id = $_POST['id'];

    $sql = "DELETE FROM students WHERE Student_ID=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);

    // Reset the ID to 1 again
    $sql = "SET @num := 0;";
    mysqli_query($conn, $sql);
    $sql = "UPDATE students SET Student_ID = @num := (@num + 1);";
    mysqli_query($conn, $sql);
    $sql = "ALTER TABLE students AUTO_INCREMENT = 1;";
    mysqli_query($conn, $sql);

    mysqli_close($conn);
?> 