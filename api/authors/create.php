<?php
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';
    
    // Instantiate DB & Connect
    $database = new Database();
    $db = $database -> connect();

    // Instantiate Author object
    $author = new Author($db);

    // Get Raw Data
    $data = json_decode(file_get_contents("php://input"));

    $author -> author = $data -> author;

    if ($author -> author == null) {
        echo json_encode(
            array('message' => 'Missing Required Parameters'));
            exit();
    }
    

    // Create Author
    if($author -> create()) {
        echo json_encode(
            array('id' => $db->lastInsertId(),
                  'author' => $author -> author
            ));
    } else {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
    }
        exit();
    
