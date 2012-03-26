<?php

// Un exemple de page plus complexe auto-generee ^^

require 'AcPU.php';

$htmlConstructor = AcPU::get()->createHTMLConstructor('Constructor');

$header = $htmlConstructor->getHeader();
    $hbar1 = $header->createChild('header');
        $hbar1_h1 = $hbar1->createChildWithText('h1', 'sendergold');
            
        $hbar1_menu = $hbar1->createChild('menu');
            $hbar1_menu_settings = $hbar1_menu->createChild('li', 'settings', 'settings');
                $hbar1_menu_settings->addLink('settings', 'Settings', '#');
                
            $hbar1_menu_favorites = $hbar1_menu->createChild('li', 'favorites', 'favorites');
                $hbar1_menu_favorites->addLink('favorites', 'Favorites', '#');
                
            $hbar1_menu_hotline = $hbar1_menu->createChild('li', 'hotline', 'hotline');
                $hbar1_menu_hotline->addLink('hotline', 'Hotline', '#');
                
    $hbar2 = $header->createChild('section', 'navigation', 'navigation');
        $hbar2->addLink('general', 'General', '#', 'general');
        $hbar2->addLink('eshop', 'E-Shop', '#', 'eshop');
        $hbar2->addLink('lovers', 'Lovers', '#', 'lovers');
        
        $hbar2->addInput('send', 'button', 'Send', 'envoyer');
        $hbar2->createChildWithText('textarea', '', 'texte', 'zone_texte');
        $hbar2->addInput('search', 'button', 'Search', 'rechercher');
        
        $hbar2->addLink('destination', 'Place', '#', 'destination');
        $hbar2->addLink('age', 'Old', '#', 'age_navi');
        $hbar2->addLink('gender', 'Gender', '#', 'sexe');
        
$center = $htmlConstructor->getCenter();
    $bloc_page = $center->createChild('div', 'bloc_page', 'bloc_page');
        $mon_profil = $bloc_page->createChild('div', 'profil', 'mon_profil');
            $mon_profil->createChildWithText('h3', 'My Profile', 'titre_profil', 'titre_profil');
        
            $mon_profil->addLink('nom', 'Leo Maurel', '#', 'nom');
            $mon_profil->addLink('age', '18 years', '#', 'age');
            $mon_profil->addLink('pays', 'France', '#', 'pays');
            $mon_profil->addLink('envoyes', 'Sent', '#', 'envoyes');
            $mon_profil->addLink('recus', 'Received', '#', 'recu');
            $mon_profil->addLink('top5', 'Best Messages', '#', 'top5');
            $mon_profil->addLink('photos', 'Pictures', '#', 'photos');
    
        $cadre_haut = $bloc_page->createChild('div', 'cadre_haut', 'cadre_haut');
            $cadre_haut->createChildWithText('h3', 'Answers to your messages', 'answers', 'titre_cadre_haut');
            
            $cadre_haut_p1 = $cadre_haut->createChild('p');
            $cadre_haut_p1->addLink('', 'Leo Maurel :', '#');
            $cadre_haut_p1->addText('lieajfu dzd, djedj"ozkdlz,d zindie,d;s ks,xsoi');
            
            $cadre_haut_p2 = $cadre_haut->createChild('p');
            $cadre_haut_p2->addLink('', 'Jacques Tronconi :', '#');
            $cadre_haut_p2->addText('kdzod !! d"kdkod"d,"od jzihjd sjnxksnxh ksnxks,xnsixjskx,sk');
            
            $cadre_haut_p3 = $cadre_haut->createChild('p');
            $cadre_haut_p3->addLink('', 'Nicolas Sarkozy :', '#');
            $cadre_haut_p3->addText('lieajfu dzd, djedj"ozkdlz,d zindie,d;s ks,xsoi');
            
            $cadre_haut_p4 = $cadre_haut->createChild('p');
            $cadre_haut_p4->addLink('', 'Maxime Zerillo :', '#');
            $cadre_haut_p4->addText('juiladzjcc hdeic ehcihdceb cue _ncez ?');
            
        $resultats = $bloc_page->createChild('div', 'resultats', 'resultats');
            $resultats_titre = $resultats->createChild('h3', 'resultats', 'titre_resultats');
            $resultats_titre->addText('Search\'s results');
            
            $resultats_p1 = $resultats->createChild('p');
            $resultats_p1->addLink('', 'Leo Maurel :', '#');
            $resultats_p1->addText('lieajfu dzd, djedj"ozkdlz,d zindie,d;s ks,xsoi');
            
            
        $messagerie = $bloc_page->createChild('div', 'messagerie', 'messagerie');
            $messagerie->createChildWithText('h3', 'Jacques Tronconi', 'titre_messagerie', 'titre_messagerie');
            
            $messagerie_p1 = $messagerie->createChild('p'); 
            $messagerie_p1->addLink('', 'Leo :', '#');
            $messagerie_p1->addText('hissnskcnsls,lc,c ?');
            
$footer = $htmlConstructor->getFooter();
    $footer->createChildWithText('div', 'Ce site a ete fait sans avoir ecrit une seule ligne de HTML ! ^^ Utilisation de '.AcPU::version().'.');
        
$page = Page::get();
$page->setManualHeader(false);

$page->addMeta('charset', 'utf-8');
$page->addHeadLinks('style.css', 'stylesheet');

$page->setHTMLConstructor($htmlConstructor);
$page->draw('sendergold : send messages to the world', '');

?>
