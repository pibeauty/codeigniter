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

class Customers extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customers_model', 'customers');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(3)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->load->library('jdf');
        $this->load->library("Custom");
        $this->load->model('Events_model', 'events');
        $this->load->model('Invoices_model', 'invoices');
        $this->li_a = 'crm';
    }

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Customers';
        $data['customers'] = $this->customers->get_datatables();
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/clist', $data);
        $this->load->view('fixed/footer');
    }

    public function create()
    {
        $this->load->library("Common");
        $data['langs'] = $this->common->languages();
        $data['customergrouplist'] = $this->customers->group_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['custom_fields'] = $this->custom->add_fields(1);
        $data['customers'] = $this->customers->get_datatables();
        $head['title'] = 'Create Customer';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/create', $data);
        $this->load->view('fixed/footer');
    }

    public function view()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['customergroup'] = $this->customers->group_info($data['details']['gid']);
        $data['money'] = $this->customers->money_details($custid);
        $data['due'] = $this->customers->due_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['activity'] = $this->customers->activity($custid);
        $data['custom_fields'] = $this->custom->view_fields_data($custid, 1);
        $head['title'] = 'View Customer';
        $data['events'] = $this->events->eventListByuser($custid);
        $data['referral'] = $this->customers->details($data['details']['moaaref']);
        $data['presenceCount'] = $this->invoices->userInvoiceCount($custid);


        $this->load->view('fixed/header', $head);
        if ($data['details']['id']) $this->load->view('customers/view', $data);
        $this->load->view('fixed/footer');
    }

    public function load_list()
    {
        $no = $this->input->post('start');

        $list = $this->customers->get_datatables();
        $data = array();
        if ($this->input->post('due')) {
            foreach ($list as $customers) {
                $no++;
				// $points = $customers->reference_points *
				// 	$customers->expense_points *
				// 	(
				// 		$customers->nail_points +
				// 		$customers->hair_points +
				// 		$customers->eyebrow_points +
				// 		$customers->skin_points +
				// 		$customers->makeup_points +
				// 		$customers->eyelash_points
				// 	);
                $row = array();
                $row[] = $no;
                $row[] = '<span class="avatar-sm align-baseline"><img class="rounded-circle" src="' . base_url() . 'userfiles/customers/thumbnail/' . $customers->picture . '" ></span> &nbsp;<a href="customers/view?id=' . $customers->id . '">' . $customers->name . '</a>';
                $row[] = amountExchange($customers->total - $customers->pamnt, 0, $this->aauth->get_user()->loc);
                // $row[] = $customers->address . ',' . $customers->city . ',' . $customers->country;
                $row[] = $age;
                $row[] = $customers->email;
                $row[] = $customers->phone;
                // $row[] = $points;
                $row[] = '<a href="customers/view?id=' . $customers->id . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a> <a href="customers/edit?id=' . $customers->id . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span>  ' . $this->lang->line('Edit') . '</a> <a href="appoint/?id=' . $customers->id . '&cusUser=0" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span>  Appoint</a> <a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
                $data[] = $row;
            }
        } else {
            foreach ($list as $customers) {
                $from = new DateTime($customers->tavalod);
                $to   = new DateTime('today');
                $age = $from->diff($to)->y;
				// $points = $customers->reference_points *
				// 	$customers->expense_points *
				// 	(
				// 		$customers->nail_points +
				// 		$customers->hair_points +
				// 		$customers->eyebrow_points +
				// 		$customers->skin_points +
				// 		$customers->makeup_points +
				// 		$customers->eyelash_points
				// 	);
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = '<span class="avatar-sm align-baseline"><img class="rounded-circle" src="' . base_url() . 'userfiles/customers/thumbnail/' . $customers->picture . '" ></span> &nbsp;<a href="customers/view?id=' . $customers->id . '">' . $customers->name . '</a>';
                // $row[] = $customers->address . ',' . $customers->city . ',' . $customers->country;
                $row[] = (int)$age;
                $row[] = $customers->email;
                $row[] = $customers->phone;
				// $row[] = $points;
                $row[] = '<a href="customers/view?id=' . $customers->id . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a> <a href="customers/edit?id=' . $customers->id . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span>  ' . $this->lang->line('Edit') . '<a href="appoint/?id=' . $customers->id . '&cusUser=0" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span>  Appoint</a>'. '</a> <a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
                $data[] = $row;
            }
        }


        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->count_all(),
            "recordsFiltered" => $this->customers->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function load_points_list()
    {
        $no = $this->input->post('start');

        $list = $this->customers->get_points_datatables();
        $data = array();
        foreach ($list as $customers) {
            $no++;
            $nail_points = $customers->nail_points ?? 0;
            $hair_points = $customers->hair_points ?? 0;
            $eyebrow_points = $customers->eyebrow_points ?? 0;
            $eyelash_points = $customers->eyelash_points ?? 0;
            $skin_points = $customers->skin_points ?? 0;
            $makeup_points = $customers->makeup_points ?? 0;
            $reference_points = $customers->reference_points ?? 0;
            $reference_points_for_total = $reference_points == 0 ? 1 : $reference_points;
            $expense_points = $customers->expense_points ?? 0;
            $expense_points_for_total = $expense_points == 0 ? 1 : $expense_points;
            $totalPoints = $reference_points_for_total *
            	$expense_points_for_total *
            	(
            		$nail_points +
            		$hair_points +
            		$eyebrow_points +
            		$skin_points +
            		$makeup_points +
            		$eyelash_points
            	);
            $row = array();
            $row[] = $no;
            $row[] = '<span class="avatar-sm align-baseline"><img class="rounded-circle" src="' . base_url() . 'userfiles/customers/thumbnail/' . $customers->picture . '" ></span> &nbsp;<a href="/customers/view?id=' . $customers->id . '">' . $customers->name . '</a>';
            $row[] = $customers->phone;
            $row[] = $nail_points;
            $row[] = $hair_points;
            $row[] = $eyebrow_points;
            $row[] = $eyelash_points;
            $row[] = $skin_points;
            $row[] = $makeup_points;
            $row[] = $reference_points;
            $row[] = $expense_points;
            $row[] = $totalPoints;
            $row[] = '<a href="/customers/view?id=' . $customers->id . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->count_all_for_points(),
            "recordsFiltered" => $this->customers->count_filtered_for_points(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }

    public function load_expectancy_list($service)
    {
        $no = $this->input->post('start');

        $list = $this->customers->get_expectancy_datatables($service);
        $data = array();
        foreach ($list as $customer) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<span class="avatar-sm align-baseline"><img class="rounded-circle" src="' . base_url() . 'userfiles/customers/thumbnail/' . $customer->picture . '" ></span> &nbsp;<a href="customers/view?id=' . $customer->customer_id . '">' . $customer->name . '</a>';
            $row[] = $customer->phone;
            $row[] = $customer->invoicedate;
            $row[] = $customer->product;
            $settingsCell = '<a href="/invoices/view?id=' . $customer->invoice_id . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span>  ' . $this->lang->line('View Invoice') . '</a>';
            $settingsCell .= $customer->last_expectancy_checked == 0 ? '<a href="javascript:markAsChecked(' . $customer->invoice_item_id .')" class="btn btn-danger btn-sm"><span class="fa fa-check"></span>' . $this->lang->line('Mark as Checked') . '</a>' : '<a href="javascript:markAsUnchecked(' . $customer->invoice_item_id .')" class="btn btn-success btn-sm"><span class="fa fa-check"></span>' . $this->lang->line('Checked') . '</a>';
            $row[] = $settingsCell;
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->count_all_for_expectancy($service),
            "recordsFiltered" => $this->customers->count_filtered_for_expectancy($service),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    //edit section
    public function edit()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $this->load->library("Common");
        $pid = $this->input->get('id');
        $data['customer'] = $this->customers->details($pid);
        $data['customergroup'] = $this->customers->group_info($data['customer']['gid']);
        $data['customergrouplist'] = $this->customers->group_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['custom_fields'] = $this->custom->view_edit_fields($pid, 1);
        $head['title'] = 'Edit Customer';
        $data['langs'] = $this->common->languages();
        $data['customers'] = $this->customers->get_datatables();
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/edit', $data);
        $this->load->view('fixed/footer');
    }

    public function addcustomer()
    {
        $name = $this->input->post('name', true);
        $company = $this->input->post('company', true);
        $phone = $this->input->post('phone', true);
        $email = $this->input->post('email', true);
        $address = $this->input->post('address', true);
        $city = $this->input->post('city', true);
        $region = $this->input->post('region', true);
        $country = $this->input->post('country', true);
        $postbox = $this->input->post('postbox', true);
        $taxid = $this->input->post('taxid', true);
        $customergroup = $this->input->post('customergroup');
        $name_s = $this->input->post('name_s', true);
        $phone_s = $this->input->post('phone_s', true);
        $email_s = $this->input->post('email_s', true);
        $address_s = $this->input->post('address_s', true);
        $city_s = $this->input->post('city_s', true);
        $region_s = $this->input->post('region_s', true);
        $country_s = $this->input->post('country_s', true);
        $postbox_s = $this->input->post('postbox_s', true);
        $language = $this->input->post('language', true);
        $create_login = $this->input->post('c_login', true);
        $password = $this->input->post('password_c', true);
        $docid = $this->input->post('docid', true);
        $custom = $this->input->post('c_field', true);
        $discount = $this->input->post('discount', true);

        $tavalodX = $this->input->post('tavalodX', true);
        if ($tavalodX)
            $tavalod = date('Y-m-d', substr($tavalodX, 0, -3));
        else
            $tavalod = null;
        
        $moaaref = $this->input->post('moaaref', true) ? $this->input->post('moaaref', true) : null;
        $picode = $this->input->post('picode', true);
        $this->customers->add($name, $company, $phone, $email, $address, $city, $region, $country, $postbox, $customergroup, $taxid, $name_s, $phone_s, $email_s, $address_s, $city_s, $region_s, $country_s, $postbox_s, $language, $create_login, $password, $docid, $custom, $discount, $tavalod, $moaaref, $picode);
    }

    public function editcustomer()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $id = $this->input->post('id');
        $name = $this->input->post('name', true);
        $company = $this->input->post('company', true);
        $phone = $this->input->post('phone', true);
        $email = $this->input->post('email', true);
        $address = $this->input->post('address', true);
        $city = $this->input->post('city', true);
        $region = $this->input->post('region', true);
        $country = $this->input->post('country', true);
        $postbox = $this->input->post('postbox', true);
        $customergroup = $this->input->post('customergroup', true);
        $taxid = $this->input->post('taxid', true);
        $name_s = $this->input->post('name_s', true);
        $phone_s = $this->input->post('phone_s', true);
        $email_s = $this->input->post('email_s', true);
        $address_s = $this->input->post('address_s', true);
        $city_s = $this->input->post('city_s', true);
        $region_s = $this->input->post('region_s', true);
        $country_s = $this->input->post('country_s', true);
        $postbox_s = $this->input->post('postbox_s', true);
        $docid = $this->input->post('docid', true);
        $custom = $this->input->post('c_field', true);
        $language = $this->input->post('language', true);
        $discount = $this->input->post('discount', true);

        $tavalodX = $this->input->post('tavalodX', true);
        if ($tavalodX && ($tavalodX != 'NaN'))
            $tavalod = date('Y-m-d', substr($tavalodX, 0, -3));
        else
            $tavalod = null;

        $moaaref = $this->input->post('moaaref', true) ? $this->input->post('moaaref', true) : null;
        $picode = $this->input->post('picode', true);

        if ($id) {
            $this->customers->edit($id, $name, $company, $phone, $email, $address, $city, $region, $country, $postbox, $customergroup, $taxid, $name_s, $phone_s, $email_s, $address_s, $city_s, $region_s, $country_s, $postbox_s, $docid, $custom, $language, $discount, $tavalod, $moaaref, $picode);
        }
    }

    public function changepassword()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        if ($id = $this->input->post()) {
            $id = $this->input->post('id');
            $password = $this->input->post('password', true);
            if ($id) {
                $this->customers->changepassword($id, $password);
            }
        } else {
            $pid = $this->input->get('id');
            $data['customer'] = $this->customers->details($pid);
            $data['customergroup'] = $this->customers->group_info($pid);
            $data['customergrouplist'] = $this->customers->group_list();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Customer';
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/edit_password', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function delete_i()
    {
        if ($this->aauth->premission(11)) {

            $id = $this->input->post('deleteid');
            if ($id > 1) {
                if ($this->customers->delete($id)) {
                    echo json_encode(array('status' => 'Success', 'message' => 'Customer details deleted Successfully!'));
                } else {
                    echo json_encode(array('status' => 'Error', 'message' => 'Error!'));
                }
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function displaypic()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/customers/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->customers->editpicture($id, $img);
        }
    }


    public function translist()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $cid = $this->input->post('cid');
        $list = $this->customers->trans_table($cid);
        $data = array();
        // $no = $_POST['start'];
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = $prd->date;
            $row[] = amountExchange($prd->debit, 0, $this->aauth->get_user()->loc);
            $row[] = amountExchange($prd->credit, 0, $this->aauth->get_user()->loc);
            $row[] = $prd->account;

            $row[] = $this->lang->line($prd->method);
            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a> <a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs delete-object"><span class="fa fa-trash"></span></a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->trans_count_all($cid),
            "recordsFiltered" => $this->customers->trans_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function inv_list()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $cid = $this->input->post('cid');
        $tid = $this->input->post('tyd');

        $list = $this->customers->inv_datatables($cid, $tid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $invoices->tid;
            $row[] = $invoices->invoicedate;
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '" class="btn btn-success btn-xs" title="View Invoice"><i class="fa fa-file-text"></i> </a> <a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a> <a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-xs delete-object" title="Delete"><span class="fa fa-trash"></span></a> ';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->inv_count_all($cid),
            "recordsFiltered" => $this->customers->inv_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function transactions()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Transactions';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/transactions', $data);
        $this->load->view('fixed/footer');
    }

    public function invoices()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Invoices';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/invoices', $data);
        $this->load->view('fixed/footer');
    }

    public function quotes()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Quotes';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/quotes', $data);
        $this->load->view('fixed/footer');
    }

    public function qto_list()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $cid = $this->input->post('cid');
        $tid = $this->input->post('tyd');
        $list = $this->customers->qto_datatables($cid, $tid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $invoices) {
            $no++;
            $row = array();

            $row[] = $invoices->tid;

            $row[] = $invoices->invoicedate;
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("quote/view?id=$invoices->id") . '" class="btn btn-success btn-xs" title="View Invoice"><i class="fa fa-file-text"></i> </a> <a href="' . base_url("quote/printquote?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a> <a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-xs delete-object" title="Delete"><span class="fa fa-trash"></span></a> ';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->qto_count_all($cid),
            "recordsFiltered" => $this->customers->qto_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function balance()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $amount = $this->input->post('amount', true);
            if ($this->customers->recharge($id, $amount)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Balance Added')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error!'));
            }
        } else {
            $custid = $this->input->get('id');
            $data['details'] = $this->customers->details($custid);
            $data['customergroup'] = $this->customers->group_info($data['details']['gid']);
            $data['money'] = $this->customers->money_details($custid);
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['activity'] = $this->customers->activity($custid);
            $head['title'] = 'View Customer';
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/recharge', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function projects()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Invoices';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/projects', $data);
        $this->load->view('fixed/footer');
    }

    public function prj_list()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $cid = $this->input->post('cid');


        $list = $this->customers->project_datatables($cid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $project) {
            $no++;
            $name = '<a href="' . base_url() . 'projects/explore?id=' . $project->id . '">' . $project->name . '</a>';

            $row = array();
            $row[] = $no;
            $row[] = $name;
            $row[] = dateformat($project->sdate);
            $row[] = $project->customer;
            $row[] = '<span class="project_' . $project->status . '">' . $this->lang->line($project->status) . '</span>';

            $row[] = '<a href="' . base_url() . 'projects/explore?id=' . $project->id . '" class="btn btn-primary btn-sm rounded" data-id="' . $project->id . '" data-stat="0"> ' . $this->lang->line('View') . ' </a> <a class="btn btn-info btn-sm" href="' . base_url() . 'projects/edit?id=' . $project->id . '" data-object-id="' . $project->id . '"> <i class="fa fa-pencil"></i> </a>&nbsp;<a class="btn btn-danger btn-sm delete-object" href="#" data-object-id="' . $project->id . '"> <i class="fa fa-trash"></i> </a>';


            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->project_count_all($cid),
            "recordsFiltered" => $this->customers->project_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function notes()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $custid = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['details'] = $this->customers->details($custid);
        $this->session->set_userdata("cid", $custid);
        $head['title'] = 'Notes';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/notes', $data);
        $this->load->view('fixed/footer');
    }

    public function notes_load_list()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $cid = $this->input->post('cid');
        $list = $this->customers->notes_datatables($cid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $note) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $note->title;
            $row[] = dateformat($note->cdate);

            $row[] = '<a href="editnote?id=' . $note->id . '&cid=' . $note->fid . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span> ' . $this->lang->line('View') . '</a> <a class="btn btn-danger btn-sm delete-object" href="#" data-object-id="' . $note->id . '"> <i class="fa fa-trash"></i> </a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->notes_count_all($cid),
            "recordsFiltered" => $this->customers->notes_count_filtered($cid),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function editnote()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $title = $this->input->post('title', true);
            $content = $this->input->post('content');
            $cid = $this->input->post('cid');
            if ($this->customers->editnote($id, $title, $content, $cid)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . " <a href='notes?id=$cid' class='btn btn-indigo btn-lg'><span class='icon-user' aria-hidden='true'></span>  </a> <a href='editnote?id=$id&cid=$cid' class='btn btn-indigo btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $id = $this->input->get('id');
            $cid = $this->input->get('cid');
            $data['note'] = $this->customers->note_v($id, $cid);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit';
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/editnote', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function addnote()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        if ($this->input->post('title')) {

            $title = $this->input->post('title', true);
            $cid = $this->input->post('id');
            $content = $this->input->post('content');

            if ($this->customers->addnote($title, $content, $cid)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='addnote?id=" . $cid . "' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='notes?id=" . $cid . "' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Add Note';
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/addnote', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function delete_note()
    {
        $id = $this->input->post('deleteid');
        $cid = $this->session->userdata('cid');
        if ($this->customers->deletenote($id, $cid)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    function statement()
    {

        if ($this->input->post()) {

            $this->load->model('reports_model');


            $customer = $this->input->post('customer');
            $trans_type = $this->input->post('trans_type');
            $sdate = datefordatabase($this->input->post('sdate'));
            $edate = datefordatabase($this->input->post('edate'));
            $data['customer'] = $this->customers->details($customer);


            $data['list'] = $this->reports_model->get_customer_statements($customer, $trans_type, $sdate, $edate);


            $html = $this->load->view('customers/statementpdf', $data, true);


            ini_set('memory_limit', '64M');


            $this->load->library('pdf');

            $pdf = $this->pdf->load();


            $pdf->WriteHTML($html);


            $pdf->Output('Statement' . $customer . '.pdf', 'I');
        } else {
            $data['id'] = $this->input->get('id');
            $this->load->model('transactions_model');

            $data['details'] = $this->customers->details($data['id']);
            $head['title'] = "Account Statement";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/statement', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function documents()
    {
        $data['id'] = $this->input->get('id');
        $data['details'] = $this->customers->details($data['id']);
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->session->set_userdata("cid", $data['id']);
        $head['title'] = 'Documents';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/documents', $data);
        $this->load->view('fixed/footer');


    }

    public function document_load_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->customers->document_datatables($cid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $document) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $document->title;
            $row[] = dateformat($document->cdate);

            $row[] = '<a href="' . base_url('userfiles/documents/' . $document->filename) . '" class="btn btn-success btn-xs"><i class="fa fa-file-text"></i> ' . $this->lang->line('View') . '</a> <a class="btn btn-danger btn-xs delete-object" href="#" data-object-id="' . $document->id . '"> <i class="fa fa-trash"></i> </a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->document_count_all($cid),
            "recordsFiltered" => $this->customers->document_count_filtered($cid),
            "data" => $data,
        );
        echo json_encode($output);
    }


    public function adddocument()
    {
        $data['id'] = $this->input->get('id');
        $this->load->helper(array('form'));
        $data['response'] = 3;
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add Document';

        $this->load->view('fixed/header', $head);

        if ($this->input->post('title')) {
            $title = $this->input->post('title', true);
            $cid = $this->input->post('id');
            $config['upload_path'] = './userfiles/documents';
            $config['allowed_types'] = 'docx|docs|txt|pdf|xls';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = 3000;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('userfile')) {
                $data['response'] = 0;
                $data['responsetext'] = 'File Upload Error';

            } else {
                $data['response'] = 1;
                $data['responsetext'] = 'Document Uploaded Successfully. <a href="documents?id=' . $cid . '"
                                       class="btn btn-indigo btn-md"><i
                                                class="icon-folder"></i>
                                    </a>';
                $filename = $this->upload->data()['file_name'];
                $this->customers->adddocument($title, $filename, $cid);
            }

            $this->load->view('customers/adddocument', $data);
        } else {


            $this->load->view('customers/adddocument', $data);


        }
        $this->load->view('fixed/footer');


    }


    public function delete_document()
    {
        $id = $this->input->post('deleteid');
        $cid = $this->session->userdata('cid');

        if ($this->customers->deletedocument($id, $cid)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

	public function reports()
	{
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
		$this->load->model('chart_model', 'chart');
		$type = $this->input->get('p');
        $custid = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['details'] = $this->customers->details($custid);
		$chart = $this->chart->singlecustomerchart($custid, $type);
		$totalExpences = 0;
		foreach ($chart as $item) {
			$totalExpences += $item['subtotal'];
		}
		$data['chart'] = [
			'chart' => $chart,
			'total_expences' => $totalExpences,
			'total_refrences' => $this->customers->totalRefrences($data['details']['name']),
			'total_visits' => $this->customers->totalVisits($custid),
		];
		$data['points'] = $this->customers->getCustomerPoints($custid);
		$data['points']['total_points'] =
			$data['points']['reference_points'] *
			($data['points']['expense_points'] != 0 ? $data['points']['expense_points'] : 1) *
			(
				$data['points']['nail_points'] +
				$data['points']['hair_points'] +
				$data['points']['eyebrow_points'] +
				$data['points']['skin_points'] +
				$data['points']['makeup_points'] +
				$data['points']['eyelash_points']
			);
        $this->session->set_userdata("cid", $custid);
        $head['title'] = 'Reports';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/reports', $data);
        $this->load->view('fixed/footer');
	}

	public function reports_update()
    {
		$this->load->model('chart_model', 'chart');
		$custid = $this->input->post('id');
        $type = $this->input->post('p');
        $d1 = $this->input->post('sdate');
        $d2 = $this->input->post('edate');
		$customerDetails = $this->customers->details($custid);
        $out = $this->chart->singlecustomerchart($custid, $type, $d1, $d2);
        $chart_array = array();
		$totalExpences = 0;
        foreach ($out as $item) {
            $chart_array[] = array('y' => $item['product'], 'a' => $item['subtotal']);
			$totalExpences += $item['subtotal'];
        }
		$chart = [
			'chart' => $chart_array,
			'total_expences' => $totalExpences,
			'total_refrences' => $this->customers->totalRefrences($customerDetails['name'], $d1, $d2),
			'total_visits' => $this->customers->totalVisits($custid, $d1, $d2)
		];
        echo json_encode($chart);

    }

    public function points()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Customers Points';
        $this->load->view('fixed/header', $head);
        $this->load->view('kyc/points');
        $this->load->view('fixed/footer');
    }

    public function expectancy($service)
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Customers Expectancy - ' . $service;
        $data = [
            'service' => $service,
            'customers' => $this->customers->get_datatables()
        ];
        $this->load->view('fixed/header', $head);
        $this->load->view('kyc/expectancy', $data);
        $this->load->view('fixed/footer');
    }

    public function checkExpectancy($invoiceItemId)
    {
        $this->db->where('id', $invoiceItemId);
        $this->db->update('geopos_invoice_items', [
            'last_expectancy_checked' => 1
        ]);
    }

    public function uncheckExpectancy($invoiceItemId)
    {
        $this->db->where('id', $invoiceItemId);
        $this->db->update('geopos_invoice_items', [
            'last_expectancy_checked' => 0
        ]);
    }
}