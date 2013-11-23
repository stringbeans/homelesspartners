<div class='container'>
	<div class='row'>
		<div class='col-md-12'>
			<h2>View Cities</h2>

			<?php if(Yii::app()->user->hasFlash('success')): ?>
		 	<div class="alert alert-success">
		    <?php echo Yii::app()->user->getFlash('success'); ?>
			</div>
		 	<?php endif; ?>
			
			<p class='text-right'>
				<a href='<?php echo $this->createUrl("city/edit") ?>' class='btn btn-warning'>+ Create new</a>
			</p>
			<table class='table table-hover'>
				<?php foreach($cities as $city): ?>
				<tr>
					<td><?php echo $city->city_id ?></td>
					<td><?php echo $city->name ?></td>
					<td>
						<a class='btn btn-info btn-xs' href='<?php echo $this->createUrl("city/edit", array('id' => $city->city_id)) ?>'>Edit</a>
						<a class='btn btn-danger btn-xs' href='<?php echo $this->createUrl("city/delete", array('id' => $city->city_id)) ?>'>Delete</a>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>