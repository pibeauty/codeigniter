<div class="content-body">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">
				<?php echo $this->lang->line('Customer Details') ?>
				:
				<?php echo $details['name'] ?>
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


				<div class="row">
					<div class="col-md-4 border-right border-right-grey">


						<div class="ibox-content mt-2">
							<img alt="image" id="dpic" class="rounded-circle img-border height-150"
								src="<?php echo base_url('userfiles/customers/') . $details['picture'] ?>">
						</div>
						<hr>


						<div class="row mt-3">
							<div class="col-md-12">
								<a href="<?php echo base_url('customers/view?id=' . $details['id']) ?>"
									class="btn btn-blue btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
										class="fa fa-user"></i>
									<?php echo $this->lang->line('View') ?>
								</a>
								<a href="<?php echo base_url('customers/invoices?id=' . $details['id']) ?>"
									class="btn btn-success btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
										class="fa fa-file-text"></i>
									<?php echo $this->lang->line('View Invoices') ?>
								</a>
								<a href="<?php echo base_url('customers/transactions?id=' . $details['id']) ?>"
									class="btn btn-blue-grey btn-md mr-1 mb-1 btn-block  btn-lighten-1"><i
										class="fa fa-money"></i>
									<?php echo $this->lang->line('View Transactions') ?>
								</a>
								<a href="<?php echo base_url('customers/statement?id=' . $details['id']) ?>"
									class="btn btn-primary btn-block btn-md mr-1 mb-1 btn-lighten-1"><i
										class="fa fa-briefcase"></i>
									<?php echo $this->lang->line('Account Statements') ?>
								</a>
								<a href="<?php echo base_url('customers/quotes?id=' . $details['id']) ?>"
									class="btn btn-purple btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
										class="fa fa-quote-left"></i>
									<?php echo $this->lang->line('Quotes') ?>
								</a> <a href="<?php echo base_url('customers/projects?id=' . $details['id']) ?>"
									class="btn btn-vimeo btn-md mr-1 mb-1 btn-block btn-lighten-2"><i
										class="fa fa-bullhorn"></i>
									<?php echo $this->lang->line('Projects') ?>
								</a>
								<a href="<?php echo base_url('customers/invoices?id=' . $details['id']) ?>&t=sub"
									class="btn btn-flickr btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
										class="fa fa-calendar-check-o"></i>
									<?php echo $this->lang->line('Subscriptions') ?>
								</a>
								<a href="<?php echo base_url('customers/notes?id=' . $details['id']) ?>"
									class="btn btn-github btn-block btn-md mr-1 mb-1 btn-lighten-1"><i
										class="fa fa-book"></i>
									<?php echo $this->lang->line('Notes') ?>
								</a>


								<a href="<?php echo base_url('customers/documents?id=' . $details['id']) ?>"
									class="btn btn-facebook btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
										class="icon-folder"></i>
									<?php echo $this->lang->line('Documents') ?>
								</a>

								<a href="<?php echo base_url('customers/reports?id=' . $details['id']) ?>"
									class="btn btn-red btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
										class="icon-eyeglasses"></i>
									<?php echo $this->lang->line('Report') ?>
								</a>
							</div>
						</div>


					</div>
					<div class="col-md-8">
						<div id="mybutton" class="mb-1">

							<div class="">
								<a href="<?php echo base_url('customers/balance?id=' . $details['id']) ?>"
									class="btn btn-success btn-md"><i class="fa fa-briefcase"></i>
									<?php echo $this->lang->line('Wallet') ?>
								</a>
								<a href="#sendMail" data-toggle="modal" data-remote="false"
									class="btn btn-primary btn-md " data-type="reminder"><i class="fa fa-envelope"></i>
									<?php echo $this->lang->line('Send Message') ?>
								</a>


								<a href="<?php echo base_url('customers/edit?id=' . $details['id']) ?>"
									class="btn btn-info btn-md"><i class="fa fa-pencil"></i>
									<?php echo $this->lang->line('Edit Profile') ?>
								</a>


								<a href="<?php echo base_url('customers/changepassword?id=' . $details['id']) ?>"
									class="btn btn-danger btn-md"><i class="fa fa-key"></i>
									<?php echo $this->lang->line('Change Password') ?>
								</a>
							</div>

						</div>
						<hr>
						<h5 class="mb-2">
							<?= $this->lang->line('Points'); ?>
						</h5>
						<style>.row.reports > .col-md-4 { margin-bottom: 0.5rem; }</style>
						<div class="row reports">
							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-prepend">
										<label class="input-group-text" for="nail_points"><?=$this->lang->line('Nail Points')?></label>
									</div>
									<input class="form-control" type="text" name="nail_points" id="nail_points" readonly value="<?=$points['nail_points']?>">
								</div>
							</div>
							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-prepend">
										<label class="input-group-text" for="hair_points"><?=$this->lang->line('Hair Points')?></label>
									</div>
									<input class="form-control" type="text" name="hair_points" id="hair_points" readonly value="<?=$points['hair_points']?>">
								</div>
							</div>
							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-prepend">
										<label class="input-group-text" for="eyebrow_points"><?=$this->lang->line('Eyebrow Points')?></label>
									</div>
									<input class="form-control" type="text" name="eyebrow_points" id="eyebrow_points" readonly value="<?=$points['eyebrow_points']?>">
								</div>
							</div>
							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-prepend">
										<label class="input-group-text" for="skin_points"><?=$this->lang->line('Skin Points')?></label>
									</div>
									<input class="form-control" type="text" name="skin_points" id="skin_points" readonly value="<?=$points['skin_points']?>">
								</div>
							</div>
							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-prepend">
										<label class="input-group-text" for="makeup_points"><?=$this->lang->line('MakeUp Points')?></label>
									</div>
									<input class="form-control" type="text" name="makeup_points" id="makeup_points" readonly value="<?=$points['makeup_points']?>">
								</div>
							</div>
							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-prepend">
										<label class="input-group-text" for="eyelash_points"><?=$this->lang->line('Eyelash Points')?></label>
									</div>
									<input class="form-control" type="text" name="eyelash_points" id="eyelash_points" readonly value="<?=$points['eyelash_points']?>">
								</div>
							</div>
							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-prepend">
										<label class="input-group-text" for="expense_points"><?=$this->lang->line('Expense Points')?></label>
									</div>
									<input class="form-control" type="text" name="expense_points" id="expense_points" readonly value="<?=$points['expense_points']?>">
								</div>
							</div>
							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-prepend">
										<label class="input-group-text" for="reference_pointts"><?=$this->lang->line('Reference Points')?></label>
									</div>
									<input class="form-control" type="text" name="reference_points" id="reference_points" readonly value="<?=$points['reference_points']?>">
								</div>
							</div>
							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-prepend">
										<label class="input-group-text" for="total_points"><?=$this->lang->line('Total Points')?></label>
									</div>
									<input class="form-control" type="text" name="total_points" id="total_points" readonly value="<?=$points['total_points']?>">
								</div>
							</div>
						</div>
						<hr>
						<h5 class="mb-2">
							<?= $this->lang->line('Report'); ?>
						</h5>
						<div class="row">
							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-prepend">
										<label class="input-group-text" for="total_expences"><?=$this->lang->line('Total Expences')?></label>
									</div>
									<input class="form-control" type="text" name="total_expences" id="total_expences" readonly value="<?=$chart['total_expences']?>">
								</div>
							</div>
							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-prepend">
										<label class="input-group-text" for="total_visits"><?=$this->lang->line('Total Visits')?></label>
									</div>
									<input class="form-control" type="text" name="total_visits" id="total_visits" readonly value="<?=$chart['total_visits']?>">
								</div>
							</div>
							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-prepend">
										<label class="input-group-text" for="total_refrences"><?=$this->lang->line('Total Refrences')?></label>
									</div>
									<input class="form-control" type="text" name="total_refrences" id="total_refrences" readonly value="<?=$chart['total_refrences']?>">
								</div>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<!-- basic buttons -->
							<button type="button" class="update_chart btn btn-primary btn-min-width btn-lg mr-1 mb-1"
								data-val="all"><i class="fa fa-magnet-o"></i>
								<?= $this->lang->line('All') ?>
							</button>
							<button type="button" class="update_chart btn btn-primary btn-min-width btn-lg mr-1 mb-1"
								data-val="week"><i class="fa fa-clock-o"></i>
								<?= $this->lang->line('This') . ' ' . $this->lang->line('Week') ?>
							</button>
							<button type="button" class="update_chart btn btn-secondary btn-min-width  btn-lg mr-1 mb-1"
								data-val="month"><i class="fa fa-calendar"></i>
								<?= $this->lang->line('This') . ' ' . $this->lang->line('Month') ?>
							</button>
							<button type="button" class="update_chart btn btn-success btn-min-width  btn-lg mr-1 mb-1"
								data-val="year"><i class="fa fa-book"></i>
								<?= $this->lang->line('This') . ' ' . $this->lang->line('Year') ?>
							</button>
							<button type="button" class="update_chart btn btn-info btn-min-width  btn-lg mr-1 mb-1"
								data-val="custom"><i class="fa fa-address-book"></i>
								<?= $this->lang->line('Custom Range') . ' ' . $this->lang->line('Date') ?>
							</button>

						</div>
						<form id="chart_custom">
							<div id="custom_c" style="display: none ">
								<div class="row">
									<div class="col-xl-3 col-lg-6 col-md-12 mb-1">
										<fieldset class="form-group">
											<label for="basicInput">
												<?php echo $this->lang->line('From Date') ?>
											</label>
											<input type="text" class="form-control required date30"
												placeholder="Start Date" name="sdate" data-toggle="datepicker"
												autocomplete="false">
										</fieldset>
									</div>
									<div class="col-xl-3 col-lg-6 col-md-12 mb-1">
										<fieldset class="form-group">
											<label for="helpInputTop">
												<?php echo $this->lang->line('To Date') ?>
											</label>
											<input type="text" class="form-control required" placeholder="End Date"
												name="edate" data-toggle="datepicker" autocomplete="false">
										</fieldset>
									</div>
									<div class="col-xl-3 col-lg-6 col-md-12 mb-1"><span class="mt-2"><br></span>
										<fieldset class="form-group">
											<input type="hidden" name="p" value="custom">
											<button type="button" id="custom_update_chart"
												class="btn btn-blue-grey">Submit
											</button>
										</fieldset>
									</div>

								</div>

							</div>
						</form>
						<div class="card-body">
							<div class="card-block">
								<div id="cat-chart" height="400"></div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var cat_data = [
            <?php foreach ($chart['chart'] as $item) {
            echo '{y: "' . $item['product'] . '", a: ' . $item['subtotal'] . ' },';
        }
            ?>
        ];
        draw_c(cat_data);
    });

    function draw_c(cat_data) {
        $('#cat-chart').empty();
        Morris.Bar({
            element: 'cat-chart',
            data: cat_data,
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Amount'],
            barColors: [
                '#007085',
            ],
            barFillColors: [
                '#34cea7',
            ],
            barOpacity: 0.6,
        });
    }

    $(document).on('click', ".update_chart", function (e) {
        e.preventDefault();
        var a_type = $(this).attr('data-val');
        if (a_type == 'custom') {
            $('#custom_c').show();
        } else {
            $.ajax({
                url: baseurl + 'customers/reports_update',
                dataType: 'json',
                method: 'POST',
                data: {
                    'p': $(this).attr('data-val'),
					'id': <?= $details['id'] ?>,
                    '<?=$this->security->get_csrf_token_name()?>': '<?=$this->security->get_csrf_hash(); ?>'
                },
                success: function (data) {
                    draw_c(data['chart']);
					$("#total_refrences").val(data['total_refrences']);
					$("#total_expences").val(data['total_expences']);
					$("#total_visits").val(data['total_visits']);
                }
            });
        }
    });


    $(document).on('click', "#custom_update_chart", function (e) {
        e.preventDefault();
        $.ajax({
            url: baseurl + 'customers/reports_update',
            dataType: 'json',
            method: 'POST',
            data: $('#chart_custom').serialize() + '&id=<?=$details["id"]?>' + '&<?=$this->security->get_csrf_token_name()?>=<?=$this->security->get_csrf_hash(); ?>',
            success: function (data) {
                draw_c(data['chart']);
				$("#total_refrences").val(data['total_refrences']);
				$("#total_expences").val(data['total_expences']);
				$("#total_visits").val(data['total_visits']);
			}
        });

    });


</script>