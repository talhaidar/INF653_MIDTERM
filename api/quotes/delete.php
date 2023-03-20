<?php
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database -> connect();

    // Instantiate quote object
    $quote = new Quote($db);

    // Get Raw Data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to DELETE
    $quote -> id = $data -> id;

    $quote -> delete();

    // DELETE quote
    if($quote -> id !== null) {
        echo json_encode(
            array('id' => $quote -> id)
        );
    } else {
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }
    exit();
