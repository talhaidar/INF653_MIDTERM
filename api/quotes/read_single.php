<?php
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database -> connect();

    // Instantiate quote object
    $quote = new Quote($db);

    // GET ID
    $quote -> id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get quote 
    $quote -> read_single();

    // Create array
    $quote_arr = array(
        'id' => $quote -> id,
        'quote' => $quote -> quote,
        'author' => $quote -> author,
        'category' => $quote -> category
    );

    if($quote -> id !== null) {
        print_r(json_encode($quote_arr));
    }
    else {
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }
exit();
