<?php

require 'AcPU.php';

//Cet exemple montre comment utiliser les bases de donnees, ainsi que les variables POST

$htmlConstructor = AcPU::get()->createHTMLConstructor('Constructor');
$bdd = AcPU::get()->initMySQLBdd('exemple5', 'root', '', 'localhost');

/*
 * Petit script qui ajoute un article si il a ete envoye.
 */

$titre_article = AcPU::get()->getPost('titre');
$contenu_article = AcPU::get()->getPost('article');

if($titre_article != '')
{
    if($contenu_article == '')
    {
        $htmlConstructor->getHeader()->addParagraphe('Please don\'t send empty article ^^');
    }
    else
    {
        $bdd->alter()->insertInto('article', array('titre', 'contenu'))->values(array($titre_article, $contenu_article))->end();
    }
}

/*
 * Creation de la page.
 */

$header = $htmlConstructor->getHeader();
    $header->createChildWithText('h1', 'Une liste d\'articles');
    
$center = $htmlConstructor->getCenter();
    $div_article = $center->createChild('div', 'articles');
    $div_article->addProperty('style', 'border: 1px solid black;');
    
$datas = $bdd->request()->select('*')->from('article')->order_by('ID')->desc()->end()->fetchAll();
foreach($datas as $article)
{
    $article_element = $div_article->createChildWithText('h1', $article['titre']);
    $div_article->addParagraphe($article['contenu']);
}

    $div_addArticle = $center->createChild('div', 'add_article');
    $div_addArticle->addProperty('style', 'border: 1px solid black;');
    
    $form = $div_addArticle->addForm('AddArticle', 'post', '#');
    $form->addInput('Titre de l\'article :', 'titre', 'text', '');
    
    $form->addLabel('article', 'Contenu de l\'article : ');
    $form->addTextArea('article');
    
    $form->addInput('', 'submit', 'submit', 'Submit');
    
$footer = $htmlConstructor->getFooter();
$footer->addParagraphe('Exemple fait avec '.AcPU::version().'.');

/*
 * Dessin de la page.
 */

$page = Page::get();

$page->setManualHeader(false);
$page->setHTMLConstructor($htmlConstructor);

$page->addMeta('charset', 'utf-8');

$page->draw('Exemple 5 - Going through BDD', '');

?>
