<?php

/*
 * Exemple 8
 * 
 * Show how to :
 * 
 * - Use dynamics Javascript event system with JQuery
 * - Create JavaScript Functions
 * - Use the JavaScriptConstructor
 * 
 */

require '../AcPU/AcPU.php';

$htmlConstructor = AcPU::get()->createHTMLConstructor('Constructor');
$jsConstructor = $htmlConstructor->createJavaScriptConstructor('JSConstructor');

$htmlConstructor->getHeader()->createChildWithText('h1', 'Exemple 8', 'titre');

$center = $htmlConstructor->getCenter();
$center->addText('Click on the paragraphe below to make him slideUp !');
$paragraphe = $center->addParagraphe('I am a paragraphe...', array(), 'paragraphe');
$paragraphe2 = $center->addParagraphe('Click on me to show again the text !', array(), 'ClickToShow');

$javafunction_content = '$(this).slideUp();';
$javafunction = $jsConstructor->createFunction('paragraphe_click', array(), $javafunction_content);
$jsConstructor->addEventListener($paragraphe, 'click', $javafunction);

$function2_content = '$("#paragraphe").slideDown();';
$function2 = $jsConstructor->createFunction('paragraphe_show', array(), $function2_content);
$jsConstructor->addEventListener($paragraphe2, 'click', $function2);

$page = Page::get();
$page->setHTMLConstructor($htmlConstructor);
$page->setManualHeader(false);

$page->addMeta('charset', 'utf-8');
$page->addJavaScriptFile('jquery.js');

$page->draw('Exemple 8', '');

?>
