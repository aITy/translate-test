<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LanguageSetup
 * trida pluginu, vlastniho action helpru starajici se o presmerovani v pripade ze neni nalezeny potrebny jazyk, nastavuje defaultni jazyk nebo dany jazyk
 * v metode dispatchLoopStartup
 *
 * @author Jan Dosedel
 */
class Plugin_LanguageSetup extends Zend_Controller_Plugin_Abstract {

    protected $_languages;
    protected $_directory;

    public function __construct($directory, $languages) {
        $this->_dir = $directory;
        $this->_languages = $languages;
    }

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
//z requestu si zskame param 'lang'
        $lang = $this->getRequest()->getParam('lang');
//testneme jestli neni v poli jazyku vytvoreneho z init config (lang.ini) souboru
        if (!in_array($lang, array_keys($this->_languages))) {
//pripadne nastavime anglictinu
            $lang = 'cs';
        }
//ziskame si jazyk, resp string daneho jazyka
        $localeString = $this->_languages[$lang];
//vytvorime novou lokalizaci dle ziskane hodnoty (staci cs region CZ se doplni sam)
        $locale = new Zend_Locale($localeString);
//zsikame soubor na danem umisteni pridanim zkratky jazyka do routy
        $file = $this->_dir . '/' . $localeString . '.php';
//checkneme jestli existuje dany file
        if (file_exists($file)) {
            $translationStrings = include $file;
//jinak nastavime vychozi (cestinu)
        } else {
            $translationStrings = include $this->_dir
                    . '/cs_CZ.php';
        }

        //vyjimka
        if (empty($translationStrings)) {
            throw new Exception('Chybejici $translationStrings soubor pro preklad daneho jazyka');
        }
        //vytvorime si instanci zend translate s preklady a pridame si ji do registru
        $translate = new Zend_Translate('array',
                        $translationStrings, $localeString);

Zend_Debug::dump('plugin:');
 
        // Create Session block and save the locale
       $session = new Zend_Session_Namespace('translate');
       
       $session->locale = $localeString;

       Zend_Debug::dump($translationStrings);
       Zend_Debug::dump('Session locale: '.  $session->locale);

        Zend_Registry::set('lang', $lang);
       // Zend_Registry::set('localeString', $localeString);
      //  Zend_Registry::set('Zend_Locale', $locale);
        Zend_Registry::set('Zend_Translate', $translate);
        //Zend_Controller_Router_Route::setDefaultTranslator($translate);

        $fc = Zend_Controller_Front::getInstance();
        $router = $fc->getRouter();
        $fc->setRouter($router);
        $router->setGlobalParam('lang', $lang);
      // $router->setGlobalParam('Zend_Locale', $locale);
        //Zend_Controller_Router_Route::setDefaultTranslator($translate);

    }

}
