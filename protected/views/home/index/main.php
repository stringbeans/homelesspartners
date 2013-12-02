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
		<p class="lead">We're a Not-For-Profit organization on a mission to help homeless people around the world. Our platform allows communities to post personal stories and Christmas wish lists of individual homeless people. Join us.</p>
	</div>
</section>

<section>
	<div class="container how-it-works">
		<h2>How It Works</h2>
		<div class="row">
			<div class="col-sm-4">
				<img src="images/icons/user-interface.svg" alt="">
				<h3>Read Stories</h3>
				<p>Browse personal stories of people in need near you</p>
			</div>
			<div class="col-sm-4">
				<img src="images/icons/money.svg" alt="">
				<h3>Pledge</h3>
				<p>Make a pledge to make their wish happen</p>
			</div>
			<div class="col-sm-4">
				<img src="images/icons/gift-box.svg" alt="">
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
		  	Homeless Partners has made a huge difference for the people that we serve. It has allowed the public to personally connect with people's needs and to help ensure that each person receives a meaningful gift at this special time of year.
			</div>
		  <div class="tab-pane" id="testimonial-two">
				Bonbon tart gummi bears. Brownie cake icing candy. Gingerbread chocolate cake chocolate bar gingerbread pastry marzipan donut candy canes halvah. 		  </div>
		  <div class="tab-pane" id="testimonial-three">
				Tootsie roll topping fruitcake. Wafer biscuit candy. Pastry chupa chups tootsie roll muffin bonbon cotton candy gingerbread carrot cake apple pie. Pastry gummi bears muffin bonbon gummies.		  </div>
		  <div class="tab-pane" id="testimonial-four">
				Cupcake cupcake pastry. Powder jelly-o fruitcake biscuit toffee. Jujubes jelly chocolate cake chocolate bar applicake jelly beans sweet roll applicake.		  </div>
		</div>
		<ul class="row nav">
			<li class="media col-sm-3 col-xs-6 active">
				<a href="#testimonial-one" data-toggle="tab">
					<img src="images/faces/129.jpg" class="img-circle"/>
					<div class="media-body">
						<h3>John Smith</h3>
						<p>Homeless Person</p>
					</div>
				</a>
			</li>
			<li class="media col-sm-3 col-xs-6">
				<a href="#testimonial-two" data-toggle="tab">
					<img src="images/faces/128.jpg" class="img-circle"/>
					<div class="media-body">
						<h3>John Smith</h3>
						<p>Pledger</p>
					</div>
				</a>
			</li>
			<li class="media col-sm-3 col-xs-6">
				<a href="#testimonial-three" data-toggle="tab">
					<img src="images/faces/131.jpg" class="img-circle"/>
					<div class="media-body">
						<h3>Rebecca Cochran</h3>
						<p>Shelter Manager</p>
					</div>
				</a>
			</li>
			<li class="media col-sm-3 col-xs-6">
				<a href="#testimonial-four"  data-toggle="tab">
					<img src="images/faces/130.jpg" class="img-circle"/>
					<div class="media-body">
						<h3>Steph Smith</h3>
						<p>City Coordinator</p>
					</div>
				</a>
			</li>
		</ul>
	</div>
</section>

<section class="section-offset">
	<div class="wish-list container">
		<h2>2013 Wish List Counter</h2>
		<table class="table table-bordered">
			<tr>
				<td>
					<h4>Total stories</h4>
					<strong>451</strong>
				</td>
				<td class="col-md-4">
					<h4>Gift Requests</h4>
					<strong>1,025</strong>
				</td>
				<td class="col-md-4">
					<h4>Pledged Gifts</h4>
					<strong>11</strong>
				</td>
			</tr>
		</table>
	</div>
</section>

<section>
	<div class="stories container">
		<h2>Read stories from your city</h2>
		<div class="row">
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
				<a href="city/cityShelters?id=18" class="city-tile">
					<img src="images/cities/victoria.png" class="img-responsive"/>
					<h3 class="city-title">Victoria</h3>
				</a>
			</div>
			<div class="col-sm-6 col-md-4">
				<a href="city/cityShelters?id=29" class="city-tile">
					<img src="images/cities/northvan.png" class="img-responsive"/>
					<h3 class="city-title">North Vancouver</h3>
				</a>
			</div>
			<div class="col-sm-6 col-md-4">
				<a href="city/cityShelters?id=28" class="city-tile">
					<img src="images/cities/surrey.png" class="img-responsive"/>
					<h3 class="city-title">Surrey</h3>
				</a>
			</div>
			<div class="col-sm-6 col-md-4">
				<a href="#" class="city-tile">
					<img src="images/cities/newwest.png" class="img-responsive"/>
					<h3 class="city-title">New Westminster</h3>
				</a>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="action container">
		<p class="lead">We’re helping homeless people together with <strong>5,000</strong><br/>donors just like you. Join us today.</p>
		<a href="#" class="btn  btn-primary btn-lg">Read Stories Now</a> <a href="#" class="btn btn-default btn-lg">Volunteer Today</a>
	</div>
</section>
