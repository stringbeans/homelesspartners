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
            'fname': 'required',
            'lname': 'required',
            'cityId': 'required',
            'gender': 'required',
            'assignedId': 'required',
            'story': 'required',
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
            <p>
                To add a new story please include all the details below. Make sure you choose the correct shelter!
            </p>
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
                        <option value='<?php echo $shelter->shelter_id ?>' <?php echo (((!empty($story) && $story->shelter_id == $shelter->shelter_id) || ($selectedShelterId == $shelter->shelter_id))?' selected':'')?>><?php echo $shelter->name ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class='form-group'>
                    <label>First Name</label>
                    <input type='text' class='form-control' name='fname' value='<?php echo !empty($story)?$story->fname:"" ?>' />
                </div>
                <div class='form-group'>
                    <label>Last Name (Initial)</label>
                    <input type='text' class='form-control' name='lname' maxlength='1' value='<?php echo !empty($story)?$story->lname:"" ?>' />
                </div>
                <div class='form-group'>
                    <label>Gender</label>
                    <input type="radio" name="gender" value="M" <?php echo (!empty($story) && $story->gender=='M')?'checked=checked':'' ?> /> Male
                    <input type="radio" name="gender" value="F" <?php echo (!empty($story) && $story->gender=='F')?'checked=checked':'' ?> /> Female
                </div>
                <div class='form-group'>
                    <label>Assigned ID <a data-toggle="tooltip" title="This will be provided to the homeless person. They will reference this when picking up gifts from the shelter." class='extra-info'>(What is this?)</a></label>
                    <input type='text' class='form-control' name='assignedId' value='<?php echo !empty($story)?$story->assigned_id:"" ?>' />
                </div>
                <div class='form-group'>
                    <label>Story</label>
                    <textarea class='form-control' rows="5" cols = "40" name='story'><?php echo !empty($story)?$story->story:"" ?></textarea>
                </div>
                <input type='hidden' name='displayOrder' value='0' />

                <script type='text/javascript'>


                $(document).ready(function(){

                    $(".extra-info").tooltip();

                    $("#giftTable .newGiftDescription").keypress(function(event){
                        if(event.which == 13)
                        {
                            $("#giftTable .add").click();
                            event.preventDefault();
                        }
                    });

                    $("#giftTable .add").click(function(event) {
                        var giftDescription = $(event.currentTarget).closest("tr").find("input").val();
                        if(giftDescription != "")
                        {
                            var markup = '<tr><td>' + giftDescription  + '</td><td><a href="#"" class="btn btn-xs btn-danger delete">Delete</a><input type="hidden" name="gifts[]" value="' + giftDescription + '" /></td></tr>';
                            $("#giftTable tbody").append(markup);
                            $(event.currentTarget).closest("tr").find("input").val("");
                        }

                        event.preventDefault();
                    });

                    $("#giftTable").on("click", ".delete", function(event) {
                        if($(event.currentTarget).closest("tr").find("input").length)
                        {
                            var giftId = $(event.currentTarget).closest("tr").find("input.giftId").val();

                            var currentGifts = [];
                            if($("#giftsToDelete").val() != "")
                            {
                                currentGifts = JSON.parse($("#giftsToDelete").val());

                            }
                            currentGifts.push(giftId);

                            $("#giftsToDelete").val(JSON.stringify(currentGifts));
                        }

                        $(event.currentTarget).closest("tr").remove();
                        event.preventDefault();
                    });

                    $("input[type='submit']").click(function(event){
                        if($(".newGiftDescription").val() != "")
                        {
                            if(!confirm("You have an un-added gift. Continue?"))
                            {
                                event.preventDefault();
                            }
                        }
                        
                    });
                });
                </script>

                <div class='form-group'>
                    <label>Gifts Requested <a data-toggle="tooltip" title="Click 'Add' to add a gift to the story!" class='extra-info'>(?)</a></label>
                    <table id='giftTable' class='table'>
                        <tbody>
                            <?php foreach ($gifts as $gift): ?>
                                <tr>
                                    <td><?php echo $gift->description ?></td>
                                    <td><a href='#' class='btn btn-xs btn-danger delete'>Delete</a> <input type='hidden' class='giftId' name='giftId' value='<?php echo $gift->gift_id ?>' /></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><input type='text' class='form-control newGiftDescription' /></td>
                                <td><a href='#' class='btn btn-xs btn-info add'>+ Add</td>
                            </tr>
                        </tfoot>
                    </table>
                    <input type='hidden' name='giftsToDelete' id='giftsToDelete' value='' />
                </div>

                <input type='hidden' name='enabled' value='1' />

                <?php /*
                <div class='form-group'>
                    <label>Enabled</label>
                    <input type="checkbox" name='enabled' value='1' <?php echo (!empty($story) && !empty($story->enabled))?"checked='checked'":"" ?> data-toggle="switch" />
                </div>
                */ ?>

                <div class='form-group'>
                    <input type='submit' class='btn btn-success' value='Save' name="saveButton"/>
                    <input type='submit' class='btn btn-success' value='Save and Add New' name="saveNewButton"/>
                </div>
            </form>
        </div>
    </div>
</div>

