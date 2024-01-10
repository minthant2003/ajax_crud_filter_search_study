<?php    
    include '../db_config.php';

    $sql = "SELECT * FROM students";
    $result = mysqli_query($conn, $sql);  
    
    while($row = mysqli_fetch_assoc($result)) {
        $arr[] = $row;
    }
    echo json_encode($arr);

    mysqli_close($conn);
?>

