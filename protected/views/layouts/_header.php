<header>
	<div class="navbar navbar-default navbar-fixed-top">
      	<div class="navbar-header">
      		<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-collapse-01"></button>
          	<a href="<?php echo Yii::app()->baseUrl ?>/" class="navbar-brand">Homeless Partners</a>
      	</div>          
        <div class="navbar-collapse collapse navbar-collapse-01">
            <ul class="nav navbar-nav">
                <?php if(!Yii::app()->user->isGuest && in_array(Yii::app()->user->role, array('admin','city','shelter','contributor'))): ?>
                <li>
                    <a href="#">Admin</a>
                    <ul>
                        <?php if(in_array(Yii::app()->user->role, array(Users::ROLE_ADMIN))): ?>
                            <li><a href="<?php echo $this->createUrl("country/index") ?>">Country Management</a></li>
                            <li><a href="<?php echo $this->createUrl("region/index") ?>">Region Management</a></li>
                            <li><a href="<?php echo $this->createUrl("city/index") ?>">City Management</a></li>
                        <?php endif;?>

                        <?php if(in_array(Yii::app()->user->role, array(Users::ROLE_ADMIN, Users::ROLE_CITY))): ?>
                            <li><a href="<?php echo $this->createUrl("shelter/index") ?>">Shelter Management</a></li>
                            <li><a href="<?php echo $this->createUrl("user/index") ?>">User Management</a></li>
                        <?php endif; ?>

                        <?php if(in_array(Yii::app()->user->role, array(Users::ROLE_ADMIN, Users::ROLE_CITY, Users::ROLE_SHELTER))): ?>
                            <li><a href="<?php echo $this->createUrl("pledge/index") ?>">Pledge Management</a></li>
                        <?php endif; ?>

                        <?php if(in_array(Yii::app()->user->role, array(Users::ROLE_ADMIN, Users::ROLE_CITY, Users::ROLE_SHELTER, Users::ROLE_CONTRIBUTOR))): ?>
                            <li><a href="<?php echo $this->createUrl("story/index") ?>">Story Management</a></li>
                        <?php endif; ?>
                        
                    </ul> <!-- /Sub menu -->
                </li>
                <?php endif; ?>
                <li>
                    <a href='#'>Cities</a>
                    <?php $cities = Cities::model()->findAll(array(
                        'order' => 'name'
                    )); ?>
                    <ul>
                        <?php foreach ($cities as $city): ?>
                            <li><a href='<?php echo $this->createUrl("city/cityShelters", array('id' => $city->city_id)) ?>'><?php echo $city->name ?></a></li>
                        <?php endforeach ?>
                    </ul>
                <li>

          	</ul> <!-- /nav -->

            <ul class="nav navbar-nav navbar-right">
                
                <?php if (!Yii::app()->user->isGuest): ?>
                    <li>
                        <a href="<?php echo $this->createUrl("pledge/viewCart") ?>">
                            Pledge Cart 
                            <span class="glyphicon glyphicon-shopping-cart" style='font-size: 20px;'></span>
                            <?php if(isset(Yii::app()->session['pledgeCart']) && sizeof(Yii::app()->session['pledgeCart']) > 0): ?>
                            <span class="navbar-new" id='pledgeCartCount' style='margin-right: -12px;'><?php echo sizeof(Yii::app()->session['pledgeCart']) ?></span>
                            <?php else: ?>
                            <span class="navbar-new" id='pledgeCartCount' style='margin-right: -12px; display: none;'><?php echo sizeof(Yii::app()->session['pledgeCart']) ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li><a href="<?php echo Yii::app()->createUrl('login/logout'); ?>">Logout</a></li>
                <?php else: ?>
                    <li><a href="#" data-toggle="modal" data-target="#loginModal">Login</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#registrationModal">Register</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('home/contact'); ?>">Contact</a></li>
                <?php endif; ?>
            </ul>
    	</div><!--/.nav-collapse -->
   	</div>
</header>

<div id='loginModal' class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close fui-cross" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Login</h3>
            </div>

            <div class="modal-body">
                <form id='loginForm' action="<?php echo Yii::app()->createUrl('login/loginProcessor'); ?>" method="post">
                    <input type='hidden' name='redirectUrl' value='<?php echo Yii::app()->request->url ?>' />
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" maxlength="16">
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <a href='#' class='pull-left showRegistration'><small>Or click here to register a new account</small></a>
                <button type="submit" form='loginForm' class="btn btn-success">Login</button>
            </div>
        </div>
    </div>  
</div>

<div id='registrationModal' class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close fui-cross" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Register</h3>
            </div>

            <div class="modal-body">
                <form id='registrationForm' action="<?php echo Yii::app()->createUrl('login/registerProcessor'); ?>" method="post">
                    <input type='hidden' name='redirectUrl' value='<?php echo Yii::app()->request->url ?>' />
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" maxlength="16">
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <a href='#' class='pull-left showLogin'><small>Or click here if you already have an account</small></a>
                <button type="submit" form='registrationForm' class="btn btn-success">Register</button>
            </div>
        </div>
    </div>  
</div>

<script type='text/javascript'>
$(document).ready(function(){
    $(".showRegistration").click(function(event){
        $("#loginModal").modal("hide");
        $("#registrationModal").modal("show");
        event.preventDefault();
    });

    $(".showLogin").click(function(event){
        $("#loginModal").modal("show");
        $("#registrationModal").modal("hide");
        event.preventDefault();
    });
});
</script>