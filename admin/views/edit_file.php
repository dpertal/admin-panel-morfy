<?php defined('PANEL_ACCESS') or die('No direct script access.');  $file = Panel::getContent(base64_decode($edit)); ?>


<ul class="breadcrumbs">
  <li><a href="#"><i class="fa fa-home"></i></a></li>
  <li class="unavailable"><a href="#">Pages</a></li>
  <li class="current"><a href="#">Edit</a></li>
</ul>


<form  data-abide method="POST" action="<?php echo Panel::Root(Panel::Settings('configuration','Folder cms name'));?>/?u=<?php echo $edit; ?>">

	<input type="hidden" name="token" value="<?php echo Panel::factory()->generateToken(); ?>">


	<?php if($type == 'css'){ ?>
		<input type="hidden" name="stylesheets" value="stylesheets">
	<?php }elseif($type == 'js'){ ?>
		<input type="hidden" name="javascript" value="javascript">
	<?php }elseif($type == 'markdown'){ ?>
		<input type="hidden" name="pages" value="pages">
	<?php }elseif($type == 'php'){ ?>
		<input type="hidden" name="templates" value="templates">
	<?php } ?>




	<div class="row">
		<div class="small-12 medium-4 large-4 columns">
			<a href="javascript:void(0);" onclick="return history.back()" class="button alert tiny"><?php echo Panel::Lang('Cancel'); ?></a>
			<input type="submit" class="button tiny" value="<?php echo Panel::Lang('Update'); ?>">
		</div>
	</div>

	<div class="row">
		<div class="small-12 medium-12 large-12 columns">

			<?php if($type == 'markdown'){ ?>
				<div class="row">
					<div class="medium-6 columns">
						<textarea name="content" class="editor-area" id="editor-area"><?php echo $file; ?></textarea>				      	
					</div>
					<div class="medium-6 columns">
						<div class="header-preview">Document Preview</div>
						<div class="result"  id="editor-preview"></div>
					</div>
				</div>

			<?php }else{ ?>
			<span class="label secondary">Autocompletion  <b>win: "Ctrl-space", mac: "Command-space"</b></span>				
			<div id="editor" data-type="<?php echo $type;?>"></div>
			<textarea name="content"  id="editor-area" class="hide"><?php echo $file; ?></textarea>
			<?php }; ?>
		</div>
	</div>

</form>