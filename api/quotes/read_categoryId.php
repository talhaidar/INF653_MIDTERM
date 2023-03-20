<?php
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database -> connect();

    // Instantiate quote object
    $quote = new Quote($db);

    // GET ID
    $quote -> categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : die();

    // Get quote 
    $result = $quote -> read_categoryId();

    // Get Row Count
    $num = $result->rowCount();


    if($num > 0) {
        $quote_arr = array();
   
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
