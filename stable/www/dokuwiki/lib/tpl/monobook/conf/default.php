<?php

/**
 * Default options for the "monobook" DokuWiki template
 *
 * Notes:
 * - In general, use the admin webinterface of DokuWiki to change config. 
 * - To change the type of a config value, have a look at "metadata.php" in
 *   the same directory as this file.
 * - To change/translate the descriptions showed in the admin/configuration
 *   menu of DokuWiki, have a look at the file
 *   "/lib/tpl/monobook/lang/<your lang>/settings.php". If it does not exists,
 *   copy and translate the English one. And don't forget to mail the
 *   translation to me, Andreas Haerter <andreas.haerter@dev.mail-node.com> :-D.
 * - To change the tab configuration, have a look at the "tabs.php" in the
 *   same directory as this file.
 *
 *
 * LICENSE: This file is open source software (OSS) and may be copied under
 *          certain conditions. See COPYING file for details or try to contact
 *          the author(s) of this file in doubt.
 *
 * @license GPLv2 (http://www.gnu.org/licenses/gpl2.html)
 * @author Andreas Haerter <andreas.haerter@dev.mail-node.com>
 * @link http://www.dokuwiki.org/template:monobook
 * @link http://www.dokuwiki.org/devel:configuration
 */


//check if we are running within the DokuWiki environment
if (!defined("DOKU_INC")){
    die();
}

//discussion pages
$conf["monobook_discuss"]    = true; //TRUE: use/show discussion pages
$conf["monobook_discuss_ns"] = ":talk:"; //namespace to use for discussion page storage 

//site notice
$conf["monobook_sitenotice"]          = true; //TRUE: use/show sitenotice
$conf["monobook_sitenotice_location"] = ":wiki:site_notice"; //page/article used to store the sitenotice

//navigation
$conf["monobook_navigation"]          = true; //TRUE: use/show navigation
$conf["monobook_navigation_location"] = ":wiki:navigation"; //page/article used to store the navigation

//custom copyright notice
$conf["monobook_copyright"]          = true; //TRUE: use/show copyright notice
$conf["monobook_copyright_default"]  = true; //TRUE: use default copyright notice (if copyright notice is enabled at all)
$conf["monobook_copyright_location"] = ":wiki:copyright"; //page/article used to store a custom copyright notice

//search form
$conf["monobook_search"] = true; //TRUE: use/show search form

//toolbox
$conf["monobook_toolbox"]               = true; //TRUE: use/show toolbox
$conf["monobook_toolbox_default"]       = true; //TRUE: use default toolbox (if toolbox is enabled at all)
$conf["monobook_toolbox_default_print"] = true; //TRUE: if default toolbox is used, show printable version link?
$conf["monobook_toolbox_location"]      = ":wiki:toolbox"; //page/article used to store a custom toolbox

//donation link/button
$conf["monobook_donate"]          = true; //TRUE: use/show donation link/button
$conf["monobook_donate_default"]  = true; //TRUE: use default donation link/button (if donation link is enabled at all)
$conf["monobook_donate_url"]      = "http://andreas-haerter.com/donate/monobook/paypal"; //custom donation URL instead of the default one

//other stuff
$conf["monobook_mediamanager_embedded"] =  true; //TRUE: Show media manager surrounded by the common navigation/tabs and stuff
$conf["monobook_breadcrumbs_position"]  = "bottom"; //position of breadcrumbs navigation ("top" or "bottom")
$conf["monobook_youarehere_position"]   = "top"; //position of "you are here" navigation ("top" or "bottom")
if (!empty($_SERVER["HTTP_HOST"])){
  $conf["monobook_cite_author"] = "Contributors of ".hsc($_SERVER["HTTP_HOST"]); //name to use for the author on the citation page (hostname included)
} else {
  $conf["monobook_cite_author"] = "Anonymous Contributors"; //name to use for the author on the citation page
}
$conf["monobook_loaduserjs"]            = false; //TRUE: monobook/user/user.js will be loaded

