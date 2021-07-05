<?php


class ApplicationAauth
{

    /**
     * The CodeIgniter object variable
     * @access public
     * @var object
     */
    public $CI;

    /**
     * Variable for loading the config array into
     * @access public
     * @var array
     */
    public $config_vars;

    /**
     * Array to store error messages
     * @access public
     * @var array
     */
    public $errors = array();

    /**
     * Array to store info messages
     * @access public
     * @var array
     */
    public $infos = array();

    /**
     * Local temporary storage for current flash errors
     *
     * Used to update current flash data list since flash data is only available on the next page refresh
     * @access public
     * var array
     */
    public $flash_errors = array();

    /**
     * Local temporary storage for current flash infos
     *
     * Used to update current flash data list since flash data is only available on the next page refresh
     * @access public
     * var array
     */
    public $flash_infos = array();

    /**
     * The CodeIgniter object variable
     * @access public
     * @var object
     */
    public $aauth_db;


    public function __construct()
    {
        // get main CI object
        $this->CI = &get_instance();
        $this->CI->li_a='';

        // Dependancies
        if (CI_VERSION >= 2.2) {
            $this->CI->load->library('driver');
        }
        $this->CI->load->library('session');
        $this->CI->lang->load('aauth');

        // config/aauth.php
        $this->CI->config->load('applicationaauth');
        $this->config_vars = $this->CI->config->item('applicationaauth');
        $this->config_vars['users'] = 'users';
        $this->aauth_db = $this->CI->load->database($this->config_vars['db_profile'], TRUE);

        // load error and info messages from flashdata (but don't store back in flashdata)
        $this->errors = $this->CI->session->flashdata('errors') ?: array();
        $this->infos = $this->CI->session->flashdata('infos') ?: array();
        // db load and get main CI object
        if (!@$this->CI->_query) {
            exit();
        }
    }


