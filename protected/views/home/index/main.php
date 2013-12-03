	<?php
		if(!Yii::app()->user->isGuest) {
			//echo Yii::app()->user->role;
		}
		?>

<section class="jumbotron on-dark">
	<div class="img"></div>
	<div class="container">
		<h1>Help Homeless In Your Community</h1>
		<p>Read their story and pledge a Christmas gift today</p>
	</div>
</section>

<section class="mission">
	<div class="container">
		<p class="lead">We're a Not-For-Profit organization on a mission to help homeless people around the world. Our platform allows communities to post personal stories and Christmas wish lists of individual homeless people. <a href="volunteer.html">Join us</a>.</p>
	</div>
</section>

<section>
	<div class="container how-it-works">
		<h2 class="section-title">How It Works</h2>
		<div class="row">
			<div class="col-sm-4">
				<div class="how-icon"><a href="#read-stories"><img src="images/icons/user-interface.svg" alt=""></a></div>
				<h3><a href="#read-stories">Read Stories</a></h3>
				<p>Browse personal stories of people in need near you</p>
			</div>
			<div class="col-sm-4">
				<div class="how-icon"><img src="images/icons/shield.svg" alt=""></div>
				<h3>Pledge</h3>
				<p>Make a pledge to make their wish happen</p>
			</div>
			<div class="col-sm-4">
				<div class="how-icon"><img src="images/icons/gift-box.svg" alt=""></a>
				<h3>Drop Off</h3>
				<p>Attach a personal message. Your gift helps change their life</p>
			</div>
		</div>
	</div>
</section>

<section class="section-offset">
	<div class="seen-on container">
		<div class="row">
			<img src="images/logos/cbc.png" alt="CBC Television"/>
			<img src="images/logos/global.png" alt="GlobalTV"/>
			<img src="images/logos/globeandmail.png" alt="The Globe and Mail"/>
			<img src="images/logos/cbcradio.png" alt="CBC Radio"/>
			<img src="images/logos/metro.png" alt="Metro"/>
		</div>
	</div>
</section>

<section>
	<div class="testimonials container">
		<p class="lead text-center">Together we’ve successfully pledged over <strong>7,000</strong><br/>gifts in <strong>11</strong> cities across North America</p>
		<div class="tab-content">
			<div class="quote-mark"><span>“</span></div>
		  <div class="tab-pane active" id="testimonial-one">
		  	The most encouraging thing is knowing that people care. I find it really encouraging that total strangers could care so much about someone they don't even know.
			</div>
		  <div class="tab-pane" id="testimonial-two">
				I had no idea buying a small gift and writing a personal message for someone who really needs it, could have the potential to make such a big change in someones life 		  </div>
		  <div class="tab-pane" id="testimonial-three">
				Watching the joy on the faces of people at Christmas time getting their Wishlist of their little essentials and how they react when reading the notes that accompany these gifts, is incredibly touching		  </div>
		  <div class="tab-pane" id="testimonial-four">
				Many of our residents do not have the joy of celebrating Christmas with their families so this time together and these personal gifts make a big difference to their spirits		  </div>
		</div>
		<ul class="row nav">
			<li class="media col-sm-3 col-xs-6 active">
				<a href="#testimonial-one" data-toggle="tab">
					<img src="images/faces/anonymous.png" class="img-circle"/>
					<div class="media-body">
						<h3>Anonymous</h3>
						<p>Homeless Person</p>
					</div>
				</a>
			</li>
			<li class="media col-sm-3 col-xs-6">
				<a href="#testimonial-two" data-toggle="tab">
					<img src="images/faces/tawny.png" class="img-circle"/>
					<div class="media-body">
						<h3>Tawny Fontana</h3>
						<p>Donor</p>
					</div>
				</a>
			</li>
			<li class="media col-sm-3 col-xs-6">
				<a href="#testimonial-three" data-toggle="tab">
					<img src="images/faces/karen.png" class="img-circle"/>
					<div class="media-body">
						<h3>Karen O’Shannacery</h3>
						<p>Emergency Aid</p>
					</div>
				</a>
			</li>
			<li class="media col-sm-3 col-xs-6">
				<a href="#testimonial-four"  data-toggle="tab">
					<img src="images/faces/don.png" class="img-circle"/>
					<div class="media-body">
						<h3>Don McTavish</h3>
						<p>Shelter Manager</p>
					</div>
				</a>
			</li>
		</ul>
	</div>
