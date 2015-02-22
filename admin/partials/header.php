<?php 
	defined('PANEL_ACCESS') or die('No direct script access.'); 
	function activeLinks($element,$callback,$active=null){
		$url = Panel::Root(Panel::Settings('configuration','Folder cms name'));
		$actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		if(trim($actual_link) == $url.'/?'.$element){echo $callback;}
		if($active == true){if(trim($actual_link) == $url.'/'){echo $callback;}}
	}
?>


<nav class="top-bar" data-topbar role="navigation">
  <ul class="title-area">
    <li class="name">
      <h1>
      	 <a class="left" href="<?php echo Panel::Root(Panel::Settings('configuration','Folder cms name'));?>">
			<?php echo Panel::Settings('configuration','Cms name');?>
    	</a>
      </h1>
    </li>
     <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
    <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
  </ul>

  <section class="top-bar-section">
    <!-- Right Nav Section -->
    <ul class="right">
    	<li>
    		<a target="_blank" href="<?php echo Panel::Root();?>">View</a>
    	</li>
      <li>
		<?php if (isset($_SESSION['login'])) {?>
			<a  href="?action=logout"><?php echo Panel::Lang('Logout');?></a>
		<?php } ?>
      </li>
    </ul>

	<ul class="left">
		
		<?php if (isset($_SESSION['login'])) { ?>

		<!-- Pages-->
		<li class="has-dropdown">
			<a href="#" <?php activeLinks('g=main','data-acc="open"',true); ?>>Content</a>
	        <ul class="dropdown">
	        	<li><a href="<?php echo Panel::Root(Panel::Settings('configuration','Folder cms name'));?>">Home</a></li>
				<?php Morfy::factory()->runAction('Navigation');?>
	        </ul>
	    </li>

		<!-- Images-->
		<li class="has-dropdown">
			<a href="#" <?php activeLinks('g=images','data-acc="open"');?>>Images</a>
			<ul class="dropdown">
				<li <?php activeLinks('g=images','class="active"'); ?>><a href="?g=images">View all Images</a></li>
				<li <?php activeLinks('g=upload_image','class="active"'); ?>><a href="?g=upload_image">Upload New File</a></li>
			</ul>
		</li>

		<!-- Theme-->
		<li class="has-dropdown">
	  		<a href="#" <?php activeLinks('g=templates','data-acc="open"'); activeLinks('g=stylesheets','data-acc="open"'); activeLinks('g=javascript','data-acc="open"'); ?>>Theme</a>
	  		<ul class="dropdown">
				<li <?php activeLinks('g=templates','class="active"'); ?>><a href="?g=templates" >Templates</a></li>
				<li <?php activeLinks('g=stylesheets','class="active"'); ?>><a href="?g=stylesheets">Stylesheets</a></li>
				<li <?php activeLinks('g=javascript','class="active"'); ?>><a href="?g=javascript">Javascript</a></li>
			</ul>
		</li>
		

		<!-- Settings-->
		<li class="has-dropdown">
			<a href="#" <?php activeLinks('g=settings','data-acc="open"'); ?>>Settings</a>
			<ul class="dropdown">
				<li <?php activeLinks('g=settings','class="active"'); ?>><a href="?g=settings">Configuration</a></li>
				<li <?php activeLinks('g=backups','class="active"'); ?>><a href="?g=backups">Backups</a></li>
			</ul>
		</li>

		<!-- Support-->
		<li class="has-dropdown">
			<a href="#"  <?php activeLinks('g=support','data-acc="open"'); ?>>Support</a>
			<ul class="dropdown">
				<li <?php activeLinks('g=support','class="active"'); ?>><a href="?g=support">Documentation</a></li>
			</ul>
		</li>

		<?php } ?>
	</ul>

  </section>
</nav>