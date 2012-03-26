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
    
    $html .= '<p>This comes from the template ;)</p>';
    
    return $html;
}

$html_code = '<p name="Imported Code">This has been imported !</p>';

$is_returned = FALSE;

//if ($_GET['ret'] === 'yes')
  //  $is_returned = true;

$htmlConstructor = AcPU::get()->createHTMLConstructor('Constructor');

$headerElement = $htmlConstructor->getHeader();
$headerElement->createChild('h1', 'Exemple Title')->addText('Exemple 6');

$center = $htmlConstructor->getCenter();
$conditionElement = $center->addCondition('My Condition', $is_returned);
    $conditionElement->addParagraphe('Condition successed !');

$link_to_succed = $center->addLink('Link to succeed', 'Succeed !', '?ret=yes');

$center->importHtml($html_code);

$footer = $htmlConstructor->getFooter();
$footer->addTemplate('MyTemplate', myTemplate);

$page = Page::get();
$page->setManualHeader(false);
$page->setHTMLConstructor($htmlConstructor);

$page->addMeta('charset', 'utf-8');

$page->draw('Exemple 6', '');

?>
