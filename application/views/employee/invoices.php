<style>
    .income * {
        display: inline;
    }
</style>
<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <div class="card-body">
        <h5><?php echo $this->lang->line('Invoices') ?> by <?php echo $employee['name'] ?></h5>
        <div class = "income">
            <h6>Total Income: </h6><p id="totalIncome">0</p><span> RM</span>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-2"><?php echo $this->lang->line('Invoice Date') ?></div>
            <div class="col-md-2">
                <input type="text" name="start_date" id="start_date"
                    class="date30 form-control form-control-sm" autocomplete="off"/>
            </div>
            <div class="col-md-2">
                <input type="text" name="end_date" id="end_date" class="form-control form-control-sm"
                    data-toggle="datepicker" autocomplete="off"/>
            </div>

            <div class="col-md-2">
                <input type="button" name="search" id="search" value="Search" class="btn btn-info btn-sm"/>
            </div>
        </div>
        <hr>
        <table id="invoices" class="table table-striped table-bordered zero-configuration">
            <thead>
            <tr>
                <th>No</th>
                <th><?php echo $this->lang->line('Invoice') ?>#</th>
                <th><?php echo $this->lang->line('Customer') ?></th>
                <th><?php echo $this->lang->line('Date') ?></th>
                <th><?php echo $this->lang->line('Total') ?></th>
                <th><?php echo $this->lang->line('Employees Share') ?></th>
                <!-- <th class="no-sort"><?php //echo $this->lang->line('Status') ?></th> -->
                <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>


            </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th>No</th>
                <th><?php echo $this->lang->line('Invoice') ?>#</th>
                <th><?php echo $this->lang->line('Customer') ?></th>
                <th><?php echo $this->lang->line('Date') ?></th>
                <th><?php echo $this->lang->line('Total') ?></th>
                <th><?php echo $this->lang->line('Employees Share') ?></th>
                <!-- <th class="no-sort"><?php //echo $this->lang->line('Status') ?></th> -->
                <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>

            </tr>
            </tfoot>
        </table>
    </div>
</div>

<div id="delete_invoice" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete Invoice') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('You can not revert') ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal" class="btn">
                    ><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        draw_data();
        
        function draw_data(start_date = '', end_date = '') {
            $('#invoices').DataTable({
                "processing": true,
                // "serverSide": true,
                'stateSave': true,
                responsive: true,
                "order": [],
                "ajax": {
                    "url": "<?php echo site_url('employee/invoices_list')?>",
                    "type": "POST",
                    data: {
                        'eid': '<?php echo $employee['id'] ?>',
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                        start_date: start_date,
                        end_date: end_date
                    }
                },
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[^0-9.]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    // Total over all pages
                    total = api
                        .column( 5 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    // // Total over this page
                    // pageTotal = api
                    //     .column( 5, { page: 'current'} )
                    //     .data()
                    //     .reduce( function (a, b) {
                    //         return intVal(a) + intVal(b);
                    //     }, 0 );
                    // // Update footer
                    // $( api.column( 5 ).footer() ).html(
                    //     pageTotal +' ('+ total +' total)'
                    // );
                    $("#totalIncome").html(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
                },
                "columnDefs": [
                    {
                        "targets": [0],
                        "orderable": false,
                    },
                ],
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
        }

        $('#search').click(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            if (start_date != '' && end_date != '') {
                $('#invoices').DataTable().destroy();
                draw_data(start_date, end_date);
            } else {
                alert("Date range is Required");
            }
        });
    });
</script>