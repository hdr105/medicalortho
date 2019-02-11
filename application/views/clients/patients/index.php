<div id="page-content" class="p20 clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1><?php echo lang('patient'); ?></h1>
            
        </div>
       <div class="table-responsive">
            <table id="patient_client_table" class="display" cellspacing="0" width="100%">            
            </table>
        </div> 
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
          
        $("#patient_client_table").appTable({
            source: '<?php echo_uri("patients/client_list_data") ?>',
            order: [[0, "ASC"]],
             
       
             columns: [
                {title: '<?php echo lang("name") ?>', "class": "w10p"},
                {title: '<?php echo lang("surname") ?>', "class": "w10p"},
                {title: '<?php echo lang("city") ?>', "class": "w10p"},
                {title: '<?php echo lang("enter_assigned_doc") ?>', "class": "w10p"},
                {title: '<?php echo lang("location_date") ?>', "class": "w10p"}


            ],
             printColumns: [0, 2, 1, 3, 4, 6, 7],
            xlsColumns: [0, 2, 1, 3, 4, 6, 7 ]
        });
    });
</script> 