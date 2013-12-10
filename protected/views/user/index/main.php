<div class='container'>
	<div class='row'>
		<div class='col-md-12'>
			<p class="pull-right"><a href="<?php echo Yii::app()->createUrl('user/edit'); ?>" class="btn btn-info">Create User</a></p>
			<h2>View Users</h2>

			<ul class="breadcrumb">
                <li>User Management</li>
                <li class='active'>View Users</li>
            </ul>

            <?php if(Yii::app()->user->hasFlash('error')): ?>
            <div class="alert alert-danger">
            <?php echo Yii::app()->user->getFlash('error'); ?>
            </div>
            <?php endif; ?>

            <?php if(Yii::app()->user->hasFlash('success')): ?>
            <div class="alert alert-success">
            <?php echo Yii::app()->user->getFlash('success'); ?>
            </div>
            <?php endif; ?>

			<table class='table table-hover'>
				<thead>
					<tr>
						<th>Email</th>
						<th>Name</th>
						<th>Role</th>
					</tr>
				</thead>
				<?php foreach($users as $user): ?>
				<tr>
					<td><?php echo $user->email; ?></td>
					<td><?php echo $user->name; ?></td>
					<td><?php echo $rolesLookup[$user->role]; ?></td>
					<td>
						<?php if(Yii::app()->user->role == Users::ROLE_ADMIN || Yii::app()->user->role == Users::ROLE_CITY): ?>
						<a class='btn btn-info btn-xs' href='<?php echo $this->createUrl("user/edit", array('id' => $user->user_id)) ?>'>Edit</a>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>