<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Demands extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->init_permission_checker("demands_request");
        
    }
        

    public function index() {
        $view_data['show_options_column'] = true;
        $this->template->rander("demands/index", $view_data);
    }

    public function clients()
    {
        $this->template->rander("clients/demands/index");
    }
    public function save() {


        $demands_array = array(
            "type_of_pres" => $this->input->post('tyype_of_pres'),
            "patient" => $this->input->post('patient'),
            "patient_tel" => $this->input->post('patient_tel'),
            "product_name" => $this->input->post('product_name'),
            "comment" => $this->input->post('coment')            
        );

        $demands_array = clean_data($demands_array);

        $demands = $this->Demands_model->save($demands_array);



        if ($demands) {
            echo json_encode(array("success" => true,  "data" => $this->clients(), 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
        log_notification("demands Added", array("id" => $demands));
     
        exit();
    }

    function list_data() {
        $this->access_only_allowed_members();

       
        $options = array();

        $list_data = $this->Demands_model->get_details($options)->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }

        echo json_encode(array("data" => $result));
    }

    private function _make_row($data) {
     


        $row_data = array(
            $data->company_name,
            $data->type_of_pres,
            $data->patient,
            $data->patient_tel,
            $data->product_name,
            $data->comment,               
        );

        return $row_data;
    }



}
