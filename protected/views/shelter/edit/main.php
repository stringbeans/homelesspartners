<script type='text/javascript'>
$(document).ready(function() {
    $("#cityForm").validate({
        submitHandler: function(form) {
            form.submit();
        },
        onsubmit: true,
        onkeyup: false,
        focusCleanup: true,
        messages: {
        },
        errorPlacement: function(error, element) {
        },
        highlight: function(element, errorClass) {
            $element = $(element);
            $element.closest("div.form-group").addClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $element = $(element);
            $element.closest("div.form-group").removeClass(errorClass);
        },
        //where to post messages
        errorClass: "has-error",
        ignore: ":hidden",
        rules: {
            'name': 'required',
            'region': 'required'
        }
    });
});
</script>

<div class='container'>
    <div class='row'>
        <div class='col-md-12'>
            <?php if(!empty($shelter)): ?>
            <h2>Edit Shelter</h2>
            <?php else: ?>
            <h2>Create Shelter</h2>
            <?php endif; ?>
        </div>
        <div class='col-md-6'>
            <form id='cityForm' action='<?php echo $this->createUrl("shelter/save") ?>' method='post'>
                <?php if(!empty($shelter)): ?>
                <input type='hidden' name='shelterId' value='<?php echo $shelter->shelter_id ?>' />
                <?php endif; ?>

                <?php if(!empty($shelter)): ?>
                <input type='hidden' name='creatorId' value='<?php echo $shelter->creator_id ?>' />
                <?php else:?>
                    <input type='hidden' name='creatorId' value='<?php echo $userId ?>' />
                <?php endif; ?>

                <div class='form-group'>
                    <label>City</label>
                    <select class='form-control' name='cityId' />
                        <?php foreach ($cities as $city): ?>
                        <option value='<?php echo $city->city_id ?>'><?php echo $city->name ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class='form-group'>
                    <label>Name</label>
                    <input type='text' class='form-control' name='name' value='<?php echo !empty($shelter)?$shelter->name:"" ?>' />
                </div>
                <div class='form-group'>
                    <label>Street</label>
                    <textarea class='form-control' name='street'><?php echo !empty($shelter)?$shelter->street:"" ?></textarea>
                </div>
                <div class='form-group'>
                    <label>Phone</label>
                    <input type='text' class='form-control' name='phone' value='<?php echo !empty($shelter)?$shelter->phone:"" ?>' />
                </div>
                <div class='form-group'>
                    <label>They Do</label>
                    <textarea class='form-control'rows="5" cols = "40" name='they_do'><?php echo !empty($shelter)?$shelter->they_do:"" ?></textarea>
                </div>
                <div class='form-group'>
                    <label>They Need</label>
                    <textarea class='form-control' rows="5" cols = "40" name='they_need'><?php echo !empty($shelter)?$shelter->they_need:"" ?></textarea>
                </div>
                <div class='form-group'>
                    <label>Drop Off Details</label>
                    <textarea class='form-control' rows="5" cols = "40" name='dropoff_details'><?php echo !empty($shelter)?$shelter->dropoff_details:"" ?></textarea>
                </div>
                <div class='form-group'>
                    <label>ID Format</label>
                    <input type='text' class='form-control' name='ID_FORMAT' value='<?php echo !empty($shelter)?$shelter->ID_FORMAT:"" ?>' />
                </div>
                <div class='form-group'>
                    <label>Website</label>
                    <input type='text' class='form-control' name='website' value='<?php echo !empty($shelter)?$shelter->website:"" ?>' />
                </div>
                <div class='form-group'>
                    <label>Email</label>
                    <input type='text' class='form-control' name='email' value='<?php echo !empty($shelter)?$shelter->email:"" ?>' />
                </div>
                <div class='form-group'>
                    <label>Mapped</label>
                    <input type="checkbox" name='mapped' value='1' <?php echo (!empty($shelter) && $shelter->mapped)?"checked='checked'":"" ?> data-toggle="switch" />
                </div>
                <div class='form-group'>
                    <label>Date Created: <?php echo !empty($shelter)?$shelter->date_created:"" ?></label>
                </div>


                <div class='form-group'>
                    <label>Enabled</label>
                    <input type="checkbox" name='enabled' value='1' <?php echo (!empty($shelter) && !empty($shelter->enabled))?"checked='checked'":"" ?> data-toggle="switch" />
                </div>
                <div class='form-group'>
                    <input type='submit' class='btn btn-success' value='Save' />
                </div>
            </form>
        </div>
    </div>
</div>

