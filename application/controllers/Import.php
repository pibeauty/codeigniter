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

use PhpOffice\PhpSpreadsheet\IOFactory;

class Import extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('export_model', 'export');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
            exit;
        }

        if ($this->aauth->get_user()->roleid < 5) {

            exit('Not Allowed!');
        }
        $this->date = 'backup_' . date('Y_m_d_H_i_s');
        // Load member model
        $this->load->model('customers_model', 'customers');

        // Load form validation library
        $this->load->library('form_validation');

        // Load file helper
        $this->load->helper('file');
        $this->load->library('jdf');
    }


    function products()
    {
        $this->load->helper(array('form'));
        $this->load->model('categories_model');
        $head['title'] = "Import Products";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['cat'] = $this->categories_model->category_list();
        $data['warehouse'] = $this->categories_model->warehouse_list();
        $this->load->view('fixed/header', $head);
        $this->load->view('import/products', $data);
        $this->load->view('fixed/footer');

    }

    public function products_upload()
    {

        $this->load->helper(array('form'));
        $data['response'] = 3;
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Import Product';

        $this->load->view('fixed/header', $head);

        if ($this->input->post('product_cat', true)) {
            $data['pc'] = $this->input->post('product_cat', true);
            $data['wid'] = $this->input->post('product_warehouse', true);
            $config['upload_path'] = './userfiles';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = 6000;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('userfile')) {
                $data['response'] = 0;
                $data['responsetext'] = 'File Upload Error';

            } else {
                $data['response'] = 1;
                $data['responsetext'] = 'Document Uploaded Successfully.';
                $data['filename'] = $this->upload->data()['file_name'];

            }

            $this->load->view('import/wizard', $data);
        } else {


            echo ' error';


        }
        $this->load->view('fixed/footer');


    }


    public function start_process()
    {
        require APPPATH . 'third_party/vendor/autoload.php';

        $name = $this->input->post('name');
        $pcat = $this->input->post('pc');
        $warehouse = $this->input->post('wid');
        $inputFileName = FCPATH . 'userfiles/' . $name;

        $spreadsheet = IOFactory::load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);
