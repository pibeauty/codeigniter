<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Software
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

class Points Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('points_model', 'points');

        if (!is_login()) {
            redirect(base_url() . 'user/profile', 'refresh');
        }

    }

	public function index() {
		$head['title'] = "Points";
		$data['points'] = $this->points->getPoints();
		$data['points']['total_points'] =
			$data['points']['reference_points'] *
			$data['points']['expense_points'] *
			(
				$data['points']['nail_points'] +
				$data['points']['hair_points'] +
				$data['points']['eyebrow_points'] +
				$data['points']['skin_points'] +
				$data['points']['makeup_points'] +
				$data['points']['eyelash_points']
			);

		$this->load->view('includes/header', $head);
		$this->load->view('points/index', $data);
		$this->load->view('includes/footer');
	}
}