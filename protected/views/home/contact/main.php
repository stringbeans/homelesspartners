<section>
	<div class='container'>
		<div class='row'>
			<div class="col-md-9 center-block">
				<h2>Contact Us</h2>
				<p class="lead">Lorem Ipsum is simply dummy text of the printing and typesetting</p>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
				Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
				when an unknown printer took a galley of type and scrambled it to make a type 
				specimen book.</p>
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
					<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2602.4046244683213!2d-123.13806914999999!3d49.2876778!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x548672288c837eef%3A0x9f231c79076c7bbe!2s301-1050+bidwell+street!5e0!3m2!1sen!2s!4v1386093259906" width="100%" height="350" frameborder="0" style="border:0"></iframe></div>
				</div>
				<div class="text-center">
					<h3 class="lead">
						Homeless Partners
					</h3>
						<p>
						123 Parkplace Road<br />
						Victoria, BC Canada<br />
						V6B 4N2<br />
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
