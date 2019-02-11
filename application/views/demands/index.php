    <div id="page-content" class="p20 clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1><?php echo lang('demands_request'); ?></h1>
        </div>
        <div class="table-responsive">
            <table id="demand-table" class="display" cellspacing="0" width="100%">            
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
        
        $("#demand-table").appTable({
            source: '<?php echo_uri("demands/list_data") ?>',
            order: [[0, "ASC"]],
             radioButtons: [{text: '<?php echo lang("open") ?>', name: "status", value: "open", isChecked: true}, {text: '<?php echo lang("closed") ?>', name: "status", value: "closed", isChecked: false}],
       
             columns: [
                {title: "<?php echo lang("company_name") ?>", "class": "w10p"},
                {title: "<?php echo lang("tyype_of_pres") ?>", "class": "w10p"},
                {title: "<?php echo lang("patient") ?>", "class": "w10p"},
                {title: "<?php echo lang("patient_tel") ?>", "class": "w10p"},
                {title: "<?php echo lang("product_name") ?>", "class": "w10p"},
                {title: "<?php echo lang("coment") ?>", "class": "w10p"},

            ],
             printColumns: [0, 2, 1, 3, 4, 6, 7],
            xlsColumns: [0, 2, 1, 3, 4, 6, 7 ]
        });

    });
</script>
