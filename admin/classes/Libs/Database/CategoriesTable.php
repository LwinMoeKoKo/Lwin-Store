<?php 

namespace Libs\Database;

use PDOException;

class CategoriesTable{
    private $db;

    public function __construct(MySQL $db)
    {
        $this->db = $db->connect();
    }

    public function allCategories(){
        try {
            $query = "SELECT * FROM categories ORDER BY `id` DESC;";
            $statement = $this->db->prepare($query);
            $statement->execute();
            return $statement->fetchAll() ?? false;
        } catch (PDOException $e) {
           echo $e->getMessage();
        }
    }

    public function allCategoriesAsc(){
        try {
            $query = "SELECT * FROM categories;";
            $statement = $this->db->prepare($query);
            $statement->execute();
            return $statement->fetchAll() ?? false;
        } catch (PDOException $e) {
           echo $e->getMessage();
        }
    }

    public function getCategory($id){
        try {
            $query = "SELECT * FROM `categories` WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ':id' => $id,
            ]);
            return $statement->fetch() ?? false;
        } catch (PDOException $e) {
           echo $e->getMessage();
        }
    }

    public function allCategoriesLimit($start, $offset){
        try {
            $query = "SELECT * FROM `categories` ORDER BY `id` DESC LIMIT $start,$offset; ";
            $statement = $this->db->prepare($query);
            $statement->execute();
            return $statement->fetchAll() ?? false;
        } catch (PDOException $e) {
           echo $e->getMessage();
        }
    }

    public function searchCategory($name){
        try {
            $query = "SELECT * FROM `categories` WHERE name LIKE :name;";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ':name' => "%$name%",
            ]);
            return $statement->fetchAll() ?? false;
        } catch (PDOException $e) {
           echo $e->getMessage();
        }
    }

    public function searchCategoryLimit($name,$start, $offset){
        try {
            $query = "SELECT * FROM `categories` WHERE name LIKE :name LIMIT $start,$offset;";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ':name' => "%$name%",
            ]);
            return $statement->fetchAll() ?? false;
        } catch (PDOException $e) {
           echo $e->getMessage();
        }
    }

    public function addCategory($name,$description){
        try {
           $query = "INSERT INTO categories(`name`,`description`,`created_at`) VALUES (:name, :description, NOW());";
           $statement = $this->db->prepare($query);
           $statement->execute([
            ':name' => $name,
            ':description' => $description,
           ]);
           return $this->db->lastInsertId();
        } catch (PDOException $e) {
           echo $e->getMessage();
        }
    }

    public function deleteCategory($id){
        try {
           $query = "DELETE FROM categories WHERE id = :id;";
           $statement = $this->db->prepare($query);
           $statement->execute([
             ':id' => $id,
           ]);
           return $statement->rowCount() ?? false;
        } catch (PDOException $e) {
           echo $e->getMessage();
        }
    }

    public function editCategory($name,$description,$id){
        try {
           $query = "UPDATE categories SET name = :name, description = :description,updated_at = NOW() WHERE id = :id;";
           $statement = $this->db->prepare($query);
           $statement->execute([
            ':name' => $name,
            ':description' => $description,
            ':id' => $id,
           ]);
           $row = $statement->rowCount();
           return $row ?? false;
        } catch (PDOException $e) {
           echo $e->getMessage();
        }
    }

    
}