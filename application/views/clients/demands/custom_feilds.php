        <div class="form-group">
            <label for="title" class=" col-md-3"><?php echo lang('tyype_of_pres'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "tyype_of_pres",
                    "name" => "tyype_of_pres",
                    "class" => "form-control",
                    "placeholder" => lang('tyype_of_pres'),
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                ));
                ?>
            </div>
        </div>

        <div class="form-group">
            <label for="title" class=" col-md-3"><?php echo lang('patient'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "patient",
                    "name" => "patient",
                    "class" => "form-control",
                    "placeholder" => lang('patient'),
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                ));
                ?>
            </div>
        </div>


        <div class="form-group">
            <label for="title" class=" col-md-3"><?php echo lang('patient_tel'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "patient_tel",
                    "name" => "patient_tel",
                    "class" => "form-control",
                    "placeholder" => lang('patient_tel'),
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                ));
                ?>
            </div>
        </div>

        <div class="form-group">
            <label for="title" class=" col-md-3"><?php echo lang('product_name'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "product_name",
                    "name" => "product_name",
                    "class" => "form-control",
                    "placeholder" => lang('product_name'),
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                ));
                ?>
            </div>
        </div>

        <div class="form-group">
            <label for="title" class=" col-md-3"><?php echo lang('coment'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_textarea(array(
                    "id" => "coment",
                    "name" => "coment",
                    "class" => "form-control",
                    "placeholder" => lang('coment'),
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                ));
                ?>
            </div>
        </div>

