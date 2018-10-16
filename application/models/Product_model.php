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

        $where = " $products.deleted =0 ";
        $where_query = false;
        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $products.id=$id";
            $where_query = true;
        }

        $sql = "SELECT $products.*, $category.name
        FROM $products
        LEFT JOIN $category ON $category.id= $products.category_id";
         
         if ($where != "") {
            
            $sql .= " WHERE  $where ";
        }
        return $this->db->query($sql);
    }

    function get_details_products($id) {

        $products = $this->db->dbprefix('products');
        $category = $this->db->dbprefix('category');

        $where = "";
        $where_query = false;
        if (!empty($id)) {

            $where .= " AND $products.category_id=$id ";

        }
        $sql = "SELECT $products.*, $category.name
        FROM $products
        LEFT JOIN $category ON $category.id = $products.category_id  WHERE $products.deleted =0";
        if ($where != "") {

            $sql .= " $where ";
        }
        return $this->db->query($sql);
    }



    function get_products($id)
    {
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("category_id",$id);
        $query = $this->db->get();
        return $query->result_array();
    }






}
?>