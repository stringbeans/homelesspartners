<script type='text/javascript'>
$(document).ready(function() {

	$("#cities select").selectize({
		plugins: ['remove_button'],
	});

	$("#shelters select").selectize({
		plugins: ['remove_button'],
	});

	$('#role').on('change', function()
	{
		$('#cities').hide();
		$('#shelters').hide();
		if($(this).val() == '<?php echo Users::ROLE_CITY; ?>')
		{
			$('#cities').show();
		}
		else if($(this).val() == '<?php echo Users::ROLE_SHELTER; ?>')
		{
			$('#shelters').show();
		}
		else if($(this).val() == '<?php echo Users::ROLE_CONTRIBUTOR; ?>')
		{
			$('#cities').show();
			$('#shelters').show();
		}
	}).change();

	$('[data-toggle="checkbox"]').each(function () {
  		$(this).checkbox();
	});

	$('#changePassword').on('change', function()
	{
		if($(this).is(':checked'))
		{
			$('#userEditPassword').prop('disabled', false);
		}
		else
		{
			$('#userEditPassword').prop('disabled', true);
			$('#userEditPassword').val('');
		}
	});

	$('#js-user-edit-form').validate({
        submitHandler: function(form) {
            form.submit();
        },
        errorLabelContainer: "#js-registration-message-box",
        onsubmit: true,
        errorElement: "div",
        rules: {
        	'name': 'required',
            'email': {
      			required: true,
      			email: true
    		},
            'password': {
            	required: {
                    depends: function(element) {
                        return $("#changePassword").is(":checked") || $("#changePassword").length == 0;
                    }
                },
      			minlength: 6,
            }
        },
        messages: {
        	name: "Please enter a name",
	    	password: "Password must be minimum 6 characters long",
	    	email: {
	      		required: "Please enter a valid email address"
	    	}
	  	}
	});
});
</script>

<div class='container'>
	<div class='row'>
		<div class='col-md-12'>
			<ul class="breadcrumb" style="margin-top: 20px;">
				<li>User Management</li>
	  			<li><a href="<?php echo Yii::app()->createUrl('user/index'); ?>">View Users</a></li>
	  			<li class="active"><?php echo empty($user)?'Create User':'Edit User'; ?></a></li>
			</ul>
			<?php /*<h2><?php echo empty($user)?'Create User':'Edit User'; ?></h2>*/ ?>
		</div>
		<div class='col-md-12'>
			<?php if(Yii::app()->user->hasFlash('error')): ?>
		 	<div class="alert alert-danger">
		    <?php echo Yii::app()->user->getFlash('error'); ?>
			</div>
		 	<?php endif; ?>

		 	<?php if(Yii::app()->user->hasFlash('success')): ?>
		 	<div class="alert alert-success">
		    <?php echo Yii::app()->user->getFlash('success'); ?>
			</div>
		 	<?php endif; ?>
		</div>
		<div class='col-md-6'>
			<form id="js-user-edit-form" class="form-horizontal" action='<?php echo $this->createUrl("user/save") ?>' method="post">
				<input type='hidden' name='userId' value='<?php echo !empty($user) ? $user->user_id : ''; ?>' />

				<div class="form-group row">
    				<label for="userEditName" class="col-md-2 control-label">Name</label>
    				<div class="col-md-10">
      					<input class="form-control" id="userEditName" value="<?php echo !empty($user) ? $user->name: ''; ?>" name="name" />
    				</div>
  				</div>

				<div class="form-group row">
    				<label for="userEditEmail" class="col-md-2 control-label">Email</label>
    				<div class="col-md-10">
      					<input class="form-control" id="userEditEmail" value="<?php echo !empty($user) ? $user->email: ''; ?>" name="email" />
    				</div>
  				</div>

  				<div class="form-group row">
    				<label for="userEditPassword" class="col-md-2 control-label">Password</label>
    				<div class="col-md-10">
      					<input type="password" class="form-control" id="userEditPassword" name="password" maxlength="16"<?php echo !empty($user)?' disabled="disabled"':''; ?> />
	    				<?php if(!empty($user)): ?>
	  					<div>
	    					<label class="checkbox" style="padding-top: 0; margin-top: 10px;">
	      						<input type="checkbox" id="changePassword" data-toggle="checkbox" /> Change password
	    					</label>
	  					</div>
	  					<?php endif; ?>
    				</div>
    				
  				</div>

				<div class='form-group row'>
					<label class="col-md-2 control-label">Role</label>
					<div class="col-md-10">
						<select id="role" class='form-control' name='role'>
							<?php foreach ($roles as $role => $name): ?>
							<option value='<?php echo $role; ?>' <?php echo ((empty($user) && $role == Users::ROLE_USER) || (!empty($user) && $user->role == $role))?"selected='selected'":"" ?>><?php echo $name; ?></option>	
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<div id="cities" class='form-group row'<?php echo (empty($user) || ($user->role != Users::ROLE_CITY && $user->role != Users::ROLE_CONTRIBUTOR ) )?' style="display: none;"':''; ?>>
					<label class="col-md-2 control-label">Cities </label>
					<div class="col-md-10">
						<select class='form-control' name='cityIds[]' multiple="multiple" />
							<?php foreach ($cities as $city): ?>
							<option value='<?php echo $city->city_id ?>'<?php echo isset($selectedCitiesLookup[$city->city_id])?' selected="selected"':''; ?>><?php echo $city->name ?></option>	
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<div id="shelters" class='form-group row'<?php echo (empty($user) || ($user->role != Users::ROLE_SHELTER && $user->role != Users::ROLE_CONTRIBUTOR))?' style="display: none;"':''; ?>>
					<label class="col-md-2 control-label">Shelters</label>
					<div class="col-md-10">
						<select class='form-control' name='shelterIds[]' multiple="multiple" />
							<?php foreach ($shelters as $shelter): ?>
							<option value='<?php echo $shelter->shelter_id ?>'<?php echo isset($selectedSheltersLookup[$shelter->shelter_id])?' selected="selected"':''; ?>><?php echo $shelter->name ?></option>	
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<div class='form-group row'>
					<div class="col-md-10">
						<input type='submit' class='btn btn-success' value="<?php echo empty($user)?'Create':'Save'; ?>" />
						<div id="js-registration-message-box"></div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>