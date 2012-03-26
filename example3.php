<?php

//Cet example montre comment creer une page grace au HTMLConstructor

//Inclusion de AcPU
require 'AcPU.php';

//Creation du constructeur
$htmlConstructor = AcPU::get()->createHTMLConstructor('My Constructor');

//On ajoute quelques balises
$titre = $htmlConstructor->getHeader()->createChild('h1', 'Un titre', 'mon_titre', array('ma_classe', 'ma_deuxieme_classe'));
$titre->addText('Ceci est un titre ;)');

$paragraphe = $htmlConstructor->getCenter()->createChild('p', 'paragraphe_principal');
$paragraphe->addText('Ceci est un beau paragraphe ! On peut faire ce que l\'on veut grace a AcPU ^^...');

//On va tester l'encapsulation
$div_centre = $htmlConstructor->getCenter();
$div_centre->addClass('centre');

$div_helloworld = $div_centre->createChild('div', 'cadre_helloWorld', '', array('hello'));
$div_helloworld->addParagraphe('Hello World avec style !');

//On cree la page
$page = Page::get();

//On cree le header
$page->setManualHeader(false);
$page->addMeta('charset', 'utf-8');

//On lui attribue le constructeur
$page->setHTMLConstructor($htmlConstructor);

//On dessine la page
$page->draw('Ma belle page', 'Ceci est une tres belle page autogeneree ;)');

?>
