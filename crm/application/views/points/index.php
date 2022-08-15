<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <?php if ($this->session->flashdata("messagePr")) { ?>
                <div class="alert alert-info">
                    <?php echo $this->session->flashdata("messagePr") ?>
                </div>
            <?php } ?>
            <div class="card card-block">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('Points') ?></h3>
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
                </div>
            </div>
        </div>


    </div>
</div>