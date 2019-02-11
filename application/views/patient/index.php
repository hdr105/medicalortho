<div id="page-content" class="p20 clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1><?php echo lang('patient'); ?></h1>
            <div class="title-button-group">
                <?php echo modal_anchor(get_uri("patients/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_patient'), array("class" => "btn btn-default", "title" => lang('add_patient'))); ?>
            </div>
        </div>
       <div class="table-responsive">
            <table id="patient_table" class="display" cellspacing="0" width="100%">            
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

        $("#patient_table").appTable({
            source: '<?php echo_uri("patients/list_data") ?>',
            order: [[0, "ASC"]],
       
             columns: [
                {title: '<?php echo lang("name") ?>', "class": "w10p"},
                {title: '<?php echo lang("surname") ?>', "class": "w10p"},
                {title: '<?php echo lang("city") ?>', "class": "w10p"},
                {title: '<?php echo lang("enter_assigned_doc") ?>', "class": "w10p"},
                {title: '<?php echo lang("location_date") ?>', "class": "w10p"},
                {title: "<?php echo lang("actions") ?>", "class": "w10p", visible: optionsVisibility},
        

            ],
             printColumns: [0, 2, 1, 3, 4, 6, 7],
            xlsColumns: [0, 2, 1, 3, 4, 6, 7 ]
        });
    });
</script> 