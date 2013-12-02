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

<div class='container'>
	<div class='row'>
		<div class='col-md-12'>

			<h2>Pledge Cart</h2>

			<?php if(Yii::app()->user->hasFlash('success')): ?>
		 	<div class="alert alert-success">
		    <?php echo Yii::app()->user->getFlash('success'); ?>
			</div>
		 	<?php endif; ?>

		 	<?php if(Yii::app()->user->hasFlash('error')): ?>
		 	<div class="alert alert-danger">
		    <?php echo Yii::app()->user->getFlash('error'); ?>
			</div>
		 	<?php endif; ?>

			
			<p>
				You currently have <strong><?php echo $totalGifts ?> gifts</strong> in your pledge cart for <strong><?php echo sizeof($pledgeCartInfo) ?> shelter lists</strong>. 
				Please confirm each gift, provide an estimated delivery date, and complete your pledge(s). 
				Please review the notes section for each drop off location.
			</p>
		</div>
	</div>
</div>

<?php if(!empty($pledgeCartInfo)): ?>
<form id='pledgeCheckoutForm' action='<?php echo $this->createUrl("pledge/confirmPledges") ?>' method='post'>

<?php foreach ($pledgeCartInfo as $shelterId => $shelter): ?>
	<div class='container' style='background-color: #fffeee; margin-top: 20px; border: 2px solid black'>
		<div class='row'>
			<div class='col-md-12'>
				<table class='table'>
					<tr>
						<td style='width: 1px;'><img src='http://placehold.it/150x150' /></td>
						<td>
							<h4><?php echo $shelter['name']; ?></h4>
							<strong><?php echo $shelter['city'] ?>, <?php echo $shelter['region'] ?></strong> <br/>
							<?php if(!empty($shelter['website'])): ?>
							<a href='<?php echo $shelter['website'] ?>'><?php echo $shelter['website'] ?></a>
							<?php endif; ?>
						</td>
						<td class='text-center'>
							<h6>Gifts for this shelter</h6>
							<h4 id='giftCount'><?php echo $shelter['giftCount'] ?></h4>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<?php if(!empty($shelter['dropoffLocations'])): ?>
		<div class='row'>
			<div class='col-md-12'>
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
		</div>
		<?php endif; ?>
		<div class='row'>
			<div class='col-md-12'>
				<table class='table'>
					<tbody>
						<?php foreach($shelter['stories'] as $story): ?>
						<tr>
							<th>Name: <?php echo $story['fname'] ?> <?php echo $story['lname'] ?></th>
							<th class='text-right'>ID: <?php echo $story['assignedId'] ?></th>
						</tr>
							<?php foreach ($story['gifts'] as $gift): ?>
								<tr>
									<td><?php echo $gift['description'] ?></td>
									<td class='text-right'>
										<a href='#' class='btn btn-danger remove' data-id='<?php echo $gift['giftId'] ?>'><span class='glyphicon glyphicon-gift'></span> Unpledge Gift</a>
										<input type='hidden' name='giftId[]' value='<?php echo $gift['giftId'] ?>' />
									</td>
								</tr>
							<?php endforeach ?>
						
						<?php endforeach; ?>
						<tr>
							<td>Estimated delivery date:</td>
							<td style='width: 300px;'>

								<div class="form-group">
						          	<div class="input-group">
						          	  <span class="input-group-btn">
						          	  	<button class="btn" type="button"><span class="fui-calendar"></span></button>
						          	  </span>
						          	  <input type="text" class="form-control datepicker" name='deliveryDate[<?php echo $shelterId ?>]' value="">
						          	</div>
						          </div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php endforeach ?>

<div class='container' style='margin-top: 20px;'>
	<div class='row'>
		<div class='col-md-12 text-center'>

			<input type='submit' class='btn btn-success col-md-8 col-md-offset-2' value='Complete Pledge Checkout' />
		</div>
	</div>
</div>

</form>
<?php endif; ?>