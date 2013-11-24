
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <h2>Explore</h2>
        </div>
    </div>

    <div class="row">
        <div class="panel-group col-md-2" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#filterCity">
                      Filter By City
                    </a>
                  </h4>
                </div>
                <div id="filterCity" class="panel-collapse collapse in">
                  <div class="panel-body">
                    <table>
                        <tbody>
                            <?php foreach($shelters as $shelter): ?>
                            <tr>
                                <td><a href="#"><?php echo $shelter['name'] ?> (<?php echo $shelter['scount'] ?>)</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                  </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#searchKeyword">
                      Search
                    </a>
                  </h4>
                </div>
                <div id="searchKeyword" class="panel-collapse collapse">
                  <div class="panel-body">
                    <div class="form-group">
                        <div class="input-group">                                     
                            <input type="text" class="form-control" placeholder="Search" id="search-query-2">
                            <span class="input-group-btn">
                                <button type="submit" class="btn"><span class="fui-search"></span></button>
                            </span>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
        </div> <!-- end of filter / search -->

        <div class="explore-shelter well col-md-10">
            <div class="row">
                <div class="col-xs-2 col-md-2">
                    <img class="img-rounded" src="http://lorempixel.com/output/city-q-g-640-480-8.jpg">
                </div>
                <div class="col-xs-8 col-md-8">
                    <h5>{SHELTER NAME}</h5>
                    <h6>{SHELTER ADDRESS}</h6>
                    <a href="#" target="_blank">{SHELTER WEBSITE}</a>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger btn-block">Ask Question</button>
                    <button class="btn btn-primary btn-block">Donate Money</button>
                </div>
            </div>
            <div class="row shelter-info">
                <div class="col-xs-12 col-md-12 ">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate</p>
                </div>
            </div>
            <div class="row shelter-stats">
                <div class="col-md-4 text-center">
                    <h6>STORIES<br/>{STORIES COUNT}</h6>
                </div>
                <div class="col-md-4 text-center">
                    <h6>GIFTS<br/>{GIFTS COUNT}</h6>
                </div>
                <div class="col-md-4 text-center">
                    <h6>PLEDGED GIFTS<br/>{PLEDGED COUNT}</h6>
                </div>
            </div>
        </div> <!-- end of explore-shelter -->

        <!-- PHP for each wishlist -->
        <div class="panel panel-default col-md-10">
          <div class="panel-body">
            <div class="row">
                <div class="col-xs-6 col-md-6">
                    <strong>Name:</strong>
                    {PERSON NAME}
                </div>
                <div class="col-xs-6 col-md-6 text-right">
                    <strong>ID:</strong>
                    {PERSON ID}
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate</p>
                </div>
            </div>            
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <table class="table table-hover explore-gifts">
                        <thead>
                            <th>Wish List</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <? php // for each gift ?>
                            <tr>
                                <td class="col-xs-9 gift-name">{GIFT NAME}</td>
                                <td class="col-xs-3"><button class="btn btn-sm btn-info btn-block"><span class="glyphicon glyphicon-gift"></span>Pledge This Gift</button></td>
                            </tr>
                            <? php // end foreach ?>
                            <tr>
                                <td class="col-xs-9 gift-name">{GIFT NAME}</td>
                                <td class="col-xs-3"><button class="btn btn-sm btn-danger btn-block"><span class="glyphicon glyphicon-gift"></span>Unpledge This Gift</button></td>
                            </tr>
                            <tr>
                                <td class="col-xs-9 gift-name">{GIFT NAME}</td>
                                <td class="col-xs-3"><button class="btn btn-sm btn-default btn-block" disabled="disabled"><span class="glyphicon glyphicon-gift"></span>Gifted</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div> <!-- end of wishlist -->
    </div>
</div>