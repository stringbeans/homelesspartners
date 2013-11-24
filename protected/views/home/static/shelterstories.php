<div class="shelter-container container">

    <!-- shelter -->

        <div class="shelter-information row">
            <div class="col-md-3 col-sm-6">
                <img class="img-responsive" src="http://lorempixel.com/output/city-q-g-640-480-8.jpg" />
            </div>

            <div class="col-md-7 col-sm-6">
                <h4>{SHELTER.TITLE}</h4>
                <h6>{CITY},{PROVINCE}</h6>
                <a href="#">http://shelterlink.com</a>
            </div>

            <div class="action-buttons col-md-2">
                <a class="col-md-12 btn btn-danger">Ask Question</a>
                <a class="col-md-12 btn btn-info">Donate Money</a>
            </div>
        </div>


        <div class="shelter-details row">
            <div class="col-md-12">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
                </p>
            </div>
        </div>

        <div class="shelter-locations row">
            <div class="col-md-12">
                <h6>Drop off Locations:</h6>
                <ul>
                    <?php for($i=0; $i<3; $i++) { ?>
                    <li><a href="#">{LOCATION}</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <div class="shelter-stats row">
            <div class="stat col-md-4">
                <strong>Stories</strong>
                <p>
                    75
                </p>
            </div>
            <div class="stat col-md-4">
                <strong>Gifts</strong>
                <p>
                    26 
                </p>
            </div>
            <div class="stat col-md-4">
                <strong>Pledged Gifts</strong>
                <p>
                    0 of 26 
                </p>
            </div>
        </div>

</div>

<div class="shelter-stories-container container">

    <?php for ($i=0; $i< 3; $i++) { ?>
    <div class="shelter-story row">
        <div class="shelter-author col-md-6">
            Name: {AUTHOR.NAME}
        </div>
        <div class="shelter-id col-md-6">
            ID: <a href="#">{AUTHOR.NAME}</a>
        </div>

        <div class="col-md-12">

            <p>
                <small>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </small>
            </p>

        </div>
    </div>
    <div class="shelter-gift row">
        <div class="col-md-9 col-xs-6">
            Winter coat for daughter, purple, size X-L
        </div>
        <a class="btn btn-primary col-md-3 col-xs-6">
            Pledge This Gift
        </a>
    </div>
    <div class="shelter-gift row">
        <div class="col-md-9 col-xs-6">
            Winter boots for son, size 10 (teen style)
        </div>
        <a class="btn btn-danger col-md-3 col-xs-6">
            Unpledge This Gift
        </a>
    </div>
    <?php } ?>

</div>
