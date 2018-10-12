<?php

class Location_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'location';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $locations_table = $this->db->dbprefix('location');
        $clients_table = $this->db->dbprefix('clients');

        $where = "";
         $where_query = false;
        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " $locations_table.id=$id ";

            $where_query = true;
        }
        $client_id = get_array_value($options, "client_id");
        if ($client_id) {
            if ($where_query) {
                $where .= " AND ";
            }

            $where .= " $locations_table.client_id=$client_id ";
            
        }

    
       
        $sql = "SELECT $locations_table.*, $clients_table.company_name
        FROM $locations_table
        LEFT JOIN $clients_table ON $clients_table.id= $locations_table.client_id ";

        if ($where != "") {
            
            $sql .= " WHERE  $where ";
        }
        return $this->db->query($sql);
    }

    function count_new_tickets($ticket_types = "") {
        $tickets_table = $this->db->dbprefix('tickets');
        $where = "";
        if ($ticket_types) {
            $where = " AND FIND_IN_SET($tickets_table.ticket_type_id, '$ticket_types')";
        }
        $sql = "SELECT COUNT($tickets_table.id) AS total
        FROM $tickets_table
        WHERE $tickets_table.deleted=0  AND $tickets_table.status='new' $where";
        return $this->db->query($sql)->row()->total;
    }

    function get_ticket_status_info() {
        $tickets_table = $this->db->dbprefix('tickets');
        $where = "";

        $sql = "SELECT $tickets_table.status, COUNT($tickets_table.id) as total
        FROM $tickets_table
        WHERE $tickets_table.deleted=0 $where
        GROUP BY $tickets_table.status";
        return $this->db->query($sql);
    }

    function get_label_suggestions() {
        $tickets_table = $this->db->dbprefix('tickets');
        $sql = "SELECT GROUP_CONCAT(labels) as label_groups
        FROM $tickets_table
        WHERE $tickets_table.deleted=0";
        return $this->db->query($sql)->row()->label_groups;
    }
    
    
     function delete_ticket_and_sub_items($ticket_id) {
        $tickets_table = $this->db->dbprefix('tickets');
        $ticket_comments_table = $this->db->dbprefix('ticket_comments');
        
      
        //get ticket comments info to delete the files from directory 
        $ticket_comments_sql = "SELECT * FROM $ticket_comments_table WHERE $ticket_comments_table.deleted=0 AND $ticket_comments_table.ticket_id=$ticket_id; ";
        $ticket_comments = $this->db->query($ticket_comments_sql)->result();

        //delete the ticket and sub items
        $delete_ticket_sql = "UPDATE $tickets_table SET $tickets_table.deleted=1 WHERE $tickets_table.id=$ticket_id; ";
        $this->db->query($delete_ticket_sql);

        $delete_comments_sql = "UPDATE $ticket_comments_table SET $ticket_comments_table.deleted=1 WHERE $ticket_comments_table.ticket_id=$ticket_id; ";
        $this->db->query($delete_comments_sql);

       
        //delete the files from directory
        $comment_file_path = get_setting("timeline_file_path");
        
        foreach ($ticket_comments as $comment_info) {
            if ($comment_info->files && $comment_info->files != "a:0:{}") {
                $files = unserialize($comment_info->files);
                foreach ($files as $file) {
                    $source_path = $comment_file_path . get_array_value($file, "file_name");
                    delete_file_from_directory($source_path);
                }
            }
        }

        return true;
    }

}
