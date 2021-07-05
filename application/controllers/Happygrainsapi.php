<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

require_once APPPATH . 'third_party/vendor/bshaffer/oauth2-server-php/src/OAuth2/Autoloader.php';
OAuth2\Autoloader::register();
use OAuth2\Request;

class Happygrainsapi extends REST_Controller
{

    var $Oauth;


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
            $this->load->model('purchase_model', 'purchase');
            $this->load->model('applicationuploadfiles_model', 'uploadfile');
             $this->load->library('Oauth2handler');

//            $this->prepare_oauth_login_api();
            $data = $this->post();
        }
        catch (Exception $e){
            $this->response(['message' => $e -> getMessage()], REST_Controller::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    protected function prepare_oauth_login_api()
    {
        echo json_encode('before_oauth');
        $token = $this->oauth2handler->getToken();
        $request = OAuth2\Request::createFromGlobals();

        if (!$this->oauth2handler->server->verifyResourceRequest($request)){
            $this->oauth2handler->server->getResponse()->send();
            die();
        }
    }

    protected function check_client_token()
    {
        if (!$this->oauth2handler->server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
            $this->oauth2handler->server->getResponse()->send();
            die;
        }
    }

    private function set_user_token(){
        $this->check_client_token();
        $userId = $this->oauth2handler->server->getAccessTokenData(OAuth2\Request::createFromGlobals());
        $this->users->setUserId($userId['user_id']);
    }

    public function loginApp_post()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $sql = "SELECT users_id,account_id,role_id,status,name,email,token,profile_pic FROM (users) WHERE ";
        $sql .= "email = '";
        $sql .= $email;
        $sql .="' and password= '";
        $sql .= md5($email.$password."Happy");
        $sql .="'";
        $query = $this->db->query($sql);
        $result = $query->result_array();

        if($result)
        {
            $token= md5("Happy#$@Token_!User215364".$result[0]["users_id"].time());
            $this->db->set("token", $token);
            $this->db->where('users_id', $result[0]["users_id"]);
            $this->db->update('users');
            $result[0]["token"]=$token;
            echo json_encode([
                "msg"  => "Successful Loing.",
                "code"  => "1",
                "user_data" => $result[0]
            ]);

        } else{
            echo json_encode([
                "msg"  => "Not Found User".$email.$password,
                "code"  => "-1",
                "user_data" => null
            ]);
        }

        /* $tokenResponse = $this->oauth2handler->getToken();
         $userCred = $tokenResponse->getResponseBody();
         $httpCode = $tokenResponse->getStatusCode();
         if($userCred && $tokenResponse->isSuccessful()) {
             $this->response(array('message' => 'User Logged in!', 'user_data' => json_decode($userCred, true)), $httpCode);
         }
         else
         {
             $this->response(array('message' => 'Log in Failed!', 'user_data' => json_decode($userCred, true)), $httpCode);
         }*/
    }


//    public function token_post(){
//        return $this->oauth2handler->getToken()->send();
//    }

    public function userData_post(){
        $this->set_user_token();
        $this->response( $this->users->login(), 200);
    }

    public function index_post()
    {
        $this->response(['status' =>'OK!'], REST_Controller::HTTP_OK);
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

    public function userProfile_post()
    {
        $this->set_user_token();
        $userData = $this->users->getUserProfileData();
        $this->response(array('message' => 'My Profile', 'user_data' => $userData), REST_Controller::HTTP_OK);
    }

    public function changePassword_put()
    {
        $this->set_user_token();
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
        $this->set_user_token();
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

    public function supplierManagement_get(){
        $this->set_user_token();
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

    public function checkPurchaseOrders_get(){

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

    public function viewPurchaseOrder_get(){

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

    public function createPurchaseOrder_post(){
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



    ///////////////////////////start new/////////////////////////////////
    ///     ///////////////////////////start new/////////////////////////////////

    ///////////////////////////start purchase and sales/////////////////////////////////
    public function listProduct_get()
    {
        $headers =  $this->input->request_headers();
        $res_checkHeader=$this->checkHeader($headers);

        if($res_checkHeader["status"]=="error"){
        echo json_encode($res_checkHeader);
        }
        else{
            $results_product_items=array();

            $query_product = $this->db->select('pid,pcat,product_name,product_price,product_des,image')->from('geopos_products')->get();
            $results_products = $query_product->result_array();
            foreach($results_products as $product){
                $results_items_details=array();
                $query_item = $this->db->select('to_product')->from('application_convert_amounts')->where('from_product', $product['pid'])->get();
                $results_items = $query_item->result_array();
                foreach($results_items as $items){
                    $query_item_temp = $this->db->select('pid,pcat,product_name,product_price,product_des,image')->from('geopos_products')->where('pid', $items['to_product'])->get();
                    $results_items_temp = $query_item_temp->result_array();

                    $items["item"]=$results_items_temp;
                    array_push($results_items_details,$items);
                }
                $product["item-details"]=$results_items_details;
                unset($results_items_details);
                array_push($results_product_items,$product);
            }

           // echo "<h2>List Stocks & Products & ProductItems</h2>"."<br>";
           // echo "<pre>"; print_r($results_product_items);echo "</pre>";
            echo json_encode(array("status" => "Success","message"=>json_encode($results_product_items)));

        }


    }

    public function purchaseOrder_post(){
       $headers =  $this->input->request_headers();
        if ($headers['Token']!=null) {
            $tokenId = $headers['Token'];
            $sql = "SELECT users_id,supuser_id FROM (users) WHERE ";
            $sql .= "token = '";
            $sql .= $tokenId;
            $sql .="'";
            $query = $this->db->query($sql);
            $result = $query->result_array();
           // print_r($result[0]['users_id']) ;

             if($result){
                 $img_name=null;
                /* $config = array(
                     'upload_path' => FCPATH . 'userfiles/order/',
                     'allowed_types' => "jpg|png|jpeg",
                     'overwrite' => TRUE,
                     'encrypt_name' => TRUE,
                     'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                 );
                 $this->load->library('upload', $config);
                 if($this->upload->do_upload('image'))
                 {
                     $data = array('upload_data' => $this->upload->data());
                     $img_name =$data['upload_data']['file_name'] ;
                 }*/
                $currency = "RM";//$this->input->post('mcurrency');
                $customer_id = $result[0]['users_id'];//$this->input->post('customer_id');
                $invocieno = rand(1000,10000);//$this->input->post('invocieno');
                $invoicedate = date('Y-m-d');//$this->input->post('invoicedate');
                $invocieduedate = date('Y-m-d');//$this->input->post('invocieduedate');
                $purch_sale=$this->input->post('purch_sale');
                $notes ="no note";// $this->input->post('notes', true);
                $tax ="0.0";// $this->input->post('tax_handle');
                $subtotal = rev_amountExchange_s($this->input->post('total'), 0, 0);// rev_amountExchange_s($this->input->post('subtotal'), 0,0);
                $shipping ="0.0";//  rev_amountExchange_s($this->input->post('shipping'), 0, 0);
                $shipping_tax ="0.0";//  rev_amountExchange_s($this->input->post('ship_tax'), 0, 0);
                $ship_taxtype ="incl";//  $this->input->post('ship_taxtype');
                if ($ship_taxtype == 'incl') @$shipping = $shipping - $shipping_tax;
                $refer ="";// $this->input->post('refer', true);
                $total = rev_amountExchange_s($this->input->post('total'), 0, 0);
                $total_tax = 0;
                $total_discount = 0;
                $discountFormat = '0';//$this->input->post('discountFormat');
                $pterms = "1";//$this->input->post('pterms');
                $i = 0;
                if ($discountFormat == '0') {
                    $discstatus = 0;
                } else {
                    $discstatus = 1;
                }

                if ($customer_id == 0) {
                    echo json_encode(array('status' => 'Error', 'message' =>
                        "Please add a new supplier or search from a previous added!"));
                    exit;
                }


                $this->db->trans_start();
                //products
                $transok = true;   log_message('error',"------------------------------------ghjghacascsascjERR:");
                //Invoice Data
                $bill_date =datefordatabase($invoicedate);
                $bill_due_date =datefordatabase($invoicedate);

                 $data = array('tid' => $invocieno, 'invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date,
                    'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype,
                    'total' => $total, 'notes' => $notes, 'csd' => $customer_id, 'eid' => $result[0]['users_id'],
                    'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer,
                    'term' => $pterms, 'loc' => '', 'multi' => $currency,'user_id'=>$result[0]['users_id'],'supuser_id'=>$result[0]['supuser_id'],
                    'image'=>$img_name,'purch_sale'=>$purch_sale);


                 if ($this->db->insert('geopos_purchase', $data)) {
                    $invocieno = $this->db->insert_id();

                    $pid = $this->input->post('pid');
                    $productlist = array();
                    $prodindex = 0;
                    $itc = 0;
                    $products= $this->input->post('products');
                   // foreach ($pid as $key => $value) {
                    foreach (json_decode($products) as $key => $value) {
                       // $total_discount += numberClean(@$ptotal_disc[$key]);
                      //  $total_tax += numberClean($ptotal_tax[$key]);


                        $data = array(
                            'tid' => $invocieno,
                            'pid' =>$value->pid,
                            'product' =>$value->product_name,
                            'code' => "1",
                            'qty' => $value->product_qty,
                            'price' => rev_amountExchange_s($value->product_price, 0, 0),
                            //'tax' => numberClean($product_tax[$key]),
                            //'discount' => numberClean($product_discount[$key]),
                            'subtotal' => rev_amountExchange_s($value->product_subtotal, 0, 0),
                            //'totaltax' => rev_amountExchange_s($ptotal_tax[$key], 0, 0),
                            //'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], 0, 0),
                            'product_des' => "desc",
                            'unit' => "1"
                        );

                        $flag = true;
                        $productlist[$prodindex] = $data;
                        $i++;
                        $prodindex++;
                        $amt = numberClean($value->product_qty);

                        if ($value->pid > 0) {
                          //  if ($this->input->post('update_stock') == 'yes') {

                                $this->db->set('qty', "qty+$amt", FALSE);
                                $this->db->where('pid', $value->pid);
                                $this->db->update('geopos_products');
                         //   }
                            $itc += $amt;
                        }

                    }
                    if ($prodindex > 0) {
                        $this->db->insert_batch('geopos_purchase_items', $productlist);
                        $this->db->set(array('discount' => rev_amountExchange_s(amountFormat_general($total_discount), 0, 0), 'tax' => rev_amountExchange_s(amountFormat_general($total_tax), 0, 0), 'items' => $itc));
                        $this->db->where('id', $invocieno);
                        $this->db->update('geopos_purchase');

                    } else {
                        echo json_encode(array('status' => 'Error', 'message' =>
                            "Please choose product from product list. Go to Item manager section if you have not added the products."));
                        $transok = false;
                    }


                    echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Purchase order success')));
                } else {
                    log_message('error',"------------------------------------ghjghacascsascj:". $this->lang->line('ERROR'));
                    echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
                    $transok = false;
                }


                if ($transok) {
                    $this->db->trans_complete();
                } else {
                    log_message('error',"------------------------------------ghjghacascsascj1:". $this->lang->line('ERROR'));

                    $this->db->trans_rollback();
                }

            } else{
                echo json_encode(array('status' => 'You are not logged in'));
            }

        }
        else{
            echo json_encode(array('status' => 'Required SupUser Id and Token'));
        }



    }

    public function purchaseOrder_get(){
        $headers =  $this->input->request_headers();
        if ($headers['Token']!=null) {
            $tokenId = $headers['Token'];
            $sql = "SELECT users_id,supuser_id FROM (users) WHERE ";
            $sql .= "token = '";
            $sql .= $tokenId;
            $sql .="'";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            // print_r($result[0]['users_id']) ;
            log_message('error',"------------------------------------ghjghacascsascj:". "purchaseOrder_get");

            if($result){
              //  $list = $this->purchase->get_purchases($result[0]['users_id']);
                $fromDate = $this->get('from');
                $toDate = $this->get('to');
                $purch_sale = $this->get('purch_sale');
                $list = $this->purchase->check_orders_by_date($result[0]['users_id'],$fromDate,$toDate,$purch_sale);
                $data = array();

                $no = 0;

                foreach ($list as $invoices) {
                    $no++;
                    $row = array();
                    $row['id'] = $invoices->id;
                    $row['tid'] = $invoices->tid;
                    $row['subtotal'] = $invoices->subtotal;
                    $row['invoicedate'] =date("M d", strtotime($invoices->invoicedate));// dateformat($invoices->invoicedate);
                    $row['status'] =  $invoices->status;
                    $data[] = $row;
                }

                //output to json format
                echo json_encode(array('status' => 'Success', 'message' =>json_encode($data)));
            }
            else{
                echo json_encode(array('status' => 'You are not logged in'));
            }

        }else{
                echo json_encode(array('status' => 'Required SupUser Id and Token'));
            }

    }

    public function purchaseOrderDetails_get(){
        $headers =  $this->input->request_headers();
        $res_checkHeader=$this->checkHeader($headers);

        if($res_checkHeader["status"]=="error"){
            print_r( json_encode($res_checkHeader));
        }
        else{
            $list = $this->purchase->purchase_products($this->get('item_id'));
            echo json_encode(array('status' => 'Success', 'message' =>json_encode($list)));
        }
    }

    public function purchaseOrderByUser_get(){
        $headers =  $this->input->request_headers();
        $res_checkHeader=$this->checkHeader($headers);

        if($res_checkHeader["status"]=="error"){
            print_r( json_encode($res_checkHeader));
        }
        else{
$data=$this->purchase->check_orders_by_user( $res_checkHeader["message"][0]['users_id']);
            echo json_encode(array('status' => 'Success', 'message' =>json_encode($data)));
        }

    }

    public function ConvertToDO_post(){
        $headers =  $this->input->request_headers();
        $res_checkHeader=$this->checkHeader($headers);

        if($res_checkHeader["status"]=="error"){
            print_r( json_encode($res_checkHeader));
        }
        else{
            $res= $this->purchase->ConvertToDO($this->input->post('item_id'));
            if($res){
                echo json_encode(array("status" => "Success","message"=>"Done"));
            }
            else{
                echo json_encode(array("status" => "error","message"=>"Error"));
            }
        }
    }
    ///////////////////////////end purchase and sales/////////////////////////////////
    ///////////////////////////start user and customer/////////////////////////////////
    public function addCustomernew_post(){
        $headers =  $this->input->request_headers();
        $res_checkHeader=$this->checkHeader($headers);

        if($res_checkHeader["status"]=="error"){
            print_r( json_encode($res_checkHeader));
        }
        else{
            $dataAccount=array('company_name'=>$this->input->post('companyName'),'credit'=>"0",
                'credit_term'=>$this->input->post('strPT'),'credit_limit'=>$this->input->post('credit_limit')
            ,'address'=>$this->input->post('address'));

            $resAddAccount= $this->users->addAccount($dataAccount);
            $strRole=$this->input->post('strRole');
            $email=$this->input->post('email');
            $name=$this->input->post('contactPerson');
            $data = array('role_id' => $strRole, 'supuser_id' => $res_checkHeader["message"][0]['users_id'],
                'password' => md5($email.$this->input->post('password')."Happy"),
                'account_id' => ($resAddAccount != FALSE) ? $resAddAccount : 0
            , 'status' => "active",'token'=>"hjghjgjh",'name'=>$name,'email'=>$email);
            $res= $this->users->addcustomer($data);
           if($res){
               echo json_encode(array("status" => "Success","message"=>"customer create"));
           }
           else{
               echo json_encode(array("status" => "error","message"=>"user exist"));
           }

        }
    }

    public function addUsernew_post(){
        $headers =  $this->input->request_headers();
        $res_checkHeader=$this->checkHeader($headers);

        if($res_checkHeader["status"]=="error"){
            print_r( json_encode($res_checkHeader));
        }
        else{
           $strRole=$res_checkHeader["message"][0]['role_id'];
            $email=$this->input->post('email');
            $name=$this->input->post('name');
            $password=$this->input->post('password');
            $data = array('role_id' => $strRole, 'supuser_id' => $res_checkHeader["message"][0]['users_id'], 'password' => md5($email.$password."Happy"),
                'account_id' => $res_checkHeader["message"][0]['account_id'], 'status' => "active",'token'=>"hjghjgjh",'name'=>$name,'email'=>$email);
            $res= $this->users->adduser_new($data);

            if($res){
                echo json_encode(array("status" => "Success","message"=>"user create"));
            }
            else{
                echo json_encode(array("status" => "error","message"=>"user exist"));
            }

        }
    }

    public function Roles_PT_get(){
        $headers =  $this->input->request_headers();
        $res_checkHeader=$this->checkHeader($headers);

        if($res_checkHeader["status"]=="error"){
            print_r( json_encode($res_checkHeader));
        }
        else{
            echo json_encode(array("status" => "Success","message"=>$this->users->getRoles_PT()));
        }

    }

    public function getProfileAccount_get(){
        $headers =  $this->input->request_headers();
        $res_checkHeader=$this->checkHeader($headers);

        if($res_checkHeader["status"]=="error"){
            print_r( json_encode($res_checkHeader));
        }
        else{
            $res= $this->users->getProfileAccount($res_checkHeader["message"][0]['users_id']
            ,$res_checkHeader["message"][0]['account_id']);
            echo json_encode(array("status" => "Success","message"=>$res));
        }
    }

    public function getCustomers_get(){
            $headers =  $this->input->request_headers();
            $res_checkHeader=$this->checkHeader($headers);

            if($res_checkHeader["status"]=="error"){
                print_r( json_encode($res_checkHeader));
            }
            else{
                $res= $this->users->getCustomers();
                echo json_encode(array("status" => "Success","message"=>$res));
            }
    }
    ///////////////////////////end user and customer/////////////////////////////////

    /////////////////////////////////////payment
    public function credit_debitSave_post(){
        $headers =  $this->input->request_headers();
        $res_checkHeader=$this->checkHeader($headers);

        if($res_checkHeader["status"]=="error"){
            print_r( json_encode($res_checkHeader));
        }
        else{

            $data = array(
                'user_id' => $res_checkHeader["message"][0]['users_id'],
                'dn_cn_num' => $this->input->post('dn_cn_num'),
                'from_to' => $this->input->post('from_to'),
                'invoice_to' => $this->input->post('invoice_to'),
                'amount' => $this->input->post('amount'),
                'remark' => $this->input->post('remark'),
                'date_time' => $this->input->post('date_time'),
                'credit_debit' => $this->input->post('credit_debit'),
            );
            $this->purchase->saveCreditDebit($data);
            echo json_encode(array('status' => 'Success', 'message' =>'YOUR CREDIT/DEBIT SENT SUCCESSFULLY'));
        }
    }
    public function paymentSave_post(){
        $headers =  $this->input->request_headers();
        $res_checkHeader=$this->checkHeader($headers);

        if($res_checkHeader["status"]=="error"){
            print_r( json_encode($res_checkHeader));
        }
        else{
            $config = array(
                'upload_path' => FCPATH . 'appUploads/images/',
                'allowed_types' => "*",
                'overwrite' => TRUE,
                'encrypt_name' => TRUE,
                'max_size' => "4096000", // Can be set to particular file size , here it is 4 MB(4096 Kb)
            );
            $img_name=null;
            $this->load->library('upload', $config);
            if($this->upload->do_upload('image'))
            {//log_message('error',"------------------------------------ghjghacascsascjhasfile:");
                $data = array('upload_data' => $this->upload->data());
                $img_name =$data['upload_data']['file_name'];
                //echo json_encode(array('status' => 'Success', 'message' =>$img_name."////".$this->input->post('desc')."////".$this->input->post('desc2')));
            }
            else {//log_message('error',"------------------------------------ghjghacascsascjNOhasfile:");
                $img_name=null;
            }

            $data = array(
                'pay_date' => $this->input->post('pay_date'),
                'user_id' => $res_checkHeader["message"][0]['users_id'],
                'pay_num' => $this->input->post('pay_num'),
                'pay_to' => $this->input->post('pay_to'),
                'pay_invoice_to' => $this->input->post('pay_invoice_to'),
                'amount' => $this->input->post('amount'),
                'remark' => $this->input->post('remark'),
                'image' => $img_name,
            );
            $this->purchase->savePayment($data);
            echo json_encode(array('status' => 'Success', 'message' =>'YOUR PAYMENT SENT SUCCESSFULLY'));
        }


    }
    private function checkHeader($headers){

        if ($headers['Token']!=null) {
            $tokenId = $headers['Token'];
            $sql = "SELECT users_id,supuser_id,role_id,account_id FROM (users) WHERE ";
            $sql .= "token = '";
            $sql .= $tokenId;
            $sql .= "'";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            if($result){
                return array("status" => 'Success',"message"=>$result);
                //response > {"status":"Success","message":[{"users_id":"1","supuser_id":"2"}]}
            }
            else{
                return array("status" => "error","message"=>"You are not logged in");
            }

        }else{
            return array("status" => "error","message"=>"Required SupUser Id and Token");
        }
    }
    ///////////////////////////end new/////////////////////////////////
    ///     ///////////////////////////end new/////////////////////////////////


}
