<?php defined('PANEL_ACCESS') or die('No direct script access.'); ?>

<ul class="breadcrumbs">
  <li><a href="#"><i class="fa fa-home"></i></a></li>
  <li class="unavailable"><a href="#">Theme</a></li>
  <li class="current"><a href="#">Javascript</a></li>
</ul>

<?php Morfy::factory()->runAction('Javascript'); ?>