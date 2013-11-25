
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <h2>Explore</h2>
        </div>
    </div>

    <div class="row">
        <div class="panel-group col-md-3" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#filterCity">
                      Filter By City / Shelter
                    </a>
                  </h4>
                </div>
                <div id="filterCity" class="panel-collapse collapse in">
                  <div class="panel-body">
                    <select id="selectCity" class="col-md-12" placeholder="Please select a city...">
                        <?php foreach ($cities as $city) { ?>
                            <optgroup label="<?php echo $city->cityInfo->name; ?>">
                                <option value="C<?php echo $city->cityInfo->city_id; ?>"
                                    <?php if ($currentCity && $currentCity->city_id == $city->cityInfo->city_id) { echo 'selected="selected"'; } ?>>All Shelters</option>
                                <?php foreach ($city->shelters as $shelter) { ?>
                                    <option value="<?php echo $shelter['shelter_id']; ?>"
                                    <?php if ($currentShelter && $currentShelter->shelter_id == $shelter['shelter_id']) { echo 'selected="selected"'; } ?>><?php echo $shelter['shelter_name']; ?></option>
                                <?php } ?>
                            </optgroup>
                        <?php } ?>
                    </select>
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

        <div class="col-md-9">
            <div class="well">
              <h4>Sponsored By: {SPONSOR NAME}</h4>
              <p>{SPONSOR DESCRIPTION}</p>
            </div>
            <?php if ($currentShelter) { ?>
            <div class="explore-shelter well">
                <div class="row">
                    <div class="col-xs-3 col-md-3">
                        <img class="img-rounded" src="http://lorempixel.com/output/city-q-g-640-480-8.jpg">
                    </div>
                    <div class="col-xs-6 col-md-6">
                        <h5>{SHELTER NAME}</h5>
                        <h6>{SHELTER ADDRESS}</h6>
                        <a href="#" target="_blank">{SHELTER WEBSITE}</a>
                    </div>
                    <div class="col-md-3">
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
            </div>
            <?php } ?> <!-- end of explore-shelter -->

            <!-- PHP for each wishlist -->
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="row">
                    <div class="col-xs-6 col-md-6">
                        <strong>Name:</strong>
                        {PERSON NAME}
                    </div>
                    <div class="col-xs-6 col-md-6 text-right">
                        <strong>ID:</strong>
                        <a href="#">{PERSON ID}</a>
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
</div>

<script src="<?php echo Yii::app()->baseUrl ?>/js/selectize.min.js"></script>
<script type="text/javascript">
    $('#selectCity').change(function() {
        var cityId = undefined;
        var shelterId = $('#selectCity').val();
        if (shelterId[0] == 'C') {
            cityId = shelterId.substring(1);
            window.location.href = "<?php echo $this->createUrl('explore/index'); ?>" + "&cityId=" + cityId;
        }
        else {
            window.location.href = "<?php echo $this->createUrl('explore/index'); ?>" + "&shelterId=" + shelterId;
        }
    })
</script>