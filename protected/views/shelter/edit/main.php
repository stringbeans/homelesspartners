
<div class='container'>
	<div class='row'>
		<div class='col-md-12'>
			<h2>Edit Shelter</h2>
			<form action='<?php echo $this->createUrl("shelter/save") ?>'>
			<table class='table'>
				<?php foreach($countries as $country): ?>
				<tr>
					<td><input type="text"><?php echo $country->country_id ?></input></td>
					<td><input type="text"><?php echo $country->name ?></input></td>
					<td><a class='btn-info btn-xs' href='<?php echo $this->createUrl("shelter/edit", array('id' => $country->country_id)) ?>'>Edit</a></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>