<?php
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database -> connect();

    // Instantiate Category object
    $category = new Category($db);

    // GET ID
    $category -> id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get category 
    $category -> read_single();

    // Create array
    $category_arr = array(
        'id' => $category -> id,
        'category' => $category -> category
    );

    // Make JSON
    if($category -> id !== null) {
        print_r(json_encode($category_arr));
    }
    else {
        echo json_encode(
            array('message' => 'categoryId Not Found')
        );
    }
    exit();
