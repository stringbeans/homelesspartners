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
		<div id='outstandingPledgeList' class='col-md-12'>
			<h2>View Undelivered Pledges</h2>

			<?php if(Yii::app()->user->hasFlash('success')): ?>
		 	<div class="alert alert-success">
		    <?php echo Yii::app()->user->getFlash('success'); ?>
			</div>
		 	<?php endif; ?>

		 	<input type='text' class='form-control search' placeholder='Search...' />
			
			<table class='table table-hover'>
				<thead>
					<tr>
						<th>Pledger's Email</th>
						<th>Story Id</th>
						<th>Recipient Name</th>
						<th>Gift Description</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody class='list'>
					<?php foreach($undeliveredPledges as $pledge): ?>
					<tr>
						<td class='email'><?php echo $pledge['email'] ?></td>
						<td class='assignedId'><?php echo $pledge['assigned_id'] ?></td>
						<td class='name'><?php echo $pledge['fname'] ?> <?php echo $pledge['lname'] ?></td>
						<td class='description'><?php echo $pledge['description'] ?></td>
						<td>
							<a href='' class='btn btn-success'>Confirm</a>
							<a href='' class='btn btn-danger btn-xs'>Unpledge</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>