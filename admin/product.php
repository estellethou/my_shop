<?php
class Product {
    const ERROR_LOG_FILE = "errors.log";
    private $name;
    private $description;
    private $picture;
    private $price;
    private $category_id;
    
    public function __construct($name, $description, $picture, $price, $category_id){
        $this->name = $name;
        $this->description = $description;
        $this->picture = $picture;
        $this->price = $price;
        $this->category_id = $category_id;
        $this->insertProductIntoDb();
    }

    public function insertProductIntoDb(){
        $bdd = connectToDb();

        $response = $bdd->prepare("INSERT INTO products(name, description, picture, price, category_id) 
                                  VALUES (?, ?, ?, ?, ?);");
        $response->bindParam(1, $this->name, PDO::PARAM_STR);
        $response->bindParam(2, $this->description, PDO::PARAM_STR);
        $response->bindParam(3, $this->picture, PDO::PARAM_STR);
        $response->bindParam(4, intval($this->price), PDO::PARAM_INT);
        $response->bindParam(5, intval($this->category_id), PDO::PARAM_INT);
        $response->execute();
    }
} 

function deleteProductIntoDb(){
    $bdd = connectToDb();
    $response = $bdd->prepare("DELETE FROM products WHERE id='" . $_POST['id'] . "';");
    $response->execute();
    $response = $bdd->prepare("SELECT * FROM products");
    $response->execute();
    echo "<meta http-equiv='refresh' content='0'>";
}

function editProductIntoDb(){
    if (isset($_POST['name']) && isset($_POST['description']) && isset($_FILES['new_picture']) && isset($_POST['price']) && isset($_POST['category_id'])) {
        $bdd = connectToDb();
        $response = $bdd->prepare("UPDATE products 
        SET name='" . $_POST['name'] . "', 
        description='" . $_POST['description'] . "',
        picture='" . $_FILES['new_picture']['name'] . "',
        category_id='" . $_POST['category_id'] . "',
        price='" . $_POST['price'] . "' WHERE id='" . $_POST['id'] . "';");
        $response->execute();
        $response = $bdd->prepare("SELECT * FROM products");
        $response->execute();
        echo "<meta http-equiv='refresh' content='0'>";
    }
}
?>