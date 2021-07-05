<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <div class="card-body">
        <h5 class="title">Services<a
                href="<?php echo base_url('services/add') ?>"
                class="btn btn-primary btn-sm rounded">
                <?php echo $this->lang->line('Add new') ?>
            </a></h5>

        <hr>
        <table id="catgtable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th><?php echo $this->lang->line('Name') ?></th>
                <th>Time(Min)</th>
                <th>Price(Toman)</th>
                <th><?php echo $this->lang->line('Action') ?></th>


            </tr>
            </thead>
            <tbody>
            <?php $i = 1;
            foreach ($services as $row) {
               $cid = $row->id;
                $title = $row->name;
                $settime= $row->settime;
                echo "<tr>
                    <td>$i</td>
                    <td><b>$title</b></td>
                  <td>$settime</td>
                  <td>ندارد</td>
                    <td><a href='" . base_url("services/edit?id=$cid") . "' class='btn btn-cyan btn-xs'><i class='icon-pencil'></i>" . $this->lang->line('Edit') . "</a>
                    <a href='" . base_url("services/delete?id=$cid") . "' class='btn btn-danger btn-xs'><i class='icon-delete'></i>" . $this->lang->line('Delete') . "</a>
                    <a href='" . base_url("services/addsub?id=$cid") . "' class='btn btn-cyan btn-xs'><i class='icon-plus'></i>Add Sub</a></td></tr>";

                foreach ($row->sub as $rowx) {
                    $cidx = $rowx->id;
                    $titlex = $rowx->name;
                    $settimex= $rowx->settime;
                    $price= $rowx->price;
                    echo "<tr>
                    <td>$i</td>
                    <td style='padding-left: 50px'> $titlex</td>
                  <td>$settimex</td>
                      <td>$price</td>
                    <td><a href='" . base_url("services/edit?id=$cidx") . "' class='btn btn-cyan btn-xs'><i class='icon-pencil'></i>" . $this->lang->line('Edit') . "</a>
                    <a href='" . base_url("services/delete?id=$cidx") . "' class='btn btn-danger btn-xs'><i class='icon-delete'></i>" . $this->lang->line('Delete') . "</a></td></tr>";
                }
                $i++;
              //  print_r($row->name);
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <th>#</th>
                <th><?php echo $this->lang->line('Name') ?></th>
                <th>Time(Min)</th>
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
