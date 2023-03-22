<?php
 class Quote {
     // DB Stuff
     private $conn;
     private $table = 'quotes';

     // quote Properties
     public $id;
     public $quote;
     public $author;
     public $category;
     public $category_id;
     public $author_id;

     // Constructor with DB
     public function __construct($db) {
         $this -> conn = $db;
     }

    // Get quote
    public function read() {
        // Create Query
        $query = 'SELECT
                quotes.id, quotes.quote, authors.author , categories.category 
            FROM
                ' . $this -> table . ' 
            LEFT JOIN
                authors ON authors.id = quotes.author_id
            LEFT JOIN 
                categories ON categories.id = quotes.category_id
            ORDER BY
                quotes.id ASC';

        // Prepare Statement
        $stmt = $this -> conn -> prepare($query);

        // Execute query
        $stmt -> execute();

        return $stmt;
    }

    // GET Single quote
    public function read_single() {
        // Create Query
        $query = 'SELECT 
                quotes.id, quotes.quote, authors.author, categories.category
            FROM
                ' . $this -> table . '
            LEFT JOIN
                authors ON authors.id = quotes.author_id
            LEFT JOIN 
                 categories ON categories.id = quotes.category_id
            WHERE
                quotes.id = ?
            LIMIT 1 OFFSET 0';
      
        // Prepare Statement
        $stmt = $this -> conn -> prepare($query);
    
        // Bind id
        $stmt -> bindParam(1, $this -> id);

    
        // Execute Query
        $stmt -> execute();
    
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);
          
        
        // Set Properties
        $this -> id = $row['id'];
        $this -> quote = $row['quote'];
        $this -> author = $row['author'];
        $this -> category = $row['category'];
    }

    // Start Get all quotes by an author ID
    public function read_author_id() {
    
        $query = 'SELECT 
                quotes.id, quotes.quote, authors.author, categories.category
             FROM
                ' . $this -> table . '
            LEFT JOIN
                authors ON authors.id = quotes.author_id
            LEFT JOIN 
                categories ON categories.id = quotes.category_id
            WHERE 
                quotes.author_id = :author_id';

        // prepare
        $stmt = $this -> conn -> prepare($query);    
  
        // Bind author_id
        $stmt -> bindParam(':author_id', $this -> author_id);
   
        // Execute
        $stmt->execute();    
    
        return $stmt;

    }

    public function read_category_id() {
    
        $query = 'SELECT 
                quotes.id, quotes.quote, authors.author, categories.category
             FROM
                ' . $this -> table . ' 
            LEFT JOIN
                authors ON authors.id = quotes.author_id
            LEFT JOIN 
                categories ON categories.id = quotes.category_id
            WHERE 
                quotes.category_id = :category_id';

        // prepare
        $stmt = $this -> conn -> prepare($query);    
  
        // Bind category_id
        $stmt -> bindParam(':category_id', $this -> category_id);
   
        // Execute
        $stmt->execute();    
    
        return $stmt;

    }

    public function read_author_id_category_id() {
    
        $query = 'SELECT 
                quotes.id, quotes.quote, authors.author, categories.category
             FROM
                ' . $this -> table . ' 
            LEFT JOIN
                authors ON authors.id = quotes.author_id
            LEFT JOIN 
                categories ON categories.id = quotes.category_id
            WHERE 
                quotes.author_id = :author_id && quotes.category_id = :category_id';

        // prepare
        $stmt = $this -> conn -> prepare($query);    
  
        // Bind author_id
        $stmt -> bindParam(':author_id', $this -> author_id);
        $stmt -> bindParam(':category_id', $this -> category_id);
   
        // Execute
        $stmt->execute();    
    
        return $stmt;

    }

    // Create quote
    public function create() {

        // Clean Data
        $this -> quote = htmlspecialchars(strip_tags($this -> quote));
        $this -> author_id = htmlspecialchars(strip_tags($this -> author_id));
        $this -> category_id = htmlspecialchars(strip_tags($this -> category_id));
      
        // Create Query
        $query = 'INSERT INTO ' . $this -> table . ' (quote, author_id, category_id)
            VALUES(\'' . $this -> quote . '\',
                  \'' . $this -> author_id . '\', 
                  \'' . $this -> category_id . '\');';
      
        
        // Prepare Statement
        $stmt = $this -> conn -> prepare($query);
        
        
        // // Bind Data
        // $stmt -> bindParam(':quote', $this -> quote);
        // $stmt -> bindParam(':author_id', $this -> author_id);
        // $stmt -> bindParam(':category_id', $this -> category_id);
        
        // Execute Query
        if($stmt -> execute()) {
            return true;
        }
                
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt -> error);
        
        return false;
    }

    // Update Quote
     public function update() {
        // Create Query
        $query = 'UPDATE ' . $this -> table . '
            SET
                id = :id,
                quote = :quote,
                author_id = :author_id,
                category_id = :category_id
            WHERE
                id = :id';
    
        // Prepare Statement
        $stmt = $this -> conn -> prepare($query);
    
        // Clean Data
        $this -> id = htmlspecialchars(strip_tags($this -> id));
        $this -> quote = htmlspecialchars(strip_tags($this -> quote));
        $this -> author_id = htmlspecialchars(strip_tags($this -> author_id));
        $this -> category_id = htmlspecialchars(strip_tags($this -> category_id));
    
        // Bind Data
        $stmt -> bindParam(':id', $this -> id);
        $stmt -> bindParam(':quote', $this -> quote);
        $stmt -> bindParam(':author_id', $this -> author_id);
        $stmt -> bindParam(':category_id', $this -> category_id);
    
        // Execute Query
        if($stmt -> execute()) {
            return true;
        }
    
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt -> error);
    
        return false;
    }

    // Delete Quote
    public function delete() {
        // Create query
        $query = 'DELETE FROM ' . $this -> table . ' WHERE id = :id';
        
        // Prepare Statement
        $stmt = $this -> conn -> prepare($query);
        
        // Clean data
        $this -> id = htmlspecialchars(strip_tags($this -> id));
        
        // Bind Data
        $stmt -> bindParam(':id', $this -> id);
        
        // Execute Query
        if($stmt -> execute()) {
            return true;
        }
        
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt -> error);
        
        return false;
    }

  
}
