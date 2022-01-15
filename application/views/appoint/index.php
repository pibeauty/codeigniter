<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-md-2"><?php echo $this->lang->line('Invoice Date') ?></div>
            <div class="col-md-2">
                <?php echo $this->lang->line('From') ?>
                <input type="text" name="start_date" id="start_date"
                    class="date30 form-control form-control-sm" autocomplete="off"/>
            </div>
            <div class="col-md-2">
                <?php echo $this->lang->line('To') ?>
                <input type="text" name="end_date" id="end_date" class="form-control form-control-sm"
                    data-toggle="datepicker" autocomplete="off"/>
            </div>
            <div class="col-sm-2">
                <?php echo $this->lang->line('Service') ?>
                <select name="services" id="services" class="form-control form-control-sm">
                    <?php
                    $serviceId = $_GET['serviceId'];
                    foreach ($services as $service) {
                        $id = $service['id'];
                        $name = $service['name'];
                        $selected = '';
                        if ($service['id'] == $serviceId)
                            $selected = 'selected';
                        echo "<option value='$id' $selected>$name</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2">
                <input type="button" name="search" id="search" value="Search" class="btn btn-info btn-sm"/>
            </div>
            <div class="col-md-2">
                <input type="checkbox" id="onlinePayedFilter" name="onlinePayed" value="online payed" />
                <lable for="onlinePayed">only show online payed appointments</lable>
            </div>
        </div>

        <hr>
        <table id="catgtable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>customer name</th>
                <th>customer mobile</th>
                <th>start time</th>
                <th>end time</th>
                <th><?php echo $this->lang->line('Action') ?></th>


            </tr>
            </thead>
            <tbody>
            <?php $i = 1;
            foreach ($events as $row) {
                $cid = $row['id'];
                $cus_name = $row['cus_name'];
                // $factor_code= $row['description'];
                $factor_code= $row['factor_code'];
                $cus_mobile= $row['cus_mobile'];
                $time = strtotime($row['start'].'+ 210 minutes');
                $timeEnd = strtotime($row['end'].'+ 210 minutes');
                $start= $this->jdf->jdate('l, j F',$time);
                $end= $this->jdf->jdate('l, j F',$timeEnd);
                $onlinePayed = $row['onlinePayed'] ? 1 : 0;
                echo "<tr data-onlinepayed = $onlinePayed>
                    <td>$i<i style='display: none' data-onlinepayed=$onlinePayed></i></td>
                    <td><b>$cus_name</b></td>
                  <td>$cus_mobile</td>
                  <td>$start</td>
                  <td>$end</td>
                    <td><a href='" . base_url("appoint/view?id=$cid") . "' class='btn btn-cyan btn-xs'><i class='icon-pencil'></i>view</a>
                  </td></tr>";
                $i++;
                //  print_r($row);
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <th>#</th>
                <th>customer name</th>
                <th>customer mobile</th>
                <th>start time</th>
                <th>end time</th>
                <th><?php echo $this->lang->line('Action') ?></th>

            </tr>
            </tfoot>
        </table>
        <input type="hidden" id="site_url" value="<?php echo site_url(); ?>">
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        /* Custom filtering function which will search data in column four between two values */
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex, rawData ) {
                const pattern = /data-onlinepayed="(\d{1})"/
                result = rawData[0].match(pattern);
                const isFilterChecked = $('#onlinePayedFilter').is(':checked')
                if (isFilterChecked) return result[1] == 1;
                else return true;
            }
        );
        //datatables
        var table = $('#catgtable').DataTable({
            responsive: true,
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5]
                    }
                }
            ],
        });

        $('#search').click(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var serviceId = $('#services').val();
            if (start_date != '' && end_date != '') {
                window.location.href=$('#site_url').val()+"appoint/?id=0&cusUser=0&start_date="+start_date+"&end_date="+end_date+"&serviceId="+serviceId;
            } else {
                alert("Date range is Required");
            }
        });

        // Event listener to filtering inputs to redraw on input
        $('#onlinePayedFilter').click( function() {
            table.draw();
        } );

    });
</script>
