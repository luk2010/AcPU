<?php

/*
 * Exemple 9
 * 
 * Show how to :
 * 
 * - Use the importHtmlFile function
 * - Modify content of imported Html from a file and copy node.
 * 
 */

require '../AcPU/AcPU.php';

$htmlConstructor = AcPU::get()->createHTMLConstructor('My Constructor');

$header = $htmlConstructor->getHeader();
$header->importHtmlFile('exemple9/header.html');

$center = $htmlConstructor->getCenter();
$center->importHtmlFile('exemple9/center.html');

$copy = $center->findRecursiveByName('CopyMe')->copyElement('I am the copy');
$center->findRecursiveByName('ToMe')->getParent()->addChild($copy);

$footer = $htmlConstructor->getFooter();
$footer->importHtmlFile('exemple9/footer.html');

$page = Page::get();

$page->setHTMLConstructor($htmlConstructor);
$page->setManualHeader(false);

$page->addMeta('charset', 'utf-8');
$page->draw('Exemple 9', '');

?>
