<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h5>Edit New Service</h5>
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
<input type="hidden" name="id" value="<?php echo $service['id'] ?>">
                <div class="form-group row">
                    <div class="col-sm-6"><label class="col-form-label"
                                                 for="product_name">
                            Name
                            *</label>
                        <input type="text" placeholder="Name" value="<?php echo $service['name'] ?>"
                               class="form-control margin-bottom required" name="name">
                    </div>
                    <div class="col-sm-6"><label class="col-form-label"
                                                 for="product_name">
                            Time
                            *</label>
                        <input type="text" placeholder="Time(Min)" value="<?php echo $service['settime'] ?>"
                               class="form-control margin-bottom required" name="settime">
                    </div>
                    <?php
                        if ($service['parent_id'] == 0) {
                    ?>
                        <div class="col-sm-6"><label class="col-form-label"
                                                    for="revisit">
                                Time interval for client to revisit
                                </label>
                            <input id="revisit" type="text" placeholder="Time(Days)" value="<?php echo $service['revisit'] ?>"
                                class="form-control margin-bottom required" name="revisit">
                        </div>
                    <?php
                        }
                    ?>
                    <div class="col-sm-6"><label class="col-form-label"
                                                 for="price">
                            Price(Toman)
                            *</label>
                        <input type="text" placeholder="Price"
                               class="form-control margin-bottom required" name="price" value="<?php echo $service['price'] ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <input type="submit" id="submit-data" class="btn btn-lg btn-blue margin-bottom"
                           value="Update" data-loading-text="Adding...">
                    <input type="hidden" value="services/update" id="action-url">
                </div>
            </form>




        </div>
    </div>
</div>
