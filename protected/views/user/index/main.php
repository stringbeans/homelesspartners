<?php echo Yii::app()->user->role; ?>
<div class='container'>
	<div class='row'>
		<div class='col-md-12'>
			<p class="pull-right"><a href="<?php echo Yii::app()->createUrl('user/edit'); ?>" class="btn btn-info">Create User</a></p>
			<h2>View Users</h2>
			<table class='table table-hover'>
				<?php foreach($users as $user): ?>
				<tr>
					<td><?php echo $user->email; ?></td>
					<td><?php echo $rolesLookup[$user->role_new]; ?></td>
					<td>
						<a class='btn btn-info btn-xs' href='<?php echo $this->createUrl("user/edit", array('id' => $user->user_id)) ?>'>Edit</a>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>