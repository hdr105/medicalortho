    <div id="page-content" class="p20 clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1><?php echo lang('orders'); ?></h1>
        </div>
        <div class="table-responsive">
            <table id="order-products" class="display" cellspacing="0" width="100%">            
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

     
        $("#order-products").appTable({
            source: '<?php echo_uri("orders/list_data/$id") ?>',
            order: [[0, "ASC"]],
       
             columns: [
                {title: '<?php echo lang("product") ?>', "class": "w10p"},
                {title: '<?php echo lang("catalog_category") ?>', "class": "w10p"},
                {title: '<?php echo lang("quantity") ?>', "class": "w10p"},
                {title: '<?php echo lang("price") ?>', "class": "w10p"},
                {title: '<i class="fa fa-bars"></i>', "class": "w10p"},

            ],
             printColumns: [0, 2, 1, 3, 4, 6, 7],
            xlsColumns: [0, 2, 1, 3, 4, 6, 7 ]
        });

    });
</script>