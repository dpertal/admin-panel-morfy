<?php  defined('PANEL_ACCESS') or die('No direct script access.');


class Panel {

    const SESSION_KEY = 'notifications';
	private function __construct() {}
    private function __clone() {}
    private static $notifications = array();
    protected static $security_token_name = 'security_token_name';
    public static function factory(){
        return new static();
    }



    /****************************************************************
    *
    *       NOTIFICATIONS GET,SET,INIT,CLEAN
    *       PART OF GELATO FRAMEWORK
    *
    *****************************************************************/
    /**
     * Returns a specific variable from the Notifications array.
     *
     *  <code>
     *      echo Notification::get('success');
     *      echo Notification::get('errors');
     *  </code>
     *
     * @param  string $key Variable name
     * @return mixed
     */
    public static function Notification_get($key){
        // Redefine arguments
        $key = (string) $key;
        // Return specific variable from the Notifications array
        return isset(Panel::$notifications[$key]) ? Panel::$notifications[$key] : null;
    }
    /**
     * Adds specific variable to the Notifications array.
     *
     *  <code>
     *      Panel::Notification_set('success', 'Data has been saved with success!');
     *      Panel::Notification_set('errors', 'Data not saved!');
     *  </code>
     *
     * @param string $key   Variable name
     * @param mixed  $value Variable value
     */
    public static function Notification_set($key, $value){
        // Redefine arguments
        $key = (string) $key;
        // Save specific variable to the Notifications array
        $_SESSION[Panel::SESSION_KEY][$key] = $value;
    }
    /**
     * Adds specific variable to the Notifications array for current page.
     *
     *  <code>
     *      Panel::Notification_setNow('success', 'Success!');
     *  </code>
     *
     * @param string $var   Variable name
     * @param mixed  $value Variable value
     */
    public static function Notification_setNow($key, $value){
        // Redefine arguments
        $key = (string) $key;
        // Save specific variable for current page only
        Panel::$notifications[$key] = $value;
    }
    /**
     * Clears the Notifications array.
     */
    public static function Notification_clean(){
        $_SESSION[Panel::SESSION_KEY] = array();
    }
    /**
     * Initializes the Notification service.
     */
    public static function Notification_init(){
        // Get notification/flash data...
        if ( ! empty($_SESSION[Panel::SESSION_KEY]) && is_array($_SESSION[Panel::SESSION_KEY])) {
            Panel::$notifications = $_SESSION[Panel::SESSION_KEY];
        }
        $_SESSION[Panel::SESSION_KEY] = array();
    }
















    /****************************************************************
    *
    *       ALERTS SUCCESS,ERROR,WARNING
    *       PART OF GELATO FRAMEWORK
    *
    *****************************************************************/

   /**
     * Show success message
     *
     *  <code>
     *      Alert::success('Message here...');
     *  </code>
     *
     * @param string  $message Message
     */
    public static function Alert_success($message){
        $message = (string) $message;
        echo '
            <div id="notif" data-alert class="alert-box">
               '.$message.'
            </div>

            <script>
                var time = setTimeout(function(){
                    document.querySelector("#notif").remove();
                    clearTimeout(time);
                },2000);
            </script>';
    }
    /**
     * Show warning message
     *
     *  <code>
     *      Panel::Alert_warning('Message here...');
     *  </code>
     *
     * @param string  $message Message
     */
    public static function Alert_warning($message){
        $message = (string) $message;
        echo '
            <div id="notif" data-alert class="alert-box warning">
               '.$message.'
            </div>
            <script>
                var time = setTimeout(function(){
                    document.querySelector("#notif").remove();
                    clearTimeout(time);
                },2000);
            </script>';
    }
    /**
     * Show error message
     *
     *  <code>
     *      Panel::Alert_error('Message here...');
     *  </code>
     *
     * @param string  $message Message
     */
    public static function Alert_error($message){
        $message = (string) $message;
        echo '
            <div id="notif" data-alert class="alert-box alert">
               '.$message.'
            </div>
             <script>
                var time = setTimeout(function(){
                    document.querySelector("#notif").remove();
                    clearTimeout(time);
                },2000);
            </script>';
    }














    /****************************************************************
    *
    *       GENERATETOKEN
    *       PART OF MORFY CMS
    *
    *****************************************************************/

