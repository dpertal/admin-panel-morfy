<?php defined('PANEL_ACCESS') or die('No direct script access.'); ?>

<!DOCTYPE html>
<html>
  <head>
    <title><?php echo Panel::Settings('configuration','Cms name'); ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo Panel::Root(Panel::Settings('configuration','Folder cms name')); ?>/assets/css/foundation.min.css">
    <link rel="stylesheet" href="<?php echo Panel::Root(Panel::Settings('configuration','Folder cms name')); ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo Panel::Root(Panel::Settings('configuration','Folder cms name')); ?>/assets/css/font-awesome.min.css">
    <script rel="javascript" src="<?php echo Panel::Root(Panel::Settings('configuration','Folder cms name')); ?>/assets/js/modernizr.min.js"></script>

  </head>
  <body id="admin">

    <?php include PARTIALS.DS.'header.php'; ?>

    <div class="row">
    <?php
        // login function
        Morfy::factory()->runAction('Login');
        // if login
        if (isset($_SESSION['login'])) {
    ?>
        <div class="small-12 medium-12 large-12 columns">
            <section class="main">
            <?php
              Morfy::factory()->runAction('Debug');
              Morfy::factory()->runAction('Info');
              Morfy::factory()->runAction('Sections');
            ?>

    <?php }else{ // if not login ?>
        <div class="small-12 medium-12 large-12 columns">
            <section class="main">
              <?php
                  Morfy::factory()->runAction('Debug');
                  Morfy::factory()->runAction('Info');
                  include VIEWS.DS.'login.php'; }
              ?>
            </section>
        </div>
    </div>


    <?php include PARTIALS.DS.'footer.php'; ?>

  <!-- Default -->
  <script src="<?php echo Panel::Root(Panel::Settings('configuration','Folder cms name')).'/assets/js/jquery.min.js'; ?>"></script>
  <script src="<?php echo Panel::Root(Panel::Settings('configuration','Folder cms name')).'/assets/js/fastclick.min.js'; ?>"></script>
  <script src="<?php echo Panel::Root(Panel::Settings('configuration','Folder cms name')).'/assets/js/foundation.min.js'; ?>"></script>

  <!-- Ace -->  
  <script src="<?php echo Panel::Root(Panel::Settings('configuration','Folder cms name')).'/assets/js/ace/ace.js'; ?>"></script>
  <script src="<?php echo Panel::Root(Panel::Settings('configuration','Folder cms name')).'/assets/js/emmet.min.js'; ?>"></script> 
  <script src="<?php echo Panel::Root(Panel::Settings('configuration','Folder cms name')).'/assets/js/ace/ext-emmet.js'; ?>"></script> 
  <script src="<?php echo Panel::Root(Panel::Settings('configuration','Folder cms name')).'/assets/js/ace/ext-settings_menu.js'; ?>"></script> 
  <script src="<?php echo Panel::Root(Panel::Settings('configuration','Folder cms name')).'/assets/js/ace/ext-language_tools.js'; ?>"></script> 

  <?php if(Panel::Request_get('t') == 'markdown'){ ?>
    <!-- markdown -->
    <script src="<?php echo Panel::Root(Panel::Settings('configuration','Folder cms name')).'/assets/js/markdown.js'; ?>"></script>
  <?php }; ?>

  <!-- Custom -->  
  <script src="<?php echo Panel::Root(Panel::Settings('configuration','Folder cms name')).'/assets/js/app.js'; ?>"></script>




  <?php if(Panel::Request_get('t') != 'markdown'){ ?>  

  <script>

  <?php 
        $Ace_theme =  Panel::Settings('configuration','Ace_theme');
        $Ace_tabsize =  Panel::Settings('configuration','Ace_tabsize');
        $Ace_fontSize =  Panel::Settings('configuration','Ace_fontSize');
        $Ace_autocompletion = Panel::Settings('configuration','Ace_autocompletion');
        $Ace_Emmet = Panel::Settings('configuration','Ace_emmet'); 
  ?>
      
      
  if (document.querySelector('#editor')) {
        var editor = ace.edit("editor");
        var textarea = $('#editor-area');
        editor.setTheme("ace/theme/<?php echo $Ace_theme; ?>");
        editor.getSession().setTabSize(<?php echo $Ace_tabsize; ?>);
        editor.getSession().setMode("ace/mode/" + $('#editor').attr('data-type'));
        editor.getSession().setValue(textarea.val());
        editor.getSession().on('change', function() {
            textarea.val(editor.getSession().getValue());
        });

        ace.require("ace/ext/language_tools");
        editor.setOptions({
            enableBasicAutocompletion: <?php echo $Ace_autocompletion; ?>,
            fontSize: <?php echo $Ace_fontSize; ?>,
            enableEmmet: <?php echo $Ace_Emmet; ?>
        });

        ace.require('ace/ext/settings_menu').init(editor);
        editor.commands.addCommands([{
            name: "showSettingsMenu",
            bindKey: {
                win: "Ctrl-q",
                mac: "Command-q"
            },
            exec: function(editor) {
                editor.showSettingsMenu();
            },
            readOnly: true
        }]);

        editor.resize();
    }
  </script>
  <?php }; ?>

  </body>
</html>