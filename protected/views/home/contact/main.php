<section>
	<div class='container'>
		<div class='row'>
			<div class="col-md-9 center-block">
				<h2>Contact Us</h2>
				<p class="lead">Have a comment, question, or idea? We want to chat with you</p>
				<p>Every aspect of our program is powered by volunteers, homeless people, shelter 
				managers, or donors that use the site. We're more than happy to entertain any new ideas, 
				or answer any questions you may have. Select a contact method of your choice and we'll 
				reply to you within 24 hours.</p>
				<a href="#contact-us" class="btn btn-primary btn-hg">Send us a message</a>
			</div>
		</div>
	</div>
</section>

<section class="section-offset">
	<div class='container'>
		<div class='row'>
			<?php foreach(Yii::app()->user->getFlashes() as $key => $message): ?>
				<div class="alert alert-<?php echo $key ?>" style="margin-top: 20px;">
				<?php echo $message; ?>
				</div>
			<?php endforeach; ?>
			<div class="col-md-9 center-block">
				<div class="map thumbnail">
					<iframe src="https://www.google.com/maps/embed?pb=!1m5!3m3!1m2!1s0x54867170b07d9a93%3A0xfbc9d4f847eec8c8!2s55+E+Cordova+St%2C+Vancouver%2C+BC+V6A+1K3%2C+Canada!5e0!3m2!1sen!2s!4v1386105738334" width="100%" height="600" frameborder="0" style="border:0"></iframe>
				</div>
				</div>
				<div class="text-center">
					<h3 class="lead">
						Homeless Partners
					</h3>
						<p>
						55 East Cordova - Unit 604<br/>
						Vancouver, BC<br/>
						V6A 0A5<br/>
						Canada							
						</p>
					</div>
				</div>
		</div>
	</div>
</section>

<section>
	<div class='container'>
		<div class='row'>
			<div class="col-md-12 text-center">
				<h4 class="section-title">Contact us via social media</h4>
					<?php $social = array(
					'twitter' => array('Twitter','http://twitter.com/homelesspartner'),
					'facebook' => array('Facebook','http://facebook.com/homelesspartners'),
					'googleplus' => array('Google Plus','https://plus.google.com/b/110397886742818442511/110397886742818442511/'),
					'instagram' => array('Instagram','http://instagram.com/homelesspartners'),
					'youtube' => array('YouTube','http://www.youtube.com/channel/UCRBq-7iRdoyErE3fCmcTJ5g/'),
					'linkedin' => array('LinkedIn','http://www.linkedin.com/company/homeless-partners')
				); ?>

				<?php foreach ($social as $classname=>$label): ?>
				<a href="<?php echo $label[1]?>" class="btn btn-social-<?php echo $classname?>">
					<i class="fui-<?php echo $classname?>"></i>
					<?php echo $label[0] ?>
				</a>
				<?php endforeach; ?>
			</div> 
		</div>
	</div>
</section>

<section id="contact-us">
	<div class='container'>
		<div class='row'>
			<div class="col-md-9 center-block">
					<div id="wufoo-r1sfdc9u1dao5ax">
					Fill out my <a href="https://homelesspartners.wufoo.com/forms/r1sfdc9u1dao5ax">online form</a>.
					</div>
					<script type="text/javascript">var r1sfdc9u1dao5ax;(function(d, t) {
					var s = d.createElement(t), options = {
					'userName':'homelesspartners', 
					'formHash':'r1sfdc9u1dao5ax', 
					'autoResize':true,
					'height':'751',
					'async':true,
					'host':'wufoo.com',
					'header':'show', 
					'ssl':true};
					s.src = ('https:' == d.location.protocol ? 'https://' : 'http://') + 'wufoo.com/scripts/embed/form.js';
					s.onload = s.onreadystatechange = function() {
					var rs = this.readyState; if (rs) if (rs != 'complete') if (rs != 'loaded') return;
					try { r1sfdc9u1dao5ax = new WufooForm();r1sfdc9u1dao5ax.initialize(options);r1sfdc9u1dao5ax.display(); } catch (e) {}};
					var scr = d.getElementsByTagName(t)[0], par = scr.parentNode; par.insertBefore(s, scr);
					})(document, 'script');</script>	
			</div> 
		</div>
	</div>
</section>
