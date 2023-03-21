<?php
 class Quote {
     // DB Stuff
     private $conn;
     private $table = 'quotes';

     // quote Properties
     public $id;
     public $quote;

     // Constructor with DB
     public function __construct($db) {
         $this -> conn = $db;
     }

    // Get quote
    public function read() {
        // Create Query
        $query = 'SELECT
                quotes.id, quotes.quote, authors.author, categories.category
            FROM
                ' . $this -> table . ' 
            LEFT JOIN
                authors ON authors.id = "quotes.authorId"
            LEFT JOIN 
                categories ON categories.id = "quotes.categoryId"
            ORDER BY
                quotes.id DESC';

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
                authors ON authors.id = "quotes.authorId"
            LEFT JOIN 
                 categories ON categories.id = "quotes.categoryId"
            WHERE
                quotes.id = ?
            LIMIT 0,1';
    
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
    public function read_authorId() {
    
        $query = 'SELECT 
                quotes.id, quotes.quote, authors.author, categories.category
             FROM
                ' . $this -> table . '
            LEFT JOIN
                authors ON authors.id = "quotes.authorId"
            LEFT JOIN 
                categories ON categories.id = "quotes.categoryId"
            WHERE 
                quotes.authorId = :authorId';

        // prepare
        $stmt = $this -> conn -> prepare($query);    
  
        // Bind AuthorId
        $stmt -> bindParam(':authorId', $this -> authorId);
   
        // Execute
        $stmt->execute();    
    
        return $stmt;

    }

    public function read_categoryId() {
    
        $query = 'SELECT 
                quotes.id, quotes.quote, authors.author, categories.category
             FROM
                ' . $this -> table . ' 
            LEFT JOIN
                authors ON authors.id = "quotes.authorId"
            LEFT JOIN 
                categories ON categories.id = "quotes.categoryId"
            WHERE 
                "quotes.categoryId" = :categoryId';

        // prepare
        $stmt = $this -> conn -> prepare($query);    
  
        // Bind categoryId
        $stmt -> bindParam(':categoryId', $this -> categoryId);
   
        // Execute
        $stmt->execute();    
    
        return $stmt;

    }

    public function read_authorId_categoryId() {
    
        $query = 'SELECT 
                quotes.id, quotes.quote, authors.author, categories.category
             FROM
                ' . $this -> table . ' 
            LEFT JOIN
                authors ON authors.id = "quotes.authorId"
            LEFT JOIN 
                categories ON categories.id = "quotes.categoryId"
            WHERE 
                "quotes.authorId" = :authorId && "quotes.categoryId" = :categoryId';

        // prepare
        $stmt = $this -> conn -> prepare($query);    
  
        // Bind AuthorId
        $stmt -> bindParam(':authorId', $this -> authorId);
        $stmt -> bindParam(':categoryId', $this -> categoryId);
   
        // Execute
        $stmt->execute();    
    
        return $stmt;

    }

    // Create quote
    public function create() {
        // Create Query
        $query = 'INSERT INTO ' . $this -> table . '
            SET
                quote = :quote,
                authorId = :authorId,
                categoryId = :categoryId';
        
        // Prepare Statement
        $stmt = $this -> conn -> prepare($query);
        
        // Clean Data
        $this -> quote = htmlspecialchars(strip_tags($this -> quote));
        $this -> authorId = htmlspecialchars(strip_tags($this -> authorId));
        $this -> categoryId = htmlspecialchars(strip_tags($this -> categoryId));
        
        // Bind Data
        $stmt -> bindParam(':quote', $this -> quote);
        $stmt -> bindParam(':authorId', $this -> authorId);
        $stmt -> bindParam(':categoryId', $this -> categoryId);
        
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
                authorId = :authorId,
                categoryId = :categoryId
            WHERE
                id = :id';
    
        // Prepare Statement
        $stmt = $this -> conn -> prepare($query);
    
        // Clean Data
        $this -> id = htmlspecialchars(strip_tags($this -> id));
        $this -> quote = htmlspecialchars(strip_tags($this -> quote));
        $this -> authorId = htmlspecialchars(strip_tags($this -> authorId));
        $this -> categoryId = htmlspecialchars(strip_tags($this -> categoryId));
    
        // Bind Data
        $stmt -> bindParam(':id', $this -> id);
        $stmt -> bindParam(':quote', $this -> quote);
        $stmt -> bindParam(':authorId', $this -> authorId);
        $stmt -> bindParam(':categoryId', $this -> categoryId);
    
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
