<div class='container'>
	<div class='row'>
		<div class='text-center' style="margin: 30px 0;">
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
			<form class="form-inline" action='<?php echo $this->createUrl("login/forgotPasswordProcessor") ?>' method="post">
				<p>Enter your email address of your account and we'll send you a recovery link.</p>
  				<div class="form-group">
					<label class="sr-only" for="forget-password-email">Email address</label>
  					<input type="email" class="form-control" name="email" id="forget-password-email" placeholder="Email Address..." style="display: inline; width: 200px;">
  				</div>
  				<button type="submit" class="btn btn-success" style="display: inline">Reset Password</button>
			</form>
		</div>
	</div>
</div>