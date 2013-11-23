
<div class='container'>
	<div class='row'>
		<div class='col-md-12'>
			<h2>View Countries</h2>
			<table class='table'>
				<?php foreach($countries as $country): ?>
				<tr>
					<td><?php echo $country->country_id ?></td>
					<td><?php echo $country->name ?></td>
					<td><button type='button' class='btn' href='<?php echo $this->createUrl("country/edit", array('id' => $country->country_id)) ?>'>Edit</button></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>