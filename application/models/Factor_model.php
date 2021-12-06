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

class Factor_model extends CI_Model
{
    function getAmount($code) {
        $this->db->select('amount');
        $this->db->from('geopos_factors');
        $this->db->where('code', $code);
        $result = $this->db->get();
        return $result->row_array()['amount'];
    }

    function add ($factorCode, $amount, $date, $status = 'processing') {
        $this->db->insert('geopos_factors', [
            'code' => $factorCode,
            'amount' => $amount,
            'date' => $date,
            'status' => $status
        ]);
    }

    function update ($code, $data) {
        $this->db->where('code', $code);
        $this->db->update('geopos_factors', $data);
    }

    function setTransactionRef ($code, $tRef) {
        $this->db->where('code', $code);
        $this->db->update('geopos_factors', [
            'transaction_ref' => $tRef
        ]);
    }
}