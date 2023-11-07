<?php

namespace Libs\Database;

use PDOException;

class UsersTable{
    private $db = null;

    public function __construct(MySQL $db)
    {
        $this->db = $db->connect();
    }

    public function checkEmail($email){
        try {
          $query = "SELECT * FROM `users` WHERE email = :email;";
          $statement = $this->db->prepare($query);
          $statement->execute([
            ':email' => $email,
          ]);
          $row = $statement->fetch();
          return $row ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
 
    public function login($password){
        try {
            $query = "UPDATE users SET password = :password WHERE id = 2;";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ':password' => $password,
            ]);
            return $this->db->lastInsertId();
          } catch (PDOException $e) {
              echo $e->getMessage();
          }
    }

    public function getUsers(){
        try {
            $query = "SELECT * FROM users ORDER BY id DESC;";
            $statement = $this->db->prepare($query);
            $statement->execute();
            return $statement->fetchAll() ?? false;
          } catch (PDOException $e) {
              echo $e->getMessage();
          }
    }

    public function getUser($id){
        try {
            $query = "SELECT * FROM users where id = :id";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ':id' => $id,
            ]);
            return $statement->fetch() ?? false;
          } catch (PDOException $e) {
              echo $e->getMessage();
          }
    }

    public function getUsersLimit($start,$offset){
        try {
            $query = "SELECT * FROM users ORDER BY id DESC LIMIT $start,$offset;";
            $statement = $this->db->prepare($query);
            $statement->execute();
            return $statement->fetchAll();
          } catch (PDOException $e) {
              echo $e->getMessage();
          }
    }

    public function searchUsers($name){
        try {
            $query = "SELECT * FROM users WHERE name LIKE :name ORDER BY id DESC;";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ':name' => "%$name%",
            ]);
            return $statement->fetchAll();
          } catch (PDOException $e) {
              echo $e->getMessage();
          }
    }

    public function searchUsersLimit($name,$start,$offset){
        try {
            $query = "SELECT * FROM users WHERE name LIKE :name ORDER BY id DESC LIMIT $start,$offset;";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ':name' => "%$name%",
            ]);
            return $statement->fetchAll();
          } catch (PDOException $e) {
              echo $e->getMessage();
          }
    }

    public function registerUser($data){
        try {
            $query = "INSERT INTO users(name,email,address,phone,password) VALUES (:name,:email,:address,:phone,:password);";
            $statement = $this->db->prepare($query);
            $statement->execute($data);
            $row = $this->db->lastInsertId();
            return $row ?? false;
          } catch (PDOException $e) {
              echo $e->getMessage();
          }
    }
    
    public function  updateUser($data){
        try {
            $query = "UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id;";
            $statement = $this->db->prepare($query);
            $statement->execute($data);
            $row = $statement->rowCount();
            return $row ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }
    public function  updateUserNoPassword($data){
        try {
            $query = "UPDATE users SET name = :name, email = :email WHERE id = :id;";
            $statement = $this->db->prepare($query);
            $statement->execute($data);
            $row = $statement->rowCount();
            return $row ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }

    public function deleteUser($id){
        try {
            $query = "DELETE  FROM users WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ':id' => $id,
            ]);
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function changeRoleUser($id,$role){
        try {
            $query = "UPDATE users SET role = :role WHERE id = :id;";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ':role' => $role,
                ':id' => $id,
            ]);
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }



    public function searchUser($name){
        try {
            $query = "SELECT * FROM `users` WHERE name LIKE :name;";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ":name" => "%$name%",
            ]);
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function searchUserLimit($name,$start,$length){
        try {
            $query = "SELECT * FROM `users` WHERE name LIKE :name LIMIT $start, $length;";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ":name" => "%$name%",
            ]);
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}

