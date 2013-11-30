
<div class='container'>
    <div class='row'>
        <div class='col-md-12'>
            <h2>View Shelters</h2>

            <ul class="breadcrumb">
                <li>Shelter Management</li>
                <li class='active'>View Shelters</li>
            </ul>
            <p class='text-right'>
                <a href='<?php echo $this->createUrl("shelter/edit") ?>' class='btn btn-warning'>+ Create new</a>
            </p>
            <table class='table'>
                    <th>Name</th>
                    <th>City</th>
                    <th>Stories</th>
                    <th>Gift Requests</th>
                    <th>Pledged Gifts</th>

                <?php foreach($shelters as $shelter): ?>
                <tr>
                    <td><?php echo $shelter['shelter_name'] ?></td>
                    <td><?php echo $shelter['city_name'] ?></td>
                    <td><?php echo $shelter['numStories'] ?></td>
                    <td><?php echo $shelter['numGifts'] ?></td>
                    <td><?php echo $shelter['numPledges'] ?></td>
                    
                    <td><a class='btn btn-info btn-xs' href='<?php echo $this->createUrl("shelter/edit", array('id' => $shelter['shelter_id'])) ?>'>Edit</a>
                        <a class='btn btn-danger btn-xs' href='<?php echo $this->createUrl("shelter/delete", array('id' => $shelter['shelter_id'])) ?>' onclick='return confirm("Deleting this shelter will delete all the stories that belong to this shelter. Continue?");'>Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>