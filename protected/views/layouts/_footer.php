<footer class="bottom-menu bottom-menu-large bottom-menu-inverse">
	<div class="container">
		<div class="row">
			<div class="col-md-2 navbar-brand">
				<a href="/">Homeless Partners</a>
			</div>

			<div class="col-md-2">
			  <h5 class="title">Homeless Partners</h5>
				<ul class="bottom-links">
					<li><a href="/how-it-works">How It Works</a></li>
					<li><a href="/contact">Contact Us</a></li>
					<li><a href="/login">Login</a></li>
					<li><a href="/register">Register</a></li>
					<li><a href="/privacy">Privacy</a></li>
					<li><a href="/terms">Terms</a></li>
					<li><a href="/search">Search</a></li>
				</ul>
			</div>

			<div class="col-md-2">
			  <h5 class="title">About Us</h5>
				<ul class="bottom-links">
					<li><a href="/team">Team</a></li>
					<li><a href="/technology">Technology</a></li>
					<li><a href="/sponsors">Sponsors</a></li>
					<li><a href="/media">Media</a></li>
				</ul>
			</div>

			<div class="col-md-2">
			  <h5 class="title">Explore</h5>
				<ul class="bottom-links">
					<?php foreach ($this->getCityList() as $city): ?>
					<li><a href="/city/cityShelters?id=<?php echo $city->city_id?>"><?php echo $city->name?></a></li>
					<?php endforeach; ?>
					<!--
					<li><a href="#fakelink">Victoria</a></li>
					<li><a href="#fakelink">Regina</a></li>
					<li><a href="#fakelink">Long Beach</a></li>
					<li><a href="#fakelink">North Vancouver</a></li>
					<li><a href="#fakelink">New Westminister</a></li>
					<li><a href="#fakelink">Cloverdale</a></li>
					<li><a href="#fakelink">Surrey</a></li>
					-->
				</ul>
			</div>

			<div class="col-md-2">
			  <h5 class="title">Get Involved</h5>
				<ul class="bottom-links">
					<li><a href="#">Pledge Gifts</a></li>
					<li><a href="/volunteer">Volunteer</a></li>
					<li><a href="/donate">Donate</a></li>
				</ul>
			</div>

			<div class="col-md-2">
			  <h5 class="title">Get To Know Us</h5>
				<ul class="bottom-links">
					<li><a href="http://blog.homelesspartners.com">Blog</a></li>
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

