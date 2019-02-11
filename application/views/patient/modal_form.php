<div class="modal-body clearfix">
    <div id="new-patient-dropzone" class="post-dropzone">
        <?php echo form_open(get_uri("patients/save"), array("id" => "patient-form", "class" => "general-form", "role" => "form")); ?>
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />

        <div class="form-group">
            <label for="title" class=" col-md-3"><?php echo lang('name'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "name",
                    "name" => "name",
                    "value" => $model_info->name,
                    "class" => "form-control",
                    "placeholder" => lang('enter_name'),
                    "autofocus" => true,
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                ));
                ?>
            </div>
        </div>

         <div class="form-group">
            <label for="title" class=" col-md-3"><?php echo lang('surname'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "sur_name",
                    "name" => "sur_name",
                    "value" => $model_info->sur_name,
                    "class" => "form-control",
                    "placeholder" => lang('enter_surname'),
                    "autofocus" => true,
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                ));
                ?>
            </div>
        </div>

         <div class="form-group">
            <label for="title" class=" col-md-3"><?php echo lang('city'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "city",
                    "name" => "city",
                    "value" => $model_info->city,
                    "class" => "form-control",
                    "placeholder" => lang('enter_city'),
                    "autofocus" => true,
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                ));
                ?>
            </div>
        </div>



         <div class="form-group catalog_div">
            <label for="parent_cat" class=" col-md-3"><?php echo lang('enter_assigned_doc'); ?></label>
            <div class=" col-md-9">
               <?php
    
               echo form_dropdown("assigned_doctor", $clients, array($model_info->assigned_doctor), "class='select2'");
               ?>
           </div>
       </div>



     
            


        
        <input type="hidden" name="previous_pdf" value="<?php echo $model_info->pdf_file; ?>">

        <?php $this->load->view("includes/dropzone_preview"); ?>
        <div class="row">
            <div class="modal-footer">
                <button class="btn btn-default upload-file-button pull-left btn-sm round" type="button" style="color:#7988a2"><i class='fa fa-file-pdf-o'></i> <?php echo lang("upload_file"); ?></button>
                <input type="hidden" name="old_image" class="old_image" value="">
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
       var uploadUrl = "<?php echo get_uri("patients/upload_file"); ?>";
       var validationUrl = "<?php echo get_uri("patients/validate_patient_file"); ?>";
       var dropzone = attachDropzoneWithForm("#new-patient-dropzone", uploadUrl, validationUrl);

        $("#patient-form").appForm({
            onSuccess: function (result) {
                if (editMode) {
                    
                    appAlert.success(result.message, {duration: 10000});
                    
                    //don't reload whole page when it's the list view
                    if($("#patient-table").length){
                        $("#patient-table").appTable({newData: result.data, dataId: result.id});
                    } else {
                        location.reload();
                    } 
                } else {
                    $("#patient-table").appTable({newData: result.data, dataId: result.id});
                }

            }
        });

     $("#patient-form .select2").select2();

});


</script>