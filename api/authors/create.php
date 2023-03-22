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

    
    $quote -> quote = $data -> quote;
    $quote -> author_id = $data -> author_id;
    $quote -> category_id = $data -> category_id;

    // Check for  missing parameters
    if($quote -> quote == null) {
        echo json_encode(
            array('message' => 'Missing Required Parameters'));
            exit();
    } elseif ($quote -> author_id == null) {
        echo json_encode(
            array('message' => 'Missing Required Parameters'));
            exit();
    } elseif ($quote -> category_id == null) {
        echo json_encode(
            array('message' => 'Missing Required Parameters'));
            exit();
    } 

    // Create quote
    if($quote -> create()) {
        echo json_encode(
            array(
                'id' => $db->lastInsertId(),
                'quote' => $quote->quote,
                'author_id' => $quote->author_id,
                'category_id' => $quote->category_id)
        );
    } else {
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
        exit();
    }
