<?php
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';
    
    //Instantiate DB & Connect
    $database = new Database();
    $db = $database -> connect();

    // Instantiate author object
    $author = new Author($db);

    // author Query
    $result = $author -> read();

    // Get Row Count
    $num = $result -> rowCount();

    // Check if any Authors
    if($num > 0) {
        // author array
        $author_arr = array();

        while($row = $result -> fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $author_item = array(
                'id' => $id,
                'author' => $author
            );

            // Push to 'data'
            array_push($author_arr, $author_item);
        }

        // Turn to JSON & output
        print_r(json_encode($author_arr));

    } else {
        // No categories
        echo json_encode(
            array('Message' => 'No Author Found')
        );
        
    }
exit();
