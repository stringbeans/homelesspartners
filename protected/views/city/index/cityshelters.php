<div class='container'>

    <!-- company sponsor -->
	<div class='company-sponsor row'>
        <div class='col-md-12'>
            <img class="img-responsive" src="http://lorempixel.com/output/city-q-g-851-100-5.jpg" />
        </div>
	</div>

    <!-- Shelters for city -->
    <h3 class="lead section-title"> Wish list collections in <?php echo $shelters[0]['city_name']?> <?php echo $shelters[0]['region_name']?></h3>

    <?php foreach($shelters as $shelter): ?>
    <div class="shelter-list row">
        <div class="col-md-12">
            <a href="<?php echo $this->createUrl("shelter/shelterStories", array('id' => $shelter['shelter_id'])) ?>" class="shelter row">
                <div class="shelter-photo col-md-4">
                    <img class="img-responsive" src="http://lorempixel.com/output/city-q-g-640-480-8.jpg" />
                </div>
                <div class="shelter-details col-md-8">
                    <h4><?php echo $shelter['shelter_name'] ?></h4>
                    <h6><?php echo $shelter['city_name'] ?>, <?php echo $shelter['region_name'] ?></h6>

                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                <?php echo $shelter['shelter_bio'] ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            Total Stories: <?php  echo $shelter['total_stories'] ?>
                        </div>
                        <div class="col-md-6">
                            Pledged Gifts: <?php  echo $shelter['numPledges'] ?> of <?php  echo $shelter['numGifts'] ?> 
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <?php endforeach; ?>
</div>