    /**
     * Generate and store a unique token which can be used to help prevent
     * [CSRF](http://wikipedia.org/wiki/Cross_Site_Request_Forgery) attacks.
     *
     *  <code>
     *      $token = Panel::generateToken();
     *  </code>
     *
     * You can insert this token into your forms as a hidden field:
     *
     *  <code>
     *      <input type="hidden" name="token" value="<?php echo Panel::generateToken(); ?>">
     *  </code>
     *
     * This provides a basic, but effective, method of preventing CSRF attacks.
     *
     * @param  boolean $new force a new token to be generated?. Default is false
     * @return string
     */
    public function generateToken($new = false){
        // Get the current token
        if (isset($_SESSION[(string) self::$security_token_name])) $token = $_SESSION[(string) self::$security_token_name]; else $token = null;
        // Create a new unique token
        if ($new === true or ! $token) {
            // Generate a new unique token
            $token = sha1(uniqid(mt_rand(), true));
            // Store the new token
            $_SESSION[(string) self::$security_token_name] = $token;
        }
        // Return token
        return $token;
    }










    /****************************************************************
    *
    *       REDIRECT SETHEADERS, SHOWDOWN
    *       PART OF GELATO FRAMEWORK
    *
    *****************************************************************/

    /**
     * Redirects the browser to a page specified by the $url argument.
     *
     *  <code>
     *		Panel::Redirect('test');
     *  </code>
     *
     * @param string  $url    The URL
     * @param integer $status Status
     * @param integer $delay  Delay
     */
    public static function Redirect($url, $status = 302, $delay = null){
        // Redefine vars
        $url 	= (string) $url;
        $status = (int) $status;
        // Status codes
        $messages = array();
        $messages[301] = '301 Moved Permanently';
        $messages[302] = '302 Found';
        // Is Headers sent ?
        if (headers_sent()) {
            echo "<script>document.location.href='" . $url . "';</script>\n";
        } else {
            // Redirect headers
            Panel::setHeaders('HTTP/1.1 ' . $status . ' ' . Panel::Arr_get($messages, $status, 302));
            // Delay execution
            if ($delay !== null) sleep((int) $delay);
            // Redirect
            Panel::setHeaders("Location: $url");
            // Shutdown request
            Panel::shutdown();

        }
    }
    /**
     * Set one or multiple headers.
     *
     *  <code>
     *		Panel::setHeaders('Location: http://site.com/');
     *  </code>
     *
     * @param mixed $headers String or array with headers to send.
     */
    public static function setHeaders($headers){
        // Loop elements
        foreach ((array) $headers as $header) {
            // Set header
            header((string) $header);
        }
    }
    /**
     * Terminate request
     *
     *  <code>
     *      Panel::shutdown();
     *  </code>
     *
     */
    public static function shutdown(){
        exit(0);
    }





























    /****************************************************************
    *
    *       ENVIRONMENT
    *
    *****************************************************************/



    /**
    * Set one or multiple headers.
    *
    *  <code>
    *      Panel::Environment(true);
    *  </code>
    *
    * @param integer
    */
    public static function Environment($debug){
        if($debug){
            ini_set('display_errors',1);
            error_reporting(E_ALL);
        }else {
            ini_set('display_errors',0);
            error_reporting(E_ALL);
        }
    }





































    /****************************************************************
    *
    *       ARR GET
    *       PART OF GELATO FRAMEWORK
    *
    *****************************************************************/
    /**
     * Returns value from array using "dot notation".
     * If the key does not exist in the array, the default value will be returned instead.
     *
     *  <code>
     *      $login = Arr::get($_POST, 'login');
     *
     *      $array = array('foo' => 'bar');
     *      $foo = Arr::get($array, 'foo');
     *
     *      $array = array('test' => array('foo' => 'bar'));
     *      $foo = Arr::get($array, 'test.foo');
     *  </code>
     *
     * @param  array  $array   Array to extract from
     * @param  string $path    Array path
     * @param  mixed  $default Default value
     * @return mixed
     */
    public static function Arr_get($array, $path, $default = null){
        // Get segments from path
        $segments = explode('.', $path);
        // Loop through segments
        foreach ($segments as $segment) {
            // Check
            if ( ! is_array($array) || !isset($array[$segment])) {
                return $default;
            }
            // Write
            $array = $array[$segment];
        }
        // Return
        return $array;
    }


























    /****************************************************************
    *
    *       REQUEST GET AND POST
    *       PART OF GELATO FRAMEWORK
    *
    *****************************************************************/

    /*
     * Get
     *
     *  <code>
     *		$action = Panel::Request_Get('action');
     *  </code>
     *
     * @param string $key Key
     * @param mixed
     */
    public static function Request_Get($key){
        return Panel::Arr_get($_GET, $key);
    }
    /**
     * Post
     *
     *  <code>
     *		$login = Panel::Request_Post('login');
     *  </code>
     *
     * @param string $key Key
     * @param mixed
     */
    public static function Request_Post($key){
        return Panel::Arr_get($_POST, $key);
    }







































