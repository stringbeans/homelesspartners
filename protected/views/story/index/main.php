
<div class='container'>
    <div class='row'>
        <div class='col-md-12'>
            <h2>View Stories</h2>

            <ul class="breadcrumb">
                <li>Admin</li>
                <li class='active'>View Stories</li>
            </ul>

            <p class='text-right'>
                <a href='<?php echo $this->createUrl("story/edit") ?>' class='btn btn-warning'>+ Create new</a>
            </p>
            <table class='table'>
                <?php foreach($stories as $story): ?>
                <tr>
                    <td><?php echo $story['story_id'] ?></td>
                    <td><?php echo $story['fname'] . ' ' . $story['lname'] ?></td>
                    <td><?php echo $story['city'] ?></td>
                    <td><?php echo $story['shelter'] ?></td>
                    <td><?php echo $story['email'] ?></td>
                    <td><a class='btn btn-info btn-xs' href='<?php echo $this->createUrl("story/edit", array('id' => $story['story_id'])) ?>'>Edit</a>
                        <a class='btn btn-danger btn-xs' href='<?php echo $this->createUrl("story/delete", array('id' => $story['story_id'])) ?>'>Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>