<?php if (isset($page_type) && $page_type === "full") { ?>
    <div id="page-content" class="m20 clearfix">
    <?php } ?>

    <div class="panel">
        <?php if (isset($page_type) && $page_type === "full") { ?>
            <div class="page-title clearfix">
                <h1><?php echo lang('locations'); ?></h1>
                <div class="title-button-group">
                    <?php echo modal_anchor(get_uri("locations/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_location'), array("class" => "btn btn-default", "data-post-client_id" => $client_id, "title" => lang('add_location'))); ?>
                </div>
            </div>
        <?php } else { ?>
            <div class="tab-title clearfix">
                <h4><?php echo lang('locations'); ?></h4>
                <div class="title-button-group">
                    <?php echo modal_anchor(get_uri("locations/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_location'), array("class" => "btn btn-default", "data-post-client_id" => $client_id, "title" => lang('add_location'))); ?>
                </div>
            </div>
        <?php } ?>

        <div class="table-responsive">
            <table id="locations-table" class="display" width="100%">            
            </table>
        </div>
    </div>
    <?php if (isset($page_type) && $page_type === "full") { ?>
    </div>
<?php } ?>

<script type="text/javascript">
    $(document).ready(function () {
        var userType = "<?php echo $this->login_user->user_type; ?>";

        $("#locations-table").appTable({
            source: '<?php echo_uri("locations/location_list_data_of_client/" . $client_id) ?>',
            order: [[0, "ASC"]],
            columns: [
                {title: '<?php echo lang("location_type") ?>'},
                {title: '<?php echo lang("location_quantity") ?>', "class": "w20p"},
                {title: '<?php echo lang("location_patient") ?>', "class": "w15p"},
                {title: '<?php echo lang("location_room") ?>', "class": "w10p"},
                {title: '<?php echo lang("location_service") ?>', "class": "w10p"},

            ],
           
        });
    });
</script>