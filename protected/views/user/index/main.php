<div class='container'>
	<div class='row'>
		<div class='col-md-12'>
			<h2>View Users</h2>

			<?php if(Yii::app()->user->hasFlash('success')): ?>
		 	<div class="alert alert-success">
		    <?php echo Yii::app()->user->getFlash('success'); ?>
			</div>
		 	<?php endif; ?>

			<table class='table table-hover'>
				<?php foreach($users as $user): ?>
				<tr>
					<td><?php echo $user->email; ?></td>
					<td><?php echo $user->role_new; ?></td>
					<td>
						<a class='btn btn-info btn-xs' href='<?php echo $this->createUrl("user/edit", array('id' => $user->user_id)) ?>'>Edit</a>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>