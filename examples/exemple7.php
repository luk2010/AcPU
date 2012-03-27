<?php

/*
 * Exemple 7 : Importing big site to AcPU
 */

require '../AcPU/AcPU.php';

$htmlConstructor = AcPU::get()->createHTMLConstructor('Constructor');

$header = $htmlConstructor->getHeader();
$center = $htmlConstructor->getCenter();
$footer = $htmlConstructor->getFooter();

$header_text = '<div>'.'<header> <div id="cadre_header">
            <h1>sendergold</h1>
            
            <menu>  
                <a id="settings" href="#">Settings</a>
                <a id="logout" href="#">Log out</a>
                <a id="hotline" href="#">Hotline</a>
            </menu>  
          </div>  
        </header>
    <section id="navigation">
        <div id="cadre_navigation">
        
            <a id="general" href="#">general</a>
            <a id="eshop" href="#">eshop</a>
            <a id="lovers" href="#">lovers</a>
            
                <input id="envoyer" type="button" value="send" />
                <textarea name="texte" id="zone_texte"></textarea>
                <input id="rechercher" type="button" value="search" />
                
            <a id="destination" href="#">place</a>
            <a id="age_navi" href="#">old</a>
            <a id="sexe" href="#">genre</a>
        </div>
   </section>'.'</div>';

$header->importHtml($header_text);

