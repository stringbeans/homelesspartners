<script type='text/javascript'>
$(document).ready(function(){

    $(".shelter-stories-container").on("click", ".pledge", function(event){
        event.preventDefault();

        <?php if(Yii::app()->user->isGuest): ?>

        $("#loginModal").modal("show");

        <?php else: ?>

        $(event.currentTarget).removeClass("pledge").addClass("unpledge").removeClass("btn-primary").addClass("btn-danger").html('<span class="glyphicon glyphicon-gift"></span> Unpledge This Gift');
        
        var giftId = $(event.currentTarget).data("id");
        $.post(
            "<?php echo $this->createUrl("pledge/addPledge") ?>",
            {
                'giftId': giftId
            },
            function() {
                //update cart counter
                if($("#pledgeCartCount").is(":hidden"))
                {
                    $("#pledgeCartCount").text("1").show();
                }
                else
                {
                    $("#pledgeCartCount").text(parseInt($("#pledgeCartCount").text()) + 1);
                }
            }
        )
        <?php endif; ?>
    });

    <?php if(!Yii::app()->user->isGuest): ?>
    $(".shelter-stories-container").on("click", ".unpledge", function(event){
        event.preventDefault();
        $(event.currentTarget).addClass("pledge").removeClass("unpledge").addClass("btn-primary").removeClass("btn-danger").html('<span class="glyphicon glyphicon-gift"></span> Pledge This Gift');
        
        var giftId = $(event.currentTarget).data("id");

        $.post(
            "<?php echo $this->createUrl("pledge/deletePledgeFromSession") ?>",
            {
                'giftId': giftId
            },
            function() {
                var numPledges = parseInt($("#pledgeCartCount").text());
                
                $("#pledgeCartCount").text(numPledges - 1);
                if(numPledges == 1)
                {
                    $("#pledgeCartCount").hide();
                }
            }
        )

    });
    <?php endif;?>
});
</script>

<div class="shelter-container container" style='padding-bottom: 0px;'>

    <!-- shelter -->

    <div class="shelter-information row">
        <div class="col-md-3 col-sm-6">
            <img class="img-responsive" src="<?php echo $shelter->img ?>" />
        </div>

        <div class="col-md-9 col-sm-6">
            <h4><?php echo $shelter->name ?></h4>
            <h6><?php echo $shelter->city->name ?>, <?php echo $shelter->city->region->name ?></h6>
            <?php if(!empty($shelter->website)): ?>
            <a href="<?php echo $shelter->website ?>" target='_blank'><?php echo $shelter->website ?></a>
            <?php endif; ?>
        </div>
    </div>


    <div class="shelter-details row">
        <div class="col-md-12">
            <p>
                <?php echo $shelter->bio ?>
            </p>
        </div>
    </div>

    <?php if(!empty($shelter->shelterDropoffs)): ?>
    <div class="shelter-locations row">
        <div class="col-md-12">
            <h6>Drop off Locations:</h6>
            <ul>
                <?php foreach($shelter->shelterDropoffs as $dropoff): ?>
                <li>
                    <strong>
                        <?php echo $dropoff->name ?>, <?php echo $dropoff->address ?>
                    </strong>
                    <?php if(!empty($dropoff->notes)): ?>
                    , <em><?php echo $dropoff->notes ?></em>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php endif; ?>

    <div class="shelter-stats row">
        <div class="stat col-md-4">
            <strong>Stories</strong>
            <p>
                <?php echo $shelterStats['totalStories'] ?>
            </p>
        </div>
        <div class="stat col-md-4">
            <strong>Gifts</strong>
            <p>
                <?php echo $shelterStats['totalGifts'] ?>
            </p>
        </div>
        <div class="stat col-md-4">
            <strong>Pledged Gifts</strong>
            <p>
                <?php echo $shelterStats['totalPledges'] ?> of <?php echo $shelterStats['totalGifts'] ?>
            </p>
        </div>
    </div>
</div>

<?php if(!empty($shelter->stories)): ?>
<div class="shelter-stories-container container">

    <?php foreach($shelter->stories as $story): ?>
        <div class="shelter-story row">
            <div class="shelter-author col-md-6">
                <?php if(!empty($story->fname)): ?>
                Name: <?php echo $story->fname ?> <?php echo $story->lname ?>
                <?php endif; ?>
            </div>
            <div class="shelter-id col-md-6 text-right">
                ID: <a href='<?php echo $this->createUrl("story/story", array('id' => $story->story_id)) ?>'><?php echo $story->assigned_id ?></a>
            </div>
        </div>
        <div class='shelter-story row' style='margin-top: 0px;'>
            <div class="col-md-12">
                <p>
                    <?php echo htmlspecialchars($story->story) ?>
                </p>
            </div>
        </div>
        <?php foreach($story->gifts as $gift): ?>
            <div class="shelter-gift row">
                <div class="col-md-9 col-xs-6">
                    <?php echo $gift->description ?>
                </div>
                <?php if(in_array($gift->gift_id, $currentPledgeCart)): ?>
                <a class="btn btn-danger col-md-3 col-xs-6 unpledge" data-id='<?php echo $gift->gift_id ?>'><span class="glyphicon glyphicon-gift"></span> Unpledge This Gift</a>
                <?php elseif(!empty($gift->pledges)): ?> 
                <button class="btn btn-default col-md-3 col-xs-6" disabled="disabled"><span class="glyphicon glyphicon-gift"></span>Gifted</button>
                <?php else: ?>
                <a class="btn btn-primary col-md-3 col-xs-6 pledge" data-id='<?php echo $gift->gift_id ?>'><span class="glyphicon glyphicon-gift"></span> Pledge This Gift</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>
<?php endif; ?>