<?php

/**
 * @see Zend_Loader_PluginLoader
 */
require_once 'Zend/Loader/PluginLoader.php';

/**
 * Loader pro třídy modelu
 *
 * @author     Jan Dosedel, 2012
 */
class Webengine_Loader_ModelLoader extends Zend_Loader_PluginLoader {

       //staticka promena, ktera uchovava instanci sebe sama (teto tridy)
    protected static $_modelLoader = null;

    /**
     *  Metoda (getter), ktera zpristupnuje instanci teto tridy (singleton)
     *
     * @param <type> $acl - seznam ACL z konfigu
     * @return <type> vraci instanci teto tridy
     */
    public static function getInstance() {
        if (is_null(self::$_modelLoader)) {
            self::$_modelLoader = new self();
            //Zend_Debug::dump(self::$_instance);
            return self::$_modelLoader;
        } else {
            return self::$_modelLoader;
        }
    }
    

    /**
     * Vloží cestu a prefix pro modul (seskupenych trid), tim se da budovat aplikace modularne
     * 
     * @param string $module Název modulu
     */
    public function addModule($module = 'default') {
        // otestuje modul, pokud je defaulni nacitame ze slozky - application/models/
        if ('default' == $module) {
            // nastaví cestu a prefix, ktery pouzivaji tridy modelu
            $path = APPLICATION_PATH . '/models';
            $prefix = 'Model_';
        } else {
            // nastaví cestu a prefix (v pripade ze nacitame tridy z urciteho modulu)
            $path = APPLICATION_PATH . '/modules/';
            $path .= $module . '/models';
            // ucfirst - make a string's first character uppercase
            $prefix = ucfirst($module) . '_Model_';
        }

        // vloží cestu a prefix
        if (!in_array($prefix, array_keys($this->getPaths()))) {
            $this->addPrefixPath($prefix, $path);
        }
    }

}
