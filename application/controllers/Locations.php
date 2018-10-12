<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Locations extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->init_permission_checker("location");
    }

    // load location list view
    function index() {
        $this->check_module_availability("module_location");

        if ($this->login_user->user_type === "staff") {

            $view_data = array();

            $this->template->rander("locations/index", $view_data);
        } else {
            $view_data['client_id'] = $this->login_user->client_id;
            $view_data['page_type'] = "full";
            $this->template->rander("clients/locations/index", $view_data);
        }
    }

    //load new tickt modal 
    function modal_form() {
        validate_submitted_data(array(
            "id" => "numeric"
        ));

        //client should not be able to edit ticket
        if ($this->login_user->user_type === "client" && $this->input->post('id')) {
            redirect("forbidden");
        }

    
        $view_data['model_info'] = $this->Location_model->get_one($this->input->post('id'));

        if ($this->login_user->user_type == "client") {
            
            $view_data['client_id'] = $this->login_user->client_id;;
        }

        

        $this->load->view('locations/modal_form', $view_data);
    }

    //get project suggestion against client
    function get_project_suggestion($client_id = 0) {

        $this->access_only_allowed_members();

        $projects = $this->Projects_model->get_dropdown_list(array("title"), "id", array("client_id" => $client_id));
        $suggestion = array(array("id" => "", "text" => "-"));
        foreach ($projects as $key => $value) {
            $suggestion[] = array("id" => $key, "text" => $value);
        }
        echo json_encode($suggestion);
    }

    // add a new ticket
    function save() {
        $id = $this->input->post('id');

        // if ($id) {
        //     validate_submitted_data(array(
        //         "ticket_type_id" => "required|numeric"
        //     ));
        // } else {
        //     validate_submitted_data(array(
        //         "client_id" => "required|numeric",
        //         "ticket_type_id" => "required|numeric"
        //     ));
        // }


        $client_id = $this->input->post('client_id');

        $this->access_only_allowed_members_or_client_contact($client_id);

        //if this logged in user is a client then overwrite the client id
        if ($this->login_user->user_type === "client") {
            $client_id = $this->login_user->client_id;
        }


        $now = get_current_utc_time();

        $location_data = array(
            "client_id" => $client_id,
            "rental_type" => $this->input->post('rental_type'),
            "quantity" => $this->input->post('quantity'),
            "patient" => $this->input->post('patient'),
            "room" => $this->input->post('room'),
            "service" => $this->input->post('service'),
            "comment" => $this->input->post('comment'),            
            "created_by" => $this->login_user->id,
            "created_at" => $now,
        );

        $location_data = clean_data($location_data);

        if ($id) {
            //client can't update ticket
            if ($this->login_user->user_type === "client") {
                redirect("forbidden");
            }

            //remove not updateable fields
            unset($location_data['client_id']);
            unset($location_data['created_by']);
            unset($location_data['created_at']);
        }

        $location_id = $this->Location_model->save($location_data, $id);



        if ($location_id) {


            //ticket added. now add a comment in this ticket
            if (!$id) {


                if ($location_id) {
                    log_notification("location_created", array("location_id" => $location_id));
                }
            }

            echo json_encode(array("success" => true,  "data" => $this->_row_data($location_id),'id' => $location_id, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }



    // list of tickets, prepared for datatable 
    function list_data() {
        $this->access_only_allowed_members();

       
        $options = array();

        $list_data = $this->Location_model->get_details($options)->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    // list of tickets of a specific client, prepared for datatable 
    function location_list_data_of_client($client_id) {
        $this->access_only_allowed_members_or_client_contact($client_id);

        $options = array(
            "client_id" => $client_id,
            "access_type" => $this->access_type,
        );

        $list_data = $this->Location_model->get_details($options)->result();

        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    // return a row of ticket list table 
    private function _row_data($id) {
     

        $options = array(
            "id" => $id,
            "access_type" => $this->access_type,
        );

        $data = $this->Location_model->get_details($options)->row();
        return $this->_make_row($data);
    }

    //prepare a row of ticket list table
    private function _make_row($data) {
     


        $row_data = array(
            $data->rental_type,
            $data->quantity,
            $data->patient,
            $data->room,
            $data->service,
                        
        );



        if ($this->login_user->user_type == "staff") {
            $options = array("id" => $data->id);

            $location_info = $this->Location_model->get_details($options)->row();

            if ($location_info) {
                $this->access_only_allowed_members_or_client_contact($location_info->client_id);        

                $row_data[] = $data->comment;
                $row_data[] = $data->company_name;
            }
        }

        return $row_data;
    }




}

/* End of file tickets.php */
/* Location: ./application/controllers/tickets.php */