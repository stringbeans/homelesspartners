<script type='text/javascript'>
$(document).ready(function(){

    $(".story-container").on("click", ".pledge", function(event){
        event.preventDefault();

        <?php if(Yii::app()->user->isGuest): ?>

        $("#loginModal").modal("show");

        <?php else: ?>

        $(event.currentTarget).removeClass("pledge").addClass("unpledge").removeClass("btn-info").addClass("btn-danger").html('<span class="glyphicon glyphicon-gift"></span> Unpledge This Gift');
        
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
    $(".story-container").on("click", ".unpledge", function(event){
        event.preventDefault();
        $(event.currentTarget).addClass("pledge").removeClass("unpledge").addClass("btn-info").removeClass("btn-danger").html('<span class="glyphicon glyphicon-gift"></span> Pledge This Gift');
        
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

<div class="story-container container">



<!-- PHP for each wishlist -->
        <div class="panel panel-default col-md-10">
          <div class="panel-body">
            <div class="row">
                <div class="col-xs-6 col-md-6">
                    <strong>Name:</strong>
                    <?php echo $stories[0]['fname']?>  <?php echo $stories[0]['lname']?>
                </div>
                <div class="col-xs-6 col-md-6 text-right">
                    <strong>ID:</strong>
                    <?php echo $stories[0]['assigned_id']?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <p><?php echo $stories[0]['story']?></p>
                </div>
            </div>            
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <table class="table table-hover explore-gifts">
                        <thead>
                            <th>Wish List</th>
                            <th></th>
                        </thead>
                        <tbody>

                            <?php foreach ($gifts as $gift): ?>
                                <tr>
                                    <td class="col-xs-9 gift-name"><?php echo $gift['description'] ?></td>
                                    <td class="col-xs-3">
                                        <?php if(in_array($gift['gift_id'], $currentPledgeCart) || (!Yii::app()->user->isGuest && ($gift['user_id'] == Yii::app()->user->id))): ?>
                                        <button class="btn btn-sm btn-danger btn-block unpledge" data-id="<?php echo $gift['gift_id'] ?>"><span class="glyphicon glyphicon-gift"></span>Unpledge This Gift</button>
                                        <?php elseif (empty($gift['numPledges'])): ?>
                                        <button class="btn btn-sm btn-info btn-block pledge" data-id="<?php echo $gift['gift_id'] ?>"><span class="glyphicon glyphicon-gift"></span>Pledge This Gift</button>    
                                        <?php else: ?>
                                        <button class="btn btn-sm btn-default btn-block" disabled="disabled"><span class="glyphicon glyphicon-gift"></span>Gifted</button>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div> <!-- end of wishlist -->



<div class="explore-shelter well col-md-10">

    <div class="row">
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

