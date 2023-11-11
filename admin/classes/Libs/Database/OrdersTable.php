<?php

namespace Libs\Database;

use PDOException;

class OrdersTable{
    private $db;

    public function __construct(MySQL $db)
    {
        $this->db = $db->connect();
    }

    public function getOrders(){
        try {
            $query = "SELECT sale_orders.* , users.name as name FROM sale_orders LEFT JOIN users ON sale_orders.user_id = users.id;";
            $statement = $this->db->prepare($query);
            $statement->execute();
            return $statement->fetchAll() ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getOrdersLimit($start,$offset){
        try {
            $query = "SELECT sale_orders.* , users.name as name FROM sale_orders LEFT JOIN users ON sale_orders.user_id = users.id LIMIT $start,$offset;";
            $statement = $this->db->prepare($query);
            $statement->execute();
            return $statement->fetchAll() ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getOrderDetail($id){
        try {
            $query = "SELECT sale_orders_details.*, products.name as Pname FROM sale_orders_details LEFT JOIN products ON sale_orders_details.product_id = products.id WHERE sale_orders_details.sale_order_id = :id;";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ':id' => $id,
            ]);
            $row = $statement->fetchAll();
            return $row ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function addOrder($user_id,$total_price){
        try {
            $query = "INSERT INTO sale_orders(user_id, total_price) VALUES (:user_id, :total_price);";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ':user_id' => $user_id,
                ':total_price' => $total_price,
            ]);
            $row = $this->db->lastInsertId();
            return $row ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function addOrderDetail($sale_order_id,$product_id,$quantity){
        try {
            $query = "INSERT INTO sale_orders_details(sale_order_id, product_id, quantity) VALUES (:sale_order_id, :product_id, :quantity);";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ':sale_order_id' => $sale_order_id,
                ':product_id' => $product_id,
                ':quantity' => $quantity,
            ]);
            $row = $this->db->lastInsertId();
            return $row ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function weeklyOrderReport($fromDate, $toDate){
        try {
            $query = "SELECT sale_orders.*,users.name as userName FROM `sale_orders` LEFT JOIN users ON sale_orders.user_id = users.id  WHERE order_date < :fromDate AND order_date >= :toDate ORDER BY id DESC;";
            $statement = $this->db->prepare($query);
            $statement->execute([
               ':fromDate' =>$fromDate,
               ':toDate' =>$toDate,
            ]);
            $row = $statement->fetchAll();
            return $row ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function monthlyOrderReport($fromDate, $toDate){
        try {
            $query = "SELECT sale_orders.*,users.name as userName FROM `sale_orders` LEFT JOIN users ON sale_orders.user_id = users.id  WHERE order_date < :fromDate AND order_date >= :toDate ORDER BY id DESC;";
            $statement = $this->db->prepare($query);
            $statement->execute([
               ':fromDate' =>$fromDate,
               ':toDate' =>$toDate,
            ]);
            $row = $statement->fetchAll();
            return $row ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function topBuyer(){
        try {
            $query = "SELECT sale_orders.*,users.name as userName FROM `sale_orders` LEFT JOIN users ON sale_orders.user_id = users.id  GROUP BY sale_orders.user_id HAVING SUM(total_price) > 200 ORDER BY SUM(total_price) DESC;";
            $statement = $this->db->prepare($query);
            $statement->execute();
            $row = $statement->fetchAll();
            return $row ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function bestSeller(){
        try {
            $query = "SELECT * FROM sale_orders_details LEFT JOIN products ON products.id = sale_orders_details.product_id GROUP BY sale_orders_details.product_id HAVING SUM(sale_orders_details.quantity) > 3 ORDER BY SUM(sale_orders_details.quantity) DESC;;";
            $statement = $this->db->prepare($query);
            $statement->execute();
            $row = $statement->fetchAll();
            return $row ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    
}