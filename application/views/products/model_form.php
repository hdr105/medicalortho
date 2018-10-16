<div class="modal-body clearfix">
    <div id="new-product-dropzone" class="post-dropzone">
        <?php echo form_open(get_uri("product/save"), array("id" => "product-form", "class" => "general-form", "role" => "form")); ?>
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />

        <div class="form-group">
            <label for="title" class=" col-md-3"><?php echo lang('product'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "title",
                    "name" => "title",
                    "value" => $model_info->title,
                    "class" => "form-control",
                    "placeholder" => lang('product'),
                    "autofocus" => true,
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                ));
                ?>
            </div>
        </div>

        <div class="form-group">
            <label for="description" class=" col-md-3"><?php echo lang('description'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_textarea(array(
                    "id" => "description",
                    "name" => "description",
                    "value" => $model_info->description,
                    "class" => "form-control",
                    "placeholder" => lang('description')
                ));
                ?>
            </div>
        </div>

        <div class="form-group">
            <label for="price" class=" col-md-3"><?php echo lang('price'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "price",
                    "name" => "price",
                    "value" => $model_info->price,
                    "class" => "form-control",
                    "placeholder" => lang('price'),
                    "autofocus" => true,
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                ));
                ?>
            </div>
        </div>


        <div class="form-group">
            <label for="quantity" class=" col-md-3"><?php echo lang('quantity'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "quantity",
                    "name" => "quantity",
                    "value" => $model_info->quantity,
                    "class" => "form-control",
                    "placeholder" => lang('quantity'),
                    "autofocus" => true,
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                ));
                ?>
            </div>
        </div>


        <div class="form-group">
            <label for="category" class=" col-md-3"><?php echo lang('catalog_category'); ?></label>
            <div class=" col-md-9">
               <?php
               echo form_dropdown("category", $category_dropdown, array($model_info->category_id), "class='select2'");
               ?>
           </div>
       </div>

            
     
  
       <?php $this->load->view("includes/dropzone_preview"); ?>
        <div class="row">
            <div class="modal-footer">
                <button class="btn btn-default upload-file-button pull-left btn-sm round <?php
                if ($model_info->id) {
                    echo "hide";
                }
                ?>" type="button" style="color:#7988a2"><i class='fa fa-camera'></i> <?php echo lang("upload_file"); ?></button>

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
        var uploadUrl = "<?php echo get_uri("product/upload_file"); ?>";
        var validationUrl = "<?php echo get_uri("product/validate_category_file"); ?>";
        var dropzone = attachDropzoneWithForm("#new-product-dropzone", uploadUrl, validationUrl);

        $("#product-form").appForm({
            onSuccess: function (result) {
                if (editMode) {
                    
                    appAlert.success(result.message, {duration: 10000});
                    
                    //don't reload whole page when it's the list view
                    if($("#product-table").length){
                        $("#product-table").appTable({newData: result.data, dataId: result.id});
                    } else {
                        location.reload();
                    } 
                } else {
                    $("#product-table").appTable({newData: result.data, dataId: result.id});
                }

            }
        });

  $("#product-form .select2").select2();
});


</script>