
<div class='container'>
	<div class='row'>
		<div class='col-md-12'>
			<h2>Edit Countries</h2>
			<form action='<?php echo $this->createUrl("country/save") ?>'>
			<table class='table'>
				<?php foreach($countries as $country): ?>
				<tr>
					<td><input type="text"><?php echo $country->country_id ?></input></td>
					<td><input type="text"><?php echo $country->name ?></input></td>
					<td><button type='button' class='btn' href='<?php echo $this->createUrl("country/edit", array('id' => $country->country_id)) ?>'>Edit</button></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>