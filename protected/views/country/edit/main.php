<script type='text/javascript'>
$(document).ready(function() {
	$("#countryForm").validate({
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
			<?php if(!empty($country)): ?>
			<h2>Edit Country</h2>

            <ul class="breadcrumb">
                <li>Country Management</li>
                <li><a href="<?php echo $this->createUrl("country/index") ?>">View Countries</a></li>
                <li class='active'>Edit Country</li>
            </ul>

			<?php else: ?>
			<h2>Create Country</h2>

            <ul class="breadcrumb">
                <li>Country Management</li>
                <li><a href="<?php echo $this->createUrl("country/index") ?>">View Countries</a></li>
                <li class='active'>Create Country</li>
            </ul>
			<?php endif; ?>
		</div>



		<div class='col-md-6'>
			<form id='countryForm' action='<?php echo $this->createUrl("country/save") ?>' method='post'>
				<?php if(!empty($country)): ?>
				<input type='hidden' name='countryId' value='<?php echo $country->country_id ?>' />
				<?php endif; ?>
				<div class='form-group'>
					<label>Name</label>
					<input type='text' class='form-control' name='name' value='<?php echo !empty($country)?$country->name:"" ?>' />
				</div>
				
				<div class='form-group'>
					<input type='submit' class='btn btn-success' value='Save' />
				</div>
			</form>
		</div>
	</div>
</div>