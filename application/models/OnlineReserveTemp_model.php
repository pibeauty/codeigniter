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

defined('BASEPATH') or exit('No direct script access allowed');

class OnlineReserveTemp_model extends CI_Model
{
    public function add($data, $name, $mobile, $referrerCode) {
        $factorCode = generateRandomString();
        $decodedData = json_decode($data);
        $amount = 50000 * count($decodedData);
        $insertData = [
            'data' => $data,
            'name' => $name,
            'mobile' => $mobile,
            'referrer_code' => $referrerCode,
            'amount' => $amount,
            'factor_code' => $factorCode
        ];
        $this->db->insert('geopos_online_reserve_temp', $insertData);
        return [$factorCode, $amount];
    }

    public function delete($factorCode) {
        $sql = "DELETE FROM geopos_online_reserve_temp WHERE factor_code = ?";
        $this->db->query($sql, array($factorCode));
    }

    public function get($factorCode) {
        $this->db->select('*');
        $this->db->from('geopos_online_reserve_temp');
        $this->db->where('factor_code', $factorCode);
        $query = $this->db->get();
        return $query->result_array();
    }
}
