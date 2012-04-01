<?php

/*
 * Here, you can change the templates to draw a cool header and footer ;).
 * 
 * These functions are deprecated ! You should use HtmlConstructor to construct your page, 
 * and import your html if you don't want to retype it ;).
 */

//Draw the header
function Header_Func($title, $description)
{
    ?>
<head>
    <title>
        <?php echo $title; ?>
    </title>
</head>

    <body>

    <?php
}

//Draw the footer
function Footer_Func()
{
    ?>
      
        <p>Build with <?php echo AcPU::version(); ?>.</p>
    </body>
</html>
        
    <?php
}

?>
