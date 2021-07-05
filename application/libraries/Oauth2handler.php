<?php
//if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'third_party/vendor/bshaffer/oauth2-server-php/src/OAuth2/Autoloader.php';
OAuth2\Autoloader::register();

use OAuth2\Storage\Pdo;
use OAuth2\Server;
use OAuth2\Request;

class Oauth2handler
{

    /**
     * The OAuth Server object variable
     * @access public
     * @var object
     */
    public $server;
    /**
     * The CodeIgniter object variable
     * @access public
     * @var object
     */
    public $CI;


    public function __construct()
    {
        $this->CI = &get_instance();
        $odsn  = 'mysql:dbname=admin_hg;host=localhost';
        $ousername = 'admin_hg';
        $opassword = '123456789';
        try {
            $storage = new OAuth2\Storage\Pdo(array('dsn' => 'mysql:dbname=admin_hg;host=localhost', 'username' => 'admin_hg', 'password' => '123456789'));
            $this->server = new OAuth2\Server($storage);
//            $this->server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));
            $this->server->addGrantType(new OAuth2\GrantType\UserCredentials($storage));
//            $this->server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));

            $this->load->model('users_model', 'users');
        }
        catch (Exception $e){
            json_encode($e->getMessage());
        }
    }

    public function getToken(){
        return $this->server->handleTokenRequest(OAuth2\Request::createFromGlobals());
    }

    public function getUser(){
        return $this->server->getUserInfoController();
    }

}