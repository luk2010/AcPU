<?php

/*
 * Exemple 6
 * 
 * Show how to :
 * 
 * 1. Use CondiitonElement to draw part of code.
 * 2. Use TemplateElement to draw pre-defined custom code.
 * 3. Use HtmlElement::importHtml() to import custom Html to AcPU elements.
 * 
 */

require 'AcPU.php';

function myTemplate()
{
    $html = '';
    
    $html .= '<p>This comes from the template ;)<br /></p>';
    
    return $html;
}

$html_code = '<p name="Imported Code">This has been imported !<div><p>This is an child of child element !</p></div></p>';

$is_returned = FALSE;
$is_returned = (isset($_GET['ret']) and $_GET['ret'] == 'win');

$htmlConstructor = AcPU::get()->createHTMLConstructor('Constructor');

$headerElement = $htmlConstructor->getHeader();
$headerElement->createChild('h1', 'Exemple Title')->addText('Exemple 6');

$center = $htmlConstructor->getCenter();
$conditionElement = $center->addCondition('My Condition', $is_returned == true);
    $conditionElement->addParagraphe('Condition successed !');
    
$conditionElement2 = $center->addCondition('My inversed condition', $is_returned == false);
    $conditionElement2->addParagraphe('Condition successfully failed ;) !');

$link_to_succed = $center->addLink('Link to succeed', 'Succeed !', '?ret=win');
$center->returnToLine(2);
$link_to_fail = $center->addLink('Link to fail', 'Fail...', '?ret=loose');

$center->importHtml($html_code);

$footer = $htmlConstructor->getFooter();
$footer->addTemplate('MyTemplate', myTemplate);

$page = Page::get();
$page->setManualHeader(false);
$page->setHTMLConstructor($htmlConstructor);

$page->addMeta('charset', 'utf-8');

$page->draw('Exemple 6', '');

?>
