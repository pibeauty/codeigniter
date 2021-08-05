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

class Invoices_model extends CI_Model
{
    var $table = 'geopos_invoices';
    var $column_order = array(null, 'geopos_invoices.tid', 'geopos_customers.name', 'geopos_invoices.invoicedate', 'geopos_invoices.total', 'geopos_invoices.status', null);
    var $column_search = array('geopos_invoices.tid', 'geopos_customers.name', 'geopos_invoices.invoicedate', 'geopos_invoices.total','geopos_invoices.status');
    var $order = array('geopos_invoices.tid' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    public function customerHasInvoice($customerId)
    {
        $this->db->select('id');
        $this->db->from($this->table);
        $this->db->where('csd', $customerId);
        $query = $this->db->get();
        $result = $query->result_array();
        if($result)
        {
            return true;
        }
        return false;
    }

    public function lastinvoice()
    {
        $this->db->select('tid');
        $this->db->from($this->table);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $this->db->where('i_class', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->tid;
        } else {
            return 1000;
        }
    }


    public function invoice_details($id, $eid = '')
    {
        $this->db->select('geopos_invoices.*,SUM(geopos_invoices.shipping + geopos_invoices.ship_tax) AS shipping,geopos_customers.*,geopos_invoices.loc as loc,geopos_invoices.id AS iid,geopos_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');
        $this->db->from($this->table);
        $this->db->where('geopos_invoices.id', $id);
        if ($eid) {
            $this->db->where('geopos_invoices.eid', $eid);
        }
              if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('geopos_invoices.loc', 0);
        }
        $this->db->join('geopos_customers', 'geopos_invoices.csd = geopos_customers.id', 'left');
        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_invoices.term', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function invoice_products($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_invoice_items');
        $this->db->where('tid', $id);
        $query = $this->db->get();
        return $query->result_array();

    }

    public function currencies()
    {

        $this->db->select('*');
        $this->db->from('geopos_currencies');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function currency_d($id, $loc = 0)
    {
        if ($loc) {
            $query = $this->db->query("SELECT cur FROM geopos_locations WHERE id='$loc' LIMIT 1");
            $row = $query->row_array();
            $id = $row['cur'];
        }
        $this->db->select('*');
        $this->db->from('geopos_currencies');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function warehouses()
    {
        $this->db->select('*');
        $this->db->from('geopos_warehouse');
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
          if(BDATA)  $this->db->or_where('loc', 0);
        }  elseif(!BDATA) { $this->db->where('loc', 0); }

        $query = $this->db->get();

        return $query->result_array();

    }

    public function invoice_transactions($id)
    {

         $this->db->select('*');
        $this->db->from('geopos_transactions');
        $this->db->where('tid', $id);
        $this->db->where('ext', 0);
        $query = $this->db->get();
        return $query->result_array();

    }

    public function invoice_delete($id, $eid = '')
    {
        $this->db->trans_start();
        $this->db->select('tid,total,status');
        $this->db->from('geopos_invoices');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        if ($this->aauth->get_user()->loc) {
            if ($eid) {

                $res = $this->db->delete('geopos_invoices', array('id' => $id, 'eid' => $eid, 'loc' => $this->aauth->get_user()->loc));


            } else {
                $res = $this->db->delete('geopos_invoices', array('id' => $id, 'loc' => $this->aauth->get_user()->loc));
            }
        }

        else {
            if (BDATA) {
                if ($eid) {

                    $res = $this->db->delete('geopos_invoices', array('id' => $id, 'eid' => $eid));


                } else {
                    $res = $this->db->delete('geopos_invoices', array('id' => $id));
                }
            } else {


                if ($eid) {

                    $res = $this->db->delete('geopos_invoices', array('id' => $id, 'eid' => $eid, 'loc' => 0));


                } else {
                    $res = $this->db->delete('geopos_invoices', array('id' => $id, 'loc' => 0));
                }
            }
        }

        $affect = $this->db->affected_rows();

        if ($res) {
            if ($result['status'] != 'canceled') {
                $this->db->select('pid,qty');
                $this->db->from('geopos_invoice_items');
                $this->db->where('tid', $id);
                $query = $this->db->get();
                $prevresult = $query->result_array();

                foreach ($prevresult as $prd) {
                    $amt = $prd['qty'];
                    $this->db->set('qty', "qty+$amt", FALSE);
                    $this->db->where('pid', $prd['pid']);
                    $this->db->update('geopos_products');
                }
            }


            if ($affect) $this->db->delete('geopos_invoice_items', array('tid' => $id));

            $data = array('type' => 9, 'rid' => $id);
            $this->db->delete('geopos_metadata', $data);

                        $alert= $this->custom->api_config(66);
            if ($alert['method'] == 1) {
                 $this->load->model('communication_model');
                 $subject= $result['tid'].' '. $this->lang->line('DELETED');
                 $body=$subject.'<br> '. $this->lang->line('Amount').' '. $result['total'].'<br> '. $this->lang->line('Employee').''. $this->aauth->get_user()->username.'<br> ID# '. $result['tid'];
               $out= $this->communication_model->send_corn_email($alert['url'], $alert['url'], $subject, $body, false, '');
            }

            if ($this->db->trans_complete()) {
                return true;
            } else {
                return false;
            }
        }

    }


    private function _get_datatables_query($opt = '')
    {
        $this->db->select('geopos_invoices.id,geopos_invoices.tid,geopos_invoices.invoicedate,geopos_invoices.invoiceduedate,geopos_invoices.total,geopos_invoices.status,geopos_customers.name');
        $this->db->from($this->table);
        $this->db->where('geopos_invoices.i_class', 0);
        if ($opt) {
            $this->db->where('geopos_invoices.eid', $opt);
        }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);
        }
        elseif(!BDATA) { $this->db->where('geopos_invoices.loc', 0); }
        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_invoices.invoicedate) >=', datefordatabase($this->input->post('start_date')));
            $this->db->where('DATE(geopos_invoices.invoicedate) <=', datefordatabase($this->input->post('end_date')));
        }
        $this->db->join('geopos_customers', 'geopos_invoices.csd=geopos_customers.id', 'left');

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if ($this->input->post('search')['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($opt = '')
    {
        $this->_get_datatables_query($opt);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        $this->db->where('geopos_invoices.i_class', 0);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);
        }  elseif(!BDATA) { $this->db->where('geopos_invoices.loc', 0); }

        return $query->result();
    }

    function count_filtered($opt = '')
    {
        $this->_get_datatables_query($opt);
        if ($opt) {
            $this->db->where('eid', $opt);
        }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);
        }  elseif(!BDATA) { $this->db->where('geopos_invoices.loc', 0); }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($opt = '')
    {
        $this->db->select('geopos_invoices.id');
        $this->db->from($this->table);
        $this->db->where('geopos_invoices.i_class', 0);
        if ($opt) {
            $this->db->where('geopos_invoices.eid', $opt);

        }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);
        }  elseif(!BDATA) { $this->db->where('geopos_invoices.loc', 0); }
        return $this->db->count_all_results();
    }


    public function billingterms()
    {
        $this->db->select('id,title');
        $this->db->from('geopos_terms');
        $this->db->where('type', 1);
        $this->db->or_where('type', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function employee($id)
    {
        $this->db->select('geopos_employees.name,geopos_employees.sign,geopos_users.roleid');
        $this->db->from('geopos_employees');
        $this->db->where('geopos_employees.id', $id);
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function meta_insert($id, $type, $meta_data)
    {
        $data = array('type' => $type, 'rid' => $id, 'col1' => $meta_data);
        if ($id) {
            return $this->db->insert('geopos_metadata', $data);
        } else {
            return 0;
        }
    }

    public function attach($id)
    {
        $this->db->select('geopos_metadata.*');
        $this->db->from('geopos_metadata');
        $this->db->where('geopos_metadata.type', 1);
        $this->db->where('geopos_metadata.rid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function meta_delete($id, $type, $name)
    {
        if (@unlink(FCPATH . 'userfiles/attach/' . $name)) {
            return $this->db->delete('geopos_metadata', array('rid' => $id, 'type' => $type, 'col1' => $name));
        }
    }

    public function gateway_list($enable = '')
    {
        $this->db->from('geopos_gateways');
        if ($enable == 'Yes') {
            $this->db->where('enable', 'Yes');
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function justCreateInvoice($products)
    {
        try {
        $this->load->library("Common");
        $currency = 0;
        $customer_id = 3;
        $invocieno = $this->lastinvoice() + 1;
        $invoicedate = date('d-m-Y');
        $invocieduedate = date('d-m-Y');
        $notes = 'This Invoice was made through API';
        $taxes = $this->common->taxdetail();
        $tax = $taxes['handle'];
        $ship_taxtype = $this->common->disc_status()['ship_tax'];

        $discountVal = 0;
        $subtotalT = 0;
        $shipping = 0;
        $shipping_tax = 0;
        $totalT = 0;

        $product_id = [];
        $pid = [];
        $product_name1 = [];
        $product_qty = [];
        $product_price = [];
        $product_tax = [];
        $product_discount = [];
        $product_subtotal = [];
        $ptotal_tax = [];
        $ptotal_disc = [];
        $product_des = [];
        $product_unit = [];
        $product_hsn = [];
        $product_alert = [];


        foreach ($products as $pr) {
            $this->db->select('*');
            $qty = $pr['qty'];
            $code = $pr['VPC'];
            $this->db->from('geopos_products');
            $this->db->where('product_code', $code);
            $query = $this->db->get();
            $product = $query->result_array();

            foreach ($product as $prd) {
                $prTax = $prd['product_price'] * $prd['taxrate'] / 100;
                $prDis = ($prd['product_price'] + $prTax) * $prd['disrate'] / 100;
                $prSubTotal = $prd['product_price'] + $prTax - $prDis;

                $discountVal += $prDis;
                $subtotalT += $prSubTotal;
                $totalT += $prSubTotal;
            }
        }

        $disc_val = numberClean($discountVal);
// Subtotal
        $subtotal = rev_amountExchange_s($subtotalT);
// Shipping
        $shipping = rev_amountExchange_s($shipping);
// Shipping Tax
        $shipping_tax = rev_amountExchange_s($shipping_tax);
        if ($ship_taxtype == 'incl') $shipping = $shipping - $shipping_tax;
        $refer = 'Tech Stream';
// Total
        $total = rev_amountExchange_s($totalT);
// Project
        $project = '';
        $total_tax = 0;
// Total Discount
        $total_discount = 0;
        $discountFormat = $this->common->disc_status()['disc_format'];
        $pterms = 1;
        $i = 0;
        $discstatus = $discountFormat == '0' ? 0:1;
        if ($customer_id == 0) {
            throw new \Exception($this->lang->line('Please add a new client'));
        }
        $transok = true;
        $st_c = 0;
//        $this->load->library("Common");
        $this->db->trans_start();
//Invoice Data
        $bill_date = datefordatabase($invoicedate);
        $bill_due_date = datefordatabase($invocieduedate);
        $data = array('tid' => $invocieno, 'invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'discount_rate' => $disc_val, 'total' => $total, 'notes' => $notes, 'csd' => $customer_id, 'eid' => 15, 'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer, 'term' => $pterms, 'multi' => $currency, 'loc' => 0);
        $invocieno2 = $invocieno;
        if ($this->db->insert('geopos_invoices', $data)) {
            $invocieno = $this->db->insert_id();
//products


            foreach ($products as $pr) {
                $this->db->select('*');
                $qty = $pr['qty'];
                $code = $pr['VPC'];
                $this->db->from('geopos_products');
                $this->db->where('product_code', $code);
                $query = $this->db->get();
                $product = $query->result_array();
//                return var_dump($product);
                foreach ($product as $prd) {
                    array_push($pid, $prd['pid']);
                    array_push($product_name1, $prd['product_name']);
                    array_push($product_qty, $qty);
                    array_push($product_price, $prd['product_price']);
                    array_push($product_tax, $prd['taxrate']);
                    array_push($product_discount, $prd['disrate']);
                    $prTax = $prd['product_price'] * $prd['taxrate'] / 100;
                    $prDis = ($prd['product_price'] + $prTax) * $prd['disrate'] / 100;
                    $prSubTotal = $prd['product_price'] + $prTax - $prDis;
                    array_push($product_subtotal, $prSubTotal);
                    array_push($ptotal_tax, $prTax);
                    array_push($ptotal_disc, $prDis);
                    array_push($product_des, '');
                    array_push($product_unit, $prd['unit']);
                    array_push($product_hsn, $prd['product_code']);
                    array_push($product_alert, $prd['qty']);
                }
            }
//            $product_id = $pid;

            $productlist = array();
            $prodindex = 0;
            $itc = 0;
            $product_id = $pid;

            foreach ($pid as $key => $value) {
                $total_discount += numberClean(@$ptotal_disc[$key]);
                $total_tax += numberClean($ptotal_tax[$key]);
                $data = array(
                    'tid' => $invocieno,
                    'pid' => $product_id[$key],
                    'product' => $product_name1[$key],
                    'code' => $product_hsn[$key],
                    'qty' => numberClean($product_qty[$key]),
                    'price' => rev_amountExchange_s($product_price[$key]),
                    'tax' => numberClean($product_tax[$key]),
                    'discount' => numberClean($product_discount[$key]),
                    'subtotal' => rev_amountExchange_s($product_subtotal[$key]),
                    'totaltax' => rev_amountExchange_s($ptotal_tax[$key]),
                    'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key]),
                    'product_des' => $product_des[$key],
                    'unit' => $product_unit[$key]
                );

                $productlist[$prodindex] = $data;
                $i++;
                $prodindex++;
                $amt = numberClean($product_qty[$key]);
                if ($product_id[$key] > 0) {
                    $this->db->set('qty', "qty-$amt", FALSE);
                    $this->db->where('pid', $product_id[$key]);
                    $this->db->update('geopos_products');
                    if ((numberClean($product_alert[$key]) - $amt) < 0 AND $st_c == 0 AND $this->common->zero_stock()) {
                        // echo json_encode(array('status' => 'Error', 'message' => 'Product - <strong>' . $product_name1[$key] . "</strong> - Low quantity. Available stock is  " . $product_alert[$key]));
                        $transok = false;
                        $st_c = 1;
                    }
                }
                $itc += $amt;
            }
            if ($prodindex > 0) {
                $this->db->insert_batch('geopos_invoice_items', $productlist);
                $this->db->set(array('discount' => rev_amountExchange_s(amountFormat_general($total_discount)), 'tax' => rev_amountExchange_s(amountFormat_general($total_tax)), 'items' => $itc));
                $this->db->where('id', $invocieno);
                $this->db->update('geopos_invoices');
            } else {
//                echo json_encode(array('status' => 'Error', 'message' =>
//                    "Please choose product from product list. Go to Item manager section if you have not added the products."));
                $transok = false;
            }
            if ($transok) {
                $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
                $link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken);
//                echo json_encode(array('status' => 'Success', 'message' =>
//                    $this->lang->line('Invoice Success') . " <a href='view?id=$invocieno' class='btn btn-primary btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='printinvoice?id=$invocieno' class='btn btn-blue btn-lg' target='_blank'><span class='fa fa-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; <a href='$link' class='btn btn-purple btn-lg'><span class='fa fa-globe' aria-hidden='true'></span> " . $this->lang->line('Public View') . " </a> &nbsp; &nbsp; <a href='create' class='btn btn-warning btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span></a>"));
            }
        } else {
            // echo json_encode(array('status' => 'Error', 'message' => "Invalid Entry!"));
            $transok = false;
        }
        if ($transok) {
            if ($project > 0) {
                $data = array('pid' => $project, 'meta_key' => 11, 'meta_data' => $invocieno, 'value' => '0');
                $this->db->insert('geopos_project_meta', $data);
            }
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
        }
        if ($transok) {
            $this->db->from('univarsal_api');
            $this->db->where('univarsal_api.id', 56);
            $query = $this->db->get();
            $auto = $query->row_array();
            /*
            if ($auto['key1'] == 1) {
                $this->db->select('name,email');
                $this->db->from('geopos_customers');
                $this->db->where('id', $customer_id);
                $query = $this->db->get();
                $customer = $query->row_array();
                $this->load->model('communication_model');
                $invoice_mail = $this->send_invoice_auto($invocieno, $invocieno2, $bill_date, $total, $currency);
                $attachmenttrue = false;
                $attachment = '';
                $this->communication_model->send_corn_email($customer['email'], $customer['name'], $invoice_mail['subject'], $invoice_mail['message'], $attachmenttrue, $attachment);
            }
            if ($auto['key2'] == 1) {
                $this->db->select('name,phone');
                $this->db->from('geopos_customers');
                $this->db->where('id', $customer_id);
                $query = $this->db->get();
                $customer = $query->row_array();
                $this->load->model('plugins_model', 'plugins');
                $invoice_sms = $this->send_sms_auto($invocieno, $invocieno2, $bill_date, $total, $currency);
                $mobile = $customer['phone'];
                $text_message = $invoice_sms['message'];
                require APPPATH . 'third_party/twilio-php-master/Twilio/autoload.php';
                $sms_service = $this->plugins->universal_api(2);
// Your Account SID and Auth Token from twilio.com/console
                $sid = $sms_service['key1'];
                $token = $sms_service['key2'];
                $client = new Client($sid, $token);
                $message = $client->messages->create(
// the number you'd like to send the message to
                    $mobile,
                    array(
// A Twilio phone number you purchased at twilio.com/console
                        'from' => $sms_service['url'],
// the body of the text message you'd like to send
                        'body' => $text_message
                    )
                );
            }
*/
//profit calculation
            $t_profit = 0;
            $this->db->select('geopos_invoice_items.pid, geopos_invoice_items.price, geopos_invoice_items.qty, geopos_products.fproduct_price');
            $this->db->from('geopos_invoice_items');
            $this->db->join('geopos_products', 'geopos_products.pid = geopos_invoice_items.pid', 'left');
            $this->db->where('geopos_invoice_items.tid', $invocieno);
            $query = $this->db->get();
            $pids = $query->result_array();
            foreach ($pids as $profit) {
                $t_cost = $profit['fproduct_price'] * $profit['qty'];
                $s_cost = $profit['price'] * $profit['qty'];
                $t_profit += $s_cost - $t_cost;
            }
            $data = array('type' => 9, 'rid' => $invocieno, 'col1' => rev_amountExchange_s($t_profit), 'd_date' => $bill_date);

            $this->db->insert('geopos_metadata', $data);

        }

        return $invocieno;
        }
        catch (Exception $exception){
            return $exception -> getMessage();
        }
    }

    public function createApiInvoice($pid){
        try {

            $this -> justCreateInvoice($pid);
            foreach ($pid as $pr) {
                $qty = $pr['qty'];
                $code = $pr['VPC'];
                $this->db->set('qty', "qty-$qty", FALSE);
                $this->db->where('product_code', $code);
                $this->db->update('geopos_products');
//            if ((numberClean($product_alert[$key]) - $amt) < 0 AND $st_c == 0 AND $this->common->zero_stock()) {
//                echo json_encode(array('status' => 'Error', 'message' => 'Product - <strong>' . $product_name1[$key] . "</strong> - Low quantity. Available stock is  " . $product_alert[$key]));
//                $transok = false;
//                $st_c = 1;
//            }
            }
            return true;
        }catch (Exception $e){
            return array(false, $e->getMessage());
        }
    }
}