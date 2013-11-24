<div class='container'>

    <!-- company sponsor -->
	<div class='company-sponsor row'>
        <div class='col-md-12'>
            <img class="img-responsive" src="http://lorempixel.com/output/city-q-g-851-100-5.jpg" />
        </div>
	</div>

    <!-- Shelters for city -->
    <div class="shelter-list row">

        <h3 class="lead section-title"> Wish list collections in {CITY},{PROVINCE}</h3>

        <div class="col-md-12">
            <?php for($i=0; $i<=3; $i++) { ?>
            <a href="#" class="shelter row">
                <div class="shelter-photo col-md-4">
                    <img class="img-responsive" src="http://lorempixel.com/output/city-q-g-640-480-8.jpg" />
                </div>
                <div class="shelter-details col-md-8">
                    <h4>{SHELTER.TITLE}</h4>
                    <h6>{CITY},{PROVINCE}</h6>

                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            Total Stories: <?php echo rand(1,16); ?>
                        </div>
                        <div class="col-md-6">
                            Pledged Gifts: <?php echo rand(1,10); ?> of <?php echo rand(10,26); ?>
                        </div>
                    </div>
                </div>
            </a>
            <?php } ?>
        </div>
    </div>


</div>
