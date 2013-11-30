<script type='text/javascript'>
$(document).ready(function() {

	$('#js-reset-password-form').validate({
        submitHandler: function(form) {
            form.submit();
        },
        errorLabelContainer: "#js-registration-message-box",
        onsubmit: true,
        rules: {
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
		<div class="col-md-5 col-md-offset-4" style="margin-top: 30px; margin-bottom: 30px;">
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
			<form id="js-reset-password-form" class="form" action='<?php echo $this->createUrl("login/resetPasswordProcessor") ?>' method="post">
				<p>Enter your email address and your new password</p>
  				<input type='hidden' name='resetPasswordKey' value='<?php echo $resetPasswordKey; ?>' />
  				<input type='hidden' name='userId' value='<?php echo $userId; ?>' />
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" maxlength="16">
                </div>
  				<button type="submit" class="btn btn-success" style="display: inline">Reset Password</button>
  				<div class="alert alert-danger" style="display: none" id="js-registration-message-box"></div>
			</form>
		</div>
	</div>
</div>