//print_r($sheetData);

        $products = array();

        foreach ($sheetData as $row) {
            $barcode = rand(100, 999) . '-' . rand(0, 9) . '-' . rand(1000000, 9999999) . '-' . rand(0, 9);

            $products[] = array(
                'pid' => null,
                'pcat' => $pcat,
                'warehouse' => $warehouse,
                'product_name' => $row[0],
                'product_code' => $row[1],
                'product_price' => $row[2],
                'fproduct_price' => $row[3],
                'taxrate' => $row[4],
                'disrate' => $row[5],
                'qty' => $row[6],
                'product_des' => $row[7],
                'alert' => $row[8],
                'barcode' => $barcode
            );


        }
        unlink(FCPATH . 'userfiles/' . $name);
        if (count($sheetData[0]) == 9) {
            $out = $this->db->insert_batch('geopos_products', $products);
            if ($out) {
                echo json_encode(array('status' => 'Success', 'message' =>
                    "Product Data Imported Successfully!"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Database Import Error! Please use proper encoding of file and its content."));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please correct the format of CSV file, it should be as per template."));
        }


    }


    //customer


    function customers()
    {
        $this->load->helper(array('form'));
        $this->load->model('categories_model');
        $head['title'] = "Import Products";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['cat'] = $this->categories_model->category_list();
        $data['warehouse'] = $this->categories_model->warehouse_list();
        $this->load->view('fixed/header', $head);
        $this->load->view('import/customers', $data);
        $this->load->view('fixed/footer');

    }

    public function customers_upload()
    {

        $data = array();
        $memData = array();


            // Form field validation rules
            $this->form_validation->set_rules('file', 'CSV file');
 // Validate submitted form data
           // if($this->form_validation->run() == true){
                $insertCount = $updateCount = $rowCount = $notAddCount = 0;


        // If file uploaded
                if(is_uploaded_file($_FILES['userfile']['tmp_name'])){
                    // Load CSV reader library
                    $this->load->library('Csvreader');

                    // Parse data from CSV file
                    $csvData = $this->csvreader->parse_csv($_FILES['userfile']['tmp_name']);

                    // Insert/update CSV data into database
                    if(!empty($csvData)){


                      foreach($csvData as $key => $value){ $rowCount++;

                          //1کد مشتری	2نام مشتری	3کد پی 	4موبایل	5معرف	6تاریخ تولد	7سن	8تاریخ اولین حضور
                              //9تاریخ آخرین حضور	10تعداد کل سرویس های اخذ شده	11تعداد روزهای که مشتری ما هستن
                              //	12تعداد روزهایی که از آخرین مراجعه تا به امروز گذشته
                              //	13جمع کل هزینه پرداختی این مشتری 	14جمع کل تخفیف این مشتری
                              //15تعداد دفعات حضور مشتری	16متوسط هزینه پرداختی این مشتری در هربار حضور
                              //17متوسط هزینه پرداختی رند شده

                          //  $jj= json_encode($row);
                          $i=1;$name="";$picode="";$phone="";$mainData=[];
                          $moaaref="";$tavalod="";$avalin_hozor="";$akharin_hozor="";$kole_serviveha=0;
                          $kole_hazine=0;$kole_takhfif=0;$tedad_hozor=0;$motevaset_hazine=0;
                          foreach ($value as $key2 =>$it){
                              if($i==2){
                                  // print_r($it);echo "<br/>";
                                  $name=$it;
                              }
                              if($i==3){
                                  $picode=$it;
                              }
                              if($i==4){
                                  $phone='0'.$it;
                              }
                              if($i==5){
                                  $moaaref=$it;
                              }
                              if($i==6){
                                  $pieces1 = explode("/", $it);
                                  $getData1=$this->jdf->jalali_to_gregorian ( $pieces1[0],$pieces1[1],$pieces1[2],'-'  );
                                  $tavalod=date('Y-m-d H:i:s',strtotime($getData1));
                              }
                              if($i==8){
                                  $pieces2 = explode("/", $it);
                                  $getData2=$this->jdf->jalali_to_gregorian ( $pieces2[0],$pieces2[1],$pieces2[2],'-'  );
                                  $avalin_hozor=date('Y-m-d H:i:s',strtotime($getData2));
                              }
                              if($i==9){
                                  $pieces3 = explode("/", $it);
                                  $getData3=$this->jdf->jalali_to_gregorian ( $pieces3[0],$pieces3[1],$pieces3[2],'-'  );
                                  $akharin_hozor=date('Y-m-d H:i:s',strtotime($getData3));
                              }
                                   if($i==10){
                                       $kole_serviveha=$it;
                                   }
                                   if($i==13){
                                       $kole_hazine=$it;
                                   }
                                  if($i==14){
                                      $kole_takhfif=$it;
                                  }
                                  if($i==15){
                                      $tedad_hozor=$it;
                                  }
                                  if($i==16){
                                      $motevaset_hazine=$it;
                                  }
                              $memData = array(
                                  'name' => $name,
                                  'phone' => $phone,
                                  'picode' => $picode,
                                  'moaaref'=>$moaaref,
                                  'tavalod'=>$tavalod,
                                  'avalin_hozor'=>$avalin_hozor,
                                  'akharin_hozor'=>$akharin_hozor,
                                  'kole_serviveha'=>$kole_serviveha,
                                  'kole_hazine'=>$kole_hazine,
                                  'kole_takhfif'=>$kole_takhfif,
                                  'tedad_hozor'=>$tedad_hozor,
                                  'motevaset_hazine'=>$motevaset_hazine,
                              );

                              $i++;
                          }echo "<br/>";echo "<br/>";echo "<br/>";echo "<br/>";echo "<br/>";
                          // print_r($memData);echo "<br/>";
                          array_push($mainData,$memData);
                          $this->customers->insertNew($mainData);

                         // print_r($mainData);//1377/02/30
                          //  echo $pieces[0].'-'.$pieces[1].'-'.$pieces[2];
                          // log_message('error',"------------------------------------ghjghacascsascj:".$jj);
                          // Prepare data for DB insertion
                          /*    $memData = array(
                                  'name' => $row['Name'],
                                  'phone' => $row['Phone'],
                              );

                              // Check whether email already exists in the database
                              $con = array(
                                  'where' => array(
                                      'email' => $row['Email']
                                  ),
                                  'returnType' => 'count'
                              );
                              $prevCount = $this->member->getRows($con);

                              if($prevCount > 0){
                                  // Update member data
                                  $condition = array('email' => $row['Email']);
                                  $update = $this->member->update($memData, $condition);

                                  if($update){
                                      $updateCount++;
                                  }
                              }else{
                                  // Insert member data
                                  $insert = $this->member->insert($memData);

                                  if($insert){
                                      $insertCount++;
                                  }
                              }*/

                      }


                        // Status message with imported data count
                      //  $notAddCount = ($rowCount - ($insertCount + $updateCount));
                      //  $successMsg = 'Members imported successfully. Total Rows ('.$rowCount.') | Inserted ('.$insertCount.') | Updated ('.$updateCount.') | Not Inserted ('.$notAddCount.')';
                      //  $this->session->set_userdata('success_msg', $successMsg);

                        }
                }else{
                    $this->session->set_userdata('error_msg', 'Error on file upload, please try again.');
                }
           // }else{
             //   $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
            //}

       // redirect('members');
echo "Done";
      /*  $this->load->helper(array('form'));
        $data['response'] = 3;
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Import Customers';

        $this->load->view('fixed/header', $head);


        $config['upload_path'] = FCPATH . '/userfiles';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = 60000;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('userfile')) {
            $data['response'] = 0;
            $data['responsetext'] = 'File Upload Error';

        } else {
            $data['response'] = 1;
            $data['responsetext'] = 'Document Uploaded Successfully.';
            $data['filename'] = $this->upload->data()['file_name'];
            $data['password_s'] = $this->input->post('c_password');
            $data['password_v'] = $this->input->post('c_password_static');

        }

        $this->load->view('import/wizard2', $data);

        $this->load->view('fixed/footer');
*/
    }
    /*
        * Callback function to check file value and type during validation
        */
    public function file_check($str){
        $allowed_mime_types = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != ""){
            $mime = get_mime_by_extension($_FILES['file']['name']);
            $fileAr = explode('.', $_FILES['file']['name']);
            $ext = end($fileAr);
            if(($ext == 'csv') && in_array($mime, $allowed_mime_types)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Please select only CSV file to upload.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check', 'Please select a CSV file to upload.');
            return false;
        }
    }


    public function customers_start_process()
    {
        require APPPATH . 'third_party/vendor/autoload.php';

        $name = $this->input->post('name');
        $c_pass = $this->input->post('c_pass');
        $c_pass_v = $this->input->post('c_pass_v');

        $inputFileName = FCPATH . 'userfiles/' . $name;

        $spreadsheet = IOFactory::load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);
