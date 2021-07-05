<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inputapi_model extends CI_Model
{

    const LOGIN_METHOD_USERNAME = 0;
    const LOGIN_METHOD_EMAIL = 1;

    protected $user;
    protected $userCred;
    protected $method;

    public function __construct()
    {
        parent::__construct();
//        $this->load->model('users_model', 'users');
//        $this->user = new users();
//        $this->load->library("ApplicationAauth");
    }

//    public function is_User_Valid($data){
//
//        if (!$this->applicationaauth->is_loggedin()) {
//            redirect('/user/', 'refresh');
//        }
//        if ($this->applicationaauth->get_user()->roleid < 5) {
//
//            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
//
//        }
//    }
//
//    public function get_User(){
//        return $this -> user;
//    }
//
//    public function set_log($data){
//        $dbData = [
//            'data' => $data,
//        ];
//        $this->db->insert('api_log',$data);
//
//    }
//
//    /**
//     * @param users $user
//     */
//    public function setUser(users $user): void
//    {
//        $this->user = $user;
//    }

    public function products($id = '')
    {

        $this->db->select('*');
        $this->db->from('geopos_products');
        if ($id !== '') {

            $this->db->where('pid', $id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }



}