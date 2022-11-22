<?php



    // Server Connection
    $conn = new mysqli('localhost','root','','test');

    // Get all urlBind data 
    $data =  json_decode(file_get_contents('php://input'));

    // Get Action
    $action = 'raed';
    if( isset($_GET['action']) ){
        $action = $_GET['action'];
    }

    /**
     *   Get all user data
     */
    if( $action == 'read' ){

        $data = $conn -> query("SELECT * FROM users ORDER BY id DESC");
        $all_users = [];


        while($user = $data -> fetch_assoc()){
            array_push($all_users, $user);
        }
    
        echo json_encode($all_users);

    }


    /**
     *   Create new user
     */

    if( $action == 'create' ){

        // $name   = $data -> name;
        // $email  = $data -> email;
        // $cell   = $data -> cell;
        // $uname  = $data -> uname;

        
        $file_name =  $_FILES['photo']['name'];
        $file_tmp_name = $_FILES['photo']['tmp_name'];

        // File upload
        move_uploaded_file($file_tmp_name, '../photos/users/' . $file_name);

        $name = $_POST['name'];
        $email = $_POST['email'];
        $cell = $_POST['cell'];
        $uname = $_POST['uname'];
    
    
        $conn -> query("INSERT INTO users (name, email, cell, username, photo) VALUES ('$name','$email','$cell','$uname', '$file_name')");

    }






    /**
     *   Delete user
     */

    if( $action == 'delete' ){
 
    $id =  $_GET['id'];

    $conn -> query("DELETE FROM users WHERE id = '$id'");

    }



    /**
     *  Single user data
     */
    if($action == 'single'){

        // get user id
        $id = $_GET['id'];

        // get single user data
        $data = $conn -> query("SELECT * FROM users WHERE id='$id'");

        $single_user_data = $data -> fetch_assoc();

        echo Json_encode($single_user_data);
    }




     /**
     *  Search user data
     */
    if($action == 'search'){

        // get search text
        $search = $_GET['s'];

        // get search result
        $data = $conn -> query("SELECT * FROM users WHERE name LIKE '%$search%'");

        $search_result = [];

        while($results = $data -> fetch_assoc()){
            array_push($search_result, $results);

        }

        echo json_encode($search_result);
     


    }






?>