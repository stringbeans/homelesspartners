<div class='container'>
	<div class='row text-center'>
		<?php foreach(Yii::app()->user->getFlashes() as $key => $message): ?>
			<div class="alert alert-<?php echo $key ?>" style="margin-top: 20px;">
			<?php echo $message; ?>
			</div>
		<?php endforeach; ?>
		<h2>Contact Us</h2>
		<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
		Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
		when an unknown printer took a galley of type and scrambled it to make a type 
		specimen book. It has survived not only five centuries, but also the leap into 
		electronic typesetting, remaining essentially unchanged. It was popularised in 
		the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, 
		and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<p>
	</div>

	<div class="row">
		<div class="col-md-3 col-md-offset-3">
			<img src="" width="150" height="150" />
		</div>
		<div class="col-md-3">
			<p>Homeless Partners<br />
			123 Some Street<br />
			Vancouver, BC<br />
			123 !@#<br />
			</p>
		</div>

	</div>

	<div class="row" style="margin-bottom: 20px;">
		<div class='col-md-6 col-md-offset-3'>
		<h3>Send us a message</h3>
			<form action="<?php echo Yii::app()->createUrl('home/contactProcessor'); ?>" method="post">
	  			<div class="form-group">
	    			<label for="name">Name</label>
	    			<input type="text" class="form-control" id="name" name="name">
	  			</div>
	  			<div class="form-group">
	    			<label for="email">Email</label>
	    			<input type="text" class="form-control" id="email" name="email">
	  			</div>
	  			<div class="form-group">
	    			<textarea id="body" name="body" class="form-control" placeholder="Message..." style="height: 150px;"></textarea>
	  			</div>
	  			<button type="submit" class="btn btn-success pull-right">Send</button>
			</form>
		</div>
	</div>
</div>