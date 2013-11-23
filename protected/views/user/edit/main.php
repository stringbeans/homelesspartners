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
	});

});
</script>

<div class='container'>
	<div class='row'>
		<div class='col-md-12'>
			<h2>Edit User</h2>
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
			<form class="form-horizontal" action='<?php echo $this->createUrl("user/save") ?>' method="post">
				<input type='hidden' name='userId' value='<?php echo $user->user_id; ?>' />

				<div class="form-group">
    				<label class="col-sm-2 control-label">Email</label>
    				<div class="col-sm-10">
      					<p class="form-control-static"><?php echo $user->email; ?></p>
    				</div>
  				</div>

				<div class='form-group'>
					<label class="col-sm-2 control-label">Role</label>
					<div class="col-sm-10">
						<select id="role" class='form-control' name='role'>
							<?php foreach ($roles as $role => $name): ?>
							<option value='<?php echo $role; ?>' <?php echo ($user->role_new == $role)?"selected='selected'":"" ?>><?php echo $name; ?></option>	
							<?php endforeach ?>
						</select>
					</div>
				</div>


				<div id="cities" class='form-group'<?php echo ($user->role_new != Users::ROLE_CITY)?' style="display: none;"':''; ?>>
					<label class="col-sm-2 control-label">Cities</label>
					<div class="col-sm-10">
						<select class='form-control' name='cityIds' multiple="multiple" />
							<?php foreach ($cities as $city): ?>
							<option value='<?php echo $city->city_id ?>'<?php echo isset($selectedCityLookup[$city->city_id])?' selected="selected"':''; ?>><?php echo $city->name ?></option>	
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<div id="shelters" class='form-group'<?php echo ($user->role_new != Users::ROLE_SHELTER)?' style="display: none;"':''; ?>>
					<label class="col-sm-2 control-label">Shelters</label>
					<div class="col-sm-10">
						<select class='form-control' name='shelterIds' multiple="multiple" />
							<?php foreach ($shelters as $shelter): ?>
							<option value='<?php echo $shelter->shelter_id ?>'<?php echo isset($selectedShelterLookup[$shelter->shelter_id])?' selected="selected"':''; ?>><?php echo $shelter->name ?></option>	
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<div class='form-group'>
					<input type='submit' class='btn btn-success' value='Save' />
				</div>
			</form>
		</div>
	</div>
</div>