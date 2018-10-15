<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orders extends MY_Controller {

    function __construct() {
        parent::__construct();

        //initialize managerial permission
        $this->init_permission_checker("orders");
        $this->load->model("Product_model");
        $this->load->model("Category_model");
        $this->load->helper("app_files");
        $this->load->helper("date_time");
        $this->load->helper("general");
    }

        function index() {
        $this->check_module_availability("module_order");
        if ($this->login_user->user_type === "client") {

            $view_data = array();
            $this->template->rander("orders/index", $view_data);
        } 
    }


}
?>