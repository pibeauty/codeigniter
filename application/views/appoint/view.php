<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h5>event View</h5>
            <hr>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>

        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card-body">
            <form method="post" id="data_form" class="form-horizontal" >

                <div class="form-group row" style="display: none">
                    <label>نحوه پرداخت</label>
                    <?php
                    $how_pay=1;
                    $factor_code="";
                    foreach($event as $item){ $how_pay=$item['how_pay'];$factor_code=$item['description']; } ?>

<input type="hidden" value="<?php echo $factor_code; ?>" name="factor_code">

                    <select name="how_pay" class="form-control col-md-12">

                        <option value="1" <?php  if($how_pay==1) {echo "selected"; } ?> >حساب 1</option>
                        <option value="2" <?php  if($how_pay==2) {echo "selected"; } ?> >حساب 2</option>
                        <option value="3" <?php  if($how_pay==3) {echo "selected"; } ?> >نقدی</option>
                        <option value="4" <?php  if($how_pay==4) {echo "selected"; } ?> >کارت به کارت</option>
                    </select>
                </div>

                <div class="form-group row">
                    <input type="submit" id="submit-data" class="btn btn-lg btn-blue margin-bottom"
                           value="Submit" data-loading-text="Adding...">
                    <input type="hidden" value="appoint/updateFactor" id="action-url">
                </div>
                <hr/>

                <div class="form-group row">
                    <?php foreach($event as $item){ ?>
                    <div class="col-sm-12" style="border: 1px solid grey;margin: 5px;border-radius: 5px">
                        <?php     echo 'سالن کار:'.$item['username']."<br/>"; ?>
                        <?php     echo 'سرویس:'.$item['service_name']."<br/>"; ?>
                        <?php
                        $time = strtotime($item['start'].'+ 0 minutes');
                        echo 'شروع:'.$this->jdf->jdate('l, j F',$time).'|'.date('H:i', strtotime($item['start']))."<br/>"; ?>
                        <?php
                        $timeend = strtotime($item['end'].'+ 0 minutes');
                        echo 'پایان:'.$this->jdf->jdate('l, j F',$timeend).'|'.date('H:i', strtotime($item['end']))."<br/>"; ?>

                    </div>
<?php } ?>
            </form>




        </div>
    </div>
</div>
