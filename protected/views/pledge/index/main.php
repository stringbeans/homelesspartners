<script type='text/javascript'>
$(document).ready(function(){
	
	var options = {
        valueNames: ['email', 'assignedId', 'name', 'description']
    };
	var pledgeList = new List('outstandingPledgeList', options);
});
</script>
<div class='container'>
	<div class='row'>
		<div class='col-md-12'>
			<h2>View Undelivered Pledges</h2>

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
		</div>

		<div id='outstandingPledgeList' class='col-md-12'>
			<input type='text' class='form-control search' placeholder='Search...' />
			<table class='table table-hover'>
				<thead>
					<tr>
						<th><a class="sort asc" data-sort="email">Pledger's Email</a></th>
						<th><a class="sort asc" data-sort="deliveryDateTime">Estimated Delivery Date</a></th>
						<th><a class="sort asc" data-sort="assignedId">Story Id</a></th>
						<th><a class="sort asc" data-sort="name">Recipient Name</a></th>
						<th><a class="sort asc" data-sort="description">Gift Description</a></th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody class='list'>
					<?php foreach($pledges as $pledge): ?>
					<tr>
						<td class='email'>
							<?php echo $pledge['email'] ?>
							<?php if(!empty($pledge['message'])): ?>
							<a class='popover-link' data-container="body" data-toggle="popover" data-placement="top" data-content='<?php echo addslashes($pledge['message']) ?>' data-original-title="" title="">
        						<small>(View Message)</small>
        					</a>
        					<?php endif; ?>
						</td>
						<td class='deliveryDate'><?php echo date("M j, Y", strtotime($pledge['estimated_delivery_date'])) ?></td>
						<td class='deliveryDateTime' style='display: none;'><?php echo strtotime($pledge['estimated_delivery_date']) ?></td>
						<td class='assignedId'><?php echo $pledge['assigned_id'] ?></td>
						<td class='name'><?php echo $pledge['fname'] ?> <?php echo $pledge['lname'] ?></td>
						<td class='description'><?php echo $pledge['description'] ?></td>
						<td>
							<?php if($pledge['status'] == 'pledged'): ?>
							<a href='<?php echo $this->createUrl("pledge/setStatus", array('id' => $pledge['pledge_id'], 'status' => 'droppedoff')) ?>' class='btn btn-success'>Confirm dropoff</a>
							<a href='<?php echo $this->createUrl("pledge/delete", array('id' => $pledge['pledge_id'])) ?>' class='btn btn-danger btn-xs' onclick='return confirm("Are you sure you want to unpledge this? This pledge will be deleted. Continue?")'>Unpledge</a>
							<?php elseif($pledge['status'] == 'droppedoff'): ?>
							<a href='<?php echo $this->createUrl("pledge/setStatus", array('id' => $pledge['pledge_id'], 'status' => 'received')) ?>' class='btn btn-success'>Confirm Received</a>
							<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>