
    <div id="page-content" class="m20 clearfix">


    <div class="panel">
       
            <div class="page-title clearfix">
                <h1><?php echo lang('catalog_category'); ?></h1>
                <div class="title-button-group">
                    <?php echo modal_anchor(get_uri("category/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_category'), array("class" => "btn btn-default", "title" => lang('add_category'))); ?>
                </div>
            </div>
       

        <div class="table-responsive">
            <table id="category-table" class="display" width="100%">            
            </table>
        </div>
    </div>
    
    </div>


<script type="text/javascript">
    $(document).ready(function () {
        
        
        $("#category-table").appTable({
            source: '<?php echo_uri("category/list_data") ?>',
            order: [[0, "ASC"]],
       
             columns: [
                {title: '<?php echo lang("catalog_category") ?>', "class": "w10p"},
                {title: '<?php echo lang("parent_category") ?>', "class": "w10p"},
                {title: '<?php echo lang("catalog") ?>', "class": "w10p"},
                {title: `<?php echo "<i class='fa fa-bars'></i>";?>`, "class": "w10p"},

            ],
             printColumns: [0, 2, 1, 3, 4, 6, 7],
            xlsColumns: [0, 2, 1, 3, 4, 6, 7]
        });

    });
</script>