</section>

<section class="section-offset">
	<div class="container">
		<h2 class="section-title">2013 Wish List Counter</h2>
		<table class="stats">
			<tr>
				<td class="stat-metric">
					<h4 class="stat-name">Total stories</h4>
					<strong class="stat-count">451</strong>
				</td>
				<td class="stat-metric">
					<h4 class="stat-name">Gift Requests</h4>
					<strong class="stat-count">1,025</strong>
				</td>
				<td class="stat-metric">
					<h4 class="stat-name">Pledged Gifts</h4>
					<strong class="stat-count">11</strong>
				</td>
			</tr>
		</table>
	</div>
</section>

<section>
	<div class="action container">
		<p class="lead">We’re helping homeless people together with <strong>5,000</strong> donors just like you. <a href="volunteer.html">Join us today</a>.</p>
		<a href="#read-stories" class="btn btn-primary btn-hg">Read Stories Now</a> <a href="volunteer.html" class="btn btn-inverse btn-hg">Volunteer Today</a>
	</div>
</section>

<section id="read-stories">
	<div class="city-stories container">
		<h2 class="section-title">Read Stories From Your City</h2>
		<div class="row">
			<div class="col-sm-6 col-md-4">
				<a href="city/cityShelters?id=18" class="city-tile">
					<img src="images/cities/victoria.png" class="img-responsive"/>
					<h3 class="city-title">Victoria</h3>
				</a>
			</div>
			<div class="col-sm-6 col-md-4">
				<a href="city/cityShelters?id=4" class="city-tile">
					<img src="images/cities/vancouver.png" class="img-responsive"/>
					<h3 class="city-title">Vancouver</h3>
				</a>
			</div>
			<div class="col-sm-6 col-md-4">
				<a href="city/cityShelters?id=7" class="city-tile">
					<img src="images/cities/regina.png" class="img-responsive"/>
					<h3 class="city-title">Regina</h3>
				</a>
			</div>
			<div class="col-sm-6 col-md-4">
				<a href="city/cityShelters?id=7" class="city-tile">
					<img src="images/cities/longbeach.png" class="img-responsive"/>
					<h3 class="city-title">Long Beach</h3>
				</a>
			</div>
			<div class="col-sm-6 col-md-4">
				<a href="city/cityShelters?id=29" class="city-tile">
					<img src="images/cities/northvan.png" class="img-responsive"/>
					<h3 class="city-title">North Vancouver</h3>
				</a>
			</div>
			<div class="col-sm-6 col-md-4">
				<a href="#" class="city-tile">
					<img src="images/cities/newwest.png" class="img-responsive"/>
					<h3 class="city-title">New Westminster</h3>
				</a>
			</div>
			<div class="col-sm-6 col-md-4">
				<a href="#" class="city-tile">
					<img src="images/cities/cloverdale.png" class="img-responsive"/>
					<h3 class="city-title">Cloverdale</h3>
				</a>
			</div>
			<div class="col-sm-6 col-md-4">
				<a href="city/cityShelters?id=28" class="city-tile">
					<img src="images/cities/surrey.png" class="img-responsive"/>
					<h3 class="city-title">Surrey</h3>
				</a>
			</div>
			<div class="col-sm-6 col-md-4">
				<a href="city/cityShelters?id=28" class="add-city">
					<img src="images/cities/add.png" class="img-responsive"/>
				</a>
			</div>
		</div>
	</div>
</section>


