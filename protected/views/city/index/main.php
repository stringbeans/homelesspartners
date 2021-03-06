<div class='container'>
	<div class='row'>
		<div class='col-md-12'>
			<h2>View Cities</h2>

			<ul class="breadcrumb">
			  	<li>City Management</li>
			  	<li class='active'>View Cities</li>
			</ul>

			<?php if(Yii::app()->user->hasFlash('success')): ?>
		 	<div class="alert alert-success">
		    <?php echo Yii::app()->user->getFlash('success'); ?>
			</div>
		 	<?php endif; ?>

			<?php if(Yii::app()->user->role == "admin"): ?>
				<p class='text-right'>
					<a href='<?php echo $this->createUrl("city/edit") ?>' class='btn btn-warning'>+ Create new</a>
				</p>
			<?php endif; ?>
			<table class='table table-hover'>
					<th>Name</th>
					<th>Shelters</th>
					<th>Stories</th>
					<th>Gift Requests</th>
					<th>Pledged Gifts</th>
				<?php foreach($cities as $city): ?>
				<tr>
					
					<td><a href='<?php echo $this->createUrl("city/cityShelters", array('id' => $city['city_id'])) ?>'><?php echo $city['name'] ?></a></td>
					<td><?php echo $city['numShelters'] ?></td>
					<td><?php echo $city['numStories'] ?></td>
					<td><?php echo $city['numGifts'] ?></td>
					<td><?php echo $city['numPledges'] ?></td>
					<td>
						<a class='btn btn-info btn-xs' href='<?php echo $this->createUrl("city/edit", array('id' => $city['city_id'])) ?>'>Edit</a>
                        <?php if(in_array(Yii::app()->user->role, array(Users::ROLE_ADMIN))): ?>						
						<a class='btn btn-danger btn-xs' href='<?php echo $this->createUrl("city/delete", array('id' => $city['city_id'])) ?>' onclick='return confirm("Deleting this city will delete all things associated with the city. Continue?");'>Delete</a>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>