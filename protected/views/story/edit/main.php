<script type='text/javascript'>
$(document).ready(function() {

    $("#giftRequests").selectize({
        plugins: ['remove_button'],
    });


    $("#storyForm").validate({
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
            'cityId': 'required',
            'gender': 'required'
        }
    });
});
</script>

<div class='container'>
    <div class='row'>
        <div class='col-md-12'>
            <?php if(!empty($story)): ?>
            <h2>Edit Story</h2>
            <?php else: ?>
            <h2>Create Story</h2>
            <?php endif; ?>
        </div>
        <div class='col-md-6'>
            <form id='storyForm' action='<?php echo $this->createUrl("story/save") ?>' method='post' enctype="multipart/form-data">
                <?php if(!empty($story)): ?>
                <input type='hidden' name='storyId' value='<?php echo $story->story_id ?>' />
                <?php endif; ?>

                <?php if(!empty($story)): ?>
                <input type='hidden' name='creatorId' value='<?php echo $story->creator_id ?>' />
                <?php else:?>
                    <input type='hidden' name='creatorId' value='<?php echo $userId ?>' />
                <?php endif; ?>

                <div class='form-group'>
                    <label>Shelter</label>
                    <select class='form-control' name='shelterId' />
                        <?php foreach ($shelters as $shelter): ?>
                        <option value='<?php echo $shelter->shelter_id ?>' <?php echo ((!empty($story) && $story->shelter_id == $shelter->shelter_id)?' selected':'')?>><?php echo $shelter->name ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class='form-group'>
                    <label>First Name</label>
                    <input type='text' class='form-control' name='fname' value='<?php echo !empty($story)?$story->fname:"" ?>' />
                </div>
                <div class='form-group'>
                    <label>Last Name</label>
                    <input type='text' class='form-control' name='lname' value='<?php echo !empty($story)?$story->lname:"" ?>' />
                </div>
                <div class='form-group'>
                    <label>Gender</label>
                    <input type="radio" name="gender" value="M" <?php echo (!empty($story) && $story->gender=='M')?'checked=checked':'' ?> /> Male
                    <input type="radio" name="gender" value="F" <?php echo (!empty($story) && $story->gender=='F')?'checked=checked':'' ?> /> Female
                </div>
                <div class='form-group'>
                    <label>Assigned ID</label>
                    <input type='text' class='form-control' name='assignedId' value='<?php echo !empty($story)?$story->assigned_id:"" ?>' />
                </div>
                <div class='form-group'>
                    <label>Story</label>
                    <textarea class='form-control' rows="5" cols = "40" name='story'><?php echo !empty($story)?$story->story:"" ?></textarea>
                </div>
                <div class='form-group'>
                    <label>Display Order</label>
                    <select name="displayOrder">
                        <?php
                        for($i = 0; $i < 11; $i++) {
                            echo '<option value="' . $i . '" ' . ((!empty($story) && $story->display_order == $i)? ' selected' :'') .
                                '>' . $i . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class='form-group'>
                    <label>Gift Requests</label>
                    <select id='giftRequests' name='giftRequests[]' multiple>
                        <?php foreach ($currentGiftRequests as $gift):?>
                            <option value='<?php echo $gift['id']?>' selected='selected'><?php echo $gift['description']; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class='form-group'>
                    <label>Gift Details</label>
                    <textarea class='form-control' rows="5" cols = "40" name='gift_description'></textarea>
                </div>

                <div class='form-group'>
                    <label>Date Created: <?php echo !empty($story)?$story->date_created:"" ?></label>
                </div>
                <div class='form-group'>
                    <label>Enabled</label>
                    <input type="checkbox" name='enabled' value='1' <?php echo (!empty($story) && !empty($story->enabled))?"checked='checked'":"" ?> data-toggle="switch" />
                </div>


                <div class='form-group'>
                    <input type='submit' class='btn btn-success' value='Save' name="saveButton"/>
                    <input type='submit' class='btn btn-success' value='Save and Add New' name="saveNewButton"/>
                </div>
            </form>
        </div>
    </div>
</div>

