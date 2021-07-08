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

class User_reserve extends CI_Controller
{

   /* public function view() {
        if ( ! file_exists(APPPATH.'/views/pages/about_us.php')) {
            //Whoops, we don't have a page for that!
            show_404();
        }
        $data['title'] = ucfirst('about us');
    $this->load->view('pages/about_us.php', $data);
  }*/
    public function __construct()
    {
        parent::__construct();

        $this->load->model('services_model', 'services');
        $this->load->model('employee_model', 'employee');
        $this->load->model('Events_model', 'events');
        // Session
        $this->load->library('session');
        $this->load->library('jdf');
    }


    public function index()
    {
       /// $data['services'] = $this->services->serviceslist();
        $data['services'] = $this->services->getServices();

        $this->load->view('user_reserve/index',$data);

    }
    public function reserve5(){
        $services= $this->input->post('services');
        print_r($services);
        log_message('error',"------------------------------------ghjghacascsascj:". $services);
    }
    public function reserve(){
        date_default_timezone_set('Asia/Tehran');
        $services= $this->input->post('services');
        $name= $this->input->post('name');
        $mobile= $this->input->post('mobile');
        $setdateU= $this->input->post('setdateU');
        $WeekNum= $this->input->post('WeekNum');

        $day_from=10;$day_to=20;
        $date = date('Y-m-d H:i:s', substr($setdateU, 0, -3));
        // MO set date_from hour to ten oclock (starting hour of working day)
        $date_from=date('Y-m-d H:i:s', strtotime($date. ' + '.$day_from.' hours'));
        // MO set date_to hour to 20 oclock (ending hour of working day)
        $date_to=date('Y-m-d H:i:s', strtotime($date. ' + '.$day_to.' hours'));


        $firstArr=[];
        $chkEmployeeInArr=[];
        for ($i=0;$i<count($services);$i++) {
            //برای همه سرویس های انتخابی تمام افرادی که اون سرویس رو ارائه میدن میده
            $ems = $this->employee->list_employee_by_service($services[$i]);
            $service_details = $this->services->details($services[$i]);
            for ($ii=0;$ii<count($ems);$ii++) {
                //گرفتن آخرین تایم رزرو شده هر کاربر
                //فقط یک بار.و افزودن آن به زمان شروع رزرو برای دیگر تایم ها
                $events  = $this->events-> getEventsByEmployeeId($date_from,$date_to,$ems[$ii]["id"]);
                $getEvent = null;
                $em_date_from = $date_from;
                $em_date_to = $date_to;
                if($events && !in_array($ems[$ii]["id"], $chkEmployeeInArr)){
                    $getEvent=$events[0];
                    $em_date_from=$events[0]->end;
                    // MO inja moshkel darad zaheran
                    $em_date_to=$events[0]->end;
                    array_push($chkEmployeeInArr,$ems[$ii]["id"]);
                }
                $ems[$ii]['service_name']=$service_details['name'];
                $ems[$ii]['service_id']=$service_details['id'];
                $ems[$ii]['service_settime']=$service_details['settime'];
                $ems[$ii]['price']=$service_details['price'];
                $ems[$ii]['start']=$em_date_from;
                $ems[$ii]['end']=$em_date_to;
                $ems[$ii]['events']=$events;
                //لیست تمام افرادی که در هر یک از سرویس های خواسته شده مشتری کار میکنه
                // MO $firstArr arrayeyi az hame karmandani hast ke service haye darkhasty moshtary ra anjam midahand, har khane araye shamele etelaate karmand, etelaate service va tarikhe shoro va payane service mibashad
                array_push($firstArr,$ems[$ii]);
            }
          //  print_r($ems);echo "<br/>"."<br/>"."<br/>";
            //print_r($chkEmployeeInArr);echo "<br/>"."<br/>"."<br/>";

        }
        for ($x=0;$x<count($firstArr);$x++) {
            //لیست تمام افرادی که در هر یک از سرویس های خواسته شده مشتری کار میکنه
            //print_r($firstArr[$x]);echo "<br/>"."<br/>"."<br/>";
        }

       // echo "---------------------------------------------------------------------------------------";
      //  echo "<br/>"."<br/>"."<br/>";
        $chkServiceTimeArr=[];
        $result=[];
        for ($n=0;$n<count($services);$n++) {
          //  print_r( $services[$n]);echo "<br/>"."<br/>"."<br/>";
            for ($z=0;$z<count($firstArr);$z++) {
                if($firstArr[$z]['service_id']==$services[$n] && !in_array($services[$n], $chkServiceTimeArr)){
                    //لیست همه امپلویی هایی که این سرویس رو ارائه میدن و آلان تایم خالی دارن
                  //  print_r($firstArr[$z]);echo "<br/>"."<br/>"."<br/>";
                    // MO $result arayeyi az karmandani hast ke baraye har service entekhab shodan, dar asl bargozidegane araye $firstArr mibashand
                    array_push($result,$firstArr[$z]);
                    array_push($chkServiceTimeArr,$services[$n]);
                }
            }
        }
        $mainTime=$date_from;//$date_toSET=$date_from;
        $finalManyResult=[];
        $finalArr=[];$finalArr2=[];$CHKdate_toSET=$date_to;

        do {

            $finalArrx=[];
            for ($m=0;$m<count($result);$m++) {
                /*  if($result[0]['start']>$date_from){
                    $mainTime=$result[0]['start'];
                }
                else{
                    $mainTime=$date_from;
                }*/
                //افزودن زمان این سرویس به زمان شروع رزرو
                // $mainTime=date('Y-m-d H:i:s', strtotime($mainTime. ' + '.$result[$m]['service_settime'].' minutes'));
                $date_fromSET=date('Y-m-d H:i:s', strtotime($mainTime));
                $date_toSET=date('Y-m-d H:i:s', strtotime($mainTime. ' + '.$result[$m]['service_settime'].' minutes'));
                $mainTime=date('Y-m-d H:i:s', strtotime($date_toSET));
                $result[$m]['date_fromSET']=$date_fromSET;
                $result[$m]['date_toSET']=$date_toSET;
                    $CHKdate_toSET=$date_toSET;
                if ($CHKdate_toSET > $date_to)
                    break;
                array_push($finalArr,$result[$m]);
                if (isset($result[$m]['events']))
                {
                    $timeIsReserved = false;
                    foreach($result[$m]['events'] as $event)
                    {
                        // MO Check if start or end time of the service is between start and end time of the event
                        if  ((
                            (($result[$m]['date_fromSET'] >= $event->start) && ($result[$m]['date_fromSET'] < $event->end))
                            ||
                            (($result[$m]['date_toSET'] > $event->start) && ($result[$m]['date_toSET'] <= $event->end))
                        ) )
                            $timeIsReserved = true;
                    }
                    if ($timeIsReserved == false)
                    {
                        array_push($finalArrx,$result[$m]);
                        array_push($finalManyResult,$finalArrx);
                    }
                }
                else
                {
                    array_push($finalArrx,$result[$m]);
                    array_push($finalManyResult,$finalArrx);
                }
                
                // print_r($date_to>$date_toSET);echo "<br/>"."<br/>"."<br/>";
                //print_r($finalArr);echo "<br/>"."<br/>"."<br/>";
            }

        }while ($CHKdate_toSET < $date_to);//befor 20


        ////////////////////////////////////////////////////////////////////////
        for ($m=0;$m<count($result);$m++) {
            /*  if($result[0]['start']>$date_from){
                   $mainTime=$result[0]['start'];
               }
               else{
                   $mainTime=$date_from;
               }*/
            //افزودن زمان این سرویس به زمان شروع رزرو
            // $mainTime=date('Y-m-d H:i:s', strtotime($mainTime. ' + '.$result[$m]['service_settime'].' minutes'));
            $date_fromSET=date('Y-m-d H:i:s', strtotime($mainTime));
            $date_toSET=date('Y-m-d H:i:s', strtotime($mainTime. ' + '.$result[$m]['service_settime'].' minutes'));
            $mainTime=date('Y-m-d H:i:s', strtotime($date_toSET));
            $result[$m]['date_fromSET']=$date_fromSET;
            $result[$m]['date_toSET']=$date_toSET;
            array_push($finalArr2,$result[$m]);
            //print_r($mainTime);echo "<br/>"."<br/>"."<br/>";
            //print_r($result[$m]);echo "<br/>"."<br/>"."<br/>";
        }
        /// /////////////////////////////////////////////////////////////////////

        // $date_fromx=date('Y-m-d H:i:s', strtotime($date));
        //گرفتن آخرین تایم کاری هر امپلویی
        // $events  = $this->events-> getEventsByEmployeeId($date_from,$date_to,28);
        //لیست تمام رزرو های این روز خاص
        //$events  = $this->events->getEvents($date_from,$date_to);
        /*  for ($i=0;$i<count($events);$i++) {

           // print_r($events[$i]);echo "<br/>"."<br/>"."<br/>";

        }*/
        foreach ($finalManyResult as $ii){
          //  print_r($ii);echo "<br/>"."<br/>"."<br/>"."<br/>"."<br/>"."<br/>";
        }

        $data['resultjson']=json_encode($finalArr);
        $data['resultjson2']=json_encode($finalArr2);
        $data['result']= $finalManyResult;
        $data['result2']=$finalArr2;
            $data['name']=$name;
        $data['services']=$services;
        $data['mobile']=$mobile;//log_message('error',"------------------------------------ghjghacascsascj:". stripslashes(json_encode($finalArr)));
        //log_message('error',"ghjghacascsascj:". $name.'///'.$mobile.'////'.$setdateU.'////'.$WeekNum);
        $this->load->view('user_reserve/response',$data);
    }
    /*
     * Array ( [0] => Array ( [id] => 28 [username] => nakhonkar [name] => nakhonkar [address] => nakhonkar [city] => nakhonkar [region] => nakhonkar [country] => nakhonkar [postbox] => nakhonkar [phone] => nakhonkar [phonealt] => [picture] => example.png [sign] => sign.png [joindate] => 2021-04-12 18:08:41 [dept] => 0 [degis] => [salary] => 0.00 [clock] => [clockin] => [clockout] => [c_rate] => 0.00 [service] => 2.3,4,5,6 [sat_from] => 10 [sat_to] => 20 [sun_from] => 10 [sun_to] => 20 [mon_from] => 10 [mon_to] => 20 [tue_from] => 10 [tue_to] => 20 [wen_from] => 10 [wen_to] => 20 [the_from] => 10 [the_to] => 20 [fri_from] => 10 [fri_to] => 20 [service_name] => ناخن کاری [service_id] => 2 [service_settime] => 20 [start] => 2021-04-12 11:00:00 [end] => 2021-04-12 11:00:00 [events] => stdClass Object ( [id] => 14 [title] => sdvsdvsv6 [description] => sdvsdv [color] => #3a87ad [start] => 2021-04-12 10:40:00 [end] => 2021-04-12 11:00:00 [allDay] => true [rel] => 0 [rid] => 0 [userid] => 28 [customerid] => 6 [cus_name] => ytyutu [cus_mobile] => 67878678 [day_name] => شنبه [service_id] => 2 [service_name] => ناخن کاری ) [date_fromSET] => 2021-04-12 10:00:00 [date_toSET] => 2021-04-12 10:20:00 ) [1] => Array ( [id] => 28 [username] => nakhonkar [name] => nakhonkar [address] => nakhonkar [city] => nakhonkar [region] => nakhonkar [country] => nakhonkar [postbox] => nakhonkar [phone] => nakhonkar [phonealt] => [picture] => example.png [sign] => sign.png [joindate] => 2021-04-12 18:08:41 [dept] => 0 [degis] => [salary] => 0.00 [clock] => [clockin] => [clockout] => [c_rate] => 0.00 [service] => 2.3,4,5,6 [sat_from] => 10 [sat_to] => 20 [sun_from] => 10 [sun_to] => 20 [mon_from] => 10 [mon_to] => 20 [tue_from] => 10 [tue_to] => 20 [wen_from] => 10 [wen_to] => 20 [the_from] => 10 [the_to] => 20 [fri_from] => 10 [fri_to] => 20 [service_name] => رنگ مو [service_id] => 3 [service_settime] => 60 [start] => 2021-04-12 10:00:00 [end] => 2021-04-12 20:00:00 [events] => [date_fromSET] => 2021-04-12 10:20:00 [date_toSET] => 2021-04-12 11:20:00 ) [2] => Array ( [id] => 28 [username] => nakhonkar [name] => nakhonkar [address] => nakhonkar [city] => nakhonkar [region] => nakhonkar [country] => nakhonkar [postbox] => nakhonkar [phone] => nakhonkar [phonealt] => [picture] => example.png [sign] => sign.png [joindate] => 2021-04-12 18:08:41 [dept] => 0 [degis] => [salary] => 0.00 [clock] => [clockin] => [clockout] => [c_rate] => 0.00 [service] => 2.3,4,5,6 [sat_from] => 10 [sat_to] => 20 [sun_from] => 10 [sun_to] => 20 [mon_from] => 10 [mon_to] => 20 [tue_from] => 10 [tue_to] => 20 [wen_from] => 10 [wen_to] => 20 [the_from] => 10 [the_to] => 20 [fri_from] => 10 [fri_to] => 20 [service_name] => کاشت مژه [service_id] => 6 [service_settime] => 50 [start] => 2021-04-12 10:00:00 [end] => 2021-04-12 20:00:00 [events] => [date_fromSET] => 2021-04-12 11:20:00 [date_toSET] => 2021-04-12 12:10:00 ) )
     */
    public function reservex(){
        date_default_timezone_set('Asia/Tehran');
        $services= $this->input->post('services');
        $name= $this->input->post('name');
        $mobile= $this->input->post('mobile');
        $setdateU= $this->input->post('setdateU');
        $WeekNum= $this->input->post('WeekNum');
        $result="";$allServiceTime=0;$arr_ems=[];


        for ($i=0;$i<count($services);$i++){
            $ems= $this->employee->list_employee_by_service($services[$i]);
            $service_details = $this->services->details($services[$i]);
           //
            if($ems){
                $allServiceTime=$allServiceTime+$service_details['settime'];
                //$dd['service_duration']=$service_details['settime'];
                //array_push($ems,$dd);
                array_push($arr_ems,$ems);//print_r($ems);echo "<br/>"."<br/>"."<br/>";
            }
        }

        $reservedTimes=[];
        for ($i=0;$i<count($arr_ems);$i++) {

            $service_details = $this->services->details($arr_ems[$i]->service);
            //print_r( $service_details['name']);
            $day_from = 10;
            $day_to = 20;
           if ($WeekNum == 1) {
                $day_from = $arr_ems[$i]->sat_from;
                $day_to = $arr_ems[$i]->sat_to;
            } elseif ($WeekNum == 2) {
                $day_from = $arr_ems[$i]->sun_from;
                $day_to = $arr_ems[$i]->sun_to;
            } elseif ($WeekNum == 3) {
                $day_from = $arr_ems[$i]->mon_from;
                $day_to = $arr_ems[$i]->mon_to;
            } elseif ($WeekNum == 4) {
                $day_from = $arr_ems[$i]->tue_from;
                $day_to = $arr_ems[$i]->tue_to;
            } elseif ($WeekNum == 5) {
                $day_from = $arr_ems[$i]->wen_from;
                $day_to = $arr_ems[$i]->wen_to;
            } elseif ($WeekNum == 6) {
                $day_from = $arr_ems[$i]->the_from;
                $day_to = $arr_ems[$i]->the_to;
            } elseif ($WeekNum == 7) {
                $day_from = $arr_ems[$i]->fri_from;
                $day_to = $arr_ems[$i]->fri_to;
            }

           /* $date = date('Y-m-d H:i:s', substr($setdateU, 0, -3));
            $date_from=date('Y-m-d H:i:s', strtotime($date. ' + '.$day_from.' hours'));
            $date_to=date('Y-m-d H:i:s', strtotime($date. ' + '.$day_to.' hours'));

           // $date_fromx=date('Y-m-d H:i:s', strtotime($date));

            $events  = $this->events->getEventsForReserve($date_from,$date_to,$service_details['id']);
            $date_fromx=date('Y-m-d H:i:s', strtotime($date));
            $date_tox=date('Y-m-d H:i:s', strtotime($date));
            if($events){//has event on this day hours
                // print_r( $events[0]->end);echo "<br/>"."<br/>"."<br/>";
                $date_fromx=date('Y-m-d H:i:s', strtotime($events[0]->end));//add working time to the end
                $date_tox=date('Y-m-d H:i:s', strtotime($events[0]->end. ' + '.$service_details['settime'].' minutes'));//add working time to the end
                // print_r( 'no event');echo "<br/>"."<br/>"."<br/>";
                $data['username']=$arr_ems[$i]->username;
                $data['name']=$arr_ems[$i]->name;
                $data['start']=$date_fromx;
                $data['end']=$date_tox;
                $data['service_id']=$service_details['id'];
                $data['service_name']=$service_details['name'];
                array_push($reservedTimes,$data);
            }
            else{
                $date_fromx=date('Y-m-d H:i:s', strtotime($date_fromx ));//add working time to the end
                $date_tox=date('Y-m-d H:i:s', strtotime($date_tox. ' + '.$service_details['settime'].' minutes'));//add working time to the end
                // print_r( 'no event');echo "<br/>"."<br/>"."<br/>";
                $data['username']=$arr_ems[$i]->username;
                $data['name']=$arr_ems[$i]->name;
                $data['start']=$date_fromx;
                $data['end']=$date_tox;
                $data['service_id']=$service_details['id'];
                $data['service_name']=$service_details['name'];
                array_push($reservedTimes,$data);
               // print_r( "no event");echo "<br/>"."<br/>"."<br/>";
            }*/
          //  $day_to=$day_to+$service_details['settime'];
          //  $result=$result.$service_details['name']." از ساعت: ".$day_from." تا: ".$day_to."<br/>";
          //

        }
        $date = date('Y-m-d H:i:s', substr($setdateU, 0, -3));
        $date_from=date('Y-m-d H:i:s', strtotime($date. ' + '.$day_from.' hours'));
        $date_to=date('Y-m-d H:i:s', strtotime($date. ' + '.$day_to.' hours'));
        $date_fromx=date('Y-m-d H:i:s', strtotime($date. ' + '.$day_from.' hours'));
        for ($i=0;$i<count($services);$i++){
            $ems= $this->employee->list_employee_by_service($services[$i]);
            $service_details = $this->services->details($services[$i]);
            //
            if($ems){
                $date_fromx=date('Y-m-d H:i:s', strtotime($date_fromx ));//add working time to the end
                $date_tox=date('Y-m-d H:i:s', strtotime($date_fromx. ' + '.$service_details['settime'].' minutes'));//add working time to the end

                $data['username']=$arr_ems[$i]->username;
                $data['name']=$arr_ems[$i]->name;
                $data['start']=$date_fromx;
                $data['end']=$date_tox;
                $data['service_id']=$service_details['id'];
                $data['service_name']=$service_details['name'];
                array_push($reservedTimes,$data);

            }
        }


        print_r($reservedTimes);echo "<br/>"."<br/>"."<br/>";
        //print_r($result);echo "<br/>";
       /* $arr_ems=[];
        foreach ($services as $item){
        $ems= $this->employee->list_employee_by_service($item);
         $service_details= $this->services->details($item);

        if($ems){
            $dd['service_duration']=$service_details['settime'];
            array_push($ems,$dd);
            array_push($arr_ems,$ems);//print_r($arr_ems);echo "<br/>";
        }

        }

        for ($i=0;$i<count($arr_ems);$i++){
           $x= $arr_ems[$i][1]['service_duration'];
           $day_from=10;$day_to=20;
           if($WeekNum ==1){
               $day_from=$arr_ems[$i][0]['sat_from'];
               $day_to=$arr_ems[$i][0]['sat_to'];
           }
           elseif ($WeekNum==2){
               $day_from=$arr_ems[$i][0]['sun_from'];
               $day_to=$arr_ems[$i][0]['sun_to'];
           }
           elseif ($WeekNum==3){
               $day_from=$arr_ems[$i][0]['mon_from'];
               $day_to=$arr_ems[$i][0]['mon_to'];
           }
           elseif ($WeekNum==4){
               $day_from=$arr_ems[$i][0]['tue_from'];
               $day_to=$arr_ems[$i][0]['tue_to'];
           }
           elseif ($WeekNum==5){
               $day_from=$arr_ems[$i][0]['wen_from'];
               $day_to=$arr_ems[$i][0]['wen_to'];
           }
           elseif ($WeekNum==6){
               $day_from=$arr_ems[$i][0]['the_from'];
               $day_to=$arr_ems[$i][0]['the_to'];
           }
           elseif ($WeekNum==7){
               $day_from=$arr_ems[$i][0]['fri_from'];
               $day_to=$arr_ems[$i][0]['fri_to'];
           }
           // print_r($arr_ems[$i][0]);echo "<br/>";
          //  print_r($x);echo "<br/>";

          //// $date = date('Y-m-d H:i:s', substr($setdateU, 0, -3));
            $date_from=date('Y-m-d H:i:s', strtotime($date. ' + '.$day_from.' hours'));
            $date_to=date('Y-m-d H:i:s', strtotime($date. ' + '.$day_to.' hours'));
           // echo $date_from.'////:'.$date_to;echo "<br/>";
            foreach ($services as $itemz){
                $events  = $this->events->getEventsForReserve($date_from,$date_to,$itemz);
                if($events){//has event on this day hours
                  //  print_r( $events);
                }
                else{

                }
           ////// }

        }*/

       // $events  = $this->events->getEventsForReserve($date);
       // print_r( $events);
       // log_message('error', $date);

        $data['result']=$reservedTimes;
        //log_message('error',"ghjghacascsascj:". $name.'///'.$mobile.'////'.$setdateU.'////'.$WeekNum);
        $this->load->view('user_reserve/response',$data);
    }

