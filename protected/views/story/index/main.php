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
                        
                        <td><a class='btn btn-info btn-xs' href='<?php echo $this->createUrl("story/edit", array('id' => $story['story_id'])) ?>'>Edit</a>
                            <a class='btn btn-danger btn-xs' href='<?php echo $this->createUrl("story/delete", array('id' => $story['story_id'])) ?>'>Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>