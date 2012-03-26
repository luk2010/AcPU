<?php

/*
 * Here, you can change the templates to draw a cool header and footer ;)
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
