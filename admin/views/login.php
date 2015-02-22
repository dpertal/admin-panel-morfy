<?php defined('PANEL_ACCESS') or die('No direct script access.');?>

  <form  method="POST" action="?action=login">
    <input type="hidden" name="token" value="<?php echo  Panel::factory()->generateToken(); ?>">
    <div class="row">
      <div class="small-12 medium-4 medium-centered larget-4 large-centered columns">
        <div class="row collapse">
          <div class="small-8 columns">
            <input type="password" name="password" id="password" class="">
          </div>
          <div class="small-4 columns">
            <input type="submit" class="button postfix" value="<?php echo Panel::Lang('Login') ?>">
          </div>
        </div>
      </div>
    </div>
  </form>