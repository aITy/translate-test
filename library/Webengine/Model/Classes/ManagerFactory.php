<?php

/**
 * Vyzaduje tridu interface s definovanymi metodami
 *
 * @see Webengine_Model_Interface
 */
require_once 'Webengine/Model/Interfaces/Factory.php';

/**
 * Abstraktní "tovarni" trida, ktera se stara o nacitani (instanciovani) manazerskych trid modelu, podle indetifikatoru (string nazvu tridy)
 * pripadne i nazvu modulu, pokus je vyzadovano zinstanciovani tridy z jineho modulu nez je provadeno volani fce load
 *
 * @author     Jan Dosedel
 */
abstract class Webengine_Model_Classes_ManagerFactory implements Webengine_Model_Interfaces_Factory {

    /**
     * promena loaderu starajici se o nacitani trid
     *
     * @var Zend_Loader_PluginLoader
     */
    protected static $_pluginLoader;

    /**
     * Vrátí PluginLoader a priradi modul podle volane prom $module
     *
     * @return Zend_Loader_PluginLoader
     */
    static public function getLoader($module) {
        // v případě, že PluginLoader neexistuje, ho vytvoří
        
            require_once 'Webengine/Loader/ModelLoader.php';
            self::$_pluginLoader = Webengine_Loader_ModelLoader::getInstance();

            if ($module == 'this') {
                // získá název modulu
                $front = Zend_Controller_Front::getInstance();
                $module = $front->getRequest()->getModuleName();
                //Zend_Debug::dump('modul (this) ' . $module . ' ' . Zend_Controller_Front::getInstance()->getRequest()->getModuleName());
                // vloží modul
                self::$_pluginLoader->addModule($module);
            } else {
                //Zend_Debug::dump('modul (not this) ' . $module . ' ' . Zend_Controller_Front::getInstance()->getRequest()->getModuleName());
                self::$_pluginLoader->addModule($module);
            }
        

        // vrátí objekt úložiště údajů
        return self::$_pluginLoader;
    }


       /**
     * Načítání třídy modelu ze stejneho modulu
     *
     * @param string $name Název třídy
     * @return Object
     */
    static public function loadModel($name) {
        // načítá třídu modelu a vrátí její instanci
        $name = ucfirst((string) $name);
        $class = self::getLoader('this')->load($name);
        return new $class();
    }

    /**
     * Načítání třídy modelu z jineho modulu
     *
     * @param string $name Název třídy
     * @param string $name Název modulu
     * @return Object
     */
    static public function loadModelFromModule($name, $module) {
        // načítá třídu modelu a vrátí její instanci
        $name = ucfirst((string) $name);
        $class = self::getLoader($module)->load($name);
        return new $class();
    }

}
