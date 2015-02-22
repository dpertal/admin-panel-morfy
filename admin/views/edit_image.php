<?php defined('PANEL_ACCESS') or die('No direct script access.'); ?>

<?php 
	Morfy::factory()->runAction('deleteImage'); 
	Morfy::factory()->runAction('editImages'); 
    // get json 
    $photos = Panel::getContent(PHOTOS.DS.'photos.json');
    // decode
    $result = json_decode($photos,true);
    // get id
    $id = Panel::Request_Get('ei');
    // filter
    $photo = $result[$id];

    $photos = Panel::File_scan(PHOTOS.DS.'images'.DS.$id);
?>

	<ul class="breadcrumbs">
	  <li><a href="#"><i class="fa fa-home"></i></a></li>
	  <li class="unavailable"><a href="#">Images</a></li>
	  <li class="current"><a href="#">Edit Images</a></li>
	</ul>

	<div class="row">
		<div class="small-12 medium-6 large-6 columns">
			<form data-abide method="post" enctype="multipart/form-data">

				<input type="hidden" name="token" value="<?php echo Panel::factory()->generateToken(); ?>">

				<div class="name-field">
					<label>Images:  <small>*</small>
						<input type="file"  name="files[]" id="files" multiple="multiple">
					</label>
				</div>

				<div class="name-field">
					<label>Title:  <small>*</small>
						<input type="text"  required  name="title" id="title" value="<?php echo $photo['title'];?>">
						<small class="error">Title is required and must be a string.</small>
					</label>
				</div>

				<div class="name-field">
					<label>Description:  <small>*</small>
						<textarea name="description" id="description" rows="8" required><?php echo $photo['description'];?></textarea>
						<small class="error">Description is required and must be a string.</small>
					</label>
				</div>

				<div class="name-field">
					<label>Tag:  <small>*</small>
						<input type="text"  required  name="tag" id="tag" value="<?php echo $photo['tag'];?>">
						<small class="error">Tag is required and must be a string.</small>
					</label>
				</div>

				<input type="submit" name="editImage" class="button small" value="Update">

			</form>
		</div>
		<div  class="small-12 medium-6 large-6 columns">
			<div class="row">
				<div class="col-md-12">
					<img  style="width:100%;" src="<?php echo Panel::Root().'/public/images/'.$photo['image']; ?>" alt="">
				</div>
				<div class="col-md-12">

					<?php  
						if($photos){
							$html = '<ul class="inline-list mini-tumbs">';
							foreach ($photos as $image) {
							  	$html .= '<li>
							  		<a href="?g=edit_image&ei='.$id.'&dlt='.$image.'" onclick="return confirm(\' '.Panel::Lang('Are you sure').' !\')">
							  			<img  width="90" src="'.Panel::Root().'/public/images/'.$id.'/'.$image.'" alt="">
							  		</a>
							  	</li>';
							}
							$html .= '</ul>';
							echo $html;
						}else{
							echo '<span class="tools-alert tools-alert-red">No photos yet</span>';
						}
					?>

				</div>
			</div>
		</div>		
	</div>

