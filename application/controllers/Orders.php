<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orders extends MY_Controller {

    function __construct() {
        parent::__construct();

        //initialize managerial permission
        $this->init_permission_checker("orders");
        $this->load->model("Product_model");
        $this->load->model("Order_model");
        $this->load->model("Category_model");
        $this->load->model("Client_groups_model");
        $this->load->helper("app_files");
        $this->load->helper("date_time");
        $this->load->helper("general");
    }

    function index() {
        $this->check_module_availability("module_order");
        if ($this->login_user->user_type === "client") {
            $view_data = array();
            $user_id = $this->login_user->id;

            $group_id = get_client_group($user_id);
            $group_ids = $group_id->group_ids;

            $category_groups = explode(",",$group_ids);

            $client_groups = $this->Client_groups_model->get_all_data();
            $newarray = array();

            foreach ($client_groups as $client) 
            {
                array_push($newarray,$client['id']);
            }


            $result=array_intersect($category_groups,$newarray);
        
            
            $view_data['categories'] = $this->Category_model->get_data($result);

            //echo $this->db->last_query(); die;
           
            $this->template->rander("orders/index", $view_data);
        }
        else{
            $this->template->rander("orders/orders");
        } 
    }


    function subCategory($id)
    {
        $user_id = $this->login_user->id;
        $group_id = get_client_group($user_id);
        $group_ids = $group_id->group_ids;
        $category_groups = explode(",",$group_ids);

        $client_groups = $this->Client_groups_model->get_all_data();
        $newarray = array();

        foreach ($client_groups as $client) 
        {
            array_push($newarray,$client['id']);
        }


        $result=array_diff($newarray,$category_groups);

        $view_data['subCategories'] = $this->Category_model->subCategories($id,$result);
        // echo $this->db->last_query();
        // exit();
        $this->template->rander("orders/sub_categories", $view_data);

    }

    function products($id)
    {
        $view_data['id'] = $id;
        $this->template->rander("orders/products", $view_data);
    }


    // list of products, prepared for datatable 
    function list_data($id) {
        $list_data = $this->Product_model->get_details_products($id)->result();
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

    $image_path = base_url("files/product_images/").$data->image;
    $image = '<div class="col-xs-6 col-md-3">
    <a href="" class="thumbnail" target="_blank">
    <img src="'.$image_path.'" alt="Product Image">
    </a>
    </div>';

    $checkbox = '<input type="checkbox" name="orders[]" class="form-check-input" value="'.$data->id.'">';

    $row_data = array(
        $checkbox,
       $image,
        $data->title,
        $data->name, 
        $data->quantity,
        $data->price,              
    );

    // $order_button = '<button class="btn btn-default dropdown-toggle  mt0 mb0" type="button">'.
    // js_anchor("<i class='fa fa-shopping-cart '></i> " . lang('place_order'), array('title' => lang('place_order'), "class" => "", "data-action-url" => get_uri("orders/place_orders/table/$data->id"), "data-action" => "insert")).'
    // </button>';
    
    // $row_data[] = $order_button;
    return $row_data;
}


function place_orders($view_type='',$product_id)
{
 $data = array(
    "product_id" => $product_id,
    "created_date" => get_current_utc_time(),
    "created_by" => $this->login_user->id

);


 $save_id = $this->Order_model->save($data);
 
 if($save_id) 
 {

     echo json_encode(array("success" => true, "data", 'message' => lang('order_placed')));
 }


 log_notification("order_placed", array("id" => $product_id));

}


function myorders()
{
    $this->template->rander("orders/myorders");
}


function order_list() {
 $user =  $this->login_user->id;
 if($user)
 {
    $user_id = $this->login_user->id;
}
$user_id = "";



$list_data = $this->Order_model->get_details_orders($user_id)->result();
$result = array();
foreach ($list_data as $data) {
    $result[] = $this->make_order_row($data);
}
echo json_encode(array("data" => $result));
}

private function make_order_row($data) {

    $row_data = array(
        $data->title,
        $data->created_date         
    );
    if ($data->status === "1") {
        $status_class = "label-warning";
        $status = "<span class='label $status_class large clickable'>" . lang('well_received') . "</span> ";
    } else if ($data->status === "2") {
        $status_class = "label-success";
        $status = "<span class='label $status_class large clickable'>" . lang('being_process') . "</span> ";
    } 
    else if ($data->status === "3") {
        $status_class = "label-danger";
        $status = "<span class='label $status_class large clickable'>" . lang('complete') . "</span> ";
    }

    $row_data[] = $status;
    return $row_data;
}

function order_list_all() {

    $user_id = "";
    

    $list_data = $this->Order_model->get_details_orders($user_id)->result();
    $result = array();
    foreach ($list_data as $data) {
        $result[] = $this->make_order_row_admin($data);
    }
    echo json_encode(array("data" => $result));
}

private function make_order_row_admin($data) {

    $row_data = array(
        $data->title,
        $data->created_date

    );

    if ($data->status === "1") {
        $status_class = "label-warning";
        $status = "<span class='label $status_class large clickable'>" . lang('well_received') . "</span> ";
    } else if ($data->status === "2") {
        $status_class = "label-success";
        $status = "<span class='label $status_class large clickable'>" . lang('being_process') . "</span> ";
    } 
    else if ($data->status === "3") {
        $status_class = "label-danger";
        $status = "<span class='label $status_class large clickable'>" . lang('complete') . "</span> ";
    }

    $row_data[] = $status;

    $options = 
    '<li role="presentation">' . js_anchor("<i class='fa fa-check-circle'></i> " . lang('well_received'), array('title' => lang('well_received'), "class" => "", "data-action-url" => get_uri("orders/change_status/table/$data->id/1"), "data-action" => "update")) . '</li>' . 
    '<li role="presentation">' . js_anchor("<i class='fa fa-check-circle'></i> " . lang('being_process'), array('title' => lang('being_process'), "class" => "", "data-action-url" => get_uri("orders/change_status/table/$data->id/2"), "data-action" => "update")) . '</li>' . 
    '<li role="presentation">' . js_anchor("<i class='fa fa-check-circle'></i> " . lang('complete'), array('title' => lang('complete'), "class" => "", "data-action-url" => get_uri("orders/change_status/table/$data->id/3"), "data-action" => "update")) . '</li>'
    ;


    $row_data[] = '
    <span class="dropdown inline-block">
    <button class="btn btn-default dropdown-toggle  mt0 mb0" type="button" data-toggle="dropdown" aria-expanded="true">
    <i class="fa fa-cogs"></i>&nbsp;
    <span class="caret"></span>
    </button>
    <ul class="dropdown-menu pull-right" role="menu">' . $options . '</ul>
    </span>';


    return $row_data;
}


function change_status($view_type='',$order_id,$status)
{
 $data = array(
    "status" => $status
);
 $save_id = $this->Order_model->save($data, $order_id);
 
 if($view_type == "table") 
 {

     echo json_encode(array("success" => true, "reload"=>true, 'message' => lang('status_changed')));

 }


 log_notification("status_changed", array("id" => $order_id));

}




public function order_all($value='')
{
    $orders = $_POST["orders"];
    $this->db->trans_start();
    foreach ($orders as $order) 
    {
        $data = array(
            "product_id" => $order,
            "created_date" => get_current_utc_time(),
            "created_by" => $this->login_user->id

        );
        $this->Order_model->save($data);
    }
    $this->db->trans_complete();
    $response = array();
    if ($this->db->trans_status() === FALSE)
    {
        $this->db->trans_rollback();
        $response['status'] = false;

    }
    else
    {

        $this->db->trans_commit();
        $response['status'] = true;
         $response['message'] = lang('order_placed');

    }
    echo json_encode($response);
    exit();
   
}



}
?>