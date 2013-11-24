<div class='container'>
	<div class='row'>
		<div class="col-md-4 col-md-offset-4">
			<?php foreach(Yii::app()->user->getFlashes() as $key => $message): ?>
        	<div class="alert alert-danger text-center"><?php echo $message; ?></div>
    		<?php endforeach; ?>
			<form action="<?php echo Yii::app()->createUrl('login/loginProcessor'); ?>" method="post">

				<div class="form-group">
	    			<label for="email">Email</label>
	    			<input type="text" class="form-control" id="email" name="email">
	  			</div>
				<div class="form-group">
					<label for="password">Password</label>
	    			<input type="password" class="form-control" id="password" name="password" maxlength="16">
	  			</div>
	  			<div class="form-group">
					<button type="submit" class="btn btn-success">Login</button>
				</div>
			</form>
		</div>
	</div>
</div>