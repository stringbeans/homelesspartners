<script type='text/javascript'>
$(document).ready(function() {
	$("#regionForm").validate({
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
			<?php if(!empty($region)): ?>
			<h2>Edit Region</h2>
			<?php else: ?>
			<h2>Create Region</h2>
			<?php endif; ?>
		</div>
		<div class='col-md-6'>
			<form id='regionForm' action='<?php echo $this->createUrl("region/save") ?>' method='post'>
				<?php if(!empty($region)): ?>
				<input type='hidden' name='regionId' value='<?php echo $region->region_id ?>' />
				<?php endif; ?>
				
				<div class='form-group'>
					<label>Country</label>
					<select class='form-control' name='countryId' />
						<?php foreach ($countries as $country): ?>
						<option value='<?php echo $country->country_id ?>' <?php echo (!empty($region) && $country->country_id == $region->country_id)?"selected='selected'":"" ?>><?php echo $country->name ?></option>
						<?php endforeach ?>
					</select>
				</div>

				<div class='form-group'>
					<label>Name</label>
					<input type='text' class='form-control' name='name' value='<?php echo !empty($region)?$region->name:"" ?>' />
				</div>
				
				<div class='form-group'>
					<input type='submit' class='btn btn-success' value='Save' />
				</div>
			</form>
		</div>
	</div>
</div>