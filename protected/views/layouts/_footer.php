<footer class="bottom-menu bottom-menu-large bottom-menu-inverse on-dark">
	<div class="container">
		<div class="row">
			<div class="col-md-2">
				<a href="/" class="navbar-brand">Homeless Partners</a>
			</div>

			<div class="col-md-2">
			  <h5 class="title">Homeless Partners</h5>
				<ul class="bottom-links">
					<li><a href="<?php echo $this->createUrl("home/about") ?>">About</a></li>
					<li><a href="<?php echo $this->createUrl("home/index") ?>#howItWorks">How It Works</a></li>
					<li><a href="<?php echo $this->createUrl("home/faq") ?>">FAQ</a></li>
					<li><a href="<?php echo $this->createUrl("home/sponsors") ?>">Sponsors</a></li>
					<li><a href="<?php echo $this->createUrl("home/contact") ?>">Contact Us</a></li>
					<?php if(Yii::app()->user->isGuest): ?><li><a href="<?php echo $this->createUrl("login/index") ?>">Login</a></li><?php endif; ?>
					<?php if(Yii::app()->user->isGuest): ?><li><a href="<?php echo $this->createUrl("login/register") ?>">Register</a></li><?php endif; ?>
					<?php /*<li><a href="<?php echo $this->createUrl("home/privacy") ?>">Privacy</a></li> */ ?>
					<?php /*<li><a href="<?php echo $this->createUrl("home/terms") ?>">Terms</a></li> */ ?>
					<li><a href="<?php echo $this->createUrl("search/index") ?>">Search</a></li>
				</ul>
			</div>
			<?php /*
			<div class="col-md-2">
			  <h5 class="title">About Us</h5>
				<ul class="bottom-links">

					<li><a href="#">Team</a></li>
					<li><a href="#">Technology</a></li>
					<li><a href="<?php echo $this->createUrl("home/sponsors") ?>">Sponsors</a></li>
					<li><a href="#">Media</a></li>
				</ul>
			</div>
			 */ ?>

			<div class="col-md-2">
			  <h5 class="title">Explore</h5>
				<ul class="bottom-links">
					<?php foreach ($this->getCityList() as $city): ?>
					<li><a href="<?php echo $this->createUrl("city/cityShelters", array('id' => $city->city_id)) ?>"><?php echo $city->name?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="col-md-2">
			  <h5 class="title">Get Involved</h5>
				<ul class="bottom-links">
					<li><a href="#top">Pledge Gifts</a></li>
					<li><a href="<?php echo $this->createUrl("home/volunteer") ?>">Volunteer</a></li>
					<li><a href="<?php echo $this->createUrl("home/donate") ?>">Donate</a></li>
                    <li><a href="<?php echo $this->createUrl("home/pledgeDay") ?>">Pledge Day 2014</a></li>
                    <li><a href="<?php echo $this->createUrl("home/spreadTheWord") ?>">Spread The Word</a></li>
				</ul>
			</div>

			<div class="col-md-2">
			  <h5 class="title">Get To Know Us</h5>
				<ul class="bottom-links">
					<li><a href="http://facebook.com/homelesspartners">Facebook</a></li>
					<li><a href="http://twitter.com/homelesspartner">Twitter</a></li>
					<li><a href="http://www.linkedin.com/company/homeless-partners">LinkedIn</a></li>
					<li><a href="https://plus.google.com/b/110397886742818442511/110397886742818442511/">Google Plus</a></li>
					<li><a href="http://instagram.com/homelesspartners">Instagram</a></li>
					<li><a href="http://www.youtube.com/channel/UCRBq-7iRdoyErE3fCmcTJ5g/">Youtube</a></li>
				</ul>
			</div>

		</div>
	</div>
</footer>

