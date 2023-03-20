<?php
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database -> connect();

    // Instantiate quote object
    $quote = new Quote($db);

    // GET ID
    $quote -> authorId = isset($_GET['authorId']) ? $_GET['authorId'] : die();

    // Get quote 
    $result = $quote -> read_authorId();

    // Get Row Count
    $num = $result->rowCount();


    if($num > 0) {
        $quote_arr = array();
       // $quote_arr['data'] = array();
   
       while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
           extract($row);
   
           $quote_item = array(
            'id' => $id,
            'quote' => html_entity_decode($quote),
            'author' => $author,
            'category' => $category
        );
   
             // Push to 'data'
             array_push($quote_arr, $quote_item);
    }
    print_r(json_encode($quote_arr));
   
   } else {
       echo json_encode(
           array('message' => 'No quotes found')
       );
   }


    exit();
