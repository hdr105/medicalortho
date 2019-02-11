<?php

class Demands_model extends CI_Model {

    function __construct() {
        
    }

    function save($data) {
        $data["created_at"] = get_current_utc_time();
        $data["created_by"] = $this->login_user->id;
        $this->db->insert("demands", $data);
        return $this->db->insert_id();
    }

    function get_details($options = array()) {
        $demands_table = $this->db->dbprefix('demands');
        $client_table = $this->db->dbprefix('clients');
  
        $sql = "SELECT *
        FROM $demands_table,$client_table WHERE $demands_table.created_by=$client_table.id";
        return $this->db->query($sql);
    }

    public function check_user_group($user_id,$groups)
    {
        return $this->db->select()->from('clients')->where('id',$user_id)->where_in("1",$groups)->get();

    }

}
?>