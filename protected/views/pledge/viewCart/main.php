<script type='text/javascript'>
	$(document).ready(function(){
		// jQuery UI Datepicker JS init
		var datepickerSelector = '.datepicker';
		$(datepickerSelector).datepicker({
		  showOtherMonths: true,
		  selectOtherMonths: true,
		  dateFormat: "d MM, yy",
		  yearRange: '-1:+1'
		}).prev('.btn').on('click', function (e) {
		  e && e.preventDefault();
		  $(datepickerSelector).focus();
		});

		// Now let's align datepicker with the prepend button
		$(datepickerSelector).datepicker('widget').css({'margin-left': -$(datepickerSelector).prev().find(".btn").outerWidth(), 'margin-top': 300});

		$("a.remove").click(function(event){
			event.preventDefault();
			$(event.currentTarget).closest("tr").remove();

			var giftId = $(event.currentTarget).data("id");

			$.post(
	            "<?php echo $this->createUrl("pledge/deletePledgeFromSession") ?>",
	            {
	                'giftId': giftId
	            },
	            function() {
	                var numPledges = parseInt($("#pledgeCartCount").text());
	                
	                $("#pledgeCartCount").text(numPledges - 1);
	                $("#giftCount").text($("#giftCount").text() - 1);
	                if(numPledges == 1)
	                {
	                    $("#pledgeCartCount").hide();
	                }
	            }
	        )
		});

		$("#pledgeCheckoutForm").validate({
	        submitHandler: function(form) {
	            form.submit();
	        },
	        onsubmit: true,
	        onkeyup: false,
	        focusCleanup: true,
	        messages: {
	        },
	        errorPlacement: function(error, element) {
	        },
	        highlight: function(element, errorClass) {
	            $element = $(element);
	            $element.closest("div.form-group").addClass(errorClass);
	        },
	        unhighlight: function(element, errorClass) {
	            $element = $(element);
	            $element.closest("div.form-group").removeClass(errorClass);
	        },
	        //where to post messages
	        errorClass: "has-error",
	        ignore: ":hidden",
	        rules: {
	        }
	    });

	    $(".datepicker").rules("add", "required");
	});
</script>

<section>
	<div class='container'>
		<div class='row'>
			<div class='col-md-10 col-md-offset-1'>
        <div class="page-header">
          <h3>Pledge Cart</h3>
        </div>
        <?php if(Yii::app()->user->hasFlash('success')): ?>
	       <div class="alert alert-success">
            <button type="button" class="close fui-cross" data-dismiss="alert"></button>
            <?php echo Yii::app()->user->getFlash('success'); ?>
         </div>
        <?php endif; ?>
        <?php if(Yii::app()->user->hasFlash('error')): ?>
        	<div class="alert alert-error">
            <button type="button" class="close fui-cross" data-dismiss="alert"></button>
            <?php echo Yii::app()->user->getFlash('error'); ?>
          </div>
        <?php endif; ?>
				<p>
					You currently have <strong><?php echo $totalGifts ?> gifts</strong> in your pledge cart for <strong><?php echo sizeof($pledgeCartInfo) ?> shelter lists</strong>. 
					Please confirm each gift, provide an estimated delivery date, and complete your pledge(s). 
					Please review the notes section for each drop off location.
				</p>

				<?php if(!empty($pledgeCartInfo)): ?>
				<form id='pledgeCheckoutForm' class="form-horizontal" action='<?php echo $this->createUrl("pledge/confirmPledges") ?>' method='post'>
					<?php foreach ($pledgeCartInfo as $shelterId => $shelter): ?>
					<div class="panel panel-default pledge-checkout">
					  <!-- Default panel contents -->
					  <div class="panel-heading">
					    <div class="media">
							  <a class="pull-left hidden-xs" href="#">
							    <img class="media-object" src="http://placehold.it/80x80" alt="...">
							  </a>
							  <div class="media-body pull-left">
							    <h4 class="media-heading"><?php echo $shelter['name']; ?><br/><small><?php echo $shelter['city'] ?>, <?php echo $shelter['region'] ?></small></h4>
							  </div>
							  <div class="stat-metric pull-right hidden-xs">
											<h4 class="stat-name">Total Gifts</h4>
											<strong class="stat-count"><?php echo $shelter['giftCount'] ?></strong>
							  </div>
							</div>
					  </div><!-- /panel-heading -->
					  <div class="panel-body">
					  	<div class="row">
				    		<div class="col-sm-7">
				    			<div class="form-group">
				    				<label class="col-sm-6 control-label">Estimated delivery date</label>
				          	<div class="col-sm-6 input-group">
				          	  <span class="input-group-btn">
				          	  	<button class="btn" type="button"><span class="fui-calendar"></span></button>
				          	  </span>
				          	  <input type="text" class="form-control datepicker" name='deliveryDate[<?php echo $shelterId ?>]' value="">
				          	</div>
				          </div>
				    		</div>
				    	</div>
							<table class='table'>
								<?php foreach ($shelter['dropoffLocations'] as $location): ?>
								<tr>
									<td rowspan='3' style='width: 1px'>Drop off location</td>
									<td><label><strong>Name:</strong></label> <?php echo $location->name ?></td>
								</tr>
								<tr>
									<td><label><strong>Address:</strong></label> <?php echo $location->address ?></td>
								</tr>
								<tr>
									<td><label><strong>Notes:</strong></label> <?php echo $location->notes ?></td>
								</tr>	
								<?php endforeach ?>
							</table>
					  </div>

						<ul class="list-group">
							<?php foreach($shelter['stories'] as $story): ?>
					    <li class="list-group-item">
					    	<h4 class="list-group-item-heading"><?php echo $story['fname'] ?> <?php echo $story['lname'] ?> <small><?php echo $story['assignedId'] ?></small></h4>
						    <table class="table">
			            <tbody>
			            	<?php foreach ($story['gifts'] as $gift): ?>
			              <tr class="checkout-item">
			                <td><?php echo $gift['description'] ?></td>
			                <td><a href='#' class='btn btn-danger remove' data-id='<?php echo $gift['giftId'] ?>'><span class='glyphicon glyphicon-gift'></span> Unpledge Gift</a>
													<input type='hidden' name='giftId[]' value='<?php echo $gift['giftId'] ?>' /></td>
			              </tr>
			              <?php endforeach ?>
			            </tbody>
			          </table>
					    </li>
					    <?php endforeach; ?>

					  </ul><!-- /list-group -->
					</div><!-- /pledge-checkout -->
					<?php endforeach ?>
					<button type="submit" class="btn btn-hg btn-success pull-right">
				    <span class="fui-check-inverted"></span> Complete Pledge Checkout
				  </button>
				</form>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