    /****************************************************************
    *
    *       COOKIE SET ,GET ,DELETE
    *       PART OF GELATO FRAMEWORK
    *
    *****************************************************************/

    /**
     * Send a cookie
     *
     *  <code>
     *      Panel::Cookie_set('limit', 10);
     *  </code>
     *
     * @param  string  $key      A name for the cookie.
     * @param  mixed   $value    The value to be stored. Keep in mind that they will be serialized.
     * @param  integer $expire   The number of seconds that this cookie will be available.
     * @param  string  $path     The path on the server in which the cookie will be availabe. Use / for the entire domain, /foo if you just want it to be available in /foo.
     * @param  string  $domain   The domain that the cookie is available on. Use .example.com to make it available on all subdomains of example.com.
     * @param  boolean $secure   Should the cookie be transmitted over a HTTPS-connection? If true, make sure you use a secure connection, otherwise the cookie won't be set.
     * @param  boolean $httpOnly Should the cookie only be available through HTTP-protocol? If true, the cookie can't be accessed by Javascript, ...
     * @return boolean
     */
    public static function Cookie_set($key, $value, $expire = 86400, $domain = '', $path = '/', $secure = false, $httpOnly = false){
        // Redefine vars
        $key      = (string) $key;
        $value    = serialize($value);
        $expire   = time() + (int) $expire;
        $path     = (string) $path;
        $domain   = (string) $domain;
        $secure   = (bool) $secure;
        $httpOnly = (bool) $httpOnly;

        // Set cookie
        return setcookie($key, $value, $expire, $path, $domain, $secure, $httpOnly);
    }
    /**
     * Get a cookie
     *
     *  <code>
     *      $limit = Panel::Cookie_get('limit');
     *  </code>
     *
     * @param  string $key The name of the cookie that should be retrieved.
     * @return mixed
     */
    public static function Cookie_get($key){
        // Redefine key
        $key = (string) $key;

        // Cookie doesn't exist
        if( ! isset($_COOKIE[$key])) return false;

        // Fetch base value
        $value = (get_magic_quotes_gpc()) ? stripslashes($_COOKIE[$key]) : $_COOKIE[$key];

        // Unserialize
        $actual_value = @unserialize($value);

        // If unserialize failed
        if($actual_value === false && serialize(false) != $value) return false;

        // Everything is fine
        return $actual_value;

    }
    /**
     * Delete a cookie
     *
     *  <code>
     *      Panel::Cookie_delete('limit');
     *  </code>
     *
     * @param string $name The name of the cookie that should be deleted.
     */
    public static function Cookie_delete($key){
        unset($_COOKIE[$key]);
    }





















    /****************************************************************
    *
    *       SANITIZE URL
    *       PART OF GELATO FRAMEWORK
    *
    *****************************************************************/

    /**
     * Create safe url.
     *
     *  <code>
     *      $url = Panel::factory()->sanitizeURL($url);
     *  </code>
     *
     * @access  public
     * @param  string $url Url to sanitize
     * @return string
     */
    public function sanitizeURL($url){
        $url = trim($url);
        $url = rawurldecode($url);
        $url = str_replace(array('--','&quot;','!','@','#','$','%','^','*','(',')','+','{','}','|',':','"','<','>',
                                  '[',']','\\',';',"'",',','*','+','~','`','laquo','raquo',']>','&#8216;','&#8217;','&#8220;','&#8221;','&#8211;','&#8212;'),
                            array('-','-','','','','','','','','','','','','','','','','','','','','','','','','','','',''),
                            $url);
        $url = str_replace('--', '-', $url);
        $url = rtrim($url, "-");
        $url = str_replace('..', '', $url);
        $url = str_replace('//', '', $url);
        $url = preg_replace('/^\//', '', $url);
        $url = preg_replace('/^\./', '', $url);

        return $url;
     }










    /****************************************************************
    *
    *       ISLOGIN,ILOGOUT
    *       PART OF GELATO FRAMEWORK
    *
    *****************************************************************/

    /**
     * Starts the session.
     *
     *  <code>
     *      Panel::isLogin();
     *  </code>
     *
     */
    public static function isLogin(){
        // Is session already started?
        if ($_SESSION['login']) {
            // Start the session
            return @session_start();
        }
        // If already started
        return true;
    }
    /**
     * Destroys the session.
     *
     *  <code>
     *      Panel::isLogout();
     *  </code>
     *
     */
    public static function isLogout(){
        // Destroy
        if (session_id()) {
            session_unset();
            session_destroy();
            $_SESSION = array();
        }
    }
































