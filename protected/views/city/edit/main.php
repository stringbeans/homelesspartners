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
			<?php if(!empty($city)): ?>
			<h2>Edit City</h2>
			<?php else: ?>
			<h2>Create City</h2>
			<?php endif; ?>
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
			<form id='cityForm' action='<?php echo $this->createUrl("city/save") ?>' method='post'>
				<?php if(!empty($city)): ?>
				<input type='hidden' name='cityId' value='<?php echo $city->city_id ?>' />
				<?php endif; ?>

				<div class='form-group'>
					<label>Region</label>
					<select class='form-control' name='regionId' />
						<?php foreach ($regions as $region): ?>
						<option value='<?php echo $region->region_id ?>'><?php echo $region->name ?></option>	
						<?php endforeach ?>
					</select>
				</div>
				<div class='form-group'>
					<label>Name</label>
					<input type='text' class='form-control' name='name' value='<?php echo !empty($city)?$city->name:"" ?>' />
				</div>
				<div class='form-group'>
					<label>Enabled</label>
					<input type="checkbox" name='enabled' <?php (!empty($city) && $city->enabled)?"checked='checked'":"" ?> data-toggle="switch" />
				</div>
				<div class='form-group'>
					<input type='submit' class='btn btn-success' value='Save' />
				</div>
			</form>
		</div>
	</div>
</div>