    public function reserveSubmit(){
      //  $this->session->set_flashdata('true', 'رزرو انجام شد');
        $dataX = $this->input->post('data');
        $name = $this->input->post('name');
        $mobile = $this->input->post('mobile');

        $data['data']=$dataX;
        $data['name']=$name;
        $data['mobile']=$mobile;
      //  foreach ($dataX as $ii){
           // log_message('error',"------------------------------------ghjghacascsascj1:". $dataX);
       // }

        $this->load->view('user_reserve/gotobank',$data);
       // echo "رزرو انجام شد";
      //  redirect('user_reserve', 'refresh');
       // return redirect()->back()->withInput()->with('error',"رزرو انجام شد");
    }

    public function gotobank(){
        $dataX = $this->input->post('data');
        $name = $this->input->post('name');
        $mobile = $this->input->post('mobile');
        $data['data']=$dataX;
        $data['name']=$name;
        $data['mobile']=$mobile;
        // var_dump($dataX);die;
        $res= $this->events->addReserve($dataX,$name,$mobile);
        //log_message('error',"------------------------------------ghjghacascsascj3:".json_encode($res));

        $this->load->view('user_reserve/responsebank',$data);
        //log_message('error',"------------------------------------ghjghacascsascj2:".json_decode($dataX));
    }

    public function responseBank(){


    }

    public function add(){
        $head['title'] = "Add Service";
        $this->load->view('fixed/header', $head);
        $this->load->view('services/service-add');
        $this->load->view('fixed/footer');
    }
    public function add_new(){
      $name = $this->input->post('name');
        $settime = $this->input->post('settime');
        echo   $this->services->addnew($name,$settime);
    }
    public function edit(){
        $id = $this->input->get('id');
         $data['service'] = $this->services->details($id);
        $head['title'] = "Edit Service";
        $this->load->view('fixed/header', $head);
        $this->load->view('services/service-edit',$data);
        $this->load->view('fixed/footer');
    }
    public function update(){
        $name = $this->input->post('name');
        $settime = $this->input->post('settime');
        $id = $this->input->post('id');
        echo   $this->services->edit($id,$name,$settime);
    }
}