$center_text = '<div id="centre">
         
            <div id="mon_profil">
            <h3 id="titre_profil">Leo Maurel</h3>
            <a id="age">18 years</a>
            <a id="pays">France</a>
            <a id="envoyes">sent</a>
            <a id="recus">recieved</a>
            <a id="top5">best messages</a>
           
       </div>
            
            
            <div id="bloc_page">
        
            <div id="cadre_haut">
                <h3 id="titre_cadre_haut">answers of your message</h3>
                <div id="overflow">
                <a>Leo Maurel :</a><p> lieajfu dzd, djedj"ozkdlz,d zindie,d;s ks,xsoi</p>
                <a>Jacques Tronconi :</a><div id="cadre_img"><div id="defilement"><a>&lt; 2/18 &gt;</a><img id="img" src="044.jpg"/></div></div><p> kdzod !! d"kdkod"d,"od jzihjd sjnxksnxh ksnxks,xnsixjskx,sk</p>
                <a>Nicolas Sarkozy :</a><img id="img" src="dsc-2674.jpg"/><p> old"j,kdj zid jksn xjqs gx ysagvx hsbxefx e g h</p>
                <a>Maxime Zerillo :</a><p> juiladzjcc hdeic ehcihdceb cue _ncez ?</p>
                <a>Leo Maurel :</a><p> lieajfu dzd, djedj"ozkdlz,d zindie,d;s ks,xsoi</p>
                <a>Jacques Tronconi :</a><p> kdzod !! d"kdkod"d,"od jzihjd sjnxksnxh ksnxks,xnsixjskx,sk</p>
                <a>Nicolas Sarkozy :</a><img id="img" src="Snow-Leopard.jpg"/><p> old"j,kdj zid jksn xjqs gx ysagvx hsbxefx e g h</p>
                <a>Maxime Zerillo :</a><p> juiladzjcc hdeic ehcihdceb cue _ncez ?</p>
                <a>Leo Maurel :</a><p> lieajfu dzd, djedj"ozkdlz,d zindie,d;s ks,xsoi</p>
                <a>Jacques Tronconi :</a><p> kdzod !! d"kdkod"d,"od jzihjd sjnxksnxh ksnxks,xnsixjskx,sk</p>
                <a>Nicolas Sarkozy :</a><p> old"j,kdj zid jksn xjqs gx ysagvx hsbxefx e g h</p>
                <a>Maxime Zerillo :</a><p> juiladzjcc hdeic ehcihdceb cue _ncez ?</p>
                  </div>              
            </div>
             <div id="resultats">
                <h3 id="titre_resultats">search\'s results</h3>
                <div id="overflow">
                <a>Leo Maurel :</a><p> lieajfu dzd, djedj"ozkdlz,d zindie,d;s ks,xsoi</p>
                <a>Jacques Tronconi :</a><p> kdzod !! d"kdkod"d,"od jzihjd sjnxksnxh ksnxks,xnsixjskx,sk</p>
                <a>Nicolas Sarkozy :</a><p> old"j,kdj zid jksn xjqs gx ysagvx hsbxefx e g h</p>
                <a>Maxime Zerillo :</a><p> juiladzjcc hdeic ehcihdceb cue _ncez ?</p>
                <a>Leo Maurel :</a><p> lieajfu dzd, djedj"ozkdlz,d zindie,d;s ks,xsoi</p>
                <a>Jacques Tronconi :</a><p> kdzod !! d"kdkod"d,"od jzihjd sjnxksnxh ksnxks,xnsixjskx,sk</p>
                <a>Nicolas Sarkozy :</a><p> old"j,kdj zid jksn xjqs gx ysagvx hsbxefx e g h</p>
                <a>Maxime Zerillo :</a><p> juiladzjcc hdeic ehcihdceb cue _ncez ?</p>
                <a>Leo Maurel :</a><p> lieajfu dzd, djedj"ozkdlz,d zindie,d;s ks,xsoi</p>
                <a>Jacques Tronconi :</a><p> kdzod !! d"kdkod"d,"od jzihjd sjnxksnxh ksnxks,xnsixjskx,sk</p>
                <a>Nicolas Sarkozy :</a><p> old"j,kdj zid jksn xjqs gx ysagvx hsbxefx e g h</p>
                <a>Maxime Zerillo :</a><p> juiladzjcc hdeic ehcihdceb cue _ncez ?</p>
             </div></div>
        <div id="messagerie">
            <h3 id="titre_messagerie">Jacques tronconi</h3>
            <div id="overflow_messagerie">
            <a>Leo :</a><p> hissnskcnsls,lc,c ?</p>
            <a>Jacques :</a><p> j\'ai pas compriis mdr</p>
            <a>Leo :</a><p> non rien je teste le site pour voir si sa marche et sa a l\'air de fonctionner :)</p>
            <a>Jacques :</a><p> ouai lol ya encore du boulot xD</p>
            </div>
            <div id="cadre_ecriture">
            <textarea id="ecriture"></textarea>
            </div>
        </div>
            </div>
            
             <div id="media">
                 <div id="photos">
                     <h3 id="titre_photos">Photos</h3>
                     <a id="vacances" href="#">Vacances 2012</a>
                     <a href="#">Reveillon</a>
                     <a href="#">en vrac !</a>
                     <a href="#">21/23/2013</a>
                 </div>
                 
                 <div id="videos">
                     
                     <a href="#">Vacances 2012</a>
                     <a href="#">Reveillon </a>
                     <a href="#">en vrac ! :D </a>
                     <a href="#">21/23/2013 </a>
                     <h3 id="titre_videos">Videos</h3>
                 </div>
                 
                 <div id="affichage">
                     <div id="deroulant">
                     
                     </div>
                 <div id="apercu">
                     
                 </div>
                     
                 </div>
                
             
         </div>
        </div>';

$center->importHtml($center_text);

$footer_text = '<footer id="footer">
            
            <a href="#">who are we ?</a>
            <a href="#">do you want a job ?</a>
            <a href="#">confidentiality</a>
            <a href="#">CEO\'s messages</a>
            <a href="#">help</a>
            <a href="#">gold book</a>
            <p>sendergold 2012 tm all rights reserved</p>
        </footer>';

$footer->importHtml($footer_text);

$page = Page::get();
$page->setHTMLConstructor($htmlConstructor);
$page->setManualHeader(false);

$page->addMeta('charset', 'utf-8');
$page->addHeadLinks('style7.css', 'stylesheet');

$page->draw('Welcome to sendergold', '');

?>
