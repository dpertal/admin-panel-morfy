<?php defined('PANEL_ACCESS') or die('No direct script access.'); ?>

<?php Panel::uploadImages(); ?>

	<ul class="breadcrumbs">
	  <li><a href="#"><i class="fa fa-home"></i></a></li>
	  <li class="unavailable"><a href="#">Images</a></li>
	  <li class="current"><a href="#">All Images</a></li>
	</ul>


	<div class="row">
		<div class="small-12 medium-6 large-6 columns">

			<form data-abide method="post"  enctype="multipart/form-data">

				<div class="name-field">
					<label>Chosse a Image file:  <small>*</small>
						<input type="file"  class="upload" name="file_upload" id="image-input" />
					</label>
				</div>

				<div class="name-field">
					<label>With: <small>*</small>
						<input type="text"  required  name="width" id="width" value="250">
						<small class="error">Name is required and must be a string.</small>
					</label>
				</div>

				<div  class="name-field">
					<label>Height:  <small>*</small>
						<input type="text" required name="height" id="height" value="180">
						<small class="error">Name is required and must be a string.</small>
					</label>
				</div>

				<div class="name-field">
					<label>Title:  <small>*</small>
						<input type="text"  required  name="title" id="title" placeholder="Title of photo">
						<small class="error">Title is required and must be a string.</small>
					</label>
				</div>

				<div class="name-field">
					<label>Description:  <small>*</small>
						<textarea name="description" id="description" rows="3" required placeholder="Description of photo"></textarea>
						<small class="error">Description is required and must be a string.</small>
					</label>
				</div>

				<div class="name-field">
					<label>Tag:  <small>Only one for Image *</small>
						<input type="text"  required  name="tag" id="tag" placeholder="Filter ( exmplate  Design )">
						<small class="error">Title is required and must be a string.</small>
					</label>
				</div>
				<input type="submit" name="upload" id="upload" class="button small" value="Upload">

			</form>
		</div>

		<div  class="small-12 medium-6 large-6 columns">
			<img  id="image-display" src="<?php echo Panel::Root(Panel::Settings('configuration','Folder cms name')).'/assets/img/nopreview.jpg'; ?>" alt="">
		</div>		
	</div>