    /****************************************************************
    *
    *       FILE EXIST,DELETE,SCAN
    *       PART OF GELATO FRAMEWORK
    *
    *****************************************************************/



    /**
     * Returns true if the File exists.
     *
     *  <code>
     *      if (Panel::file_exists('filename.txt')) {
     *          // Do something...
     *      }
     *  </code>
     *
     * @param  string  $filename The file name
     * @return boolean
     */
    public static function File_exists($filename){
        // Redefine vars
        $filename = (string) $filename;
        // Return
        return (file_exists($filename) && is_file($filename));
    }
    /**
     * Delete file
     *
     *  <code>
     *      Panel::File_delete('filename.txt');
     *  </code>
     *
     * @param  mixed   $filename The file name or array of files
     * @return boolean
     */
    public static function File_delete($filename){
        // Is array
        if (is_array($filename)) {
            // Delete each file in $filename array
            foreach ($filename as $file) {
                @unlink((string) $file);
            }
        } else {
            // Is string
            return @unlink((string) $filename);
        }
    }
    /**
     * Get list of files in directory recursive
     *
     *  <code>
     *      $files = Panel::File_scan('folder','md',true);
     *  </code>
     *
     * @param  string $folder Folder
     * @param  mixed  $type   Files types
     * @return array
     */
    public static function File_scan($dir){
        $indir = array_filter(scandir($dir), function($item) {
            return $item;
        });
        return array_diff($indir, array(".", ".."));
    }





































    /****************************************************************
    *
    *       DIR CREATE ,EXIST,DELETE
    *       PART OF GELATO FRAMEWORK
    *
    *****************************************************************/


    /**
     * Creates a directory
     *
     *  <code>
     *      Panel::Dir_create('folder1');
     *  </code>
     *
     * @param  string  $dir   Name of directory to create
     * @param  integer $chmod Chmod
     * @return boolean
     */
    public static function Dir_create($dir, $chmod = 0775){
        // Redefine vars
        $dir = (string) $dir;
        // Create new dir if $dir !exists
        return ( ! Panel::Dir_exists($dir)) ? @mkdir($dir, $chmod, true) : true;
    }
    /**
     * Delete directory
     *
     *  <code>
     *      Panel::Dir_delete('folder1');
     *  </code>
     *
     * @param string $dir Name of directory to delete
     */
    public static function Dir_delete($dir){
        foreach (glob($dir."/*.*") as $filename) {
            if (is_file($filename)) {
                unlink($filename);
            }
        }
        rmdir($dir);
    }
    /**
     * Checks if this directory exists.
     *
     *  <code>
     *      if (Panel::Dir_exists('folder1')) {
     *          // Do something...
     *      }
     *  </code>
     *
     * @param  string  $dir Full path of the directory to check.
     * @return boolean
     */
    public static function Dir_exists($dir){
        // Redefine vars
        $dir = (string) $dir;
        // Directory exists
        if (file_exists($dir) && is_dir($dir)) return true;
        // Doesn't exist
        return false;
    }





















    /****************************************************************
    *
    *       GETCONTENT ,SETCONTENT
    *       PART OF MORFY CMS
    *
    *****************************************************************/


    /**
     * Fetch the content from a file or URL.
     *
     *  <code>
     *      echo Panel::getContent('filename.txt');
     *  </code>
     *
     * @param  string  $filename The file name
     * @return boolean
     */
    public static function getContent($filename){
        // Redefine vars
        $filename = (string) $filename;
        // If file exists load it
        if (Panel::File_exists($filename)) {
            return file_get_contents($filename);
        }
    }

