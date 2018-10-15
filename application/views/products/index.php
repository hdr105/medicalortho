
    <div id="page-content" class="m20 clearfix">


    <div class="panel">
       
            <div class="page-title clearfix">
                <h1><?php echo lang('product'); ?></h1>
                <div class="title-button-group">
                    <?php echo modal_anchor(get_uri("product/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_product'), array("class" => "btn btn-default", "title" => lang('add_product'))); ?>
                </div>
            </div>
       

        <div class="table-responsive">
            <table id="product-table" class="display" width="100%">            
            </table>
        </div>
    </div>
    
    </div>


<script type="text/javascript">
    $(document).ready(function () {
        
        
        $("#product-table").appTable({
            source: '<?php echo_uri("product/list_data") ?>',
            order: [[0, "ASC"]],
       
             columns: [
                {title: '<?php echo lang("product") ?>', "class": "w10p"},
                {title: '<?php echo lang("catalog_category") ?>', "class": "w10p"},
                {title: '<?php echo lang("quantity") ?>', "class": "w10p"},
                {title: '<?php echo lang("price") ?>', "class": "w10p"}

            ],
             printColumns: [0, 2, 1,4],
            xlsColumns: [0, 2, 1, 3, 4]
        });

    });
</script>