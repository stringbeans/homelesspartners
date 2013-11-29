<div class='container'>

    <?php if(!empty($city->img)): ?>
    <!-- city sponsor -->
	<div class='company-sponsor row'>
        <div class='col-md-12'>
            <?php if(!empty($city->img_link_url)): ?>
            <a href='<?php echo $city->img_link_url ?>' target='_blank'><img class="img-responsive" src="<?php echo $city->img ?>" /></a>
            <?php else: ?>
            <img class="img-responsive" src="<?php echo $city->img ?>" />
            <?php endif; ?>
            
        </div>
	</div>
    <?php endif; ?>

    <!-- Shelters for city -->
    <h3 class="lead section-title"> Wish list collections in <?php echo $city->name ?>, <?php echo $region->name ?></h3>

    <?php foreach($shelters as $shelter): ?>
    <div class="shelter-list row">
        <div class="col-md-12">
            <a href="<?php echo $this->createUrl("shelter/shelterStories", array('id' => $shelter->shelter_id)) ?>" class="shelter row">
                <div class="shelter-photo col-md-4">
                    <img class="img-responsive" src="<?php echo $shelter->img ?>" />
                </div>
                <div class="shelter-details col-md-8">
                    <h4><?php echo $shelter->name ?></h4>
                    <h6><?php echo $city->name ?>, <?php echo $region->name ?></h6>

                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                <?php echo $shelter->bio ?>
                            </p>
                        </div>
                    </div>
                    <?php $shelterStats = $shelter->getStats(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            Total Stories: <?php  echo $shelterStats['totalStories'] ?>
                        </div>
                        <div class="col-md-6">
                        Pledged Gifts: <?php  echo $shelterStats['totalPledges'] ?> of <?php  echo $shelterStats['totalGifts'] ?> 
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <?php endforeach; ?>
</div>