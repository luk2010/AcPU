<?php

require 'AcPU.php';

//Cette fonction remplace la fonction par defaut
function headerfunc($title, $description)
{
    ?>

<body>

    <?php
}

function Center_Function()
{
    ?>

    <h1>Tutorial 2 - Autogeneration du head</h1>
    <p>AcPU peut autogenerer l'interieur des balises &lt;head&gt;, en lui specifiant les differentes balises.</p>

    <?php
}

$page = Page::get();

//On va remplacer la fonction par defaut par celle qu'on a definit
$page->setHeaderFunc(header_func);

//On va indiquer que le head doit etre genere automatiquement
$page->setManualHeader(false);

//On definit le header et son contenu
$page->addMeta("charset", "utf-8");
$page->addMeta("description", "Ceci est une bien belle page !");
$page->addHeadLinks("style.css", "stylesheet");

//On peut dessiner la page ;)
$page->draw("Exemple 2 - AutoGeneration du head", "");

?>
