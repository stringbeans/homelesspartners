<div class='container'>
	<div class='row'>
		<div class='col-md-12'>
			<h2>View Cities</h2>
			<table class='table table-hover'>
				<?php foreach($cities as $city): ?>
				<tr>
					<td><?php echo $city->city_id ?></td>
					<td><?php echo $city->name ?></td>
					<td><a class='btn btn-info btn-xs' href='<?php echo $this->createUrl("city/edit", array('id' => $city->city_id)) ?>'>Edit</a></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>