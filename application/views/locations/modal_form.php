<div class="modal-body clearfix">
    <div id="new-location-dropzone" class="post-dropzone">
        <?php echo form_open(get_uri("locations/save"), array("id" => "location-form", "class" => "general-form", "role" => "form")); ?>
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />


        <div class="form-group">
            <label for="title" class=" col-md-3"><?php echo lang('location_type'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "rental_type",
                    "name" => "rental_type",
                    "value" => $model_info->rental_type,
                    "class" => "form-control",
                    "placeholder" => lang('location_type'),
                    "autofocus" => true,
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                ));
                ?>
            </div>
        </div>
            <div class="form-group">
            <label for="title" class=" col-md-3"><?php echo lang('location_quantity'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "quantity",
                    "name" => "quantity",
                    "value" => $model_info->quantity,
                    "class" => "form-control",
                    "placeholder" => lang('location_quantity'),
                    "autofocus" => true,
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                ));
                ?>
            </div>
        </div>

         <div class="form-group">
            <label for="title" class=" col-md-3"><?php echo lang('location_patient'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "patient",
                    "name" => "patient",
                    "value" => $model_info->patient,
                    "class" => "form-control",
                    "placeholder" => lang('location_patient'),
                    "autofocus" => true,
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                ));
                ?>
            </div>
        </div>
         <div class="form-group">
            <label for="title" class=" col-md-3"><?php echo lang('location_room'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "room",
                    "name" => "room",
                    "value" => $model_info->room,
                    "class" => "form-control",
                    "placeholder" => lang('location_room'),
                    "autofocus" => true,
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                ));
                ?>
            </div>
        </div>
         <div class="form-group">
            <label for="title" class=" col-md-3"><?php echo lang('location_service'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "service",
                    "name" => "service",
                    "value" => $model_info->service,
                    "class" => "form-control",
                    "placeholder" => lang('location_service'),
                    "autofocus" => true,
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                ));
                ?>
            </div>
        </div>
        
            <!-- client can't be changed during editing -->
            <?php if ($client_id) { ?>
                <input type="hidden" name="client_id" value="<?php echo $client_id; ?>" />
            <?php } else { ?>
                <!-- <div class="form-group">
                    <label for="client_id" class=" col-md-3"><?php echo lang('client'); ?></label>
                    <div class="col-md-9">
                        <?php
                        echo form_dropdown("client_id", $clients_dropdown, array(""), "class='select2 validate-hidden' id='client_id' data-rule-required='true', data-msg-required='" . lang('field_required') . "'");
                        ?>
                    </div>
                </div> -->
            <?php } ?>

  

        <?php if (!$model_info->id) { ?>
            <!-- description can't be changed during editing -->
            <div class="form-group">
                <label for="description" class=" col-md-3"><?php echo lang('location_comment'); ?></label>
                <div class=" col-md-9">
                    <?php
                    echo form_textarea(array(
                        "id" => "comment",
                        "name" => "comment",
                        "class" => "form-control",
                        "placeholder" => lang('location_comment'),
                        "data-rule-required" => true,
                        "data-msg-required" => lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
        <?php } ?>

  


        <?php //$this->load->view("includes/dropzone_preview"); ?>    
        <div class="row">
            <div class="modal-footer">


                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
                <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
            </div>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        var editMode = "<?php echo $model_info->id; ?>";

        $("#location-form").appForm({
            onSuccess: function (result) {
                if (editMode) {
                    
                    appAlert.success(result.message, {duration: 10000});
                    
                    //don't reload whole page when it's the list view
                    if($("#locations-table").length){
                        $("#locations-table").appTable({newData: result.data, dataId: result.id});
                    } else {
                        location.reload();
                    } 
                } else {
                    $("#locations-table").appTable({newData: result.data, dataId: result.id});
                }

            }
        });

});


</script>