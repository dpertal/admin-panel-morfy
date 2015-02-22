
<?php


/*************************************************
*
*               Debug
*
**************************************************/
Morfy::factory()->addAction('Debug', function () {
    // if environment true show krumo
    Panel::Environment(Panel::Settings('configuration','Debug'));
    if(Panel::Settings('configuration','Debug')){
        // debug class
        include_once(CONTROLLERS.DS.'krumo'.DS.'class.krumo.php');
    }
});

/*************************************************
*
*               Notifications
*
**************************************************/
Morfy::factory()->addAction('Info', function () {
    // init notifications
    Panel::Notification_init();
    Panel::Notification_get('success') AND Panel::Alert_success(Panel::Notification_get('success'));
    Panel::Notification_get('warning') AND Panel::Alert_warning(Panel::Notification_get('warning'));
    Panel::Notification_get('error')   AND Panel::Alert_error(Panel::Notification_get('error'));
});


/*************************************************
*
*               Login
*
**************************************************/
Morfy::factory()->addAction('Login', function () {
    // Check if exist folders if not  make new
    $full   = ROOTBASE.DS.'public'.DS.'images'.DS;
    // make dir  if not
    if(!Panel::Dir_exists($full)) Panel::Dir_create($full, 0755);

    // use default if empty in config.php
    $password = Panel::Settings('configuration','Password');
    $secret_key1 =  Panel::Settings('configuration','Key_1');
    $secret_key2 =  Panel::Settings('configuration','Key_2');
    $hash = md5($secret_key1.$password.$secret_key2);

    // get actions
    if (Panel::Request_Get('action')) {
        $action = Panel::Request_Get('action');
        // swich
        switch ($action) {
            case 'login':
                // isset
                if ((Panel::Request_Post('password')) && (Panel::Request_Post('token')) && (Panel::Request_Post('password') === $password)) {
                        $_SESSION['login'] = $hash;
                        Panel::Cookie_set('login',10);
                        Panel::isLogin();
                        // redirect if true
                        Panel::Notification_set('success',Panel::Lang('Hello Admin'));
                        Panel::Redirect(Panel::Root(Panel::Settings('configuration','Folder cms name')));
                }else{
                    Panel::Notification_set('error',Panel::Lang('You need provide a password'));
                    Panel::Redirect(Panel::Root(Panel::Settings('configuration','Folder cms name')));
                }
            break;
            case 'logout':
                Panel::Cookie_delete('login');
                Panel::isLogout();
                Panel::redirect(Panel::Root());
            break;
        }
    }
});


/*************************************************
*
*               SECTIONS
*
**************************************************/
Morfy::factory()->addAction('Sections', function () {
    if (Panel::Request_Get('g')) {
        $get = Panel::factory()->sanitizeURL(Panel::Request_Get('g'));
        if($get == 'images' || $get == 'edit_image' ||  $get == 'backups' || $get == 'upload_image' || $get == 'settings' || $get == 'support'|| $get == 'templates'|| $get == 'stylesheets'|| $get == 'javascript'){
            return include_once VIEWS.DS.$get.'.php';            
        }else{
            // for content folder only
            return include_once VIEWS.DS.'other.php';
        }
    }elseif(Panel::Request_Get('e') && Panel::Request_Get('t')){
        return Morfy::factory()->runAction('Edit');
    }elseif(Panel::Request_Get('u')){
        return Morfy::factory()->runAction('Update');
    }elseif(Panel::Request_Get('n') && Panel::Request_Get('t')){
        return Morfy::factory()->runAction('New_file');
    }elseif(Panel::Request_Get('nfd')){
        // Create folder with prompt
        Panel::Dir_create(ROOTBASE.DS.'content'.DS.Panel::Request_Get('nfd'));
        Panel::Notification_set('success',Panel::Lang('Your folder has ben create'));
        Panel::Redirect(Panel::Root(Panel::Settings('configuration','Folder cms name')));
    }elseif(Panel::Request_Get('dfd')){
        // Create folder with prompt
        Panel::Dir_delete(ROOTBASE.DS.'content'.DS.Panel::Request_Get('dfd'));
        Panel::Notification_set('success',Panel::Lang('Your folder has ben create'));
        Panel::Redirect(Panel::Root(Panel::Settings('configuration','Folder cms name')));
    }else{
        // home
        return include_once VIEWS.DS.'main.php';
    }
});


