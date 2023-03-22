<?php

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database -> connect();

    // Instantiate category object
    $category = new Category($db);

    // category Query
    $result = $category -> read();

    // Get Row Count
    $num = $result -> rowCount();

    // Check if any categories
    if($num > 0) {
        // category array
        $category_arr = array();

        while($row = $result -> fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $category_item = array(
                'id' => $id,
                'category' => $category
            );

            // Push to 'data'
            array_push($category_arr, $category_item);
        }

        // Turn to JSON & output
        echo json_encode($category_arr);

    } else {
        // No categories
        echo json_encode(
            array('Message' => 'No Category Found')
        );
   exit();
    }
