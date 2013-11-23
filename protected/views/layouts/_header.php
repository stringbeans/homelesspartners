<header>
	<div class="navbar navbar-default navbar-fixed-top">
      	<div class="navbar-header">
      		<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-collapse-01"></button>
          	<a href="/" class="navbar-brand">Homeless Partners</a>
      	</div>          
        <div class="navbar-collapse collapse navbar-collapse-01">
          	<ul class="nav navbar-nav">
              <li class='active'>
                  <a href="#">Admin</a>
                  <ul>
                    <li><a href="<?php echo $this->createUrl("country/index") ?>">Country</a></li>
                    <li><a href="<?php echo $this->createUrl("region/index") ?>">Region</a></li>
                    <li><a href="<?php echo $this->createUrl("city/index") ?>">City</a></li>
                    <li><a href="<?php echo $this->createUrl("shelters/index") ?>">Shelters</a></li>
                  </ul> <!-- /Sub menu -->
              </li>
            	
              <?php /*
              <li class="active"><a href="#fakelink">Products</a></li>
            	<li>
              		<a href="#fakelink">Features</a>
              		<ul>
                		<li><a href="#fakelink">Element One</a></li>
                		<li>
                  			<a href="#fakelink">Sub menu</a>
                  			<ul>
                    			<li><a href="#fakelink">Element One</a></li>
		                        <li><a href="#fakelink">Element Two</a></li>
		                        <li><a href="#fakelink">Element Three</a></li>
		                    </ul> <!-- /Sub menu -->
                		</li>
                		<li><a href="#fakelink">Element Three</a></li>
              		</ul> <!-- /Sub menu -->
            	</li>
              */ ?>

                <?php if (!Yii::app()->user->isGuest): ?>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('login/logout'); ?>">Logout</a>
                </li>
                <?php else: ?>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('login/index'); ?>">Login</a>
                </li>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('login/register'); ?>">Register</a>
                </li>
                <?php endif; ?>
          	</ul> <!-- /nav -->


          	<form class="navbar-form navbar-right" action="#">
          		<div class="form-group">
	              	<div class="input-group input-group-sm">
						<input class="form-control" id="navbarInput-02" type="search" placeholder="Search">
						<span class="input-group-btn">
							<button type="submit" class="btn"><span class="fui-search"></span></button>
						</span>            
					</div>
              	</div>                                    
            </form>

    	</div><!--/.nav-collapse -->
   	</div>
</header>