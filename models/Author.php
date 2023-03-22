<?php
 class Author {
     // DB Stuff
     private $conn;
     private $table = 'authors';

     // Author Properties
     public $id;
     public $author;

     // Constructor with DB
     public function __construct($db) {
         $this -> conn = $db;
     }

    // Get Author
    public function read() {
        // Create Query
        $query = 'SELECT
                    id, author
                FROM
                    ' . $this -> table . '
                ORDER BY
                    id DESC';

        // Prepare Statement
        $stmt = $this -> conn -> prepare($query);

        // Execute query
        $stmt -> execute();

        return $stmt;
    }
    
    // GET Single Author
    public function read_single() {
         // Create Query
        $query = 'SELECT id, author
        FROM
            ' . $this -> table . '
        WHERE
            id = ?
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
        $this -> author = $row['author'];
    }

    // Create Author
    public function create() {
      
        // Clean Data
        $this -> author = htmlspecialchars(strip_tags($this -> author));
      
        // Create Query
        // BUG FIX: using double quotes is reserved for column names
        // by putting a \ in front of the quotes you want to keep in the string
        // it disualifies it from string interpolation and records it as a character
        // the \ is used to disualify characters that would usually be used for other means
        // in string interpolation
        // therefore allowing it to be recorded in the query
        $query = 'INSERT INTO ' . $this -> table . ' (author) 
                  VALUES(\'' . $this -> author . '\');';
        // this query now equals to 
        // INSERT INTO author (author) VALUES('nolo');
        // instead of 
        // INSERT INTO author (author) VALUES(''nolo'');
        // or
        // INSERT INTO author (author) VALUES("nolo");
      

        // Prepare Statement
        $stmt = $this -> conn -> prepare($query);

        // Clean Data
        // $this -> author = htmlspecialchars(strip_tags($this -> author));

        // Bind Data
        // $stmt -> bindParam(':author', $this -> author);

        // Execute Query
        if($stmt -> execute()) {
        return true;
        }
        
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt -> error);

        return false;
    }

    // Update Author
    public function update() {
        // Create Query
        $query = 'UPDATE ' . $this -> table . '
        SET
            id = :id,
            author = :author
        WHERE
            id = :id';

        // Prepare Statement
        $stmt = $this -> conn -> prepare($query);

        // Clean Data
        $this -> id = htmlspecialchars(strip_tags($this -> id));
        $this -> author = htmlspecialchars(strip_tags($this -> author));

        // Bind Data
        $stmt -> bindParam(':id', $this -> id);
        $stmt -> bindParam(':author', $this -> author);

        // Execute Query
        if($stmt -> execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt -> error);

        return false;
    }

    // Delete Author
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