/*************************************************
*
*               Pages
*
**************************************************/
Morfy::factory()->addAction('Pages', function () {
     Morfy::factory()->runAction('dp');
    return Panel::ReadFolder('../content','md');
});


/*************************************************
*
*               Navigation md files
*
**************************************************/
Morfy::factory()->addAction('Navigation', function () {
    foreach(glob(ROOTBASE.DS.'content'.DS.'*', GLOB_ONLYDIR) as $dir) {
        $dir = str_replace(ROOTBASE.DS.'content'.DS, '', $dir);
        echo '<li><a href="?g='.$dir.'">'.ucfirst($dir).'</a></li>';
    }
});






/*************************************************
*
*               Themes
*
**************************************************/
Morfy::factory()->addAction('Templates', function () {
    Morfy::factory()->runAction('dp');
    return Panel::ReadAssetsFiles('../themes','html');
});
Morfy::factory()->addAction('Stylesheets', function () {
    Morfy::factory()->runAction('dp');
    return Panel::ReadAssetsFiles('../themes','css');
});
Morfy::factory()->addAction('Javascript', function () {
    Morfy::factory()->runAction('dp');
    return Panel::ReadAssetsFiles('../themes','js');
});



/*************************************************
*
*               Edit Pages
*
**************************************************/
Morfy::factory()->addAction('Edit', function () {
    $edit = Panel::factory()->sanitizeURL(Panel::Request_get('e'));
    $type = Panel::factory()->sanitizeURL(Panel::Request_get('t'));
   return  include VIEWS.DS.'edit_file.php';
});

/*************************************************
*
*               New File
*
**************************************************/
Morfy::factory()->addAction('New_file', function () {
    $file = Panel::Request_get('n');
    $type = Panel::Request_get('t');

    if($type == 'css'){
        $mode = 'css';
    }elseif($type == 'javascript'){
        $mode = 'js';
    }elseif($type == 'php'){
        $mode = 'html';
    }elseif($type == 'markdown'){
        $mode = 'md';
    }

    if (Panel::Request_Post('saveFile')) {
        if(Panel::Request_Post('token')){
           // get content
            if(Panel::Request_Post('filename')) $filename = Panel::Request_Post('filename'); else $filename = '';
            if(Panel::Request_Post('content')) $content = Panel::Request_Post('content'); else $content = 'Nothing here';
            // save file
            Panel::setContent(base64_decode($file).'/'.Panel::Seolink($filename).'.'.$mode,$content);
            // redirect if true
            Panel::Notification_set('success',Panel::Lang('Your file has ben save'));

            if(Panel::Request_Post('pages')){
                Panel::Redirect(Panel::Root(Panel::Settings('configuration','Folder cms name')));  
            }elseif(Panel::Request_Post('templates')){
                Panel::Redirect(Panel::Root(Panel::Settings('configuration','Folder cms name')).'/?g='.Panel::Request_Post('templates'));
            }elseif(Panel::Request_Post('stylesheets')){
                Panel::Redirect(Panel::Root(Panel::Settings('configuration','Folder cms name')).'/?g='.Panel::Request_Post('stylesheets'));
            }elseif(Panel::Request_Post('javascript')){
                Panel::Redirect(Panel::Root(Panel::Settings('configuration','Folder cms name')).'/?g='.Panel::Request_Post('javascript'));
            }else{
                 Panel::Redirect(Panel::Root(Panel::Settings('configuration','Folder cms name')));
            }

        }else{
            die('crsf detect');
        }

    }

   return  include VIEWS.DS.'new_file.php';
});


