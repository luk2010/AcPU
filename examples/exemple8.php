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
$jquery = $jsConstructor->initJQuery();
$dragdrop = $jsConstructor->initDragAndDrop();

$htmlConstructor->getHeader()->createChildWithText('h1', 'Exemple 8', 'titre');

$center = $htmlConstructor->getCenter();

$center->addText('Click on the paragraphe below to make him slideUp !');
$paragraphe = $center->addParagraphe('I am a paragraphe...', array(), 'paragraphe');
$paragraphe2 = $center->addParagraphe('Click on me to show again the text !', array(), 'ClickToShow');

$carre1 = $center->createChild('div', 'My Draggable', '', array('draggable'));
$dragdrop->addDraggable('draggable');
$carre1->addText('Drag this to where you want ;)');

// Evenement du paragraphe 1
$javafunction_content = '$(this).slideUp();';
$javafunction = $jquery->addFunction('paragraphe_click', array(), $javafunction_content);
$jquery->addEventListener($paragraphe, 'click', $javafunction);

// Evenement du paragraphe 2
$function2_content = '$("#paragraphe").slideDown();';
$function2 = $jquery->addFunction('paragraphe_show', array(), $function2_content);
$jquery->addEventListener($paragraphe2, 'click', $function2);

$page = Page::get();
$page->setHTMLConstructor($htmlConstructor);
$page->setManualHeader(false);

$page->addMeta('charset', 'utf-8');
$page->addJavaScriptFile('jquery.js');

$page->draw('Exemple 8', '');

?>
