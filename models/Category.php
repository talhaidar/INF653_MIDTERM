<?php
 class Category {
    //DB Stuff
    private $conn;
    private $table = 'categories';

      //category Properties
    public $id;
    public $category;

    //  Constructor with DB
    public function __construct($db) {
        $this -> conn = $db;
    }

      //Get category
    public function read() {
         // Create Query
        $query = 'SELECT
                    id, category
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

       // GET Single category
      public function read_single() {
           // Create Query
          $query = 'SELECT id, category
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

            //Set Properties
          $this -> id = $row['id'];
          $this -> category = $row['category'];
      }

       // Create Category
      public function create() {
            //Create Query
          $query = 'INSERT INTO ' . $this -> table . '
           SET
              category = :category';
    
          //  Prepare Statement
          $stmt = $this -> conn -> prepare($query);
    
           // Clean Data
          $this -> category = htmlspecialchars(strip_tags($this -> category));
    
          //  Bind Data
          $stmt -> bindParam(':category', $this -> category);
    
           // Execute Query
          if($stmt -> execute()) {
              return true;
          }
            
           // Print error if something goes wrong
          printf("Error: %s.\n", $stmt -> error);
    
          return false;
      }

      //  Update Category
      public function update() {
           // Create Query
          $query = 'UPDATE ' . $this -> table . '
          SET
              id = :id,
              category = :category
          WHERE
              id = :id';

           // Prepare Statement
          $stmt = $this -> conn -> prepare($query);

           // Clean Data
          $this -> id = htmlspecialchars(strip_tags($this -> id));
          $this -> category = htmlspecialchars(strip_tags($this -> category));

           // Bind Data
          $stmt -> bindParam(':id', $this -> id);
          $stmt -> bindParam(':category', $this -> category);

           // Execute Query
          if($stmt -> execute()) {
              return true;
          }

          //  Print error if something goes wrong
          printf("Error: %s.\n", $stmt -> error);

          return false;
      }

       // Delete Category
      public function delete() {
          //  Create query
          $query = 'DELETE FROM ' . $this -> table . ' WHERE id = :id';
    
          //  Prepare Statement
          $stmt = $this -> conn -> prepare($query);
    
          //  Clean data
          $this -> id = htmlspecialchars(strip_tags($this -> id));
    
          //  Bind Data
          $stmt -> bindParam(':id', $this -> id);
    
          //  Execute Query
          if($stmt -> execute()) {
              return true;
          }
    
          //  Print error if something goes wrong
          printf("Error: %s.\n", $stmt -> error);
    
          return false;
      }
}
