<?php

class Category_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'category';
        parent::__construct($this->table);
    }

    function get_dropdown_list_catagory($option_fields = array(), $key = "id", $where = array()) {
        $where["parent_id"] = 0;
        $list_data = $this->get_all_where($where, 0, 0, $option_fields[0])->result();
        $result = array();
        foreach ($list_data as $data) {
            $text = "";
            foreach ($option_fields as $option) {
                $text.=$data->$option . " ";
            }
            $result[$data->$key] = $text;
        }
        return $result;
    }

    function get_details($options = array()) {
        $category = $this->db->dbprefix('category');
        $client_groups = $this->db->dbprefix('client_groups');

        $where = "";
        $where_query = false;
       
       
        $sql = "SELECT $category.*, $client_groups.title
        FROM $category
        LEFT JOIN $client_groups ON $client_groups.id= $category.catalog_id ";

       
        return $this->db->query($sql);
    }



}
?>