<div class='container'>
	<div class='row'>
		<div class='col-md-12'>
			<h2>Search</h2>
			<p>Use this search dashboard to search all stories ...</p>

			<form method='post'>
				<input type='text' name='query' placeholder='Search term...' value='<?php echo $query?>' />
				<select name='filter'>
					<?php foreach ($filters as $key=>$val): ?>
					<option value='<?php echo $key?>' <?php if ($filter==$key) echo 'selected';?>><?php echo $val?></option>
					<?php endforeach; ?>
				</select>
				<input type='submit' value='Search'/>
			</form>

			<?php if (!empty($results)): ?>
			<div id='results'>
				<!-- TODO - needs styling -->
				<table width="100%">
					<tr>
						<th>Assigned ID</th>
						<th>Name</th>
						<th>City</th>
						<th>Shelter</th>
						<th>Status</th>
						<th>Gift Description</th>
					</tr>
					
					<?php foreach ($results as $result): ?>
					<tr>
						<td><?php echo $result['assigned_id']?></td>
						<td><?php echo ucwords($result['fname']).' '.ucwords($result['lname'])?></td>
						<td><?php echo $result['city_name']?></td>
						<td><?php echo $result['shelter_name']?></td>
						<td><?php echo empty($result['pledge_status']) ? 'Needs pledge' : $result['pledge_status']?></td>
						<td><?php echo $result['gift_description']?></td>

					</tr>
					<?php endforeach;?>
				</table>
			</div>
			<?php else: ?>
				<h3>Sorry, no results found</h3>
				<h4>Please try a different search term.</h4>
			<?php endif; ?>
		</div>
	</div>
</div>