<script type='text/javascript'>
$(document).ready(function(){

    $(".story-container").on("click", ".pledge", function(event){
        event.preventDefault();
        $(event.currentTarget).removeClass("pledge").addClass("unpledge").removeClass("btn-primary").addClass("btn-danger").text("Unpledge This Gift");
        $.post(
            "<?php echo $this->createUrl("pledge/addPledge") ?>",
            {

            },
            function() {
                //update cart counter
            }
        )
    });
});
</script>

<div class="story-container container">

    <!-- story -->
    <div class="shelter-story row">
        <div class="shelter-author col-md-6">
            Name: <?php echo $stories[0]['fname']?> <?php echo $stories[0]['lname']?>
        </div>
        <div class="shelter-id col-md-6">
            ID: <a href="#"><?php echo $stories[0]['assigned_id']?></a>
        </div>

        <div class="col-md-12">

            <p>
                <small>
                <?php echo $stories[0]['story']?>
                </small>
            </p>

        </div>
    </div>
    

    <?php foreach($stories as $story): ?>
        <div class="shelter-gift row">

         <?php $pledge_status=$story['pledge_status']?>
            <?php
             
            if ($pledge_status != "pledged") {
               echo '<div class="col-md-9 col-xs-6">'. $story['gift_description'] . '</div>';
               echo '<a class="btn btn-primary col-md-3 col-xs-6">Pledge This Gift</a>';
                //echo Yii::app()->user->id;
            }
            else{
               if (Yii::app()->user->isGuest == 0 AND Yii::app()->user->id == $story['pledge_user']){
                    echo '<div class="col-md-9 col-xs-6">'. $story['gift_description'] . '</div>';
                    echo '<a class="btn btn-danger col-md-3 col-xs-6">Unpledge This Gift</a>';
                }
            }
         ?>
    </div>
    <?php endforeach; ?>
</div>

<div class="shelter-container container">

    <div class="shelter-information row">
        <div class="col-md-3">
            <img class="img-responsive" src="http://lorempixel.com/output/city-q-g-640-480-8.jpg" />
        </div>

        <div class="col-md-7">
            <h4><?php echo $stories[0]['shelter_name']?></h4>
            <h6><?php echo $stories[0]['city_name']?>, <?php echo $stories[0]['region_name']?></h6>
            <a href="<?php echo $stories[0]['shelter_website']?>" target="_blank"><?php echo $stories[0]['shelter_website']?></a>

            <p>
                <?php echo $stories[0]['shelter_bio']?>
            </p>
        </div>

    </div>

    <div class="col-md-12 text-center">
        <a href="<?php echo $this->createUrl("shelter/shelterstories", array('id' => $stories[0]['shelter_id'])) ?>">View more stories from the Living Room</a>
    </div>


</div>

