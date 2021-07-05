<?php
foreach ($result as $itemx){
    ?>
    <div class="form-group col-md-4 boxed">

        <div class="">
            <input type="radio"  name="data" value=" <?php echo htmlspecialchars(json_encode($itemx)); ?>">
            <label >
                <?php
                $i=0;
                foreach ($itemx as $item){
                    //print_r($item['service_name']);
                    $time = strtotime($item['date_fromSET']);
                    $date_fromSET = date('H:i',$time);
                    //echo $newformat;
                    $time2 = strtotime($item['date_toSET']);
                    $date_toSET = date('H:i',$time2);

                    $time3 = strtotime($item['date_toSET']);
                    $dat = date('d',$time3);
                    if($i==0){
                        // echo " رزرو در روز: ".$dat." ماه <br/>";
                        $i++;
                    }
                    print_r($item['service_name']." از: ".$date_fromSET." تا: ".$date_toSET) ;echo "<br/>";

                }

                ?>
            </label></div>
    </div>
    <?php
}
?>