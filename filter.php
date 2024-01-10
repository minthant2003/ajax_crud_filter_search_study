<?php
    sleep(1);
    include 'db_config.php';

    $major = $_GET['major'];
    $sql = ($major === "*") ? "SELECT * FROM students" : "SELECT * FROM students WHERE Major='" . $major . "'";

    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }    
    echo json_encode($data);
    mysqli_close($conn);
?>