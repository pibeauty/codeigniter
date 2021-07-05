<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h5>Edit Role</h5>
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
<input type="hidden" name="id" value="<?php echo $role['id'] ?>">
                <div class="form-group row">
                    <div class="col-sm-6"><label class="col-form-label"
                                                 for="name">
                            Name
                            *</label>
                        <input type="text" placeholder="Name" value="<?php echo $role['name'] ?>"
                               class="form-control margin-bottom required" name="name">
                    </div>

                </div>
                <div class="form-group row">
                    <input type="submit" id="submit-data" class="btn btn-lg btn-blue margin-bottom"
                           value="Update" data-loading-text="Adding...">
                    <input type="hidden" value="employee/updateRole" id="action-url">
                </div>
            </form>




        </div>
    </div>
</div>
