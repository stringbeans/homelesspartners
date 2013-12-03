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

<section class="section-offset">
    <div class="container shelter-container">
        <div class="row">
            <div class="col-md-7">
                <h4><?php echo $shelter->name ?><br/><small><?php echo $shelter->city->name ?>, <?php echo $shelter->city->region->name ?></small></h4>
                <p>
                    <?php echo $shelter->bio ?>
                </p>
                <?php if(!empty($shelter->website)): ?>
                <a class="btn btn-default btn-lg" href="<?php echo $shelter->website ?>" target='_blank'>Visit Website</a>
                <?php endif; ?>
            </div>
            <div class="col-md-4 col-md-offset-1">
                <img class="img-responsive" src="<?php echo $shelter->img ?>" />
            </div>
        </div>
        <div class="shelter-locations row">
            <?php if(!empty($shelter->shelterDropoffs)): ?>
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
            <?php endif; ?>
        </div>
        <div class="row">
            <table class="stats">
                <tr>
                    <td class="stat-metric">
                        <h4 class="stat-name">Stories</h4>
                        <strong class="stat-count"><?php echo $shelterStats['totalStories'] ?></strong>
                    </td>
                    <td class="stat-metric">
                        <h4 class="stat-name">Gifts</h4>
                        <strong class="stat-count"><?php echo $shelterStats['totalGifts'] ?></strong>
                    </td>
                    <td class="stat-metric">
                        <h4 class="stat-name">Pledged Gifts</h4>
                        <strong class="stat-count"><?php echo $shelterStats['totalPledges'] ?> of <?php echo $shelterStats['totalGifts'] ?></strong>
                    </td>
                </tr>
            </table>
        </div>
</section>
<?php if(!empty($stories)): ?>
<section>
    <?php foreach($stories as $story): ?>
    <div class="container shelter-stories-container">
        <div class="page-header">
          <h3><a href="<?php echo $this->createUrl("story/story", array('id' => $story['story_id'])) ?>'"><?php if(!empty($story['fname'])): ?><?php echo $story['fname'] ?> <?php echo $story['lname'] ?>
          <?php endif; ?></a><small class="pull-right">ID: <?php echo $story['assigned_id'] ?></small></h3>
        </div>
        <div class="row">
            <div class="col-md-7">
                <p><?php echo htmlspecialchars($story['story']) ?></p>
            </div>
            <div class="col-md-4 col-md-offset-1">
                <div class="panel panel-default">
                  <div class="panel-heading">Wish List</div>
                  <ul class="list-group explore-gifts">
                      <?php foreach($story['gifts'] as $gift): ?>
                          <li class="list-group-item">
                            <p class="list-group-item-text"><?php echo $gift['description'] ?></p>
                            <?php if(in_array($gift['gift_id'], $currentPledgeCart)): ?>
                            <a class="btn btn-danger unpledge" data-id='<?php echo $gift['gift_id'] ?>'><span class="glyphicon glyphicon-gift"></span> Unpledge This Gift</a>
                            <?php elseif(!empty($gift['hasPledge'])): ?> 
                            <button class="btn btn-default" disabled="disabled"><span class="glyphicon glyphicon-gift"></span>Gifted</button>
                            <?php else: ?>
                            <a class="btn btn-primary pledge" data-id='<?php echo $gift['gift_id'] ?>'><span class="glyphicon glyphicon-gift"></span> Pledge This Gift</a>
                            <?php endif; ?>
                          </li>
                      <?php endforeach ?>
                  </ul>
                </div>
            </div>
        </div><!-- /row -->
    </div>
    <?php endforeach; ?>
</section>
<?php endif; ?>