    /**
     * Writes a string to a file.
     *
     * @param  string  $filename   The path of the file.
     * @param  string  $content    The content that should be written.
     * @param  boolean $createFile Should the file be created if it doesn't exists?
     * @param  boolean $append     Should the content be appended if the file already exists?
     * @param  integer $chmod      Mode that should be applied on the file.
     * @return boolean
     */
    public static function setContent($filename, $content, $create_file = true, $append = false, $chmod = 0666){
        // Redefine vars
        $filename    = (string) $filename;
        $content     = (string) $content;
        $create_file = (bool) $create_file;
        $append      = (bool) $append;

        // File may not be created, but it doesn't exist either
        if ( ! $create_file && Panel::File_exists($filename)) throw new RuntimeException(vsprintf("%s(): The file '{$filename}' doesn't exist", array(__METHOD__)));
        // Create directory recursively if needed
        Panel::Dir_create(dirname($filename));
        // Create file & open for writing
        $handler = ($append) ? @fopen($filename, 'a') : @fopen($filename, 'w');
        // Something went wrong
        if ($handler === false) throw new RuntimeException(vsprintf("%s(): The file '{$filename}' could not be created. Check if PHP has enough permissions.", array(__METHOD__)));
        // Store error reporting level
        $level = error_reporting();
        // Disable errors
        error_reporting(0);
        // Write to file
        $write = fwrite($handler, $content);
        // Validate write
        if($write === false) throw new RuntimeException(vsprintf("%s(): The file '{$filename}' could not be created. Check if PHP has enough permissions.", array(__METHOD__)));
        // Close the file
        fclose($handler);
        // Chmod file
        chmod($filename, $chmod);
        // Restore error reporting level
        error_reporting($level);
        // Return
        return true;
    }























    /****************************************************************
    *
    *       DATABASE FUNCTIONS
    *
    *****************************************************************/




    /*
    *   If not exist in config show out alternative
    ^   Panel:Config('config text','alternative');
    */
    public static function Config($in,$out){
        if(isset($in)) $config = $in; else $config = $out;
        return $config;
    }
    /*
    *   Get config settings
    ^   Panel::settings('password')
    */
    public static function Settings($file,$filter){
        $config = self::getContent(DATABASE.DS.$file.'.json');
        $result = json_decode($config,true);
        return $result[$filter];
    }
    /*
    *   Get database file
    ^   Panel::db('shop')
    */
    public static function db($file){
        $config = self::getContent(DATABASE.DS.$file.'.json');
        $result = json_decode($config,true);
        return $result;
    }
    /*
    *   Get language
    ^   Panel::Lang('foo')
    */
    public static function Lang($filter){
        $config = self::getContent(LANGUAGE.DS.self::Settings('configuration','language').'.json');
        $result = json_decode($config,true);
        return $result[$filter];
    }














    /****************************************************************
    *
    *       SITE URL FUNCTION
    *
    *****************************************************************/



    /*
    *   Get  Site url default panel
    */
    public static function Root($url = false){
        return self::Settings('configuration','Site_url').'/'.$url;
    }
















    /****************************************************************
    *
    *       SEO LINK
    *
    *****************************************************************/


    /*
    *   Get  pretty url like hello-world
    */
    public static function seoLink($str){
        //Lower case everything
        $str = strtolower($str);
        //Make alphanumeric (removes all other characters)
        $str = preg_replace("/[^a-z0-9_\s-]/", "", $str);
        //Clean up multiple dashes or whitespaces
        $str = preg_replace("/[\s-]+/", " ", $str);
        //Convert whitespaces and underscore to dash
        $str = preg_replace("/[\s_]/", "-", $str);
        return $str;
    }



















    /****************************************************************
    *
    *       DEBUG PHP IN CONSOLE
    *
    *****************************************************************/

    /*
    *   Print data in javascript console
    */
    public static function Console($key,$value){
        $code = '<script>console.log("'.$key.' : '.$value.'");</script>';
        return print_r($code);
    }







    /****************************************************************
    *
    *       UPLOAD IMAGES REQUIRE RESIZE CLASS
    *
    *****************************************************************/



