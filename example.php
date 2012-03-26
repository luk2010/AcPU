<?php

require 'AcPU.php';

//This is an example php file that draw a simple page

//1 - We make function Center_Function
function Center_Function()
{
    echo '<h1>AcPU - Tutorial 1 : Hello World !</h1>';
    
    ?>

<p>
    This tutorial will show you the basis to better understand how to make a basic web page with AcPU. It is very easy to generate this kind of page :
</p>

<h2>1 - Create a new php page</h2>
<p>This is an evidence ;)</p>

<h2>2 - Include the AcPU.php file</h2>

<h2>3 - Create Function Center_Function()</h2>
<p>This function is used by the AcPU to draw the center of your page (between header and footer ;) ).</p>

<h2>4 - Call the Page::get()->draw() function</h2>
<p>This function has 2 argues : the title of your web page, and his description !</p>

    <?php
}

//For convenience, we just recup the page in a variable
$page = Page::get();

//2 - We draw the page, with title and description ;)
$page->draw("Example - First step", "This example shows the first steps !");

?>