    public function login($identifier, $pass, $remember = FALSE, $captcha, $totp_code = NULL, $application_id = 4)
    {

        // Remove cookies first
        $cookie = array(
            'name' => 'user',
            'value' => '',
            'expire' => -3600,
            'path' => '/',
        );
        $this->CI->input->set_cookie($cookie);
        if ($this->config_vars['ddos_protection'] && !$this->update_login_attempts()) {

            $this->error($this->CI->lang->line('aauth_error_login_attempts_exceeded'));
            return FALSE;
        }
        if (!@$this->CI->_ci_camrap) {
            exit();
        }

        //&& $this->get_login_attempts() > $this->config_vars['recaptcha_login_attempts']
        //Recaptcha
        if ($this->config_vars['ddos_protection'] && $captcha && $this->get_login_attempts() > $this->config_vars['recaptcha_login_attempts']) {
            $this->aauth_db->select('url AS recaptcha_s');
            $this->aauth_db->from('univarsal_api');
            $this->aauth_db->where('id', 53);
            $query = $this->aauth_db->get();
            $result = $query->row();
            $this->CI->load->helper('recaptchalib');
            $reCaptcha = new ReCaptcha($result->recaptcha_s);
            $resp = $reCaptcha->verifyResponse($this->CI->input->server("REMOTE_ADDR"), $this->CI->input->post("g-recaptcha-response"));

            if (!$resp->success) {
                $this->error($this->CI->lang->line('aauth_error_recaptcha_not_correct'));
                return FALSE;
            }
        }


        if ($this->config_vars['login_with_name'] == TRUE) {

            if (!$identifier OR strlen($pass) < $this->config_vars['min'] OR strlen($pass) > $this->config_vars['max']) {
                $this->error($this->CI->lang->line('aauth_error_login_failed_name'));
                return FALSE;
            }
            $db_identifier = 'username';
        } else {
            $this->CI->load->helper('email');
            if (!valid_email($identifier) OR strlen($pass) < $this->config_vars['min'] OR strlen($pass) > $this->config_vars['max']) {
                $this->error($this->CI->lang->line('aauth_error_login_failed_email'));
                return FALSE;
            }
            $db_identifier = 'email';
        }

        // if user is not verified
        $query = null;
        $query = $this->aauth_db->where($db_identifier, $identifier);
        $query = $this->aauth_db->where('banned', 1);
        $query = $this->aauth_db->where('verification_code !=', '');
        $query = $this->aauth_db->get($this->config_vars['users']);

        if ($query->num_rows() > 0) {
            $this->error($this->CI->lang->line('aauth_error_account_not_verified'));
            return FALSE;
        }

        // to find user id, create sessions and cookies
        $query = $this->aauth_db->where($db_identifier, $identifier);
        $query = $this->aauth_db->get($this->config_vars['users']);

        if ($query->num_rows() == 0) {
            $this->error($this->CI->lang->line('aauth_error_no_user'));
            return FALSE;
        }
        if ($this->config_vars['totp_active'] == TRUE AND $this->config_vars['totp_only_on_ip_change'] == FALSE AND $this->config_vars['totp_two_step_login_active'] == FALSE) {
            if ($this->config_vars['totp_two_step_login_active'] == TRUE) {
                $this->CI->session->set_userdata('totp_required', true);
            }

            $query = null;
            $query = $this->aauth_db->where($db_identifier, $identifier);
            $query = $this->aauth_db->get($this->config_vars['users']);
            $totp_secret = $query->row()->totp_secret;
            if ($query->num_rows() > 0 AND !$totp_code) {
                $this->error($this->CI->lang->line('aauth_error_totp_code_required'));
                return FALSE;
            } else {
                if (!empty($totp_secret)) {
                    $this->CI->load->helper('googleauthenticator');
                    $ga = new PHPGangsta_GoogleAuthenticator();
                    $checkResult = $ga->verifyCode($totp_secret, $totp_code, 0);
                    if (!$checkResult) {
                        $this->error($this->CI->lang->line('aauth_error_totp_code_invalid'));
                        return FALSE;
                    }
                }
            }
        }

        if ($this->config_vars['totp_active'] == TRUE AND $this->config_vars['totp_only_on_ip_change'] == TRUE) {
            $query = null;
            $query = $this->aauth_db->where($db_identifier, $identifier);
            $query = $this->aauth_db->get($this->config_vars['users']);
            $totp_secret = $query->row()->totp_secret;
            $ip_address = $query->row()->ip_address;
            $current_ip_address = $this->CI->input->ip_address();

            if ($query->num_rows() > 0 AND !$totp_code) {
                if ($ip_address != $current_ip_address) {
                    if ($this->config_vars['totp_two_step_login_active'] == FALSE) {
                        $this->error($this->CI->lang->line('aauth_error_totp_code_required'));
                        return FALSE;
                    } else if ($this->config_vars['totp_two_step_login_active'] == TRUE) {
                        $this->CI->session->set_userdata('totp_required', true);
                    }
                }
            } else {
                if (!empty($totp_secret)) {
                    if ($ip_address != $current_ip_address) {
                        $this->CI->load->helper('googleauthenticator');
                        $ga = new PHPGangsta_GoogleAuthenticator();
                        $checkResult = $ga->verifyCode($totp_secret, $totp_code, 0);
                        if (!$checkResult) {
                            $this->error($this->CI->lang->line('aauth_error_totp_code_invalid'));
                            return FALSE;
                        }
                    }
                }
            }
        }

        $query = null;

        $query = $this->aauth_db->where($db_identifier, $identifier);
        $query = $this->aauth_db->where('banned', 0);

        $query = $this->aauth_db->get($this->config_vars['users']);

        $row = $query->row();

        // if email and pass matches and not banned
        $password = ($this->config_vars['use_password_hash'] ? $pass : $this->hash_password($pass, @$row->id));

        if ($query->num_rows() != 0 && $this->verify_password($password, $row->pass)) {

            if ($row-> application_id != $application_id){
                return false;
            }

            // If email and pass matches
            // create session
            $data = array(
                'id' => $row->id,
                'username' => $row->username,
                'email' => $row->email,
                's_role' => 'r_'.$row->roleid,
                'loggedin' => TRUE
            );

            $this->CI->session->set_userdata($data);

            if ($remember) {
                $this->CI->load->helper('string');
                $expire = $this->config_vars['remember'];
                $today = date("Y-m-d");
                $remember_date = date("Y-m-d", strtotime($today . $expire));
                $random_string = random_string('alnum', 16);
                $this->update_remember($row->id, $random_string, $remember_date);
                $cookie = array(
                    'name' => 'user',
                    'value' => $row->id . "-" . $random_string,
                    'expire' => 99 * 999 * 999,
                    'path' => '/',
                );
                $this->CI->input->set_cookie($cookie);
            }

            // update last login
            $this->update_last_login($row->id);
            $this->update_activity();

            if ($this->config_vars['remove_successful_attempts'] == TRUE) {
                $this->reset_login_attempts();
            }

            return TRUE;
        } // if not matches
        else {

            $this->error($this->CI->lang->line('aauth_error_login_failed_all'));
            return FALSE;
        }
    }

    public function setUserCreds($user): void
    {
        $this->userCred = $user;
    }

    public function isUserValid($userCred){
        if(!$userCred){
            return false;
        }
        $this->setUserCreds($userCred);
        $this->setTheMethod();
        $this->checkThisGuy();
    }


    public function getMe()
    {
        return 'hello There';
    }

    public function checkThisGuy(){
        $this->db->select('*');
        $this->db->from('users');
        if($this->method === 1){
            $this->db->where('email', $this->user->username);
        }
        else if ($this->method === 0)
        {
            $this->db->where('username', $this->user->username);
        } else {
            return false;
        }
        $this->db->where('geopos_projects.cid=', $this->session->userdata('user_details')[0]->cid);
        $this->db->where('geopos_project_meta.meta_key=', 2);
        $this->db->where('geopos_project_meta.meta_data=', 'true');
        $this->db->join('geopos_customers', 'geopos_projects.cid = geopos_customers.id', 'left');
        $this->db->join('geopos_project_meta', 'geopos_project_meta.pid = geopos_projects.id', 'left');
        $query = $this->db->get();
        $project = $query->row_array();
    }

    public function setTheMethod(){
        if (strpos($this->user['username'], '@') === false){
            $this->method = 0;
        }else{
            $this->method = 1;
        }
    }

    public function get_user(){
        return 'hello_there';
    }
}