    /**
     * Multiple upload files
     *
     *  <code>
     *      $Render = Render::run()->uploadImages();
     *  </code>
     *
     * @access  public
     */
    public static function uploadImages(){
        require_once('class.resize.php');
        // css path
        $full   = ROOTBASE.DS.'public'.DS.'images'.DS;
        // submit botton
        if(Panel::Request_post('upload')){
            // get extension
            $ext =  pathinfo($_FILES['file_upload']['name'], PATHINFO_EXTENSION);

            if(!empty($_POST['width'])) $w = $_POST['width']; else $w = '100';
            if(!empty($_POST['height'])) $h = $_POST['height']; else $h = '100';
            if(!empty($_POST['options'])) $o = $_POST['options']; else $o = 'exact';

            $n = sha1(rand(1,1000)).'.'. $ext;
            // change name if repeat
            $name = sha1($n.rand(1,100)).'.'.$ext;

            if(isset($_FILES['file_upload'])){
                $errors= array();
                $file_name = $_FILES['file_upload']['name'];
                $file_size =$_FILES['file_upload']['size'];
                $file_tmp =$_FILES['file_upload']['tmp_name'];
                $file_type=$_FILES['file_upload']['type'];   
                $ext = explode('.',$_FILES['file_upload']['name']);
                $file_ext=strtolower(end($ext));
                $extensions = array("jpeg","jpg","png","gif");        
                if(in_array($file_ext,$extensions )=== false){
                    $errors[]= Panel::Lang('Unsupported filetype uploaded.');
                }
                if($file_size > 2097152){
                    $errors[]= Panel::Lang('Please ensure you are uploading an image.');
                }               
                if(empty($errors)==true){
                    move_uploaded_file($file_tmp, $full.$name);
                }else{
                    Panel::Notification_set('error',$errors);
                    Panel::Redirect(Panel::Root(Panel::Settings('configuration','Folder cms name').'?g=upload_image')); 
                }
            }

            $photos = self::getContent(PHOTOS.DS.'photos.json');
            $result = json_decode($photos,true);
            // make uniq id
            $id = uniqid();
            $result[$id] = array(
                'id' => $id,
                'title' => htmlentities(Panel::Request_post('title')),
                'description' => htmlentities(Panel::Request_post('description')),
                'tag' => htmlentities(Panel::Request_post('tag')),
                'image' => $name,
                'width' => htmlentities(Panel::Request_post('width')),
                'height' => htmlentities(Panel::Request_post('height'))
            );

            // create dir if not exist
            if(!Panel::Dir_exists($full.DS.$id)) Panel::Dir_create($full.DS.$id);

            // encode
            $save = json_encode($result, JSON_PRETTY_PRINT);
            // save content
            Panel::setContent(PHOTOS.DS.'photos.json',$save);
            // clean html and show this
            $html = '

                <div class="row">
                    <div class="small-12 medium-12 large-12 columns">
                        <span class="alert-box success">'.Panel::Lang('File uploaded successfully').'.</span>
                    </div>
                </div>

                <div class="row">
                    <div class="small-12 medium-12 large-12 columns">
                        <img class="th" style="width:100%;" src="'.Panel::Root().'/public/images/'.$name.'" alt="Image preview">
                    </div>
                </div>

                <footer class="footer">
                    <div class="row">
                        <div class="large-12 columns text-center">
                            <hr/>
                            <p><small>Official Support Forum / Documentation / © 2012 - 2014 Morfy – Version 3.0.1</small></p>
                        </div>
                    </div>
                </div>';

            $html .= 
              '<script src="'.Panel::Root(Panel::Settings('configuration','Folder cms name')).'/assets/js/jquery.min.js"></script>
              <script src="'.Panel::Root(Panel::Settings('configuration','Folder cms name')).'/assets/js/fastclick.min.js"></script>
              <script src="'.Panel::Root(Panel::Settings('configuration','Folder cms name')).'/assets/js/foundation.min.js"></script>
              <script src="'.Panel::Root(Panel::Settings('configuration','Folder cms name')).'/assets/js/ace/ace.js"></script>
              <script src="'.Panel::Root(Panel::Settings('configuration','Folder cms name')).'/assets/js/ace/ext-settings_menu.js"></script> 
              <script src="'.Panel::Root(Panel::Settings('configuration','Folder cms name')).'/assets/js/ace/ext-language_tools.js"></script> 
              <script src="'.Panel::Root(Panel::Settings('configuration','Folder cms name')).'/assets/js/app.js"></script>
              </body>
            </html>';

            die($html);
        }
    }
















    /****************************************************************
    *
    *       READ FOLDERS,FILES,ASSETS
    *
    *****************************************************************/




    /**
     * Read  folder files
     *
     *  <code>
     *      Panel::ReadFolder('../content','md');
     *  </code>
     *
     * @param  string  $folder The content folder
     * @param  string  $type File type
     * @return function
     */
    public static function ReadFolder($folder,$type=null){
        // scan folder contnet
        $entry = Panel::File_scan( $folder.'/',$type,true);
        if($entry){
            // Render folder
            panel::RenderFoldersFiles($folder.DS,$folder,$entry,$type);
        }else{
            $mode = 'markdown';
            echo '<span class="tools-alert tools-alert-red">'.Panel::Lang('The Folder is Empty').'  <a href="?n='.base64_encode($folder).'&t='.$mode.'">Add New File</a>  Or  <a  href="?dfd='.Panel::Request_Get('g').'" onclick="return confirm(\' Are you sure to delete this folder \')">Delete '.ucfirst(Panel::Request_Get('g')).' folder</a> </span>';
        }

    }



