<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product extends MY_Controller {

    function __construct() {
        parent::__construct();

        //initialize managerial permission
        $this->init_permission_checker("product");
        $this->load->model("Product_model");
        $this->load->model("Category_model");
        $this->load->helper("app_files");
        $this->load->helper("date_time");
        $this->load->helper("general");
    }

    function index() {
        //$this->check_module_availability("module_product");
        if ($this->login_user->user_type === "staff") {

            $view_data = array();

            $this->template->rander("products/index", $view_data);
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
        $view_data['model_info'] = $this->Product_model->get_one($this->input->post('id'));
        $view_data['category_dropdown'] = array("" => "-") + $this->Category_model->get_dropdown_list_subcatagory(array("name"));
        $this->load->view('products/model_form', $view_data);
    }

    function save() {
        $id = $this->input->post('id');

        $data = array(
            "category_id" => $this->input->post('category'),
            "title" => $this->input->post('title'),
            "description"=> $this->input->post("description"),
            "quantity"=> $this->input->post("quantity"),
            "price"=> $this->input->post("price")
        );

        if (!$id) {

            $target_path = get_setting("product_file_path");
            $files_data = move_files_from_temp_dir_to_permanent_dir($target_path, "product");
            
            $new_images = array();
            foreach ($files_data as $files) 
            {
                $file = $files['file_name'];
                array_push($new_images,$file);
            }
            $uploaded_image =  implode(",",$new_images);


            $data['image'] = $uploaded_image;
            $data["created_date"] = get_current_utc_time();
            $data["created_by"] = $this->login_user->id;
        }
        $save_id = $this->Product_model->save($data, $id);
         if ($save_id) {


            if (!$id) {

                log_notification("Product_created", array("id" => $save_id));
            }
            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }



    }


    // list of products, prepared for datatable 
    function list_data() {
        $this->access_only_allowed_members();


        $options = array();

        $list_data = $this->Product_model->get_details($options)->result();
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

        $data = $this->Product_model->get_details($options)->row();
        return $this->_make_row($data);
    }

    private function _make_row($data) {

        $row_data = array(
            $data->title,
            $data->name, 
            $data->quantity,
            $data->price
        );
        $edit = '<li role="presentation">' . modal_anchor(get_uri("product/modal_form"), "<i class='fa fa-pencil'></i> " . lang('edit_product'), array("title" => lang('category'), "data-post-view" => "details", "data-post-id" => $data->id)) . '</li>';

        $delete = '<li role="presentation">' . js_anchor("<i class='fa fa-times fa-fw'></i>" . lang('delete_product'), array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("product/delete"), "data-action" => "delete-confirmation")) . '</li>';

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

    /* check valid file for products */

    function validate_category_file() {
        return validate_post_file($this->input->post("file_name"));
    }

     function delete() {
        $this->access_only_allowed_members();

        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');

        if ($this->input->post('undo')) {
            if ($this->Product_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_row_data($id), "message" => lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, lang('error_occurred')));
            }
        } else {
            if ($this->Product_model->delete($id)) {
                echo json_encode(array("success" => true, 'message' => lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
            }
        }
    }


}

?>