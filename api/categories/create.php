<?php
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database -> connect();

    // Instantiate category object
    $category = new Category($db);

    // Get Raw Data
    $data = json_decode(file_get_contents("php://input"));

    $category -> category = $data -> category;

    if ($category -> category == null) {
        echo json_encode(
            array('message' => 'Missing Required Parameters'));
            exit();
    }

    // Create category
    if($category -> create()) {
        echo json_encode(
            array('id' => $db->lastInsertId(),
                  'category' => $category -> category
            ));
    } else {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
    }
    exit();
    
