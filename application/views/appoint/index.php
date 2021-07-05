<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <div class="card-body">


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
                $factor_code= $row['description'];
                $cus_mobile= $row['cus_mobile'];
                $time = strtotime($row['start'].'+ 210 minutes');
                $timeEnd = strtotime($row['end'].'+ 210 minutes');
                $start= $this->jdf->jdate('l, j F',$time);
                $end= $this->jdf->jdate('l, j F',$timeEnd);
                echo "<tr>
                    <td>$i</td>
                    <td><b>$cus_name</b></td>
                  <td>$cus_mobile</td>
                  <td>$start</td>
                  <td>$end</td>
                    <td><a href='" . base_url("appoint/view?factor_code=$factor_code") . "' class='btn btn-cyan btn-xs'><i class='icon-pencil'></i>view</a>
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
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#catgtable').DataTable({responsive: true});

    });
</script>
