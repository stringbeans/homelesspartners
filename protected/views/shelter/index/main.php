
<div class='container'>
    <div class='row'>
        <div class='col-md-12'>
            <h2>View Shelters</h2>
            <table class='table'>
                <?php foreach($shelters as $shelter): ?>
                <tr>
                    <td><?php echo $shelter->shelter_id ?></td>
                    <td><?php echo $shelter->name ?></td>
                    <td><a class='btn btn-info btn-xs' href='<?php echo $this->createUrl("shelter/edit", array('id' => $shelter->shelter_id)) ?>'>Edit</a></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>