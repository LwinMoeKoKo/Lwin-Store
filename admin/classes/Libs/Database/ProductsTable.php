<?php

namespace Libs\Database;

use Helpers\HTTP;
use PDOException;

class ProductsTable{
    private $db;

    public function __construct(MySQL $db)
    {
        $this->db = $db->connect();
    }
    
    public function getProducts(){
        try {
            $query = "SELECT * FROM `products` ORDER BY id DESC;";
            $statement = $this->db->prepare($query);
            $statement->execute();
            return $statement->fetchAll() ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getProductsLimit($start,$offset){
        try {
            $query = "SELECT * FROM `products` ORDER BY id DESC LIMIT $start,$offset;";
            $statement = $this->db->prepare($query);
            $statement->execute();
            return $statement->fetchAll() ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getProductsLimitWithCategory($start,$offset){
        try {
            $query = "SELECT products.*, categories.name as c_name, categories.description as c_description  FROM `products` LEFT JOIN categories ON products.category_id = categories.id WHERE products.quantity > 0 LIMIT $start,$offset;";
            $statement = $this->db->prepare($query);
            $statement->execute();
            return $statement->fetchAll() ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getProductAll(){
        try {
            $query = "SELECT products.*, categories.name as c_name, categories.description as c_description  FROM `products` LEFT JOIN categories ON products.category_id = categories.id  WHERE products.quantity > 0;";
            $statement = $this->db->prepare($query);
            $statement->execute();
            return $statement->fetchAll() ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getProduct($id){
        try {
            $query = "SELECT products.*, categories.name as c_name, categories.description as c_description  FROM `products` LEFT JOIN categories ON products.category_id = categories.id WHERE products.id = :id;";
            $statement = $this->db->prepare($query);
            $statement->execute([
                'id' => $id,
            ]);
            return $statement->fetch() ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
   

    public function addProduct($data){
        try {
            $query = "INSERT INTO products(name, description,category_id, quantity, price, image, created_at) VALUES (:name, :description,:category_id, :quantity, :price, :image, NOW());";
            $statement = $this->db->prepare($query);
            $statement->execute($data);

            $row = $this->db->lastInsertId();
            return $row ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function updateProductQuantity($quantity,$id){
        try {
            $query = "UPDATE products SET quantity = :quantity WHERE id = :id;";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ':quantity' =>$quantity,
                ':id' => $id,
            ]);

            $row = $statement->rowCount();
            return $row ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function deleteProduct($id){
        try {
            $query = "DELETE FROM products WHERE id = :id;";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ':id' => $id,
            ]);

            $row = $statement->rowCount();
            return $row ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function editProduct($data){
        try {
            $query = "UPDATE products SET name = :name, description = :description,category_id= :category_id, quantity = :quantity, image = :image, price = :price WHERE id = :id;";
            $statement = $this->db->prepare($query);
            $statement->execute($data);

            $row = $statement->rowCount();
            return $row ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function searchProduct($name){
        try {
            $query = "SELECT * FROM products WHERE name LIKE :name AND quantity > 0 ORDER BY id DESC;";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ':name' => "%$name%",
            ]);

            $row = $statement->fetchAll();
            return $row ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function searchProductWithCategory($name){
        try {
            $query = "SELECT products.*, categories.name as c_name, categories.description as c_description FROM `products` LEFT JOIN categories ON products.category_id = categories.id WHERE products.name LIKE :name AND quantity > 0 ORDER BY id DESC;";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ':name' => "%$name%",
            ]);

            $row = $statement->fetchAll();
            return $row ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function searchProductLimit($name,$start,$offset){
        try {
            $query = "SELECT  * FROM products WHERE name LIKE :name ORDER BY id DESC LIMIT $start,$offset;";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ':name' => "%$name%",
            ]);

            $row = $statement->fetchAll();
            return $row ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function searchProductLimitWithCategory($name,$start,$offset){
        try {
            $query = "SELECT products.*, categories.name as c_name, categories.description as c_description FROM `products` LEFT JOIN categories ON products.category_id = categories.id WHERE products.name LIKE :name AND quantity > 0  ORDER BY id ASC LIMIT $start,$offset;";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ':name' => "%$name%",
            ]);

            $row = $statement->fetchAll();
            return $row ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function checkQuantity($id){
        try {
            $query = "SELECT * FROM `products` WHERE id = :id;";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ':id' => "$id",
            ]);

            $row = $statement->fetch();
            return $row ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function h($content){
        return htmlspecialchars($content);
    }
    
    public function tokenCsrf(){
        if(!isset($_SESSION['csrf'])){
            $token = sha1(rand(1,1000).time(). 'csrf secret');
            $_SESSION['csrf'] = $token;
        } else {
            return $_SESSION['csrf'];
        }
    }
    public function tokenCreate(){
        $token = sha1(rand(1,1000).time(). 'csrf secret');
        $_SESSION['csrf'] = $token;
    }
       
    public function tokenCheck($csrf){
            if($csrf !== $_SESSION['csrf']){
                unset($_SESSION['user']);
                unset($_SESSION['csrf']);
                HTTP::redirect("/index.php");
            }
        }

    public function token(){
           session_start();
           if($_SERVER['REQUEST_METHOD'] === "POST"){
               if($_POST['csrf'] !== $_SESSION['csrf']){
                   unset($_SESSION['user']);
                   unset($_SESSION['csrf']);
                   HTTP::redirect("/index.php");
               }
            }
             if(!isset($_SESSION['csrf'])){
                 $token = sha1(rand(1,1000).time(). 'csrf secret');
                 $_SESSION['csrf'] = $token;
             } else {
                 return $_SESSION['csrf'];
             }
         }
 
 }           
        
    

        
            
            
