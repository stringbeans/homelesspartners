<script type='text/javascript'>
$(document).ready(function(){
    
    var options = {
        valueNames: ['name', 'city', 'shelter', 'email', 'assignedId']
    };
    var pledgeList = new List('storiesList', options);
});
</script>

<div class='container'>
    <div class='row'>
        <div class='col-md-12' id='storiesList'>
            <h2>View Stories</h2>

            <ul class="breadcrumb">
                <li>Story Management</li>
                <li class='active'>View Stories</li>
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


            <p class='text-right'>
                <a href='<?php echo $this->createUrl("story/edit") ?>' class='btn btn-warning'>+ Create new</a>
            </p>

            <input type='text' class='form-control search' placeholder='Filter by anything. Begin typing...' />

            <table class='table'>
                <thead>
                    <tr>
                        <th>Interviewer Email</th>
                        <th>Assigned ID</th>
                        <th>City</th>
                        <th>Shelter</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class='list'>
                    <?php foreach($stories as $story): ?>
                    <tr>
                        <td class='email'><?php echo $story['email'] ?></td>
                        <td class='assignedId'><?php echo $story['assigned_id'] ?></td>
                        <td class='city'><?php echo $story['city'] ?></td>
                        <td class='shelter'><?php echo $story['shelter'] ?></td>
                        <td class='name'><?php echo $story['fname'] . ' ' . $story['lname'] ?></td>
                        
                        <td>
                            <?php /* Now only listing stories that the user can edit so always just show these. */ ?>
                            <?php //if(Yii::app()->user->id == $story['creator_id'] || Yii::app()->user->role == Users::ROLE_ADMIN): ?>
                            <a class='btn btn-info btn-xs' href='<?php echo $this->createUrl("story/edit", array('id' => $story['story_id'])) ?>'>Edit</a>
                            <a class='btn btn-danger btn-xs' href='<?php echo $this->createUrl("story/delete", array('id' => $story['story_id'])) ?>' onclick='return confirm("Are you sure you want to delete this story? This will delete all the pledges for it. Continue?");'>Delete</a>
                            <?php //endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>