//print_r($sheetData);

        $data = array();
        $data2 = array();

        $this->db->select('id');
        $this->db->from('geopos_customers');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $l_id = +$query->row()->id + 1;
        } else {
            $l_id = 1;
        }

        foreach ($sheetData as $row) {


            $data[] = array(
                'id' => $l_id,
                'name' => $row[0],
                'phone' => $row[1],
                'address' => $row[2],
                'city' => $row[3],
                'region' => $row[4],
                'country' => $row[5],
                'postbox' => $row[6],
                'email' => $row[7],
                'gid' => $row[8],
                'taxid' => $row[9],
                'company' => $row[10],
                'name_s' => $row[11],
                'phone_s' => $row[12],
                'email_s' => $row[13],
                'address_s' => $row[14],
                'city_s' => $row[15],
                'region_s' => $row[16],
                'country_s' => $row[17],
                'postbox_s' => $row[18]
            );

            if ($c_pass == 'random') {
                $temp_password = rand(200000, 999999);
                $pass = password_hash($temp_password, PASSWORD_DEFAULT);
            } else {
                $pass = password_hash($c_pass_v, PASSWORD_DEFAULT);
            }

            $data2[] = array(
                'users_id' => null,
                'user_id' => 1,
                'status' => 'active',
                'is_deleted' => 0,
                'name' => $row[0],
                'password' => $pass,
                'email' => $row[7],
                'profile_pic' => $row[5],
                'user_type' => 'Member',
                'cid' => $l_id
            );
            $l_id++;


        }
        // unlink(FCPATH . 'userfiles/' . $name);
        if (count($sheetData[0]) == 19) {
            $out = $this->db->insert_batch('geopos_customers', $data);
            $out = $this->db->insert_batch('users', $data2);
            if ($out) {
                echo json_encode(array('status' => 'Success', 'message' =>
                    "Customer Data Imported Successfully!"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Database Import Error! Please use proper encoding of file and its content."));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please correct the format of CSV file, it should be as per template."));
        }


    }


}