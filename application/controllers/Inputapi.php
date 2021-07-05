<?php
////defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/qrcode/vendor/autoload.php';

use Endroid\QrCode\QrCode;

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

class Inputapi extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key

        try {

            $this->load->model('users_model', 'users');
            $this->load->model('inputapi_model', 'inputApi');
            $this->load->model('restservice_model', 'restservice');
            $this->load->model('purchaseorder_model', 'purchaseorder');
            $this->load->model('applicationuploadfiles_model', 'uploadfile');
            $data = $this->post();
            $data['message'] = false;
            $data['req'] = $this->getrequest();
            $data['headers'] = $this->getHeader();
            $user = $this->getUser();
//            $data['user'] = $user;
            $is_valid = $this->users->isUserValid($user);
            if ($is_valid !== true) {
                $this->response(['message'=>$is_valid], REST_Controller::HTTP_UNAUTHORIZED);
            }
//            $requested_url = $_SERVER['REQUEST_URI'];
//            $requested_url = explode('/',$_SERVER['REQUEST_URI']);
//            $requested_api_index = 0;
//            foreach ($requested_url as $index => $key){
//                if (strtoupper($key) === 'INPUTAPI'){
//                    $requested_api_index = $index;
//                    break;
//                }
//            }
//            if ($requested_api_index !== 0) {
//                $requested_function = $requested_url[$requested_api_index+1];
//                if ($requested_function && !method_exists($this, $requested_function)){
//                    $this->response(['message'=>'Not Such a url exists!'], REST_Controller::HTTP_BAD_REQUEST);
//                }
//            }
//            else
//            {
//                $this->response(['message'=>'Not Such a url exists!'], REST_Controller::HTTP_BAD_REQUEST);
//            }

        }
        catch (Exception $e){
            $this->response(['message' => $e -> getMessage()], REST_Controller::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    public function index_get()
    {
        $this->response(['message'=>'Place Holder to Test!'], REST_Controller::HTTP_OK);
    }

    public function index_post()
    {
        $this->response(['status' =>'OK!'], REST_Controller::HTTP_OK);
    }

    public function login_post()
    {
        $userCred = $this->users->login();
        if($userCred) {
            $this->response(array('message' => 'User Logged in!', 'user_data' => $userCred), REST_Controller::HTTP_OK);
        }
        else
        {
            $this->response(array('message' => 'Log in Failed!', 'user_data' => $userCred), REST_Controller::HTTP_OK);
        }
    }

    public function products_get()
    {
        $id = $this->get('id');
        if ($id === NULL) {
            $list = $this->inputApi->products();
            if ($list) {
                $this->response(array('products' => $list), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                exit();
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Products were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                exit();
            }
        }
        $id = intval($id);
        if ($id <= 0) {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            exit();
        }
        $list = $this->inputApi->products($id);
        if (!empty($list)) {
            $this->response(array('product' => $list), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            exit();
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Product could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            exit();
        }
    }

    public function userprofile_get()
    {
        $userData = $this->users->getUserProfileData();
        $this->response(array('message' => 'My Profile', 'user_data' => $userData), REST_Controller::HTTP_OK);
    }

    public function changePassword_put()
    {
        $data = $this->put();
        $respond = $this -> users -> changePassword($data);
        if ($respond === true){
            $this->response(array('message' => 'Password Changed Successfully!'), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            exit();
        }
        elseif ($respond === 0)
        {
            $this->response(array('message' => 'Invalid Password!'), REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            exit();
        }
        elseif ($respond === false)
        {
            $this->response(array('message' => 'Confirmation Error!'), REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            exit();
        }
        else
        {
            $this->response(array('message' => 'Something is wrong! '.$respond), REST_Controller::HTTP_SERVICE_UNAVAILABLE); // BAD_REQUEST (400) being the HTTP response code
        }
    }

    public function addUser_post()
    {
        $data = $this->post();
        $respond = $this -> users -> addApiUser($data);
        if ($respond === true){
            $this->response(array('message' => 'User Created Successfully!'), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            exit();
        }
        elseif ($respond === 0)
        {
            $this->response(array('message' => 'User Id Exists!'), REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            exit();
        }
        elseif ($respond === false)
        {
            $this->response(array('message' => 'Confirmation Error!'), REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            exit();
        }
        else
        {
            $this->response(array('message' => 'Something is wrong! '.$respond), REST_Controller::HTTP_SERVICE_UNAVAILABLE); // BAD_REQUEST (400) being the HTTP response code
        }
    }

    public function suppliermanagement_get(){
        $id = $this->get('id');
        $role_id = $this->users->get_user_role();
        if ($id === NULL) {
            $list = $this->purchaseorder->get_supplier($role_id);
            if ($list) {
                $this->response(array('supplier' => $list), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                exit();
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Suppliers were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                exit();
            }
        }
        $id = intval($id);
        if ($id <= 0) {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            exit();
        }
        $list = $this->purchaseorder->get_supplier_by_id($role_id, $id);
        if (!empty($list)) {
            $this->response(array('supplier' => $list), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            exit();
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Supplier could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            exit();
        }
    }

    public function checkpurchaseorders_get(){

        $app_uid = $this->users->get_app_user_id();
        $fromDate = $this->get('from');
        $toDate = $this->get('to');
        if ($fromDate === NULL && $toDate === NULL) {
            $list = $this->purchaseorder->check_orders($app_uid);
            if ($list) {
                $this->response(array('orders' => $list), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                exit();
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Orders were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                exit();
            }
        }
        $list = $this->purchaseorder->check_orders_by_date($app_uid, $fromDate, $toDate);
        if (!empty($list)) {
            $this->response(array('orders' => $list), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            exit();
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Orders could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            exit();
        }
    }

    public function viewpurchaseorder_get(){

        $app_uid = $this->users->get_app_user_id();
        $id = $this->get('id');
        if (is_null($id)){
            $this->response([
                'status' => FALSE,
                'message' => 'No Order Selected!'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        $list = $this->purchaseorder->view_order($app_uid, $id);
        if (!empty($list)) {
            $this->response(array('orders' => $list), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            exit();
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Order could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            exit();
        }

    }

    public function createpurchaseorder_post(){
        $data = $this->post();

        $app_uid = $this->users->get_app_user_id();
        $data['app_user_id'] = $app_uid;
//        $data['user_id'] = $user_id['id'];
//        exit();

        $respond = $this -> purchaseorder -> create_po($data);
//        if ($respond === true){
//            $this->response(array('message' => 'PO Created Successfully!'), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
//            exit();
            $poNum = $respond;
//        }
//        elseif ($respond === 0)
//        {
//            $this->response(array('message' => 'PO Id Already Exists call for help!'), REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
//            exit();
//        }
//        elseif ($respond === false)
//        {
//            $this->response(array('message' => 'Confirmation Error!'), REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
//            exit();
//        }
//        else
//        {
//            $this->response(array('message' => 'Something is wrong! '.$respond), REST_Controller::HTTP_SERVICE_UNAVAILABLE); // BAD_REQUEST (400) being the HTTP response code
//        }

        $scope = 'purchase_order';
//        $config = $this->get_config_image($scope, $poNum);
        $this->load->helper('form');
        $this->load->helper('url');

//        $config['upload_path'] = base_url(APPPATH).'appUploads/images/'. $scope. '/';
//        $config['upload_path'] = './uploads/';
//        $config['file_name'] = $poNum;
//        $config['overwrite'] = FALSE;
//        $config["allowed_types"] = 'jpg|jpeg|png|gif';
//        $config["max_size"] = 2048000;
        clearstatcache();
//        $config['upload_path']          = FCPATH . 'uploads/';
        $config['upload_path']          = FCPATH . 'appUploads/images/'. $scope. '/';
//        $config['allowed_types']        = 'gif|jpg|png';
//        $config['max_size']             = 100;
//        $config['max_width']            = 1024;
//        $config['max_height']           = 768;
//        $this->load->library('upload', $config);

        $config['file_name'] = $poNum;
        $config['overwrite'] = FALSE;
        $config["allowed_types"] = 'jpg|jpeg|png|gif';
        $config["max_size"] = 2048000;

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('image')) {
            $this->response(array('message' => 'Something is wrong! '.$this->upload->display_errors().  var_dump($_FILES).  var_dump($data['upload_data']) . var_dump($config). var_dump($this->upload)), REST_Controller::HTTP_SERVICE_UNAVAILABLE); // BAD_REQUEST (400) being the HTTP response code
            exit();
        } else {
            $imageData = $this -> input -> post();
            $imageInfo = $this -> upload -> data();
            $imagePath = FCPATH . 'appUploads/images/'. $scope. '/'. $poNum. $imageInfo['file_ext'];
            $imagePath = base_url('appUploads/images/'. $scope. '/'. $poNum. $imageInfo['file_ext']);
//            $upload_result = $this -> purchaseorder -> update_po_image($imageInfo, $poNum);
            $upload_result = $this -> purchaseorder -> update_po_image($imagePath, $poNum);
        }
        if (!$upload_result){
            $this->response(array('message' => 'Error on picture upload!'. var_dump($upload_result). var_dump($imageInfo). var_dump($imageData). var_dump($imagePath)), REST_Controller::HTTP_SERVICE_UNAVAILABLE); // BAD_REQUEST (400) being the HTTP response code
            exit();
        }
        $this->response(array('message' => 'Your P.O. Submitted Successfully!'), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    }

    /*
    protected function get_config_image($scope, $id){
        $this->load->helper('form');
        $this->load->helper('url');
        $config['upload_path'] = './appUploads/images/'. $scope. '/';
        $config['file_name'] = $id;
        $config['overwrite'] = FALSE;
        $config["allowed_types"] = 'jpg|jpeg|png|gif';
        $config["max_size"] = 2048000;
    }
    */

    public function stock_get(){
        $list = $this->users->getStock();
        $stock = [];
        foreach ($list as $item){
            $stock_item = [];
            $stock_item['product'] = $item['product'];
            $stock_item['quantity'] = $item['quantity'];
            $stock_item['product_name'] = $item['product_name'];
            $stock_item['price'] = $item['price'];
            $stock_item['category'] = $item['pcat'];
            $stock_item['category_name'] = $item['title'];
            if ($convert = $this->users->isStockConvertible($item['product'])){
                $stock_item['convertible'] = 1;
                $stock_item['convert'] = $convert;
            }
            array_push($stock, $stock_item);
        }
        if ($list) {
            $this->response(array('status' => 'Successful' ,'stock' => $stock), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            exit();
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Stock is empty or not found!'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            exit();
        }
    }

    public function adjustStock_post(){
        $data = $this->post();
        $respond = $this -> users -> adjustStock($data);
        if ($respond == true){
            $this->response(array('status' => 'Successful' ,'message' => 'Stock Adjusted Successfully!'), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            exit();
        }
        else
            {
            $this->response([
                'status' => FALSE,
                'message' => 'Stock Couldn\'t be adjusted!'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            exit();
        }
    }

    public function convertStock_post(){
        $data = $this->post();
        $respond = $this -> users -> convertStock($data);
        if ($respond == true){
            $this->response(array('status' => 'Successful' ,'message' => 'Stock Converted Successfully!'), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            exit();
        }
        else
        {
            $this->response([
                'status' => FALSE,
                'message' => 'Stock Couldn\'t be converted!'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            exit();
        }
    }

    public function addCustomer_post(){
        $data = $this->post();
        $username = $this -> users -> add_customer($data);
        if(!$username){
            $this->response(array('message' => 'User name Exists or Something is wrong! '.$this->upload->display_errors()), REST_Controller::HTTP_SERVICE_UNAVAILABLE); // BAD_REQUEST (400) being the HTTP response code
            exit();
        }
//        if ($respond === true){
//            $this->response(array('status' => 'Successful' ,'message' => 'Customer Added Successfully!'), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
//            exit();
//        }
//        else
//        {
//            $this->response([
//                'status' => FALSE,
//                'message' => 'Stock Couldn\'t be converted!'
//            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
//            exit();
//        }
        $scope = 'users';
        $this->load->helper('form');
        $this->load->helper('url');

        clearstatcache();

        $files = $_FILES['images'];
        $config['upload_path']          = FCPATH . 'appUploads/images/'. $scope. '/';
//        $config['file_name'] = $poNum;
        $config['overwrite'] = FALSE;
        $config["allowed_types"] = 'jpg|jpeg|png|gif';
        $config["max_size"] = 2048000;

        $this->load->library('upload', $config);

        $images = array();
        $imagePaths = [];
        foreach ($files['name'] as $key => $image) {
            $_FILES['images[]']['name']= $files['name'][$key];
            $_FILES['images[]']['type']= $files['type'][$key];
            $_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
            $_FILES['images[]']['error']= $files['error'][$key];
            $_FILES['images[]']['size']= $files['size'][$key];


            if($key === 0) {
                $fileName = $username . '_profile_pic';
            }
            elseif ($key === 1){
                $fileName = $username . '_register_doc';
            }
            else {
                $fileName = $username . '_' . $image;
            }
            $images[] = $fileName;

            $config['file_name'] = $fileName;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('images[]')) {
//            $this->upload->do_upload('images[]');
                $imageInfo = $this->upload->data();
                $imagePath = base_url('appUploads/images/'. $scope. '/'. $fileName. $imageInfo['file_ext']);
//                $upload_result = $this -> users -> update_customer_images($imagePath, $username, $key);
                array_push($imagePaths, $imagePath);
//                if (!$upload_result){
//                    $this->response(array('message' => 'Error on picture upload!'), REST_Controller::HTTP_SERVICE_UNAVAILABLE); // BAD_REQUEST (400) being the HTTP response code
//                    exit();
//                }
            } else {
                $this->response(array('message' => 'Something is wrong! '.$this->upload->display_errors()), REST_Controller::HTTP_SERVICE_UNAVAILABLE); // BAD_REQUEST (400) being the HTTP response code
                exit();
            }
        }
        $upload_result = $this -> users -> update_customer_images($imagePaths, $username);
        if (!$upload_result){
            $this->response(array('message' => 'Error on picture upload!'), REST_Controller::HTTP_SERVICE_UNAVAILABLE); // BAD_REQUEST (400) being the HTTP response code
            exit();
        }
        $this->response(array('message' => 'Customer Added Successfully!'), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    }

}
