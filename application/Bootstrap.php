<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    /**
     * inicializace configu do Zend registru (aby byl pristupny)
     */
    protected function _initConfig() {
        $config = $this->getOptions();
        Zend_Registry::set('config', $config);
        return $config;
    }

    /**
     * inicializace action helpru
     */
    protected function _initHelpers() {
        //pridani prefixu pro hledani action helper trid
        Zend_Controller_Action_HelperBroker::addPrefix('Webengine_Controller_Action_Helper');
        //registrace helpru
        Zend_Controller_Action_HelperBroker::getStaticHelper('Forminit');
        Zend_Controller_Action_HelperBroker::getStaticHelper('Kitsinit');
    }

    protected function _initBaseUrl() {
        $this->bootstrap("frontController");
        $front = $this->getResource("frontController");
        $request = new Zend_Controller_Request_Http();
        $front->setRequest($request);
    }

    protected function _initHeadScript() {
        //pro tenhle layout
        $this->bootstrap('view');
        $view = $this->getResource('view');
    }

    protected function _initLocalization() {

        //ziskame si instanci PluginLoaderu
        $loader = new Zend_Loader_PluginLoader();
        //pridame umisteni, kde ma Zend nase pluginy hledat
        $loader->addPrefixPath('Plugin', APPLICATION_PATH . '/controllers/plugins');
        //nacteme plugin daneho nazvu
        $plugin = $loader->load('LanguageSetup');
        //vytvorime si nas config ze souboru
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/lang.ini', 'lang');
        //ziskame si instanci frontcontrolleru
        $frontController = Zend_Controller_Front::getInstance();
        //z nej si vytvorime pole klicovych hodnot
        $languages = array_keys($config->languages->toArray());
        //registrace pluginu pro jayzkove mutace, v podstate nova instance s predanymi param tykajici se umisteni souboru s prekladem a polem jazyku z configu
        $frontController->registerPlugin(new $plugin(APPLICATION_PATH . '/languages/',
                        $config->languages->toArray()));

        Zend_Debug::dump('bootstrap:');
        //---------------------
        $session = new Zend_Session_Namespace('translate');


        if (!isset($session->locale)) {
            // $locale = new Zend_Locale('cs_CZ');
            //$lang = $locale->getLanguage();
            Zend_Debug::dump('prazdne session');
        } else {
            $locale = $session->locale;
            Zend_Debug::dump('Bootstrap locale: ' . $session->__get('locale'));
        }


        //zsikame soubor na danem umisteni pridanim zkratky jazyka do routy
        $file = APPLICATION_PATH . '/languages/' . $locale . '.php';

        //checkneme jestli existuje dany file
        if (file_exists($file)) {
            $translationStrings = include $file;
            //jinak nastavime vychozi (anglictinu)
        } else {
            $translationStrings = include APPLICATION_PATH . '/languages/'
                    . '/en_GB.php';
        }

        $translate = new Zend_Translate('array',
                        $translationStrings, $locale);
        Zend_Registry::set('Zend_Translate', $translate);
        Zend_Debug::dump($translationStrings);
// Set it as default translator for routes
//Zend_Controller_Router_Route::setDefaultTranslator($translate);
    }

    //incializace navigace z xml konfiguratoru
    protected function _initNavigation() {
        //pro tenhle layout
        $this->bootstrap('layout');
        //ziskame si layout
        $layout = $this->getResource('layout');
        //ziskame si viewu
        $view = $layout->getView();
        //vytvorime si nas config ze souboru
        $config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');
        //vytvroime novou navigaci z daneho konfiguraku
        $navigation = new Zend_Navigation($config);
        //nastavime ho do viewu
        $view->navigation($navigation);
    }

    protected function _initRoutes() {
        // o routach http://forum.zendframework.cz/index.php?topic=197.0
        $this->bootstrap('frontController');
        $router = Zend_Controller_Front::getInstance()->getRouter();

        $route = new Zend_Controller_Router_Route(
                        ':lang/:@controller/:@action/',
                        array(
                            'action' => 'services',
                            'controller' => 'index',
                            'module' => 'default',
                            'lang' => '',
                        )
        );

        $router->addRoute('services', $route);
        $route->assemble(array());
    }

    protected function _initHeadLink() {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->headLink()->prependStylesheet($this->view->baseUrl() . '/css/site.css')
                ->appendStylesheet($this->view->baseUrl() . '/css/jquery.ad-gallery.css');
    }

    protected function _initMeta() {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
        $view->headMeta()->appendName('keywords', 'bioethanol, E86, ethanol, auto, přestavba ');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8')
                ->appendHttpEquiv('Content-Language', 'cs')
                ->appendHttpEquiv('Generator', 'EasyPHP, NetBeans, Zend Framework 10.1, PSPad')
                ->appendHttpEquiv('Description', 'Internetova prezentace spolecnosti GoodCar zabyvajici se profesionalni prestavbou aut na kvalitni palivo E85.')
                ->appendHttpEquiv('Author', 'JJ-Studio');
//                ->appendHttpEquiv('Robots', 'index,nofollow')
//                ->appendHttpEquiv('Googlebot', 'index,nofollow,snippet,archive');
    }

}
