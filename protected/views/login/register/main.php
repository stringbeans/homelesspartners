<script type='text/javascript'>
$(document).ready(function() {

	$('#js-registration-form').validate({
        submitHandler: function(form) {
            form.submit();
        },
        errorLabelContainer: "#js-registration-message-box",
        onsubmit: true,
        rules: {
        	'name': 'required',
            'email': {
      			required: true,
      			email: true
    		},
            'password': {
            	required: true,
      			minlength: 6
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
		<div class="col-md-4 col-md-offset-4">
			<?php foreach(Yii::app()->user->getFlashes() as $key => $message): ?>
        	<div class="alert alert-danger text-center"><?php echo $message; ?></div>
    		<?php endforeach; ?>
			<form action="<?php echo Yii::app()->createUrl('login/registerProcessor'); ?>" method="post" id="js-registration-form">
				<div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
				<div class="form-group">
	    			<label for="email">Email</label>
	    			<input type="text" class="form-control" id="email" name="email">
	  			</div>
				<div class="form-group">
					<label for="password">Password</label>
	    			<input type="password" class="form-control" id="password" name="password" maxlength="16">
	  			</div>
	  			<div class="form-group">
					<button type="submit" class="btn btn-success">Register</button>
				</div>
				<div class="alert alert-danger" style="display: none" id="js-registration-message-box"></div>
			</form>
		</div>
	</div>
</div>