 <div class="modal-body clearfix">
    <div id="new-catagory-dropzone" class="post-dropzone">
        <?php echo form_open(get_uri("category/save"), array("id" => "category-form", "class" => "general-form", "role" => "form")); ?>
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />

        <div class="form-group">
            <label for="title" class=" col-md-3"><?php echo lang('catalog_category'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "category",
                    "name" => "category",
                    "value" => $model_info->name,
                    "class" => "form-control",
                    "placeholder" => lang('catalog_category'),
                    "autofocus" => true,
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                ));
                ?>
            </div>
        </div>

     
            
        <div class="form-group">
            <label for="parent_cat" class=" col-md-3"><?php echo lang('parent_category'); ?></label>
            <div class=" col-md-9">
                 <?php
                    echo form_dropdown("parent_cat", $parent_category, array($model_info->parent_id), "class='select2 parent_cat'");
                ?>
            </div>
        </div>

           <div class="form-group catalog_div">
            <label for="parent_cat" class=" col-md-3"><?php echo lang('catalog'); ?></label>
            <div class=" col-md-9">
               <?php
               $selected = $model_info->catalog_id;
               if ($selected != "") {
                   
                   $selected = explode(",", $selected);
               }
               echo form_dropdown("catalog[]", $client_group, $selected, "class='select2' multiple='multiple'");
               ?>
           </div>
       </div>
        
        <input type="hidden" name="previous_image" value="<?php echo $model_info->image; ?>">

        <?php $this->load->view("includes/dropzone_preview"); ?>
        <div class="row">
            <div class="modal-footer">
                <button class="btn btn-default upload-file-button pull-left btn-sm round" type="button" style="color:#7988a2"><i class='fa fa-camera'></i> <?php echo lang("upload_file"); ?></button>
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
       var uploadUrl = "<?php echo get_uri("category/upload_file"); ?>";
       var validationUrl = "<?php echo get_uri("category/validate_category_file"); ?>";
       var options = {maxFiles:1};
       var dropzone = attachDropzoneWithForm("#new-catagory-dropzone", uploadUrl, validationUrl,options);

        $("#category-form").appForm({
            onSuccess: function (result) {
                if (editMode) {
                    
                    appAlert.success(result.message, {duration: 10000});
                    
                    //don't reload whole page when it's the list view
                    if($("#category-table").length){
                        $("#category-table").appTable({newData: result.data, dataId: result.id});
                    } else {
                        location.reload();
                    } 
                } else {
                    $("#category-table").appTable({newData: result.data, dataId: result.id});
                }

            }
        });

     $("#category-form .select2").select2();

});


</script>