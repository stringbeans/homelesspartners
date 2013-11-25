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
			<form class="form" action='<?php echo $this->createUrl("login/resetPasswordProcessor") ?>' method="post">
				<p>Enter your email address and your new password</p>
  				<input type='hidden' name='resetPasswordKey' value='<?php echo $resetPasswordKey; ?>' />
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" maxlength="16">
                </div>
  				<button type="submit" class="btn btn-success" style="display: inline">Reset Password</button>
			</form>
		</div>
	</div>
</div>