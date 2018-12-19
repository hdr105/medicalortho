<?php

class Category_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'category';
        parent::__construct($this->table);
    }

    function get_dropdown_list_catagory($option_fields = array(), $key = "id", $where = array()) {
        $where["parent_id"] = 0;
        $where['deleted'] = 0;
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

     function get_dropdown_list_subcatagory($option_fields = array(), $key = "id", $where = array()) {
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("parent_id != 0");
        $this->db->where("deleted",0);
        $query = $this->db->get()->result();

         $result = array();
        foreach ($query as $data) {
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

        $where = " $category.deleted = 0 ";
        $where_query = false;
        $id = get_array_value($options, "id");
        
        if ($id) {
            $where .= " AND $category.id=$id ";
            $where_query = true;
        }
       
       
        $sql = "SELECT $category.*
        FROM $category ";

        if ($where != "") {
            
            $sql .= " WHERE  $where ";
        }

       
        return $this->db->query($sql);
    }

    function get_data($group_ids)
    {

        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("parent_id",0);
        $this->db->where("deleted",0);
        if(isset($group_ids))
        {
            foreach ($group_ids as $group) 
            {
                $this->db->where("catalog_id != $group");
            }
            
        }
        

        $query = $this->db->get();
        return $query->result_array();
    }

    function subCategories($id,$group_id)
    {
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("parent_id",$id);
        $this->db->where("deleted",0);
        if(isset($group_id))
        {
            foreach ($group_id as $group) 
            {
                $this->db->where("catalog_id != $group");
            }
            
        }
        $query = $this->db->get();
        return $query->result_array();
    }



}
?>