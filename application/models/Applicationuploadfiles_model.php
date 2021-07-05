<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Uma Shankar. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@infinitywebinfo.com
 *  Website: https://www.infinitywebinfo.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://infinitywebinfo.com/licenses/standard/
 * ***********************************************************************
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Applicationuploadfiles_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function upload_image($scope, $data, $id){
        $config['upload_path'] = APPPATH . 'appUploads/images/'. $scope. '/';
        $config['file_name'] = $id;
        $config['overwrite'] = FALSE;
        $config["allowed_types"] = 'jpg|jpeg|png|gif';
        $config["max_size"] = 2048000;
//        $config["max_width"] = 400;
//        $config["max_height"] = 400;
        $this->load->library('upload', $config);

        if(!$this->upload->do_upload()) {
            return $this->upload->display_errors();
        } else {
            //success
        }
    }

}