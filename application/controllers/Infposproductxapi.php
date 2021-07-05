<?php
////defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/qrcode/vendor/autoload.php';

use Endroid\QrCode\QrCode;

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

class infposproductxapi extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('restservice_model', 'restservice');
    }

//    public function set_response($data = NULL, $http_code = NULL)
//    {
//        $this->response($data, $http_code, TRUE);
//    }
//
//    public function response($data = NULL, $http_code = NULL, $continue = FALSE)
//    {
//        //if profiling enabled then print profiling data
//        $isProfilingEnabled = $this->config->item('enable_profiling');
//        if (!$isProfilingEnabled) {
//            ob_start();
//            // If the HTTP status is not NULL, then cast as an integer
//            if ($http_code !== NULL) {
//                // So as to be safe later on in the process
//                $http_code = (int)$http_code;
//            }
//
//            // Set the output as NULL by default
//            $output = NULL;
//
//            // If data is NULL and no HTTP status code provided, then display, error and exit
//            if ($data === NULL && $http_code === NULL) {
//                $http_code = self::HTTP_NOT_FOUND;
//            } // If data is not NULL and a HTTP status code provided, then continue
//            elseif ($data !== NULL) {
//                // If the format method exists, call and return the output in that format
//                if (method_exists($this->format, 'to_' . $this->response->format)) {
//                    // Set the format header
//                    $this->output->set_content_type($this->_supported_formats[$this->response->format], strtolower($this->config->item('charset')));
//                    $output = $this->format->factory($data)->{'to_' . $this->response->format}();
//
//                    // An array must be parsed as a string, so as not to cause an array to string error
//                    // Json is the most appropriate form for such a data type
//                    if ($this->response->format === 'array') {
//                        $output = $this->format->factory($output)->{'to_json'}();
//                    }
//                } else {
//                    // If an array or object, then parse as a json, so as to be a 'string'
//                    if (is_array($data) || is_object($data)) {
//                        $data = $this->format->factory($data)->{'to_json'}();
//                    }
//
//                    // Format is not supported, so output the raw data as a string
//                    $output = $data;
//                }
//            }
//
//            // If not greater than zero, then set the HTTP status code as 200 by default
//            // Though perhaps 500 should be set instead, for the developer not passing a
//            // correct HTTP status code
//            $http_code > 0 || $http_code = self::HTTP_OK;
//
//            $this->output->set_status_header($http_code);
//
//            // JC: Log response code only if rest logging enabled
//            if ($this->config->item('rest_enable_logging') === TRUE) {
//                $this->_log_response_code($http_code);
//            }
//
//            // Output the data
//            $this->output->set_output($output);
//
//            if ($continue === FALSE) {
//                // Display the data and exit execution
//                $this->output->_display();
//                exit;
//            } else {
//                ob_end_flush();
//            }
//
//            // Otherwise dump the output automatically
//        } else {
//            echo json_encode($data);
//        }
//    }

    public function products_get()
    {
        $id = $this->get('id');
        if ($id === NULL) {
            $list = $this->restservice->products();
            if ($list) {
                // Set the response and exit
                $this->response($list, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Client were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular user.
        $id = (int)$id;
        // Validate the id.
        if ($id <= 0) {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.
        $list = $this->restservice->products($id);
        if (!empty($list)) {
            $this->set_response($list[0], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Product could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function ordersChange_get()
    {
        $id = $this->get('id');
        if ($id === NULL) {
            $list = $this->restservice->ordersChange();
            if ($list) {
                // Set the response and exit
                $this->response($list, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Client were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular user.
        $id = (int)$id;
        // Validate the id.
        if ($id <= 0) {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.
        $list = $this->restservice->products($id);
        if (!empty($list)) {
            $this->set_response($list[0], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            // Reset table status
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Product could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function ordersChangeSuccess_post()
    {

        try {
            $data = $this->post();
            $list = $this->post('list');
            $status = $this->post('status');
            if ($list && $status) {
                // Set the response and exit
                foreach ($list as $order) {
                    $curId = $order['id'];
                    $id = $this->restservice->updateIsChanged($curId);
                }
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Client were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }

            if ($id && $id != '') {

                $this->response(array('status' => true), REST_Controller::HTTP_OK);
                exit();

            }


            throw new Exception("Could not be Updated!");
        }
        catch (Exception $e){
            $this->response(array('errorMsg' => $e->getMessage()), REST_Controller::HTTP_BAD_GATEWAY);
            exit();
        }
    }

    public function clients_post()
    {
        $id = $this->post('id');
        if ($id === NULL) {
            $list = $this->restservice->customers();
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($list) {
                // Set the response and exit
                $this->response($list, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Client were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular user.
        $id = (int)$id;
        // Validate the id.
        if ($id <= 0) {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.
        $list = $this->restservice->customers($id);
        if (!empty($list)) {
            $this->set_response($list[0], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Client could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }


    public function clients_delete()
    {
        $id = (int)$this->get('id');
        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        if ($this->restservice->delete_customers($id)) {
            $message = [
                'id' => $id,
                'message' => 'Deleted the resource'
            ];

            $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
        }
    }

    public function products_post()
    {
        try {
            $data = $this->post();
//            var_dump($data);
            $products = $this->post('products');
//            var_dump($products);
//            var_dump($data['buyer']);
//            var_dump($data['purchase_id']);
            $id = $this->restservice->addSaleOrder($data);
//            var_dump($id);
            if ($id && $id != '') {

                $this->response(array('id' => $id, 'products' => $products), REST_Controller::HTTP_OK);
                exit();

            }


            throw new Exception("Could not be created!");
        }
        catch (Exception $e){
            $this->response(array('errorMsg' => $e->getMessage()), REST_Controller::HTTP_BAD_GATEWAY);
            exit();
        }

    }

    public function ordersDelivered_post()
    {
//        $this->response($this->post(), REST_Controller::HTTP_BAD_GATEWAY);
//        exit();
        try {
            $data = $this->post();
            $external_id = $this->post('id');
            $order = $this->restservice->getOrderSale($external_id);
            $order = $order[0];
            $products = $order['products_n_qty'];
            $id = $order['external_number'];
            if (isset($id) && $id != '') {

                $order = $this->restservice->orderDelivered($external_id);
                $this->response(array('id' => $external_id, 'external_number' => $id, 'status' => true, 'products_n_qty' => $products), REST_Controller::HTTP_OK);
                exit();

            }


            throw new Exception("Could not be created!");
        }
        catch (Exception $e){
            $this->response(array('errorMsg' => $e->getMessage()), REST_Controller::HTTP_BAD_GATEWAY);
            exit();
        }

    }

    public function ordersDeliveredSuccess_post()
    {
        try {
            $data = $this->post();
            $external_id = $this->post('id');
            $id = $this->restservice->orderDelivered($external_id);
            if ($id && $id != '') {

                $this->response(array('status' => true), REST_Controller::HTTP_OK);
                exit();

            }


            throw new Exception("Could not be Updated!");
        }
        catch (Exception $e){
            $this->response(array('errorMsg' => $e->getMessage()), REST_Controller::HTTP_BAD_GATEWAY);
            exit();
        }

    }

    public function cancelOrder_post()
    {
        try {
            $data = $this->post();
            $external_id = $this->post('id');
            $order = $this->restservice->getOrderSale($external_id);
            $order = $order[0];
            $products = $order['products_n_qty'];
            $id = $order['external_number'];
            if ($id && $id != '') {

                $this->response(array('id' => $external_id, 'external_number' => $id, 'status' => true, 'products_n_qty' => $products), REST_Controller::HTTP_OK);
                return;
            }

            throw new Exception("Could not be created!");
        } catch (Exception $e) {
            $this->response(array('errorMsg' => $e->getMessage()), REST_Controller::HTTP_BAD_GATEWAY);
            return;
        }

    }

    public function cancelOrderSuccess_post()
    {
        try {
            $data = $this->post();
            $external_id = $this->post('id');
            $id = $this->restservice->cancelOrder($external_id);
            if ($id && $id != '') {

                $this->response(array('status' => true), REST_Controller::HTTP_OK);
                return;
            }

            throw new Exception("Could not be Updated!");
        } catch (Exception $e){
            $this->response(array('errorMsg' => $e->getMessage()), REST_Controller::HTTP_BAD_GATEWAY);
        }
    }

    public function invoice_get()
    {
        $id = $this->get('id');

        if ($id === NULL) {
            $list = $this->restservice->invoice($id);
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($list) {
                // Set the response and exit
                $this->response($list, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Products were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular user.
        $id = (int)$id;
        // Validate the id.
        if ($id <= 0) {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            return;
        }
        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.
        $list = $this->restservice->invoice($id);
        if (!empty($list)) {
            $this->set_response($list[0], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Invoice could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function invoicepdf_get()
    {
        $run = false;
        $this->load->model('pos_invoices_model', 'invocies');
        $id = $this->get('id');
        $key = $this->get('key');
        $this->db->select('key');
        $this->db->from('geopos_restkeys');
        $this->db->limit(1);
        $this->db->where('key', $key);
        $query_r = $this->db->get();
        if ($query_r->num_rows() > 0) {
            $run = true;
        }


        if (!$run) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Invoice could not be found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }


        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.
        $this->load->library('Aauth');
        $this->load->library('Custom');
        $tid = $id;
        $data['qrc'] = 'pos_' . date('Y_m_d_H_i_s') . '_.png';
        $data['id'] = $tid;
        $data['title'] = "Invoice $tid";
        $data['invoice'] = $this->invocies->invoice_details($tid);
        if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);


        $this->load->model('billing_model', 'billing');
        $online_pay = $this->billing->online_pay_settings();
        if ($online_pay['enable'] == 1) {
            $token = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));
            $data['qrc'] = 'pos_' . date('Y_m_d_H_i_s') . '_.png';

            $qrCode = new QrCode(base_url('billing/card?id=' . $tid . '&itype=inv&token=' . $token));

//header('Content-Type: '.$qrCode->getContentType());
//echo $qrCode->writeString();
            $qrCode->writeFile(FCPATH . 'userfiles/pos_temp/' . $data['qrc']);
        }

        $this->pheight = 0;
        $this->load->library('pdf');
        $pdf = $this->pdf->load_thermal();
        // retrieve data from model or just static date
        $data['title'] = "items";
        $pdf->allow_charset_conversion = true;  // Set by default to TRUE
        $pdf->charset_in = 'UTF-8';
        //   $pdf->SetDirectionality('rtl'); // Set lang direction for rtl lang
        $pdf->autoLangToFont = true;
        $data['round_off'] = $this->custom->api_config(4);
        $html = $this->load->view('print_files/pos_pdf_compact', $data, true);
        // render the view into HTML

        $h = 160 + $this->pheight;
        $pdf->_setPageSize(array(70, $h), $pdf->DefOrientation);
        $pdf->WriteHTML($html);
        $file_name = substr($key, 0, 6) . $id;
        $pdf->Output('userfiles/pos_temp/' . $file_name . '.pdf', 'F');
        if (!extension_loaded('imagick')) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Imagick extension not installed!'
            ], REST_Controller::HTTP_OK);
            return;
        }
        $im = new Imagick();
        $im->setResolution(300, 300);
        $im->readimage(FCPATH . 'userfiles/pos_temp/' . $file_name . '.pdf');
        $im->setImageType(imagick::IMGTYPE_TRUECOLOR);
        $im->setImageFormat('png');
        //$im->transparentPaintImage(      'white', 0, 100, false    );
        $im->writeImage(FCPATH . 'userfiles/pos_temp/rest-' . $file_name . '.png');
        $im->clear();
        $im->destroy();
        unlink('userfiles/pos_temp/' . $data['qrc']);
        unlink(FCPATH . 'userfiles/pos_temp/' . $file_name . '.pdf');
        $this->set_response(array('w' => 1), REST_Controller::HTTP_OK);

    }

    public function acceptSaleorder_post(){
        $id = $this->input->post('soid');
        if ($id && $id !='') {
            try {
                $this->db->set('status', 3);
                $this->db->set('is_changed', 1);
                $this->db->where('id', $id);
                $this->db->update('sales_order');
                $list = $this->restservice->getOrderSale($id);
                $this->load->model('invoices_model', 'invoice');
                foreach ($list as $row){
                    $products = unserialize($row['products_n_qty']);
                    $invoiceNo = $this->invoice->justCreateInvoice($products);
                }
                $this->set_response(array('status' => 'Success', 'invoiceNo' => $invoiceNo), REST_Controller::HTTP_OK);
                return;
            }
            catch (Exception $e){
                $this->set_response(array('status' => 'Error', 'message' => $e->getMessage()), REST_Controller::HTTP_OK);
                return;
                //throw new Exception("Couldn't accept the sale order!".$e->getMessage());
            }
        } else {
            $this->set_response(array('status' => 'Error', 'message' => 'invalid id', 'id' => $id, 'amount' => 0), REST_Controller::HTTP_OK);
            return;
        }
    }


    public function changeQuantity_post(){
        $id = $this->input->post('soid');
        $quantities = json_decode($this->input->post('qty'));
        $products = [];
        $list = $this->restservice->getOrderSale($id);
        foreach ($list as $row){
            $products = unserialize($row['products_n_qty']);
//            array_push($productsNQty, $products);
        }

        foreach ($products as $index => $product){
            $products[$index]['qty'] = $quantities[$index];
        }

        $productsNqty = serialize($products);

        if ($id && $id !='') {
            try {
                $this->db->set('status', 5);
                $this->db->set('is_changed', 1);
                $this->db->set('products_n_qty', $productsNqty);
                $this->db->where('id', $id);
                $this->db->update('sales_order');
                echo json_encode(array('status' => 'Success', $id));
            }
            catch (Exception $e){
                throw new Exception("Couldn't accept the sale order!".$e->getMessage());
            }
        } else {
            throw new Exception("Something is wrong!");
            echo json_encode(array('status' => 'Error', 'message' => '', 'amount' => 0));
        }


    }

    public function denySaleorder_post(){
        $id = $this->input->post('soid');
        if ($id && $id !='') {
            try {
                $this->db->set('status', 0);
                $this->db->set('is_changed', 1);
                $this->db->where('id', $id);
                $this->db->update('sales_order');
                echo json_encode(array('status' => 'Success'));
            }
            catch (Exception $e){
                throw new Exception("Couldn't accept the sale order!".$e->getMessage());
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' => '', 'amount' => 0));
        }
    }

//    public function returnStock_post()
//
//    {
//        try {
//            $data = $this->post();
//            $raw_data = $this->post('data');
//            $order = $this->restservice->getOrderSale($external_id);
//            $order = $order[0];
//            $products = $order['products_n_qty'];
//            $id = $order['external_number'];
//            if ($id && $id != '') {
//
//                $this->response(array('id' => $external_id, 'external_number' => $id, 'status' => true, 'products_n_qty' => $products), REST_Controller::HTTP_OK);
//                return;
//            }
//
//            throw new Exception("Could not be created!");
//        } catch (Exception $e) {
//            $this->response(array('errorMsg' => $e->getMessage()), REST_Controller::HTTP_BAD_GATEWAY);
//            return;
//        }
//
//    }

    public function returnStock_post()
    {
        try {
            $data = $this->post();
            $returnData = $this->post('return_data');
            $returnData = json_decode($returnData, true);
            $id = $this->restservice->returnStock($returnData);
//            if ($id) {
                $this->response(array('status' => $id), REST_Controller::HTTP_OK);
                return;
//            }

            throw new Exception("Could not be Updated!");
        } catch (Exception $e){
            $this->response(array('errorMsg' => $e->getMessage()), REST_Controller::HTTP_BAD_GATEWAY);
        }
    }

}
