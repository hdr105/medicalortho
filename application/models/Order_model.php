<?php

class Order_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'orders';
        parent::__construct($this->table);
    }

    function get_details_orders($id) {

        
        $orders = $this->db->dbprefix('orders');
        $products = $this->db->dbprefix('products');

        $where = "";
        $where_query = false;
        if (!empty($id)) {

            $where .= " $orders.created_by=$id ";

        }
        $sql = "SELECT $orders.*, $products.title
        FROM $orders
        LEFT JOIN $products ON $products.id= $orders.product_id ";
        if ($where != "") {

            $sql .= " WHERE  $where ";
        }
        return $this->db->query($sql);
    }




}
?>