<?php

class Patient_model extends Crud_model {

    function __construct() {
        $this->table = 'patients';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {

        $patients = $this->db->dbprefix('patients');

         $where = "deleted = 0 ";
        $where_query = false;
        $id = get_array_value($options, "id");
        
        if ($id) {
            $where .= "AND id = $id ";
            $where_query = true;
        }
       
       
        $sql = "SELECT *
        FROM $patients ";

        if ($where != "") {
            
            $sql .= " WHERE  $where ";
        }

       
        return $this->db->query($sql);
    }


}
?>