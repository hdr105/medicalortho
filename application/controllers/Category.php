<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category extends MY_Controller {

    function __construct() {
        parent::__construct();

        //initialize managerial permission
        $this->init_permission_checker("category");
        $this->load->model("Category_model");
        $this->load->helper("app_files");
        $this->load->helper("date_time");
        $this->load->helper("general");
    }
    function index() {
        $this->check_module_availability("module_catalog");
        if ($this->login_user->user_type === "staff") {

            $view_data = array();

            $this->template->rander("category/index", $view_data);
        } 
    }

        //load new category modal 
    function modal_form() {
        validate_submitted_data(array(
            "id" => "numeric"
        ));

        //client should not be able to edit categories
        if ($this->login_user->user_type === "client" && $this->input->post('id')) {
            redirect("forbidden");
        }

        $view_data['client_id'] = $this->login_user->client_id;
        $view_data['model_info'] = $this->Category_model->get_one($this->input->post('id'));
        $view_data['parent_category'] = array("" => "-") + $this->Category_model->get_dropdown_list_catagory(array("name"));

        $view_data['client_group'] = array("" => "-") + $this->Client_groups_model->get_dropdown_list(array("title"));
        $this->load->view('category/modal_form', $view_data);
    }
    
    function validate_category_file() {
        return validate_post_file($this->input->post("file_name"));
    }

    function save() {



        $id = $this->input->post('id');


        $data = array(
            "name" => $this->input->post('category'),
            "parent_id" => $this->input->post('parent_cat'),
            "catalog_id"=> $this->input->post("catalog"),
        );

        if (!$id) {

            $target_path = get_setting("category_file_path");
            $files_data = move_files_from_temp_dir_to_permanent_dir($target_path, "category");

            $new_images = array();
            foreach ($files_data as $files) 
            {
                $file = $files['file_name'];
                array_push($new_images,$file);
            }
            $uploaded_image =  implode(",",$new_images);
            
            $data["created_date"] = get_current_utc_time();
            $data["created_by"] = $this->login_user->id;
            $data['image'] = $uploaded_image;
        }
        $save_id = $this->Category_model->save($data, $id);

         if ($save_id) {


            if (!$id) {

                log_notification("catagory_created", array("id" => $save_id));
            }

            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }



    }

        // list of categories, prepared for datatable 
    function list_data() {
        $this->access_only_allowed_members();


        $options = array();

        $list_data = $this->Category_model->get_details($options)->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    private function _row_data($id) {


         $options = array(
            "id" => $id,
        );

        $data = $this->Category_model->get_details($options)->row();
        return $this->_make_row($data);
    }

    public function get_parent_name($id)
    {
       $res = $this->Category_model->get_one($id);
       return $res->name;
    }

    private function _make_row($data) {

        $parent_name = $this->get_parent_name($data->parent_id);

        $row_data = array(
            $data->name,
            $parent_name, 
            $data->title,
            //  modal_anchor(get_uri("category/modal_form"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_category'), "data-post-id" => $data->id))
            // . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete_category'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("estimates/delete"), "data-action" => "delete"))
                                
        );

        $edit = '<li role="presentation">' . modal_anchor(get_uri("category/modal_form"), "<i class='fa fa-pencil'></i> " . lang('edit_category'), array("title" => lang('category'), "data-post-view" => "details", "data-post-id" => $data->id)) . '</li>';

        $delete = '<li role="presentation">' . js_anchor("<i class='fa fa-times fa-fw'></i>" . lang('delete_category'), array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("category/delete"), "data-action" => "delete-confirmation")) . '</li>';

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

    /* upload a file */

    function upload_file() {
        upload_file_to_temp();
    }


    function delete() {
        $this->access_only_allowed_members();

        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');
        if ($this->input->post('undo')) {
            if ($this->Category_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_row_data($id), "message" => lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, lang('error_occurred')));
            }
        } else {
            if ($this->Category_model->delete($id)) {
                echo json_encode(array("success" => true, 'message' => lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
            }
        }
    }



}

?>