<div id="page-content" class="p20 clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1><?php echo lang('estimates'); ?></h1>
            <div class="title-button-group">
                <?php echo modal_anchor(get_uri("estimates/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_estimate'), array("class" => "btn btn-default", "title" => lang('add_estimate'))); ?>
            </div>
        </div>
        <div class="table-responsive">
            <table id="estimate-table" class="display" cellspacing="0" width="100%">   
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#estimate-table").appTable({
            source: '<?php echo_uri("estimates/list_data") ?>',
            order: [[0, "desc"]],
            dateRangeType: "monthly",
            filterDropdown: [{name: "status", class: "w150", options: <?php $this->load->view("estimates/estimate_statuses_dropdown"); ?>}],
            columns: [
                {title: "<?php echo lang("estimate") ?> ", "class": "w15p"},
                {title: "<?php echo lang("client") ?>"},
                {visible: false, searchable: false},
                {title: "<?php echo lang("estimate_date") ?>", "iDataSort": 2, "class": "w20p"},
                {title: "<?php echo lang("amount") ?>", "class": "text-right w20p"},
                {title: "<?php echo lang("status") ?>", "class": "text-center"},
                {title: "<i class='fa fa-bars'></i>", "class": "text-center option w100"}
            ],
            printColumns: [0, 1, 3, 4, 5],
            xlsColumns: [0, 1, 3, 4, 5],
            summation: [{column: 4, dataType: 'currency', currencySymbol: "none"}]
        });
    });



</script>