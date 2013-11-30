
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
            <!--TODO: tried to implement sorting like on the pledge page but couldn't quite figure it out -->

            <table class='table table-hover'>
                <thead>
                    <tr>
                    <th><a class="sort asc" data-sort="name">Name</a></th>
                    <th><a class="sort asc" data-sort="city">City</a></th>
                    <th><a class="sort asc" data-sort="stories">Stories</a></th>
                    <th><a class="sort asc" data-sort="gifts">Gift Requests<a></th>
                    <th><a class="sort asc" data-sort="pledges">Pledged Gifts</a></th>
                    <th>Actions</th>
                    </tr>
                </thead>
                <tbody class='list'>
                <?php foreach($shelters as $shelter): ?>
                <tr>
                    <td class="name"><a href='<?php echo $this->createUrl("shelter/shelterStories", array('id' => $shelter['shelter_id'])) ?>'><?php echo $shelter['shelter_name'] ?></a></td>
                    <td class="city"><?php echo $shelter['city_name'] ?></td>
                    <td class="stories"><?php echo $shelter['numStories'] ?></td>
                    <td class="gifts"><?php echo $shelter['numGifts'] ?></td>
                    <td class="pledges"><?php echo $shelter['numPledges'] ?></td>
                    
                    <td><a class='btn btn-info btn-xs' href='<?php echo $this->createUrl("shelter/edit", array('id' => $shelter['shelter_id'])) ?>'>Edit</a>
                    <?php if(Yii::app()->user->role == Users::ROLE_ADMIN): ?><a class='btn btn-danger btn-xs' href='<?php echo $this->createUrl("shelter/delete", array('id' => $shelter['shelter_id'])) ?>' onclick='return confirm("Deleting this shelter will delete all the stories that belong to this shelter. Continue?");'>Delete</a><?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>