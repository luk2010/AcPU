<?php

// Example 10 : Using PayPal Object. 

require '../AcPU/AcPU.php';
require '../AcPU/PayPal.php';

$htmlConstructor = AcPU::get()->createHTMLConstructor('My Constructor');

$header = $htmlConstructor->getHeader();
$header->importHtmlFile('exemple9/header.html');

$center = $htmlConstructor->getCenter();
$center->importHtmlFile('exemple9/center.html');

$copy = $center->findRecursiveByName('CopyMe')->copyElement('I am the copy');
$center->findRecursiveByName('ToMe')->getParent()->addChild($copy);

$paypalObj = new PayPal("jacques.tronconi-facilitator_api1.gmail.com", "ADQY6WTG6RBBRS9E",
					   "AFcWxV21C7fd0v3bYYYRCpSSRl31Av0pHr3t-Df76cZjmgDQ.CNbdFkO");
$paypalObj->SetSandBoxed(true);
// We will add the Node to the center node.
$center->importHtml($paypalObj->MakePayPalForm());

$footer = $htmlConstructor->getFooter();
$footer->importHtmlFile('exemple9/footer.html');

$page = Page::get();

$page->setHTMLConstructor($htmlConstructor);
$page->setManualHeader(false);

$page->addMeta('charset', 'utf-8');
$page->draw('Exemple 10', '');

?>