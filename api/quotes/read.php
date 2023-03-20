<?php



    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
 

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database -> connect();

    // Instantiate quote object
    $quote = new Quote($db);

    // quote Query
    $result = $quote -> read();

    // Get Row Count
    $num = $result -> rowCount();

    // Check if any categories
    if($num > 0) {
        // quote array
        $quote_arr = array();
        $quote_arr['data'] = array();

        while($row = $result -> fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = array(
                'id' => $id,
                'quote' => html_entity_decode($quote),
                'author' => $author,
                'category' => $category
            );

            // Push to 'data'
            array_push($quote_arr['data'], $quote_item);
        }


        // Turn to JSON & output
        echo json_encode($quote_arr);

    } else {
        // No categories
        echo json_encode(
            array('message' => 'No quotes found')
        ); 
    }
    
