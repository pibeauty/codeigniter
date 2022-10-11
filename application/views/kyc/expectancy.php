<?php
$due = false;
if ($this->input->get('due')) {
    $due = true;
} ?>
<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                <a href="#" class="mr-5">
                    <?php echo $this->lang->line('Expected Clients For') . " ". $this->lang->line(ucfirst($service)) . " " . $this->lang->line('Service')?>
                </a>
                </a>
                <a href="#sendMail" data-toggle="modal" data-remote="false" class="btn btn-primary btn-sm" data-type="reminder">
                    <i class="fa fa-envelope"></i>
                    <?php echo $this->lang->line('Send SMS') ?>
                </a>
            </h4>
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

                <table id="clientstable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Phone') ?></th>
                        <th><?php echo $this->lang->line('Visited At') ?></th>
                        <th><?php echo $this->lang->line('Visited For') ?></th>
                        <th><?php echo $this->lang->line('Settings') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Phone') ?></th>
                        <th><?php echo $this->lang->line('Visited At') ?></th>
                        <th><?php echo $this->lang->line('Visited For') ?></th>
                        <th><?php echo $this->lang->line('Settings') ?></th>
                    </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    let dataTable = null;
    $(document).ready(function () {
        dataTable = $('#clientstable').DataTable({
            'processing': true,
            'serverSide': false,
            // 'serverSide': true,
            'stateSave': true,
            responsive: true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('customers/load_expectancy_list/'.$service)?>",
                'type': 'POST',
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash <?php if ($due) echo ",'due':true" ?> }
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ], dom: 'Blfrtip',
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

    function markAsChecked(invoiceItemId) {
        $.get("<?= site_url('/customers/checkExpectancy/') ?>" + invoiceItemId)
        dataTable.ajax.reload();
    }

    function markAsUnchecked(invoiceItemId) {
        $.get("<?= site_url('/customers/uncheckExpectancy/') ?>" + invoiceItemId)
        dataTable.ajax.reload();
    }
</script>

<div id="sendMail" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">SMS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="sendmail_form"><input type="hidden"
                                                name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                                value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <!-- <div class="row">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-envelope-o"
                                                                     aria-hidden="true"></span></div>
                                <input type="text" class="form-control" placeholder="Mobile" name="mobile"
                                       value="<?php //echo $details['phone'] ?>" readonly>
                            </div>

                        </div>

                    </div> -->


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                                for="name">Customers</label>

                        <div class="col-sm-12">
                            <select name="mobile[]" class="select-box form-control margin-bottom"  multiple="multiple" style="width:100%">
                                <?php
                                foreach ($customers as $row) {
                                    $name = $row->name;
                                    $mobile = $row->phone;
                                    if( isset($mobile) ){
                                        echo ' <option value="' . $mobile . '"> ' . $name . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-envelope-o"
                                                                     aria-hidden="true"></span></div>
                                <input type="checkbox" name="sendToAll" value="1">
                                    <label for="vehicle1">&nbsp;&nbsp;Send SMS to all customers</label>
                                    <span style="color:red">(Caution: Please be careful with this option. A sms will be sent to all of your customers!)</span>
                                    <br>
                            </div>

                        </div>

                    </div>
                    
                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Message') ?></label>
                            <textarea name="text_message" class="form-control" id="contents" title="Contents"></textarea></div>
                    </div>

                    <input type="hidden" class="form-control"
                           id="cid" name="tid" value="<?php echo $details['id'] ?>">
                    <input type="hidden" id="action-url" value="sms/send_sms">


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                <button type="button" class="btn btn-primary"
                        id="sendNow"><?php echo $this->lang->line('Send') ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('.select-box').select2();
    });
</script>