    /**
     * Read  all folders files
     *
     *  <code>
     *      Panel::ReadFolders('../content','md');
     *  </code>
     *
     * @param  string  $folder The content folder
     * @param  string  $type File type
     * @return function
     */
    public static function ReadFolders($folder,$type=null){

        // open dir ../content
        $handle = opendir($folder);
        while(($entry = readdir($handle)) !== false){

            if($entry == "." || $entry == ".."){
                continue;
            }
            elseif(is_dir($folder.DS.$entry)){
                $files = Panel::File_scan( $folder.'/'.$entry,$type,true);
                panel::RenderFoldersFiles($folder.'/'.$entry,$entry,$files,$type);
            }
        }
    }

    /**
     * Read  Assets files
     *
     *  <code>
     *      Panel::ReadAssetsFiles('../content','md');
     *  </code>
     *
     * @param  string  $folder The content folder
     * @param  string  $type File type css or js
     * @return function
     */
    public static function ReadAssetsFiles($folder,$type=null){
        // open dir ../content
        $handle = opendir($folder);
        while(($entry = readdir($handle)) !== false){
            if($entry == "." || $entry == ".."){
                continue;
            }elseif(is_dir($folder.DS.$entry)){
                $filetype = '';

                if($type == 'js'){
                    $js = isset($js) ? $js = 'js' : $js = 'assets';
                    $filetype = $js;
                    if($js == 'assets'){
                        $files = Panel::File_scan($folder.'/'.$entry.'/'.$js.'/js','js',true);
                        $filetype = $js.'/js';
                    }elseif($js == 'js'){
                        $files = Panel::File_scan($folder.'/'.$entry.'/'.$js,'js',true);
                        $filetype = $js;
                    }

                }
                if($type == 'css'){
                    $css = isset($css) ? $css = 'css' : $css = 'assets';
                    if($css == 'assets'){
                        $files = Panel::File_scan( $folder.'/'.$entry.'/'.$css.'/css','css',true);
                        $filetype = $css.'/css';
                    }elseif($css == 'css'){
                        $files = Panel::File_scan( $folder.'/'.$entry.'/'.$css,'css',true);
                        $filetype = $css;
                    }
                }

                if($type == 'html'){
                    $html = '';
                    $files = Panel::File_scan( $folder.'/'.$entry.'/','html',true);
                    $filetype = $html;
                }

                panel::RenderAssetsFiles($folder.'/'.$entry,$entry,$files,$type,$filetype);
            }
        }
    }









    /**
     * Show Assets files
     *
     *  <code>
     *      Panel::RenderFoldersFiles($path,$folder,$files,$type);
     *  </code>
     *
     * @param  string  $path The content folder
     * @param  string  $folder name of folder
     * @param  string  $files all content files
     * @param  string  $type  file type
     */
    public static function RenderFoldersFiles($path,$folder,$files,$type){
        $mode = 'markdown';
        $html = '
        <a  href="?n='.Panel::factory()->sanitizeURL(base64_encode($path)).'&t='.$mode.'" class="button tiny">New '.$type.' file</a>';

        $foldername = str_replace('../content/','',$folder);

        if($folder == '../content/'.$foldername){
             $html .= ' <a  href="?dfd='.$foldername.'" onclick="confirm(\' Are you sure to delete this folder \')" class="button alert tiny">Delete folder</a>';
        }

        $html .= '<table class="responsive">
            <thead>
                    <tr>
                        <th scope="column" style="width:33%" class="hide-for-small-only">Folder</th>
                        <th scope="column" style="width:33%">Files</th>
                        <th scope="column" style="width:33%" class="hide-for-small-only">Type</th>
                        <th scope="column" style="width:33%">Options</th>
                    </tr>
            </head>
            <tbody>';
        $i = 0;
        foreach ($files as $file) {
            if(!is_Dir($path.DS.$file)){
                // remove .md
                $url = str_replace('.md','',$file);
                // remove ../content
                $folder = str_replace('../content','',$folder);
                $folder = str_replace('/','',$folder);
                $mode = 'markdown';
                // if blank return no folder
                $name = ($folder) ? $folder = $folder.'/' : $name='No Folder';

                    $num = $i++;

                    $url = Panel::factory()->sanitizeURL(base64_encode('../content/'.$folder.$file));

                    $get = (Panel::Request_Get('g')) ? $get = Panel::Request_Get('g') : 'main';

                    $page = str_replace('.md','',$file);
                    
                    $html .= '
                        <tr>
                            <td scope="row" class="hide-for-small-only">'.$name.'</td>
                            <td scope="row">'.$file.'</td>
                            <td scope="row" class="hide-for-small-only">'.$type.'</td>
                            <td scope="row">
                                <button href="#" data-dropdown="drop_'.$num.'" aria-controls="drop_'.$num.'" aria-expanded="false" class="button tiny dropdown">Options</button><br>
                                <ul id="drop_'.$num.'" data-dropdown-content class="f-dropdown" aria-hidden="true" tabindex="-1">
                                    <li><a  target="_blank" href="'.Panel::Root().$folder.$page.'"><i class="fa fa-eye"></i> &nbsp; Preview</a></li>
                                    <li><a  href="?e='.$url.'&t='.$mode.'"><i class="fa fa-edit"></i> &nbsp; Edit</a></li>
                                    <li><a  href="?g='.$get.'&dp='.$url.'" onclick="return confirm(\' '.Panel::Lang('Are you sure').' !\')"><i class="fa fa-remove"></i> &nbsp; Delete</a></li>
                                </ul>
                            </td>
                        </tr>';
            }
        }
        $html .= '</tbody></table>';
        echo $html;
    }



