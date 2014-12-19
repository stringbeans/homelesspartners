<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script src="//platform.twitter.com/oct.js" type="text/javascript"></script>
<script type="text/javascript">
twttr.conversion.trackPid('l5aof');</script>
<noscript>
<img height="1" width="1" style="display:none;" alt="" src="https://analytics.twitter.com/i/adsct?txn_id=l5aof&p_id=Twitter" />
<img height="1" width="1" style="display:none;" alt="" src="//t.co/i/adsct?txn_id=l5aof&p_id=Twitter" /></noscript>

<div class='container'>
	<div class='row'>
		<div class='col-md-12'>
			<h2>Thank you for your pledge.</h2>

			<?php if(Yii::app()->user->hasFlash('success')): ?>
		 	<div class="alert alert-success">
		    <?php echo Yii::app()->user->getFlash('success'); ?>
			</div>
		 	<?php endif; ?>

		 	<?php if(Yii::app()->user->hasFlash('error')): ?>
		 	<div class="alert alert-danger">
		    <?php echo Yii::app()->user->getFlash('error'); ?>
			</div>
		 	<?php endif; ?>

			<p>Your pledge makes a significant difference in your community, and to every homeless person. We've sent a copy of your pledges to your email address.</p>
			<h3>Next Steps:</h3>
			<p>
				<ol>
					<li><a href='#' onclick='window.print(); return false;'>Print off your order</a></li>
					<li>Purchase pledge(s), wrap it, and attach the assigned id for each gift. Add a personal note for each recipient (optional, but recommended)</li>
					<li>Drop off pledges at corresponding drop off locations before your estimated delivery time</li>
					<li>Help get other gifts pledged by sharing this site with friends and family</li>
				</ol>
			</p>
		</div>
	</div>
	<div class='row'>
		<div class='col-md-12'>
				<a href="https://twitter.com/share" class="twitter-share-button pull-left" data-url="http://www.homelesspartners.com" data-text="I just pledged gifts to those that need it most. To help homeless in your community, visit">Tweet</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

				<div class="fb-share-button pull-left" data-href="http://www.homelesspartners.com" data-type="button_count" style='margin-top: -7px;'></div>
		</div>
	</div>

	<hr/>

	<div class='row'>
		<div class='col-md-12'>	
			<h3>Summary:</h3>
			<pre>
<?php echo $email ?>
			</pre>
		</div>
	</div>
</div>