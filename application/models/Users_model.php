<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model
{
    protected $DBname_users="users";protected $DBname_account="account";
    protected $DBname_roles="application_roles";
    protected $DBname_payment_term="payment_term";
    const EMAIL_METHOD = 1;
    const USERNAME_METHOD = 0;
    const APPLICATION_ID = 7;
    const SALT = '432!@YcL*08e%X';
    const DEFAULT_PASSWORD_PT1 = '123456';

    protected $user;
    protected $is_authorized;
    protected $is_application;
    protected $userCred;
    protected $method;

    private $user_id;


    public function __construct()
    {
        parent::__construct();

        $this->user = null;
        $this->is_authorized = false;
        $this->is_application = false;

    }

    public function adduser($data){
        try {
            $user_data = array(
                'username' => $data['username'],
                'employee_id' => null,
                'status' => 1,
                'is_deleted' => 0,
                'is_banned' => 0,
                'name' => $data['name'],
                'password' => $this->makePassword($data['password']),
                'email' => $data['email'],
                'profile_pic' => $data['pro_pic'],
                'role_id' => $data['role_id'],
                'location' => $data['location'],
                'user_type' => 1,
                'lang' => 'english',
                'application_id' => self::APPLICATION_ID,
                'address' => $data['address'],
                'city' => $data['city'],
                'region' => $data['region'],
                'country' => $data['country'],
                'phone' => $data['phone'],
                'salary' => $data['salary'],
                'sales_commission' => $data['commission'],
                'department' => $data['department'],
                'updated_at' => null,
                'created_at' => date('Y/m/d H:i:s'),
            );
            $this->db->insert('application_subusers', $user_data);
            echo json_encode(array('status' => 'Success', 'message' => 'Added'));
        }
        catch (Exception $e){
            echo json_encode(array('status' => 'Error', 'message' => 'ERROR'.$e->getMessage()));
//            return array(false, $e->getMessage());
        }
    }

    public function generate_unique_username($string_name, $rand_no = 1000)
    {
        $counter = 0;
        while($counter < $rand_no)
        {
            $username_parts = array_filter(explode(" ", strtolower($string_name)));
            $username_parts = array_slice($username_parts, 0, 2);

            $part1 = (!empty($username_parts[0]))?substr($username_parts[0], 0,8):"";
            $part2 = (!empty($username_parts[1]))?substr($username_parts[1], 0,5):"";
            $part3 = ($rand_no)? mt_rand($counter, $rand_no): "";

            $username = $part1. str_shuffle($part2). $part3;

            $username_exist_in_db = $this -> username_exist_in_database($username);
            if(!$username_exist_in_db){
                return $username;
            }
            $counter ++;
        }
        return false;
    }

    public function username_exist_in_database($username)
    {

        $this->db->select('username');
        $this->db->from('oauth_users');
        $this->db->where('username', $username);
        $query = $this->db->get();
        $result = $query->result_array();
        if($result)
        {
            return count($result);
        }
        return false;
    }

    public function setUserCreds($user)
    {
        $this->user = $user;
    }

    protected function makePassword($password){
        return sha1($password);
    }

    protected function getUser()
    {
        $this->db->select('*');
        $this->db->from('oauth_users');
        $this->db->where('username', $this->getUserId());
        $query = $this->db->get();
        $result = $query->result_array();
        if($result)
        {
            if (count($result) > 1){
                return false;
            }
            return $result[0];
        }
        return false;
    }

    protected function getUserId(){
        return $this->user_id;
    }

    protected function getUserName(){
        return $this->getUserId();
    }

    protected function getUsersName(){
        $this->db->select('name');
        $this->db->from('oauth_users');
        $this->db->where('username', $this->getUserName());
        $query = $this->db->get();
        $result = $query->result_array();
        if($result)
        {
            if (count($result) > 1){
                return false;
            }
            return $result[0];
        }
        return false;
    }

    protected function getUsersEmail(){
        $this->db->select('email');
        $this->db->from('oauth_users');
        $this->db->where('username', $this->getUserName());
        $query = $this->db->get();
        $result = $query->result_array();
        if($result)
        {
            if (count($result) > 1){
                return false;
            }
            return $result[0];
        }
        return false;
    }

    protected function getUsersCred(){
//        return ['username'=>$this->getUserName(),
//                'name'=>$this->getUsersName(),
//                'email'=>$this->getUsersEmail(),
//                'role_id'=>1];
        $sql = "SELECT `oauth_users`.`username`, `oauth_users`.`name`, `oauth_users`.`email`, `application_users`.`role_id`  FROM (`oauth_users`) INNER JOIN `application_users` ON `application_users`.`id`=`oauth_users`.`app_user_id` WHERE ";
        $sql .= "`oauth_users`.`username` = '";
        $sql .= $this->getUserName();
        $sql .="'";
        $query = $this->db->query($sql);
        if($query){
            $result = $query->result_array();
        }
        else
        {
            return $query;
        }
        if($result)
        {
            if (count($result) > 1){
                return false;
            }
            return $result[0];
        }
        return false;
    }

    protected function updateUser($field, $data)
    {
        try {
            $user_id = $this->getUserId();
            $this->db->set($field, $data);
            $this->db->where('username', $user_id);
            $this->db->update('oauth_users');
            return true;
        }
        catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function setUserId($userId){
        $this->user_id = $userId;
    }

    public function login(){
//        $user_id = $this->getUserId();
//        $this->db->set('is_logged_in', 1);
//        $this->db->where('id', $user_id);
//        $this->db->update('oauth_users');
        return $this->getUsersCred();
    }

    public function getUserProfileData()
    {
//        $this->db->select('address, email, phone');
        $this->db->select('email');
        $this->db->from('oauth_users');
        $this->db->where('username', $this->getUserName());
        $query = $this->db->get();
        $result = $query->result_array();
        if($result)
        {
            if (count($result) > 1){
                return false;
            }
            return $result[0];
        }
        return false;
    }

    public function changePassword($data)
    {
        $myUser = $this->getUser();
        $currentPassword = $data['current_password'];
        $newPassword = $data['new_password'];
        $newPasswordConfirmation = $data['new_password_confirmation'];
        if(!$currentPassword || !$newPassword || !$newPasswordConfirmation){
            return 0;
        }
        if ($newPassword !== $newPasswordConfirmation){
            return false;
        }
        if ($this->makePassword($currentPassword) !== $myUser['password']){
            return 0;
        }
        return $this->updateUser('password', $this->makePassword($newPassword));
    }

    public function addApiUser($data)
    {
//        $myUser = $this->getUser();
        if(!$data['name'] || !$data['username'] || !$data['email']
            || !$data['password'] || !$data['password_confirmation']
        ){
            return 0;
        }
        if ($data['password'] !== $data['password_confirmation']){
            return false;
        }
        if ($this->username_exist_in_database($data['username'])){
            return 0;
        }
        return $this->addUserApi($data);
    }

    protected function addUserApi($data)
    {
        try {
            $app_uid = $this -> get_app_user_id();
            $user_data = array(
                'username' => $data['username'],
                'name' => $data['name'],
                'password' => $this->makePassword($data['password']),
                'email' => $data['email'],
                'app_user_id' => $app_uid,
            );
            $this->db->insert('oauth_users', $user_data);
            return true;
        }
        catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function get_app_user_id(){
        $this->db->select('app_user_id');
        $this->db->from('oauth_users');
        $this->db->where('username', $this->getUserName());
        $query = $this->db->get();
        $result = $query->result_array();
        if($result)
        {
            if (count($result) > 1){
                return false;
            }
            return $result[0]['app_user_id'];
        }
        return false;
    }

    public function get_user_role(){
        $sql = "SELECT `application_users`.`role_id`  FROM (`oauth_users`) INNER JOIN `application_users` ON `application_users`.`id`=`oauth_users`.`app_user_id` WHERE ";
        $sql .= "`application_subusers`.`username` = '";
        $sql .= $this->getUserName() ."'";
        $query = $this->db->query($sql);
        if($query){
            $result = $query->result_array();
        }
        else
        {
            return $query;
        }
        if($result)
        {
            if (count($result) > 1){
                return false;
            }
            return $result[0]['role_id'];
        }
        return false;
    }

    public function getMasterId(){
        $userId = $this -> get_app_user_id();
    }

    public function getMaster(){
        $userId = $this -> get_app_user_id();
    }

    public function getStock(){
        $userId = $this -> get_app_user_id();
        $this->db->select('*');
        $this->db->from('application_user_stocks stock');
        $this->db->where('user_id', $userId);
        $this->db->join('application_users user', 'user.id = stock.user_id', 'left');
        $this->db->join('geopos_products product', 'product.pid = stock.product', 'left');
//        $this->db->join('geopos_products type', 'product.pid = stock.product', 'left');
        $this->db->join('geopos_product_cat category', 'category.id = product.pcat', 'left');
        $this->db->join('application_product_prices price', '(price.product_id = stock.product AND price.level = user.role_id)', 'left');
//        $this->db->join('application_convert_amounts convert', 'convert.from_product = stock.product', 'left');
        $query = $this->db->get();
        if($query->num_rows() != 0)
        {
            return $query->result_array();
        }
        else
        {
            return $this->create_stock();
        }
    }

    private function create_stock(){
        $this->load->model('inputapi_model', 'inputApi');
        $list = $this->inputApi->products();
        foreach ($list as $product){
            $app_uid = $this -> get_app_user_id();
            $product_data = array(
                'product' => $product['pid'],
                'quantity' => 0,
                'user_id' => $app_uid,
            );
            $this->db->insert('application_user_stocks', $product_data);
        }
    }

    public function adjustStock($data){
        try {
            foreach ($data['products'] as $index => $product) {
                $update = $this->updateStockQuantity($product, $data['quantity'][$index]);
                if (!$update){
                    return false;
                }
            }
            return true;
        }
        catch (Exception $e){
            return false;
            return $e->getMessage();
        }
    }

    private function updateStockQuantity($product, $quantity){
        $uid = $this -> get_app_user_id();
        $stockData = array(
            'quantity' => $quantity,
        );
        $this->db->set($stockData);
        $this->db->where('product', $product);
        $this->db->where('user_id', $uid);
        return $this->db->update('application_user_stocks');
    }

    public function isStockConvertible($product){
        $userId = $this->get_app_user_id();
        $this->db->select('*');
        $this->db->from('application_convert_amounts');
        $this->db->where('from_product', $product);
        $query = $this->db->get();
        if($query->num_rows() != 0)
        {
            return $list = $query->result_array();
        }
        else
            {
            return false;
        }
    }

    public function convertStock($data){
        foreach ($data['products'] as $index => $product) {
            $number = intval($data['amount'][$index]);
            $to_product = $data['to_products'][$index];
            $userId = $this->get_app_user_id();
            $this->db->select('*');
            $this->db->from('application_user_stocks stock');
            $this->db->where('user_id', $userId);
            $this->db->where('product', $product);
            $this->db->join('application_convert_amounts convert', 'convert.from_product = stock.product', 'left');
            $this->db->where('convert.to_product', $to_product);
            $query = $this->db->get();
            if($query->num_rows() != 0)
            {
                $list = $query->result_array();
                $this->db->select('*');
                $this->db->from('application_user_stocks stock');
                $this->db->where('user_id', $userId);
                $this->db->where('product', $list[0]['to_product']);
                $query_to = $this->db->get();
                $to_list = $query_to->result_array();
                if (intval($list[0]['quantity']) >= $number * intval($list[0]['amount'])){
                    for ($i=0; $i<$number; $i++){
                        $quantity = intval($list[0]['quantity']);
                        $amount = intval($list[0]['amount']);
//                        if($amount > $quantity){
//                            continue;
//                        }
                        $to_quantity = intval($to_list[0]['quantity']);
                        $this->updateStockQuantity($product, $quantity-$amount);
                        $this->updateStockQuantity($list[0]['to_product'], $to_quantity+1);
                        $quantity = $quantity - $amount;
                        $to_quantity = $to_quantity + 1;
                    }
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        return true;
    }

    public function add_customer($data){
        try {
            if ($this->username_exist_in_database($data['username'])){
                return false;
            }
            $app_uid = $this -> get_app_user_id();
            $user_data = array(
                'username' => $data['username'],
                'company_name' => $data['company_name'],
                'contact_person' => $data['contact_person'],
                'contact_no' => $data['contact_no'],
                'address' => $data['address'],
                'password' => $this->makePassword(self::DEFAULT_PASSWORD_PT1.$data['company_name']),
                'email' => $data['email'],
                'payment_term' => $data['payment_term'],
                'credit_limit' => $data['credit_limit'],
                'role_id' => $data['role_id'],
                'master' => $app_uid,
            );
            $this->db->insert('application_users', $user_data);
            return $data['username'];
        }
        catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function update_customer_images($src, $id){
        $this->db->set(['profile_pic' => $src[0], 'register_doc' => $src[1]]);
//        $this->db->set('register_doc', $src);
        $this->db->where('username', $id);
        $this->db->update('application_users');
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function get_user($user_id){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('users_id', $user_id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function getUserByCustomerId($customerId){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('cid', $customerId);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0];
    }

    public function getRoles_PT(){
        $query = $this->db->get($this->DBname_roles);
        $query2 = $this->db->get($this->DBname_payment_term);
        $data = array(
            'roles'=>$query->result_array(),
            'payment_term'=>$query2->result_array()
        );
        return json_encode($data);
    }

    public function addcustomer($data){
        try {
            $this->db->insert('users', $data);
            return true;
        }
        catch (Exception $e){
          //  echo json_encode(array('status' => 'Error', 'message' => 'ERROR'.$e->getMessage()));
          return false;
        }
    }

    public function addAccount($data){
        try {
            $this->db->insert('account', $data);
            $insert_id = $this->db->insert_id();

            return  $insert_id;
        }
        catch (Exception $e){
            //  echo json_encode(array('status' => 'Error', 'message' => 'ERROR'.$e->getMessage()));
            return false;
        }
    }

    public function adduser_new($data){

        try {
            $this->db->insert('users', $data);
            return true;
        }
        catch (Exception $e){
            //  echo json_encode(array('status' => 'Error', 'message' => 'ERROR'.$e->getMessage()));
            return false;
        }
    }

    public function getProfileAccount($user_id,$account_id){
        $user = $this->db->get_where($this->DBname_users, array('users_id' => $user_id))->result();
        $account = $this->db->get_where($this->DBname_account, array('id' => $account_id))->result();
        $data = array(
            'user'=>$user[0],
            'account'=>$account[0]
        );
        return json_encode($data);
    }

    public function getCustomers(){
        //$data=  $this->db->select('*')->from($this->DBname_users)->group_by('acconut_id')->result();
        $data = $this->db->group_by('account_id')->get($this->DBname_users)->result();
        return json_encode($data);
    }

    public function getAllUser(){
        $data = $this->db->get($this->DBname_users)->result();
        return  $data;
    }
}