<?php

class Product_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'products';
        parent::__construct($this->table);
    }



    function get_details($options = array()) {
        $products = $this->db->dbprefix('products');
        $category = $this->db->dbprefix('category');

        $sql = "SELECT $products.*, $category.name
        FROM $products
        LEFT JOIN $category ON $category.id= $products.category_id ";
        return $this->db->query($sql);
    }



}
?>