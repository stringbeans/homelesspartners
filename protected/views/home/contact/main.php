<div class='container'>
	<div class='row'>
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
			<!-- THE MAP GOES HERE -->
		</div>
		<div class="col-md-3">
			<p>Homeless Partners<br />
			123 Some Street<br />
			Vancouver, BC<br />
			123 !@#<br />
			</p>
		</div>

	</div>
	<div class="row">
		<div class='col-md-12'>
			<h3>Contact us via social media</h3>
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
	<div class="row">
		<div class='col-md-12'>
			<h3>Send us a message</h3>
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