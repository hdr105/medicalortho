<div class="tab-content">
    <?php echo form_open(get_uri("demands/save/"), array("id" => "demand-form", "class" => "general-form dashed-row white", "role" => "form")); ?>
    <div class="panel">
        <div class="panel-default panel-heading">
            <h4> <?php echo lang('demands_request'); ?></h4>
        </div>
        <div class="panel-body">
            <?php $this->load->view("clients/demands/custom_feilds"); ?>
        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-primary" id="submit"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {

       $("#demand-form").appForm({
            isModal: false,
            onSuccess: function (result) {
                appAlert.success(result.message, {duration: 10000});
            },
            onAjaxSuccess: function() {
                  $("#demand-form").trigger("reset");
            }
        }); 

    });
</script>
