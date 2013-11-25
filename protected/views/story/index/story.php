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

<div class="shelter-container container">

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <h3>Read Their Story And Make A Pledge Today</h3>
        </div>
    </div>


<!-- PHP for each wishlist -->
        <div class="panel panel-default col-md-12">
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
                            <?php foreach($stories as $story): ?>
                             <tr>
                                <td class="col-xs-9 gift-name"><?php echo $story['gift_description'] ?></td>
                                <?php
                                 $pledge_status=$story['pledge_status'];
                                 if ($pledge_status != "pledged" AND $pledge_status != "droppedoff" AND $pledge_status != "received") {
                                    echo '<td class="col-xs-3"><button class="btn btn-sm btn-info btn-block"><span class="glyphicon glyphicon-gift"></span>Pledge This Gift</button></td>';
                                 } 
                                else{
                                    if (Yii::app()->user->isGuest == 0 AND Yii::app()->user->id == $story['pledge_user']){
                                        echo '<td class="col-xs-3"><button class="btn btn-sm btn-danger btn-block"><span class="glyphicon glyphicon-gift"></span>Unpledge This Gift</button></td>';
                                    }
                                    else
                                        echo '<td class="col-xs-3"><button class="btn btn-sm btn-default btn-block" disabled="disabled"><span class="glyphicon glyphicon-gift"></span>Gifted</button></td>';
                                    }


                                ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div> <!-- end of wishlist -->



<div class="explore-shelter well col-md-12">

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

