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
            $query = "SELECT sale_orders_details.*, products.name as Pname FROM sale_orders_details LEFT JOIN products ON sale_orders_details.product_id = products.id WHERE sale_orders_details.id = :id;";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ':id' => $id,
            ]);
            return $statement->fetch() ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}