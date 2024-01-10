<?php
    include 'db_config.php';

    $search = $_POST['search'];
    $sql = ($search === "") ? "SELECT * FROM students" : "SELECT * FROM students WHERE Name LIKE '%" . $search . "%'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    } else {
        $data['err'] = "No records found!";
        $data['status'] = 404;
    }

    echo json_encode($data);
    mysqli_close($conn);
?>