<section>
  <div class='container'>
    <div class='row'>
      <div class="col-md-9 center-block">
        <h2>Sponsors</h2>
        <p class="lead">In 2013 we created an indiegogo campaign to rebuild our site</p>
        <p>We are extremely grateful for all of the generous donations during our 22 day campaign. We would like to recognize all of those people on this page. Without their support, we wouldn't have a homeless partners program this year. Thank you.</p>
      </div>
    </div>
  </div>
</section>
<section class="section-offset">
  <div class='container narrow-container'>
    <div class="row tiles">
        <p class="lead text-center">Silver Sponsors</p>

        <?php $sponsors = array(
          array('url' => 'http://fullstack.ca/', 'img'=>'full-stack.jpg'),
          array('url' => 'http://www.ardisbears.com/', 'img'=>'aradibears.jpg'),
          array('url' => 'http://painfreetaxes.ca/', 'img'=>'pain-free-tax.jpg'),
          array('url' => 'http://ctihalifax.com/', 'img'=>'cmhc.jpg'),
          array('url' => 'http://viralfoundry.com/', 'img'=>'viralfoundry.jpg'),
        ); ?>

        <?php foreach ($sponsors as $sponsor): ?>
        <div class="col-sm-6 col-md-4">
          <div class="tile">
            <a href="<?php echo $sponsor['url']?>" target="_blank"><img src="/images/sponsors/<?php echo $sponsor['img']?>" class="tile-image img-responsive"></a>
            <?php if (!empty($sponsor['title'])): ?>
            <h3 class="tile-title"><?php echo $sponsor['title']?></h3>
            <?php endif; ?>
            <?php if (!empty($sponsor['description'])): ?>            
            <p><?php echo $sponsor['description']?></p>
            <?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
    </div>
  </div>

</section>
