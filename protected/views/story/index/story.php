<script type='text/javascript'>
$(document).ready(function(){

    $(".shelter-container").on("click", ".pledge", function(event){
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
    $(".shelter-container").on("click", ".unpledge", function(event){
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
<section>
    <div class="container">
        <p class="lead text-center">Read Their Story And Make A Pledge Today</h2>
        <div class="page-header">
          <h3><?php echo $stories[0]['fname']?>  <?php echo $stories[0]['lname']?> <small class="pull-right">ID: <?php echo $stories[0]['assigned_id']?></small></h3>
        </div>
        <div class="row">
            <div class="col-md-7">
                <p><?php echo $stories[0]['story']?></p>
            </div>
            <div class="col-md-4 col-md-offset-1">
                

                <div class="panel panel-default">
                  <div class="panel-heading">Wish List</div>
                  <ul class="list-group explore-gifts">
                      <?php foreach ($gifts as $gift): ?>
                          <li class="list-group-item">
                            <p class="list-group-item-text"><?php echo $gift['description'] ?></p>
                            <?php if(in_array($gift['gift_id'], $currentPledgeCart) || (!Yii::app()->user->isGuest && ($gift['gift_id'] == Yii::app()->user->id))): ?>
                            <button class="btn btn-danger unpledge" data-id="<?php echo $gift['gift_id'] ?>"><span class="glyphicon glyphicon-gift"></span> Unpledge This Gift</button>
                            <?php elseif (empty($gift['numPledges'])): ?>
                            <button class="btn btn-primary pledge" data-id="<?php echo $gift['gift_id'] ?>"><span class="glyphicon glyphicon-gift"></span> Pledge This Gift</button>    
                            <?php else: ?>
                            <button class="btn btn-default" disabled="disabled"><span class="glyphicon glyphicon-gift"></span> Gifted</button>
                            <?php endif ?>
                          </li>
                      <?php endforeach ?>
                  </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-offset">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h4><?php echo $stories[0]['shelter_name']?><br/><small><?php echo $stories[0]['city_name']?>, <?php echo $stories[0]['region_name']?></small></h4>
                
                <p>
                    <?php echo $stories[0]['shelter_bio']?>
                </p>
                <a class="btn btn-default btn-lg" href="<?php echo $stories[0]['shelter_website']?>" target="_blank">Visit Website</a>
                <a class="btn btn-primary btn-lg" href="<?php echo $this->createUrl("shelter/shelterstories", array('id' => $stories[0]['shelter_id'])) ?>">View more stories from the Living Room</a>

            </div>
            <div class="col-md-4 col-md-offset-1">
                <img class="img-responsive" src="<?php echo $stories[0]['img'] ?>" />
            </div>
        </div>
    </div>
</section>

