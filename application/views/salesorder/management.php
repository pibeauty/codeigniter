<div class="content-body">
    <div class="card">
        <div class="card-header">
            <?php //var_dump($products);

            foreach ($products as $product) {
                $pr_code = $product['VPC'];
                $pr = $this->prodmod->get_product_by_code($pr_code);
                echo $pr['product_name'] . "<br>";
            }

            ?>
            <h5 class="title"> Sales Order Management <a
<!--                        href="--><?php //echo base_url('productcategory/add') ?><!--"-->
<!--                        class="btn btn-primary btn-sm rounded">-->
<!--                    --><?php //echo $this->lang->line('Add new') . ' ' . $this->lang->line('Category') ?>
<!--                </a> <a-->
<!--                        href="--><?php //echo base_url('productcategory/add_sub') ?><!--"-->
<!--                        class="btn btn-blue btn-sm rounded">-->
<!--                    --><?php //echo $this->lang->line('Add new') . ' - ' . $this->lang->line('Sub') . ' ' . $this->lang->line('Category') ?>
<!--                </a>-->
            </h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">

                <table id="catgtable" class="table table-striped table-bordered zero-configuration">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th> ID </th>
                        <th> Date </th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th> Products </th>
                        <th> Quantities </th>
                        <th> Status </th>
                        <th><?php echo $this->lang->line('Action') ?></th>


                    </tr>
                    </thead>
                    <tbody><pre>
                    <?php $i = 1;
                    foreach ($sales as $row) {
                        $products = unserialize($row['products_n_qty']);
                        $buyer = unserialize($row['buyer']);
                        $buyer = json_decode($buyer, true);
                        $cid = $row['id'];
                        $title = $row['title'];
                        $total = $row['pc'];

                        $qty = +$row['qty'];
//                        echo "<tr>
//                    <td>$i</td>
//                    <td>
//                    <a href='" . base_url("productcategory/view?id=$cid") . "' >$title</a>
//                    </td>
//                    <td>$total</td>
//                    <td>$qty</td>
//                    <td>$salessum/$worthsum</td>
//                    <td><a href='" . base_url("productcategory/view?id=$cid") . "' class='btn btn-success btn-sm'><i class='fa fa-eye'></i> " . $this->lang->line('View') . "</a>&nbsp; <a class='btn btn-blue  btn-sm' href='" . base_url() . "productcategory/report_product?id=" . $cid . "' target='_blank'> <span class='fa fa-pie-chart'></span>" . $this->lang->line('Sales') . "</a>&nbsp;  <a href='" . base_url("productcategory/edit?id=$cid") . "' class='btn btn-warning btn-sm'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') . "</a>&nbsp;<a href='#' data-object-id='" . $cid . "' class='btn btn-danger btn-sm delete-object' title='Delete'><i class='fa fa-trash'></i></a></td></tr>";


                        ?><tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['external_number']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td>
                    <a href="<?php //echo base_url("productcategory/view?id=".$cid); ?>"><?php echo $buyer['name']; ?></a>
                    </td>
                    <td>
                        <?php foreach ($products as $product){
                            $pr_code = $product['VPC'];
//                            var_dump($pr_code);
//                            var_dump($this->prodmod);
                            try {
                                $pr = $this->salesorder->get_product_by_code($pr_code);
//                                var_dump($pr);
                                echo "<p>".$pr['product_name'] . "</p>";
                            } catch (Exception $e){
                                echo $e -> getMessage();
                            }
                        }

                    //$total
                    ?></td>
                    <td>
                        <?php foreach ($products as $product){
                            echo "<p class='qty'>".$product['qty']."</p>";
//                            var_dump($product['qty']);
                        }
                        //$qty
                    ?>
                    </td>
                    <td id="status_<?php echo $cid; ?>">
                        <?php
                        $status = $row['status'];
                        switch ($status){
                            case 1:
                                echo 'Requested';
                                break;
                            case 2:
                                echo 'Confirmed';
                                break;
                            case 3:
                                echo 'Shipped';
                                break;
                            case 4:
                                echo 'Delivered';
                                break;
                            case 5:
                                echo 'Changed Quantity';
                                break;
	                        case 6:
	                        	echo 'Cancelled';
	                        	break;
                            case 0:
                                echo 'Denied';
                                break;
                            default:
                                echo 'No Status';
                        }
                        ?>
                    </td>
                        <?php
                        if ($status == 1 || $status == 5){
                            echo
                            "<td>
                        <a href='#' data-object-id='" . $cid . "' id='sale-order-change-qty' class='btn btn-success btn-sm' style='background-color: #0d6aad !important;'>Change Quantity</a>
                        <a href='#' data-object-id='" . $cid . "' id='sale-order-accept' class='btn btn-success btn-sm'>Accept</a>&nbsp;
                        <a href='#' data-object-id='" . $cid . "' id='sale-order-reject' class='btn btn-danger btn-sm' title='Reject'>Reject
                        </a>
                    </td>
                        </tr>";
                        }
                        else
                        {
                            echo
                            "<td>
                            <a href='#' data-object-id='" . $cid . "' id='sale-order-delete' class='btn btn-danger btn-sm' style='background-color: #ff0000 !important;' title='Delete'>Delete
                        </a>
                    </td>
                        </tr>";
                        }



                        $i++;
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th> ID </th>
                        <th> Date </th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th> Products </th>
                        <th> Quantities </th>
                        <th> Status </th>
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            //datatables
            $('#catgtable').DataTable({
                responsive: true, dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    }
                ],
            });

        });


    </script>
    <div id="delete_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p><?php echo $this->lang->line('delete this product category') ?></strong></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id" value="">
                    <input type="hidden" id="action-url" value="productcategory/delete_i">
                    <button type="button" data-dismiss="modal" class="btn btn-primary"
                            id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                    <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                </div>
            </div>
        </div>
    </div>