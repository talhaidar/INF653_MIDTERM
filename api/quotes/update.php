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

    // Set ID to UPDATE
    $quote -> id = $data -> id;
    $quote -> quote = $data -> quote;
    $quote -> author_id = $data -> author_id;
    $quote -> category_id = $data -> category_id;

    // Check for  missing parameters
    if($quote -> id == null) {
        echo json_encode(
            array('message' => 'No Quotes Found'));
            exit();
    } elseif ($quote -> quote == null) {
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
    
    // UPDATE quote
    if($quote -> update()) {
        echo json_encode(
            array('id' => $quote->id,
                  'quote' => $quote->quote,
                  'author_id' => $quote->author_id,
                  'category_id' => $quote->category_id 
            ));
    } else {
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }
    exit();
