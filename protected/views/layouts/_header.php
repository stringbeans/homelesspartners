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
                        <?php if(in_array(Yii::app()->user->role, array("admin"))): ?>
                            <li><a href="<?php echo $this->createUrl("country/index") ?>">Country</a></li>
                            <li><a href="<?php echo $this->createUrl("region/index") ?>">Region</a></li>
                            <li><a href="<?php echo $this->createUrl("city/index") ?>">City</a></li>
                        <?php endif;?>

                        <?php if(in_array(Yii::app()->user->role, array("admin", "city"))): ?>
                            <li><a href="<?php echo $this->createUrl("shelters/index") ?>">Shelters</a></li>
                            <li><a href="<?php echo $this->createUrl("user/index") ?>">User Management</a></li>
                        <?php endif; ?>

                        <?php if(in_array(Yii::app()->user->role, array("admin", "city", "shelter"))): ?>
                            <li><a href="<?php echo $this->createUrl("pledge/index") ?>">Pledges</a></li>
                        <?php endif; ?>

                        <?php if(in_array(Yii::app()->user->role, array("admin", "city", "shelter", "contributer"))): ?>
                            <li><a href="<?php echo $this->createUrl("story/index") ?>">Stories</a></li>
                        <?php endif; ?>
                        
                    </ul> <!-- /Sub menu -->
                </li>
                <?php endif; ?>
          	</ul> <!-- /nav -->

            <ul class="nav navbar-nav navbar-right">
                
                <?php if (!Yii::app()->user->isGuest): ?>
                    <li>
                        <a href="<?php echo $this->createUrl("pledge/viewCart") ?>">
                            Pledge Cart 
                            <span class="glyphicon glyphicon-shopping-cart" style='font-size: 20px;'></span>
                            <?php if(isset(Yii::app()->session['pledgeCart']) && sizeof(Yii::app()->session['pledgeCart']) > 0): ?>
                            <span class="navbar-new" id='pledgeCartCount' style='margin-right: -12px;'><?php echo sizeof(Yii::app()->session['pledgeCart']) ?></span>
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
                <button type="submit" form='registrationForm' class="btn btn-success">Register</button>
            </div>
        </div>
    </div>  
</div>