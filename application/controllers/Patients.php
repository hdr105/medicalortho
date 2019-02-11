<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Patients extends MY_Controller {

    function __construct() {
        parent::__construct();

        //initialize managerial permission
        $this->init_permission_checker("module_patients");
        $this->load->model("Patient_model");
        $this->load->model("Clients_model");
        $this->load->helper("app_files");
        $this->load->helper("date_time");
        $this->load->helper("general");
    }

    function index() {
        if ($this->login_user->user_type === "staff") 
        {
            $view_data['show_options_column'] = true;
           
          

            $this->template->rander("patient/index", $view_data);
        }
        else
        {
            $this->template->rander("clients/patients/index");
        }   
    }

     function modal_form() {
        validate_submitted_data(array(
            "id" => "numeric"
        ));

        //client should not be able to edit categories
        if ($this->login_user->user_type === "client" && $this->input->post('id')) {
            redirect("forbidden");
        }

        $view_data['client_id'] = $this->login_user->client_id;
        $view_data['model_info'] = $this->Patient_model->get_one($this->input->post('id'));
        $clients = $this->Clients_model->get_dropdown_list_clients();
        $client_names = array();
        foreach ($clients as $key => $value) {
           array_push($client_names, $value->company_name);
        }
        $client_id = array();
        foreach ($clients as $key => $value) {
           array_push($client_id, $value->id);
        }

        $sort_clients = array_combine($client_id,$client_names);
        $view_data['clients'] =  $sort_clients;
        $this->load->view('patient/modal_form',$view_data);
    }



        function save() {



        $id = $this->input->post('id');


        $data = array(
            "name" => $this->input->post('name'),
            "sur_name" => $this->input->post('sur_name'),
            "city" => $this->input->post('city'),
            "assigned_doctor" => $this->input->post('assigned_doctor')
        );

  
        


        $target_path = get_setting("patient_file_path");
        $files_data = move_files_from_temp_dir_to_permanent_dir($target_path, "patients");
        
        $prv_pdf = $this->input->post('previous_pdf');



        $new_images = array();
        foreach ($files_data as $files) 
        {
            $file = $files['file_name'];
            array_push($new_images,$file);
        }

        $uploaded_image =  implode(",",$new_images);
        $inserted_image = !empty($files_data)?$uploaded_image:$prv_pdf; 
           
        $data["created_date"] = get_current_utc_time();
        $data['pdf_file'] = $inserted_image;


        $save_id = $this->Patient_model->save($data, $id);

         if ($save_id) {


            if (!$id) {

                log_notification("patient_added", array("id" => $save_id));
            }
             

            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }



    }

    function list_data() {
        $this->access_only_allowed_members();


        $options = array();

        $list_data = $this->Patient_model->get_details($options)->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }


    function client_list_data() {
        


        $options = array();

        $list_data = $this->Patient_model->get_details($options)->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row_client($data);
        }
        echo json_encode(array("data" => $result));
    }




    private function _row_data($id) {


         $options = array(
            "id" => $id,
        );

        $data = $this->Patient_model->get_details($options)->row();
        return $this->_make_row($data);
    }

    public function get_client_name($id)
    {
       $res = $this->Clients_model->get_one($id);
       return $res->company_name;
    }

    private function _make_row($data) {

        $ass_doc =  $this->get_client_name($data->assigned_doctor);
        $date = $data->created_date;
        $format = date_create($date);
        $created_date = date_format($format,'d-m-Y');
        $row_data = array(
            $data->name,
            $data->sur_name, 
            $data->city, 
            $ass_doc, 
            $created_date
                                
        );
        
        $edit = '<li role="presentation">' . modal_anchor(get_uri("patients/modal_form"), "<i class='fa fa-pencil'></i> " . lang('edit_patient'), array("title" => lang('patients'), "data-post-view" => "details", "data-post-id" => $data->id)) . '</li>';

        $delete = '<li role="presentation">' . js_anchor("<i class='fa fa-times fa-fw'></i>" . lang('delete_patient'), array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("patients/delete"), "data-action" => "delete-confirmation")) . '</li>';

          $row_data[] = '
                <span class="dropdown inline-block">
                    <button class="btn btn-default dropdown-toggle  mt0 mb0" type="button" data-toggle="dropdown" aria-expanded="true">
                        <i class="fa fa-cogs"></i>&nbsp;
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">' . $edit . $delete . '</ul>
                </span>';
           

        return $row_data;
    }


    private function _make_row_client($data) {


         $ass_doc =  $this->get_client_name($data->assigned_doctor);

        $name = modal_anchor(get_uri("patients/view/".$data->id), $data->name, array("class" => "", "title" => $data->name)); 
        $date = $data->created_date;
        $format = date_create($date);
        $created_date = date_format($format,'d-m-Y');
        $row_data = array(
            $name,
            $data->sur_name, 
            $data->city, 
           $ass_doc, 
            $created_date
                                
        );
        return $row_data;
    }

    /* upload a file */

    function upload_file() {
        upload_file_to_temp();
    }

      function validate_patient_file() {
        return validate_post_file($this->input->post("file_name"));
    }

    function delete() {
        $this->access_only_allowed_members();

        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');

            if ($this->Patient_model->delete($id)) {
                echo json_encode(array("success" => true, 'message' => lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
            }
        
    }

    function view($patient_id = 0) {

        if ($patient_id) {

            

            $options = array("id" => $patient_id);
            $patient_info = $this->Patient_model->get_details($options)->row();

            if ($patient_info) {
                $view_data['patient_info'] = $patient_info;
                $this->load->view("clients/patients/view", $view_data);
            } else {
                show_404();
            }
        }
    }


}

?>