/*************************************************
*
*               Update Pages
*
**************************************************/
Morfy::factory()->addAction('Update', function () {
    if (Panel::Request_Get('u')) {
        if(Panel::Request_Post('token')){
            // name of file
            $filename = Panel::Request_Get('u');
            // get content
            if(Panel::Request_Post('content')) $content = Panel::Request_Post('content'); else $content = '';
            // save
            Panel::setContent(base64_decode($filename),$content);
            // redirect if true
            Panel::Notification_set('success',Panel::Lang('Your file has ben update'));
            

            if(Panel::Request_Post('pages')){
                Panel::Redirect(Panel::Root(Panel::Settings('configuration','Folder cms name')));  
            }elseif(Panel::Request_Post('templates')){
                Panel::Redirect(Panel::Root(Panel::Settings('configuration','Folder cms name')).'/?g='.Panel::Request_Post('templates'));
            }elseif(Panel::Request_Post('stylesheets')){
                Panel::Redirect(Panel::Root(Panel::Settings('configuration','Folder cms name')).'/?g='.Panel::Request_Post('stylesheets'));
            }elseif(Panel::Request_Post('javascript')){
                Panel::Redirect(Panel::Root(Panel::Settings('configuration','Folder cms name')).'/?g='.Panel::Request_Post('javascript'));
            }else{
                 Panel::Redirect(Panel::Root(Panel::Settings('configuration','Folder cms name')));
            }



        }else{
            die('crsf detect');
        }

    }
});

/*************************************************
*
*               DELETE PAGES
*
**************************************************/
Morfy::factory()->addAction('dp', function () {
    // delete image file
    if(Panel::Request_Get('g') && Panel::Request_Get('dp')){
        $url = Panel::factory()->sanitizeURL(base64_decode(Panel::Request_Get('dp')));
        unlink(ROOTBASE.DS.$url);
        // redirect if true
        Panel::Notification_set('success',Panel::Lang('Your file has ben Delete'));
        Panel::Redirect(Panel::Root(Panel::Settings('configuration','Folder cms name').'/?g='.Panel::Request_Get('g')));
    }
});











/*************************************************
*
*               Images
*
**************************************************/
Morfy::factory()->addAction('Images', function () {
    // delete images
    Morfy::factory()->runAction('deleteImages');

    $photos = Panel::getContent(PHOTOS.DS.'photos.json');
    $result = json_decode($photos,true);

    if($result){

        $html = '';
        foreach ($result as $f) {
            $url = Panel::Root().'public/images/'.$f['image'];
            $html .= '
                <li class="imagePreview">
                    <a  class="imageDelete button alert tiny" onclick="return confirmDelete(\' '.Panel::Lang('Are you sure').'\')" href="?g=images&deleteImage='.$f['id'].'" >&times;</a>
                    <a  class="imageEdit button tiny" href="?g=edit_image&ei='.$f['id'].'" >Edit</a>
                    <a class="lightCustom" href="'.$url.'">
                        <span>'.$f['title'].'</span>
                        <img  src="'.$url.'" alt="'.$f['image'].'" />
                    </a>
                </li>';
        }
    
        echo '<ul class="imageGallery">'.$html.'</ul>';
    }else{
        echo '<span class="tools-alert tools-alert-red">No Images yet <a href="?g=upload_image">Upload the first </a></span>';
    }
});




