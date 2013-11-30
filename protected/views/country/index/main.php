<div class='container'>
	<div class='row'>
		<div class='col-md-12'>
			
			<h2>View Countries</h2>

			<ul class="breadcrumb">
			  <li>Country Management</li>
			  <li class='active'>View Countries</li>
			</ul>

			<?php if(Yii::app()->user->hasFlash('success')): ?>
		 	<div class="alert alert-success">
		    <?php echo Yii::app()->user->getFlash('success'); ?>
			</div>
		 	<?php endif; ?>

			<p class='text-right'>
				<a href='<?php echo $this->createUrl("country/edit") ?>' class='btn btn-warning'>+ Create new</a>
			</p>
			<table class='table table-hover'>
				<th>Name</th>
				<th>Regions</th>
				<th>Cities</th>
				<th>Shelters</th>
				<?php foreach($countries as $country): ?>
				<tr>
					<td><?php echo $country['name'] ?></td>
					<td><?php echo $country['numRegions'] ?></td>
					<td><?php echo $country['numCities'] ?></td>
					<td><?php echo $country['numShelters'] ?></td>
					<td><a class='btn btn-info btn-xs' href='<?php echo $this->createUrl("country/edit", array('id' => $country['country_id'])) ?>'>Edit</a>
					<a class='btn btn-danger btn-xs' href='<?php echo $this->createUrl("country/delete", array('id' => $country['country_id'])) ?>' onclick='return confirm("Deleting this country will delete all things associated with the country. Continue?");'>Delete</a></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>