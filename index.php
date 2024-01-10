<?php
    include 'db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>  

    <style>
        th, td {
            border: 1px solid black;
        }

        #add_form, #update_form {
            display: none;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        function view() {
            $.ajax({
                url: 'data/view.php',
                method: 'GET',
                success: function(data) {                    
                    var data = JSON.parse(data);
                    data.forEach(element => {
                        $('tbody').append(
                            `<tr>
                                <td>${element.Student_ID}</td>
                                <td>${element.Name}</td>
                                <td>${element.Age}</td>
                                <td>${element.Major}</td>
                                <td>
                                    <button data-id='${element.Student_ID}' data-name='${element.Name}' 
                                        data-age='${element.Age}' data-major='${element.Major}' 
                                        class='update_show'>Update</button>
                                </td>
                                <td><button data-id='${element.Student_ID}' class='delete'>Delete</button></td>
                            </tr>`
                        );
                    });
                }
            });
        }

        function add() {
            var name = $('#add_name').val();
            var age = $('#add_age').val();
            var major = $('#add_major').val();

            if(name !== "" && age !== "" && major !== "") {
                $.ajax({
                    url: 'data/add.php',
                    method: 'POST',
                    data: {
                        name: name,
                        age: age,
                        major: major
                    },
                    success: function() {    
                        $('tbody').empty();                        
                        view();
                        $('#add_name').val('');
                        $('#add_age').val('');
                        $('#add_major').val('');
                    }
                })
            }
        }

        function update() {
            var id = $('#update_id').val();
            var name = $('#update_name').val();
            var age = $('#update_age').val();
            var major = $('#update_major').val();

            if(id !== '' && name !== '' && age !== '' && major !== '') {
                $.ajax({
                    url: 'data/update.php',
                    method: 'POST',
                    data: {
                        id: id,
                        name: name,
                        age: age,
                        major: major
                    },
                    success: function() {
                        $('tbody').empty();
                        view();
                        $('#update_id').val('');
                        $('#update_name').val('');
                        $('#update_age').val('');
                        $('#update_major').val('');
                    }
                })
            }
        }

        function destroy(id) {
            var id = id;

            $.ajax({
                url: 'data/destroy.php',
                method: 'POST',
                data: { id: id },
                success: function() {
                    $('tbody').empty();
                    view();
                }
            })
        }
        
        $(document).ready(function() {                
            view();
            // 
            $('#add_show').on('click',  function() {
                $('#update_form').css('display', 'none');
                $('#add_form').css('display', 'block');
            })

            $('#add_form').on('submit', function(event) {
                event.preventDefault();
                add();
            })             
            // //             
            // 
            $('tbody').on('click', '.update_show', function() {                  
                var id = $(this).data('id');
                var name = $(this).data('name');
                var age = $(this).data('age');
                var major = $(this).data('major');

                $('#add_form').css('display', 'none');
                $('#update_form').css('display', 'block');

                $('#update_id').val(id);
                $('#update_name').val(name);
                $('#update_age').val(age);
                $('#update_major').val(major);
            })

            $('#update_form').on('submit', function(event) {                
                event.preventDefault();
                update();
            })
            // //
            // 
            $('tbody').on('click', '.delete', function() {
                var id = $(this).data('id');
                destroy(id);
            })
            // //
        })        
    </script>
</head>
<body>

    <select name="" id="filter">
        <option value="*">__Choose Major__</option>
        <option value="*">All</option>
        <?php            
            $sql = "SELECT * FROM students GROUP BY Major";
            $result = mysqli_query($conn, $sql);            
            
            while($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['Major'] . "'>" . $row['Major'] . "</option>";
            }            
        ?>
    </select>

    <input id="search" type="text" placeholder="Search by Name...">
    
    <button id="add_show">Add Student</button>

    <table>
        <thead>
            <tr>
                <th>Student_ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Major</th>
                <th>Action</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!--  -->            
        </tbody>
    </table>

    <form id="add_form" action="index.php" method="POST">
        <input id="add_name" type="text" placeholder="Name"></br>
        <input id="add_age" type="text" placeholder="Age"></br>
        <input id="add_major" type="text" placeholder="Major"></br>
        <input id="add_submit" type="submit" value="Add Student">
        <input type="reset">
    </form>

    <form id="update_form" action="index.php" method="POST">
        <input id="update_id" type="text" placeholder="ID" hidden>
        <input id="update_name" type="text" placeholder="Name"></br>
        <input id="update_age" type="text" placeholder="Age"></br>
        <input id="update_major" type="text" placeholder="Major"></br>
        <input id="update_submit" type="submit" value="Update Student">
        <input type="reset">
    </form>

    <script>               
        $('#search').on('keyup', function() {               
            if($(this).val().match(/^[a-z\s]+$/i) || $(this).val() === "") {
                $.ajax({
                    url: 'search.php',
                    method: 'POST',
                    data: { search: $(this).val() },
                    success: function(data) {
                        var data = JSON.parse(data);                            
                        $('tbody').empty();

                        if(data.err) {
                            $('tbody').append(`<h3>${data.err}</h3>`);
                        } else {
                            data.forEach(element => {                                
                                $('tbody').append(
                                    `<tr>
                                        <td>${element.Student_ID}</td>
                                        <td>${element.Name}</td>
                                        <td>${element.Age}</td>
                                        <td>${element.Major}</td>
                                        <td>
                                            <button data-id='${element.Student_ID}' data-name='${element.Name}' 
                                                data-age='${element.Age}' data-major='${element.Major}' 
                                                class='update_show'>Update</button>
                                        </td>
                                        <td><button data-id='${element.Student_ID}' class='delete'>Delete</button></td>
                                    </tr>`
                                );                                
                            });
                        }                         
                    }
                })
            }
        })

        $('#filter').on('change', function() {               
            var major = $(this).val();
            $.ajax({
                url: 'filter.php',
                type: 'GET',
                data: { major: major },
                beforeSend: function() {
                    $('tbody').html('<h3>Loading data from the server...</h3>');                        
                },
                success: function(data) {                        
                    var data = JSON.parse(data);
                    $('tbody').empty();
                    data.forEach(element => {
                        $('tbody').append(
                            `<tr>
                                <td>${element.Student_ID}</td>
                                <td>${element.Name}</td>
                                <td>${element.Age}</td>
                                <td>${element.Major}</td>
                                <td>
                                    <button data-id='${element.Student_ID}' data-name='${element.Name}' 
                                        data-age='${element.Age}' data-major='${element.Major}' 
                                        class='update_show'>Update</button>
                                </td>
                                <td><button data-id='${element.Student_ID}' class='delete'>Delete</button></td>
                            </tr>`
                        );
                    });
                }
            })
        })                   
    </script>
</body>
</html>