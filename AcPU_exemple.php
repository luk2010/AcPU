<?php

require 'AcPU.php';// Le plus important ;)

//On va construire la page web grace a un constructeur
$htmlConstructor = AcPU::get()->createHTMLConstructor('Mon Constructor');// Le nom est inutile pour l'instant ;)

//Les balises header, footer, header sont deja crees ;)
//Le head se fait apres

//On va rajouter un titre dans une barre
$ma_barre = $htmlConstructor->getHeader()->createChild('div', 'barre de titre');
$ma_barre->addProperty('style', 'width=100%; height=50px; background-color=#000;');

$mon_titre = $ma_barre->createChild('h1', 'Titre');
$mon_titre->addText('Le titre');

//Bon maintenant on va mettre un sous titre dans le centre, juste pour le fun :)
$mon_sous_titre = $htmlConstructor->getCenter()->createChild('h2', 'Un sous titre');
$mon_sous_titre->addText('Un sous titre');

//Et on va rajouter le footer
$htmlConstructor->getFooter()->addParagraphe('Copyright Les cons.com');

//Maintenant on va creer la page
$page = Page::get();

//On lui donne le constructeur
$page->setHTMLConstructor($htmlConstructor);

//On fais le head
$page->setManualHeader(false);//Il ne faut pas oublier de lui indiquer que l'on veut automatiquement generer le head ;)
$page->addMeta('charset', 'utf-8');

//le titre est genere automatiquement

//On peut donc dessiner la page ;)
$page->draw('Exemple', '');//Pardon ;p

?>

Le style que j'ai donne a la div de header de marche par car il faut aussi appliquer width:100% au body, ce qui n'est pas possible pour le moment ;)

Voila ^^

Le fichier resultant est "compresse", ce qui signifie qu'il ne contient pratiquement qu'une seule ligne ! lol