<?php
$due = false;
if ($this->input->get('due')) {
    $due = true;
} ?>
<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                <?php echo $this->lang->line('Clients Points') ?>
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
                        <th><?php echo $this->lang->line('Nail Points') ?></th>
                        <th><?php echo $this->lang->line('Hair Points') ?></th>
                        <th><?php echo $this->lang->line('Eyebrow Points') ?></th>
                        <th><?php echo $this->lang->line('Eyelash Points') ?></th>
                        <th><?php echo $this->lang->line('Skin Points') ?></th>
                        <th><?php echo $this->lang->line('Make-up Points') ?></th>
                        <th><?php echo $this->lang->line('Reference Points') ?></th>
                        <th><?php echo $this->lang->line('Expense Points') ?></th>
                        <th><?php echo $this->lang->line('Total Points') ?></th>
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
                        <th><?php echo $this->lang->line('Nail Points') ?></th>
                        <th><?php echo $this->lang->line('Hair Points') ?></th>
                        <th><?php echo $this->lang->line('Eyebrow Points') ?></th>
                        <th><?php echo $this->lang->line('Eyelash Points') ?></th>
                        <th><?php echo $this->lang->line('Skin Points') ?></th>
                        <th><?php echo $this->lang->line('Make-up Points') ?></th>
                        <th><?php echo $this->lang->line('Reference Points') ?></th>
                        <th><?php echo $this->lang->line('Expense Points') ?></th>
                        <th><?php echo $this->lang->line('Total Points') ?></th>
                        <th><?php echo $this->lang->line('Settings') ?></th>
                    </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#clientstable').DataTable({
            'processing': true,
            'serverSide': false,
            // 'serverSide': true,
            'stateSave': true,
            responsive: true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('customers/load_points_list')?>",
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
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    }
                }
            ],
        });
    });
</script>

<script>
    $(function () {
        $('.select-box').select2();
    });
</script>