<?php defined('PANEL_ACCESS') or die('No direct script access.'); ?>

	<ul class="breadcrumbs">
	  <li><a href="#"><i class="fa fa-home"></i></a></li>
	  <li class="unavailable"><a href="#">Settings</a></li>
	  <li class="current"><a href="#">Documentation</a></li>
	</ul>
  

	<div class="row">
		<div class="medium-12 columns">


		    <h4>Text file markup</h4>
        <p>Text files are marked up using Markdown Plugin. They can also contain regular HTML. At the top of text files you can place a block comment and specify certain attributes of the page.</p>
		    <pre>
Title: Welcome  
Description: Some description here  
Keywords: key, words  
Author: Awilum  
Date: 2013/12/31  
Tags: tag1, tag2  
Robots: noindex,nofollow  
Template: index (allows you to use different templates in your theme)  

----
        </pre>



        <hr>





        <h4>Text file vars</h4>
        <p>Text files are marked up using Markdown Plugin. They can also contain regular HTML. At the top of text files you can place a block comment and specify certain attributes of the page.</p>
        <pre>

{site_url}        Outputs site url
{morfy_separator} Outputs morfy separator
{morfy_version}   Outputs morfy version
{cut}             Page Cut
{php}             For embeded php code
        </pre>




        <hr>





        <h4>Theme structure</h4>
        <pre>
themes
  - default
    - - blog.html
    - - blog_post.html
    - - footer.html
    - - header.html
    - - index.html
    - - navbar.html
        </pre>


        <hr>




        <h4>Theme variables</h4>
        <pre>

$config['site_url'] Site url
$config['site_charset'] Site charset
$config['site_timezone']  Site timezone
$config['site_theme'] Site theme
$config['site_title'] Site title
$config['site_description'] Site description
$config['site_keywords']  Site keywords


Page  
$page['title']  Page title
$page['description']  Page description
$page['keywords'] Page keywords
$page['tags'] Page tags
$page['url']  Page url
$page['author'] Page author
$page['date'] Page date
$page['robots'] Page robots
$page['template'] Page template
        </pre>


        <hr>



      <h4>Blog poste example</h4>
      <pre>
Title: Hello World!
Description: Some description here   
Keywords: Some keywords here  
Author: Admin
Date: January 20, 2014
Tags: Some tags here  
Template: blog_post

----

## Example heading here

Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima, sunt, nisi id magni dignissimos rem dolorem aut dicta quis a officiis accusamus cum facere reiciendis quam iste laborum! Quasi, quos.

<!-- Short post to blog.html -->
{cut}

Vitae, velit, temporibus sequi mollitia dolorem voluptatibus assumenda et cumque soluta laudantium commodi odit cupiditate eos nobis quisquam obcaecati vero rerum ut.
      </pre>



        <hr>




      <h4>Portfoliio images</h4>
      <pre>
&lt;?php
  // get json
  $file = file_get_contents('public/photos.json');
  // decode
  $json = json_decode($file,true);
  // start loop
  $html = '&lt;div class="images-loop"&gt;'; 
  // loop
  foreach ($json as $item) {

    // custom vars i not use all for this demo
    $url = Morfy::$config['site_url'].'/public/images/';
    $title = $item['title'];
    $description = $item['description'];
    $tag = $item['tag'];
    $width = $item['width'];
    $height = $item['height'];
    $image = $url.$item['image'];


    // inner loop
    $html .= '&lt;a data-filter="'.$tag.'" href="'.$image.'" title="'.$title.'"&gt;
      &lt;img width="'.$width.'" height="'.$height.'" src="'.$image.'"&gt;
    &lt;/a&gt;'; 
  }
  // end loop
  $html .='&lt;/div&gt;'; 
  // render
  echo  $html;
?&gt;
      </pre>


        <hr>



      <h4>Contact simple </h4>
      <pre>
&lt;?php 
// send mail simple
  if (isset($_POST['sd'])){
    $to = 'example@gmail.com';
    $name = $_POST[ "name"];
    $message = $_POST["message"];
    $headers = 'From: '.$_POST[ "email" ].PHP_EOL;
    if(isset($_POST["robot"])){
      if(mail($to, name, $message, $headers)){
        echo('&lt;span class="success"&gt;Your e-mail has been sent! You should receive a reply within 24 hours!&lt;/span&gt;');            
      }else{
        echo('&lt;span class="error" &gt;Houston i have a problem&lt;/span&gt;');
      }              
    }else{
      echo('&lt;span class="error"&gt;Are you a robot ?&lt;/span&gt;');
    }
  }
?&gt;
      </pre>


    </div>	
	</div>

