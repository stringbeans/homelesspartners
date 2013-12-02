<script type='text/javascript'>
$(document).ready(function() {

    $("#shelterCoordinators").selectize({
        plugins: ['remove_button'],
    });

    $("#dropoffLocations").selectize({
        plugins: ['remove_button'],
    });


    $("#shelterForm").validate({
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
            'cityId': 'required'
        }
    });

    $("#citySelect").selectpicker({style: 'btn-white', menuStyle: 'dropdown'});
});
</script>

<div class='container'>
    <div class='row'>
        <div class='col-md-12'>
            <?php if(!empty($shelter)): ?>
            <h2>Edit Shelter</h2>

            <ul class="breadcrumb">
                <li>Shelter Management</li>
                <li><a href='<?php echo $this->createUrl("shelter/index") ?>'>View Shelters</a></li>
                <li class='active'>Edit Shelter</li>
            </ul>
            <?php else: ?>
            <h2>Create Shelter</h2>

            <ul class="breadcrumb">
                <li>Shelter Management</li>
                <li><a href='<?php echo $this->createUrl("shelter/index") ?>'>View Shelters</a></li>
                <li class='active'>Create Shelter</li>
            </ul>
            <?php endif; ?>
        </div>
        <div class='col-md-12'>
            <form id='shelterForm' action='<?php echo $this->createUrl("shelter/save") ?>' method='post' enctype="multipart/form-data">
                <?php if(!empty($shelter)): ?>
                <input type='hidden' name='shelterId' value='<?php echo $shelter->shelter_id ?>' />
                <?php endif; ?>

                <?php if(!empty($shelter)): ?>
                <input type='hidden' name='creatorId' value='<?php echo $shelter->creator_id ?>' />
                <?php else:?>
                    <input type='hidden' name='creatorId' value='<?php echo $userId ?>' />
                <?php endif; ?>

                <div class='row'>
                    <div class='form-group col-md-6'>
                        <label style='display: block;'>City</label>
                        <select id='citySelect' name='cityId' />
                            <?php foreach ($cities as $city): ?>
                            <option value='<?php echo $city->city_id ?>' <?php echo ((!empty($shelter) && $shelter->city_id == $city->city_id)?' selected':'')?>><?php echo $city->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class='row'>
                    <div class='form-group col-md-6'>
                        <label>Name</label>
                        <input type='text' class='form-control' name='name' value='<?php echo !empty($shelter)?$shelter->name:"" ?>' />
                    </div>
                </div>

                <div class='row'>
                    <div class='form-group col-md-6'>
                        <label>Street</label>
                        <textarea class='form-control' name='street'><?php echo !empty($shelter)?$shelter->street:"" ?></textarea>
                    </div>
                </div>

                <div class='row'>
                    <div class='form-group col-md-6'>
                        <label>Phone</label>
                        <input type='text' class='form-control' name='phone' value='<?php echo !empty($shelter)?$shelter->phone:"" ?>' />
                    </div>
                </div>

                <div class='row'>
                    <div class='form-group col-md-6'>
                        <label>Biography</label>
                        <textarea class='form-control'rows="5" cols = "40" name='bio'><?php echo !empty($shelter)?$shelter->bio:"" ?></textarea>
                    </div>
                </div>

                <div class='row'>
                    <div class='form-group col-md-6'>
                        <label>ID Format</label>
                        <input type='text' class='form-control' name='ID_FORMAT' value='<?php echo !empty($shelter)?$shelter->ID_FORMAT:"" ?>' />
                    </div>
                </div>

                <div class='row'>
                    <div class='form-group col-md-6'>
                        <label>Website</label>
                        <input type='text' class='form-control' name='website' value='<?php echo !empty($shelter)?$shelter->website:"" ?>' />
                    </div>
                </div>
                
                <div class='row'>
                    <div class='form-group col-md-6'>
                        <label>Email</label>
                        <input type='text' class='form-control' name='email' value='<?php echo !empty($shelter)?$shelter->email:"" ?>' />
                    </div>
                </div>
                
                <input type='hidden' name='enabled' value='1' />

                <div class='row'>
                    <div class='form-group col-md-6'>
                        <label>Shelter Coordinators</label>
                        <select id='shelterCoordinators' name='shelterCoordinators[]' multiple>
                            <?php foreach ($allShelterCoordinators as $user): ?>
                                <option value='<?php echo $user->user_id ?>' <?php echo in_array($user->user_id, $currentShelterCoordinators)?"selected='selected'":"" ?>><?php echo $user->email ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <?php /*
                <div class='form-group'>
                    <label>Dropoff Locations</label>
                    <select id='dropoffLocations' name='dropoffLocations[]' multiple>
                        <?php foreach ($currentDropoffLocations as $location):?>
                            <option value='<?php echo $location['id']?>' selected='selected'><?php echo $location['name'] . ': ' . $location['address']; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class='form-group'>
                    <label>Drop Off Details</label>
                    <textarea class='form-control' rows="5" cols = "40" name='dropoff_details'></textarea>
                </div>
                <div class='form-group'>
                    <label>Dropoff Location Name</label>
                    <input type='text' class='form-control' name='location-name' />
                </div>
                <div class='form-group'>
                    <label>Dropoff Location Address</label>
                    <input type='text' class='form-control' name='location-address' />
                </div>
                <div class='form-group'>
                    <label>Dropoff Location Notes</label>
                    <textarea class='form-control' name='location-notes'></textarea>
                </div>
                */ ?>

                <div class='row'>
                    <div class='form-group col-md-6'>

                        <label>Shelter Image</label>
                        <input type='file' class='form-control' name='image' />
                        <?php if(!empty($shelter) && !empty($shelter->img)): ?>
                        <div><label><input type='checkbox' name='remove_image' autocomplete='off' /> Remove Image</label></div>
                        <img src='<?php echo $shelter->img ?>' />
                        <?php endif; ?>
                    </div>
                </div>


                <script type='text/javascript'>
                $(document).ready(function(){
                    $(".extra-info").tooltip();
                    
                    $("#dropoffTable .add").click(function(event) {
                        var $row = $(event.currentTarget).closest("tr");
                        var dropoffName = $row.find(".dropoffName").val();
                        var dropoffAddress = $row.find(".dropoffAddress").val();
                        var dropoffDetails = $row.find(".dropoffDetails").val();
                        var dropoffNotes = $row.find(".dropoffNotes").val();

                        if(dropoffName != "" && dropoffAddress != "")
                        {
                            var markup = '<tr>';
                                markup += '<td>' + dropoffName + '<input type="hidden" name="dropoffName[]" value="' + dropoffName +'" /></td>';
                                markup += '<td>' + dropoffAddress + '<input type="hidden" name="dropoffAddress[]" value="' + dropoffAddress +'" /></td>';
                                markup += '<td>' + dropoffNotes + '<input type="hidden" name="dropoffNotes[]" value="' + dropoffNotes +'" /></td>';
                                markup += '<td><a href="#" class="btn btn-xs btn-danger delete">Delete</a></td>';
                                markup +=  '</tr>';
                            $("#dropoffTable tbody").append(markup);
                            $(event.currentTarget).closest("tr").find("input, textarea").val("");
                        }

                        event.preventDefault();
                    });

                    $("#dropoffTable").on("click", ".delete", function(event) {
                        $(event.currentTarget).closest("tr").remove();
                        event.preventDefault();
                    });

                    $("#dropoffTable tfoot").find("input, textarea").keypress(function(event){
                        if(event.which == 13)
                        {
                            $("#dropoffTable .add").click();
                            event.preventDefault();
                        }
                    });
                });
                </script>

                <div class='row'>
                    <div class='form-group dropoffLocations col-md-12'>
                        <label>Drop off locations <a data-toggle="tooltip" title="Click 'Add' to add multiple dropoff locations" class='extra-info'>(?)</a></label>
                        <table id='dropoffTable' class='table'>
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Address</td>
                                    <td>Additional Notes</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($currentDropoffLocations as $dropoff): ?>
                                    <tr>
                                        <td>
                                            <?php echo $dropoff->name ?>
                                            <input type='hidden' name='dropoffName[]' value='<?php echo $dropoff->name ?>' />
                                        </td>
                                        <td>
                                            <?php echo $dropoff->address ?>
                                            <input type='hidden' name='dropoffAddress[]' value='<?php echo $dropoff->address ?>' />
                                        </td>
                                        <td>
                                            <?php echo $dropoff->notes ?>
                                            <input type='hidden' name='dropoffNotes[]' value='<?php echo $dropoff->notes ?>' />
                                        </td>
                                        <td><a href="#" class="btn btn-xs btn-danger delete">Delete</a></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><input type='text' class='dropoffName form-control' /></td>
                                    <td><input type='text' class='dropoffAddress form-control' /></td>
                                    <td><textarea class='dropoffNotes form-control'></textarea></td>
                                    <td><a href='#' class='btn btn-xs btn-info add'>+ Add Dropoff Location</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>


                <div class='form-group'>
                    <input type='submit' class='btn btn-success' value='Save' />
                </div>
            </form>
        </div>
    </div>
</div>

