<section>
	<div class='container'>
		<div class='row'>
			<?php foreach(Yii::app()->user->getFlashes() as $key => $message): ?>
				<div class="alert alert-<?php echo $key ?>" style="margin-top: 20px;">
				<?php echo $message; ?>
				</div>
			<?php endforeach; ?>
			<div class="col-md-6 pull-left">
				<h3>Contact Us</h3>
				<p class="lead">Lorem Ipsum is simply dummy text of the printing and typesetting</p>
			</div>
			<div class="col-md-5 col-md-offset-1 pull-right text-center">
				<img src="http://placehold.it/300x200"/><br/>
				<p>Homeless Partners<br />
				123 Some Street<br />
				Vancouver, BC<br />
				123 !@#<br />
				</p>
			</div> 
		</div>
	</div>
</section>

<section class="section-offset">
	<div class='container'>
		<div class='row'>
			<div class="col-md-12 text-center">
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

<section>
	<div class='container'>
		<div class='row'>
			<div class="col-md-12 text-center">
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
