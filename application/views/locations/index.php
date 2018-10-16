    <div id="page-content" class="p20 clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1><?php echo lang('location_request'); ?></h1>
        </div>
        <div class="table-responsive">
            <table id="locations-table" class="display" cellspacing="0" width="100%">            
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var optionsVisibility = false;
        if("<?php if(isset($show_options_column) && $show_options_column){echo '1';}?>"=="1"){
            optionsVisibility = true;
        }
        
        $("#locations-table").appTable({
            source: '<?php echo_uri("locations/list_data") ?>',
            order: [[0, "ASC"]],
             radioButtons: [{text: '<?php echo lang("open") ?>', name: "status", value: "open", isChecked: true}, {text: '<?php echo lang("closed") ?>', name: "status", value: "closed", isChecked: false}],
       
             columns: [
                {title: '<?php echo lang("location_type") ?>', "class": "w10p"},
                {title: '<?php echo lang("location_quantity") ?>', "class": "w10p"},
                {title: '<?php echo lang("location_patient") ?>', "class": "w10p"},
                {title: '<?php echo lang("location_room") ?>', "class": "w10p"},
                {title: '<?php echo lang("location_service") ?>', "class": "w10p"},
                {title: '<?php echo lang("location_comment") ?>', "class": "w20p"},
                {title: "<?php echo lang("company_name") ?>", "class": "w10p"},
                {title: "<?php echo lang("start_date") ?>", "class": "w10p"},
                {title: "<?php echo lang("end_date") ?>", "class": "w10p"},
                {title: "<?php echo lang("location_status") ?>", "class": "w10p"},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center dropdown-option w50", visible: optionsVisibility},

            ],
             printColumns: [0, 2, 1, 3, 4, 6, 7],
            xlsColumns: [0, 2, 1, 3, 4, 6, 7 ]
        });

    });
</script>
