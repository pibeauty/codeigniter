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

class Points_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

	private function getPointsSelectStatement()
	{
		return "
			(
				SELECT 
				COUNT(geopos_events.id) * 0.1
				FROM 
				geopos_events 
				WHERE 
				customerid = geopos_customers.id 
				AND service_id in (
					SELECT 
					id 
					FROM 
					services 
					WHERE 
					parent_id = 2
				)
			) nail_points, 
			(
				SELECT 
				COUNT(geopos_events.id) * 0.2
				FROM 
				geopos_events 
				WHERE 
				customerid = geopos_customers.id 
				AND service_id in (
					SELECT 
					id 
					FROM 
					services 
					WHERE 
					parent_id = 3
				)
			) hair_points, 
			(
				SELECT 
				COUNT(geopos_events.id) * 0.1
				FROM 
				geopos_events 
				WHERE 
				customerid = geopos_customers.id 
				AND service_id in (
					SELECT 
					id 
					FROM 
					services 
					WHERE 
					parent_id = 36
				)
			) eyebrow_points, 
			(
				SELECT 
				COUNT(geopos_events.id) * 0.2
				FROM 
				geopos_events 
				WHERE 
				customerid = geopos_customers.id 
				AND service_id in (
					SELECT 
					id 
					FROM 
					services 
					WHERE 
					parent_id = 40
				)
			) skin_points, 
			(
				SELECT 
				COUNT(geopos_events.id) * 0.3
				FROM 
				geopos_events 
				WHERE 
				customerid = geopos_customers.id 
				AND service_id in (
					SELECT 
					id 
					FROM 
					services 
					WHERE 
					parent_id = 55
				)
			) makeup_points, 
			(
				SELECT 
				COUNT(geopos_events.id) * 0.1
				FROM 
				geopos_events 
				WHERE 
				customerid = geopos_customers.id 
				AND service_id in (
					SELECT 
					id 
					FROM 
					services 
					WHERE 
					parent_id = 105
				)
			) eyelash_points, 
			(
				SELECT 
				(COUNT(geopos_customers.id) + 1) * 5
				FROM 
				geopos_customers 
				WHERE 
				moaaref = geopos_customers.name
			) reference_points, 
			(
				SELECT 
				SUM(geopos_invoices.subtotal) / 1000000 
				FROM 
				geopos_invoices 
				WHERE 
				geopos_invoices.csd = geopos_customers.id
			) expense_points
		";
	}

	public function getPoints()
	{
		$this->db->select('geopos_customers.id, ' . $this->getPointsSelectStatement());
		$this->db->from('geopos_customers');
		$this->db->where('geopos_customers.id', $this->session->userdata('user_details')[0]->cid);
		$query = $this->db->get();
		return $query->row_array();
	}
}