/*************************************************
*
*               Edit Images
*
**************************************************/
Morfy::factory()->addAction('editImages', function () {

    if (Panel::Request_Post('editImage')) {
        if(Panel::Request_Post('token')){

            // get json 
            $photos = Panel::getContent(PHOTOS.DS.'photos.json');
            // decode
            $result = json_decode($photos,true);
            // get id
            $id = Panel::Request_Get('ei');
            // filter
            $photo = $result[$id];
            
            // post title and description
            $title = (Panel::Request_Post('title')) ? Panel::Request_Post('title') : $photo['title'];
            $description = (Panel::Request_Post('description')) ? Panel::Request_Post('description') : $photo['description'];
            $tag = (Panel::Request_Post('tag')) ? Panel::Request_Post('tag') : $photo['tag'];

            // update id
            $result[$id] = array(
                'id' => $id,
                'title' => htmlentities($title),
                'description' => htmlentities($description),
                'tag' => htmlentities($tag),
                'image' => $photo['image'],
                'width' => $photo['width'],
                'height' => $photo['height']
            );
            // encode json
            $save = json_encode($result, JSON_PRETTY_PRINT);
            // save content
            Panel::setContent(PHOTOS.DS.'photos.json',$save);  


            /*  Multiple upload files
            *-----------------------------------------------------*/
            // url
            $url = ROOTBASE.DS.'public'.DS.'images'.DS.$id;
            $valid_formats = array("jpg", "png", "gif", "zip", "bmp");
            $max_file_size = 2097152; // 2M
            $path = $url.DS; // Upload directory
            $count = 0;

            // Loop $_FILES to exeicute all files
            foreach ($_FILES['files']['name'] as $f => $name) {     
                if ($_FILES['files']['error'][$f] == 4) {
                    continue; // Skip file if any error found
                }          
                if ($_FILES['files']['error'][$f] == 0) {              
                    if ($_FILES['files']['size'][$f] > $max_file_size) {
                        Panel::Notification_set('success','$name is too large!.');
                        continue; // Skip large files
                    }
                    elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
                        Panel::Notification_set('success','$name is not a valid format');
                        continue; // Skip invalid file formats
                    }
                    else{ // No error found! Move uploaded files 
                        // get extension
                        $ext = explode('.',$name);
                        $file_ext=strtolower(end($ext));
                        // get filename
                        $filename = basename($name, $file_ext);
                        $image =  Panel::Seolink($filename).'.'.$file_ext;
                        if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$image)){
                            $count++;
                        };
                    }
                }
            }

            Panel::Notification_set('success',Panel::Lang('Your file has ben Update'));
            Panel::Redirect(Panel::Root(Panel::Settings('configuration','Folder cms name').'?g=edit_image&ei='.$id));

        }else{die('crsf detect');}
    }
});



/*************************************************
*
*               Delete Images
*
**************************************************/
Morfy::factory()->addAction('deleteImages', function () {
    // delete image file
    if(Panel::Request_Get('deleteImage')){
        // id of photos
        $id = Panel::Request_Get('deleteImage');

        // remove dir
        $dir = PHOTOS.DS.'images'.DS.$id;
        foreach (glob($dir."/*.*") as $filename) {
            if (is_file($filename)) {
                unlink($filename);
            }
        }
        rmdir($dir);

        // get json 
        $photos = Panel::getContent(PHOTOS.DS.'photos.json');
        $result = json_decode($photos,true);
        // Remove image
        Panel::File_delete(PHOTOS.DS.'images'.DS.$result[$id]['image']);
        // delete id
        unset($result[$id]);
        // encode json
        $save = json_encode($result, JSON_PRETTY_PRINT);
        // save content
        Panel::setContent(PHOTOS.DS.'photos.json',$save);  
        // redirect if true
        Panel::Notification_set('success',Panel::Lang('Your file has ben Delete'));
        Panel::Redirect(Panel::Root(Panel::Settings('configuration','Folder cms name').'?g=images'));
    }
});



/*************************************************
*
*               Delete Image
*
**************************************************/
Morfy::factory()->addAction('deleteImage', function () {
    // delete image file
    if(Panel::Request_Get('ei') && Panel::Request_Get('dlt')){
        // id of photos
        $id = Panel::Request_Get('ei');
        $img = Panel::Request_Get('dlt');
        // delete image
        unlink(PHOTOS.DS.'images'.DS.$id.DS.$img);
        // redirect if true
        Panel::Notification_set('success',Panel::Lang('Your file has ben Delete'));
        Panel::Redirect(Panel::Root(Panel::Settings('configuration','Folder cms name').'?g=edit_image&ei='.$id));
    }
});


