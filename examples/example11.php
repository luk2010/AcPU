<?php 

// Example 11 : Create a Menu using the UiConstructor Object, and uses of Layout objects.

require_once "../AcPU/AcPU.php";
require_once "../AcPU/UiConstructor.php";

$page = Page::get();
$page->setManualHeader(false);
$page->setHTMLConstructor(AcPU::get()->createHTMLConstructor('Constructor'));

$page->addMeta('charset', 'utf-8');
$page->addHeadLinks('css/acpu-main.css', 'stylesheet');
$page->addHeadLinks('css/acpu-menubar-default.css', 'stylesheet');

$htmlConstructor = Page::Get()->GetHtmlConstructor();
$UiConstructor   = new UiConstructor();

$MenuBar = $UiConstructor->CreateMenuBar("MenuTest", array('Item1', 'Item2'));
$MenuBar->SetStyle('cssmenu'); // Style found in default AcPU stylesheet.
$MenuBar->AddItem('Item3');

$Title1 = $UiConstructor->CreateSimpleTitle(2, 'Example 11', $htmlConstructor->GetCenter());

$Vert = $UiConstructor->CreateVerticalLayout(null, $htmlConstructor->GetCenter());

$layout1style = array ('background-color' => 'coral', 
					   'border' => '1px dotted black',
					   'border-spacing' => '2px',
					   'margin' => '1px',
					   'padding' => '2px');

$layout2style = array ('background-color' => 'blue', 
					   'border' => '1px dotted black',
					   'border-spacing' => '2px',
					   'margin' => '1px',
					   'padding' => '2px');

$layout1prop = array (
	0 => array('grow' => '1'),
	1 => array('grow' => '1')
);

$layout2prop = array (
	0 => array('grow' => '1'),
	1 => array('grow' => '2')
);

$MyLayout = $UiConstructor->CreateHorizontalLayout($layout1prop, $Vert->Get(0));
$MyLayout->Container->AddStyles($layout1style); 

$MyLayoutT1 = $UiConstructor->CreateSimpleTitle(2, 'Layout 1', $MyLayout->Get(0));
$MyLayoutT2 = $UiConstructor->CreateSimpleTitle(2, 'Layout 2', $MyLayout->Get(1));
$MyLayout->Get(0)->AddParagraphe('Layout 1');
$MyLayout->Get(1)->AddParagraphe('Layout 2');

$MyLayout2 = $UiConstructor->CreateHorizontalLayout($layout2prop, $Vert->Get(1));
$MyLayout2->Container->AddStyles($layout2style);

$MyLayout2T1 = $UiConstructor->CreateSimpleTitle(2, 'Layout 3', $MyLayout2->Get(0));
$MyLayout2T2 = $UiConstructor->CreateSimpleTitle(2, 'Layout 4', $MyLayout2->Get(1));
$MyLayout2->Get(0)->AddParagraphe('Layout 3');
$MyLayout2->Get(1)->AddParagraphe('Layout 4');

$Vert2Prop = array (0 => array('grow' => 3),
					1 => array('grow' => 1));
$Vert2 = $UiConstructor->CreateVerticalLayout($Vert2Prop, $MyLayout->Get(1));
$Vert2->Get(0)->AddParagraphe('Layout 5');
$Vert2->Get(1)->AddParagraphe('Layout 6');

$page->draw('Exemple 11', '');

?>