<div class='container'>
	<div class='row'>
		<div class='col-md-12'>
			<h2>View Regions</h2>

			<ul class="breadcrumb">
			  	<li>Region Management</li>
			  	<li class='active'>View Regions</li>
			</ul>

			<?php if(Yii::app()->user->hasFlash('success')): ?>
		 	<div class="alert alert-success">
		    <?php echo Yii::app()->user->getFlash('success'); ?>
			</div>
		 	<?php endif; ?>

			<p class='text-right'>
				<a href='<?php echo $this->createUrl("region/edit") ?>' class='btn btn-warning'>+ Create new</a>
			</p>
			<table class='table table-hover'>
				<th>Region Name</th>
				<th>Country</th>
				<th>Cities</th>
				<th>Shelters</th>
				<?php foreach($regions as $region): ?>
				<tr>
					<td><?php echo $region['region_name'] ?></td>
					<td><?php echo $region['country_name'] ?></td>
					<td><?php echo $region['numCities'] ?></td>
					<td><?php echo $region['numShelters'] ?></td>					
					<td>
						<a class='btn btn-info btn-xs' href='<?php echo $this->createUrl("region/edit", array('id' => $region['region_id'])) ?>'>Edit</a>
						<a class='btn btn-danger btn-xs' href='<?php echo $this->createUrl("region/delete", array('id' => $region['region_id'])) ?>' onclick='return confirm("Deleting this region will delete all things associated with the region. Continue?");'>Delete</a></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>