/*************************************************
*
*               Settings
*
**************************************************/
Morfy::factory()->addAction('settings', function () {

    // submit function
    if (Panel::Request_Post('saveConfigSettings')) {
        if(Panel::Request_Post('token')){
            
             // get json 
            $configuration = Panel::getContent(DATABASE.DS.'configuration.json');
            // decode
            $result = json_decode($configuration,true);            
            // requests
            $url = (Panel::Request_Post('siteurl')) ? Panel::Request_Post('siteurl') : $result['Site_url'];
            $timezone = (Panel::Request_Post('timezone')) ? Panel::Request_Post('timezone') : $result['Timezone'];
            $pass = (Panel::Request_Post('pass')) ? Panel::Request_Post('pass') : $result['Password'];
            $sk1 = (Panel::Request_Post('sk1')) ? Panel::Request_Post('sk1') : $result['Key_1'];
            $sk2 = (Panel::Request_Post('sk2')) ? Panel::Request_Post('sk2') : $result['Key_2'];
            $adminemail = (Panel::Request_Post('adminEmail')) ? Panel::Request_Post('adminEmail') : $result['admin_email'];
            $cmsFolder = (Panel::Request_Post('csmfolder')) ? Panel::Request_Post('csmfolder') : $result['Folder cms name'];
            $cmsName = (Panel::Request_Post('cmsName')) ? Panel::Request_Post('cmsName') : $result['Cms name'];
            $lang = (Panel::Request_Post('lang')) ? Panel::Request_Post('lang') : $result['language'];
            $Debuger = (Panel::Request_Post('Debug')) ? Panel::Request_Post('Debug') : $result['Debug'];  
            $ace_theme = (Panel::Request_Post('ace_theme')) ? Panel::Request_Post('ace_theme') : $result['Ace_theme']; 
            $ace_emmet = (Panel::Request_Post('ace_Emmet')) ? Panel::Request_Post('ace_Emmet') : $result['Ace_emmet']; 
            $ace_tabSize = (Panel::Request_Post('ace_tabSize')) ? Panel::Request_Post('ace_tabSize') : $result['Ace_tabsize']; 
            $ace_fontSize = (Panel::Request_Post('ace_fontSize')) ? Panel::Request_Post('ace_fontSize') : $result['Ace_fontSize']; 
            $ace_autocompletion = (Panel::Request_Post('ace_autocompletion')) ? Panel::Request_Post('ace_autocompletion') : $result['Ace_autocompletion'];
            
            // array for save
            $result = array(
                "Site_url" => $url,
                "Timezone" => $timezone,
                "Password" => $pass,
                "Key_1" => $sk1,
                "Key_2" => $sk2,
                "admin_email" => $adminemail,
                "language" => $lang,
                "Debug" => $Debuger,
                "Cms name" => $cmsName,
                "Folder cms name" => $cmsFolder,
                "Ace_theme" => $ace_theme,
                "Ace_emmet" => $ace_emmet,
                "Ace_tabsize" => $ace_tabSize,
                "Ace_fontSize" => $ace_fontSize,
                "Ace_autocompletion" => $ace_autocompletion
            );        
            // encode json
            $save = json_encode($result, JSON_PRETTY_PRINT);
            // save content
            Panel::setContent(DATABASE.DS.'configuration.json',$save);
            // notification
            Panel::Notification_set('success',Panel::Lang('Your file has ben Update'));
            // redirect if true
            Panel::Redirect(Panel::Root(Panel::Settings('configuration','Folder cms name').'?g=settings'));
        }else{die('crsf detect');}
    }
});

/*************************************************
*
*               Documentation
*
**************************************************/
Morfy::factory()->addAction('documentation', function () {
    echo 'Comming Soon';
});





/*************************************************
*
*               Create backup
*
**************************************************/
Morfy::factory()->addAction('backups', function () {

    if(Panel::Request_Get('g') && Panel::Request_Get('createBackup')){
        Panel::Create_zip(array(DATABASE,PHOTOS), BACKUP.DS.Panel::Request_Get('createBackup').'.zip');
         // redirect if true
        Panel::Notification_set('success',Panel::Lang('Your file has created'));
        Panel::Redirect(Panel::Root(Panel::Settings('configuration','Folder cms name').'?g=backups'));
    }

    if(Panel::Request_Get('g') && Panel::Request_Get('downloadBackup')){
        // or however you get the path
        $yourfile = Panel::Request_Get('downloadBackup');
        $file_name = basename($yourfile);
        header("Content-Type: application/zip");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Content-Length: " . filesize($yourfile));
        readfile($yourfile);
        exit;
    }

    if(Panel::Request_Get('g') && Panel::Request_Get('deleteBackup')){
        if (Panel::file_exists(Panel::Request_Get('deleteBackup'))) {
            unlink(Panel::Request_Get('deleteBackup'));
             // redirect if true
            Panel::Notification_set('success',Panel::Lang('Your file has delete'));
            Panel::Redirect(Panel::Root(Panel::Settings('configuration','Folder cms name').'?g=backups'));
        }
    }
});