    /**
     * Show Assets files
     *
     *  <code>
     *      Panel::RenderAssetsFiles($path,$folder,$files,$type);
     *  </code>
     *
     * @param  string  $path The content folder
     * @param  string  $folder name of folder
     * @param  string  $files all content files
     * @param  string  $type  file type
     */
    public static function RenderAssetsFiles($path,$folder,$files,$type,$filetype=''){

        if($type == 'css'){
            $mode = 'css';
        }elseif($type == 'js'){
            $mode = 'javascript';
        }else{
            $mode = 'php';
        }

        $html = '
        <p><a  href="?n='.Panel::factory()->sanitizeURL(base64_encode($path.'/'.$filetype)).'&t='.$mode.'" class="button tiny">New '.$type.' file</a></p>
        <table class="table-bordered table-stripped">
            <thead>
                <tr>
                    <th scope="column" style="width:33%" class="hide-for-small-only">Folder</th>
                    <th scope="column" style="width:33%">Files</th>
                    <th scope="column" style="width:33%" class="hide-for-small-only">Type</th>
                    <th scope="column" style="width:33%">Options</th>
                </tr>
            </thead>
            <tbody>';
        $i = 0;
        foreach ($files as $file) {
            if(!is_Dir($path.DS.$file)){
                $num = $i++;

                $get = Panel::Request_Get('g');

                if($get == 'templates'){
                    $url = Panel::factory()->sanitizeURL(base64_encode($path.'/'.$filetype.$file));                    
                }else{
                    $url = Panel::factory()->sanitizeURL(base64_encode($path.'/'.$filetype.'/'.$file)); 
                }

                $html .= '
                    <tr>
                        <td>'.$folder.'</td>
                        <td>'.$file.'</td>
                        <td>'.$type.'</td>
                        <td>
                    
                        <button href="#" data-dropdown="drop_'.$num.'" aria-controls="drop_'.$num.'" aria-expanded="false" class="button tiny dropdown">Options</button><br>
                        <ul id="drop_'.$num.'" data-dropdown-content class="f-dropdown" aria-hidden="true" tabindex="-1">
                            <li><a  href="?e='.$url.'&t='.$mode.'"><i class="fa fa-edit"></i> &nbsp Edit</a></li>
                            <li><a  href="?g='.$get.'&dp='.$url.'" onclick="return confirm(\' '.Panel::Lang('Are you sure').' !\')""><i class="fa fa-remove"></i> &nbsp Delete</a></li>
                        </ul>
                        </td>
                    </tr>';
            }
        }
        $html .= '</tbody></table>';
        echo $html;
    }






    /**
     * Create zip files
     *
     *  <code>
     *      Panel::Create_zip($files,$folder);
     *  </code>
     *
     * @param  array  $source_arr 
     * @param  string  $destination name of folder
     */
    public static function Create_zip($source_arr, $destination){

        if (!extension_loaded('zip')) {
            return false;
        }
        $zip = new ZipArchive();
        if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
            return false;
        }
        foreach ($source_arr as $source){

            if (!file_exists($source)) continue;

            $source = str_replace('\\', '/', realpath($source));

            if (is_dir($source) === true){
                $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
                foreach ($files as $file){
                    $file = str_replace('\\', '/', realpath($file));

                    if (is_dir($file) === true){
                        $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                    }else if (is_file($file) === true){
                        $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                    }
                }
            }else if (is_file($source) === true){
                $zip->addFromString(basename($source), file_get_contents($source));
            }

        }

        return $zip->close();

    }

}

