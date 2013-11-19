<?php

/**
 * Vyzaduje tridu interface s definovanymi metodami
 *
 * @see Webengine_Model_Interface
 */
require_once 'Webengine/Model/Interfaces/Manager.php';

/**
 * Abstraktní třída, ktera slouzi pro ancitani vsech manazerskych trid pomoci fce load
 *
 * @author     Jan Dosedel
 */
abstract class Webengine_Model_Classes_AbstractManager implements Webengine_Model_Interfaces_Manager {

    /**
     * promena loaderu starajici se o nacitani trid
     *
     * @var Zend_Loader_PluginLoader
     */
    protected static $_pluginLoader;
    /**
     * Objekt úložiště údajů
     * @var Zend_Db_Table
     */
    protected $_storage = null;
    /**
     * Název úložiště
     * @var string
     */
    protected $_storageName = null;
    /**
     * Objekty formulářů
     * @var array
     */
    protected $_forms = array();
    /**
     * Třídy formulářů
     * @var array
     */
    protected $_formClasses = array();

    /**
     * Vrátí PluginLoader a priradi modul podle volane prom $module
     *
     * @return Zend_Loader_PluginLoader
     */
    static public function getLoader($module) {
        // v případě, že PluginLoader neexistuje, ho vytvoří
       //OPRAVENA CHYBA vzdy 1 insatnce loaderu (singleton), coz umoznuje volat
        //nekolik load metod a registrovat vice modulu
            require_once 'Webengine/Loader/ModelLoader.php';
            self::$_pluginLoader = Webengine_Loader_ModelLoader::getInstance();

            //pokud je volano z tohoto modulu
            if ($module == 'this') {
                // získá název modulu
                $front = Zend_Controller_Front::getInstance();
                $module = $front->getRequest()->getModuleName();
                //Zend_Debug::dump($module);
                // vlozime modul
                self::$_pluginLoader->addModule($module);
            } else {
                //Zend_Debug::dump($module);
                // vlozime explicitne volany modul
                self::$_pluginLoader->addModule($module);
            
        }

        // vrátí objekt úložiště údajů
        return self::$_pluginLoader;
    }

    /**
     * Načítání třídy modelu
     *
     * @param string $name Nazev tridy
     * @param string $module Nazev modulu
     * @return Mabo_Model_Database
     */
    static public function loadModelFromModule($name, $module) {
        // načítá třídu modelu a vrátí její instanci
        $name = ucfirst((string) $name);
        $class = self::getLoader($module)->load($name);
        return new $class();
    }

    /**
     * Načítání úložiště údajů, resp DB uloziste
     *
     * @param string $name Název úložiště
     * @return Zend_Db_Table
     */
    static public function loadStorage($name, $module) {
        // načítá úložiště a vrátí jeho instanci
        $name = 'DbTable_' . ucfirst((string) $name);
        $class = self::getLoader($module)->load($name);
        return new $class();
    }

    /**
     * Načítání formuláře
     *
     * @param string $name Název formuláře
     * @param Webengine_Model_Abstract $model Instance modelu
     * @return Zend_Form
     */
    static public function loadForm($name, $module, Webengine_Model_Classes_AbstractManager $model) {
        // načítá úložiště a vrátí jeho instanci
        $name = 'Form_' . ucfirst((string) $name);
        $class = self::getLoader($module)->load($name);
        return new $class($model);
    }

    /**
     * Načítání dokumentu
     *
     * @param string $name Název dokumentu
     * @return Zend_Search_Lucene_Document
     */
    static public function loadDocument($name, $module) {
        // načítá úložiště a vrátí jeho instanci
        $name = 'Document_' . ucfirst((string) $name);
        $class = self::getLoader($module)->load($name);
        return new $class();
    }

    /**
     * Vrátí úložiště údajů
     *
     * @return Zend_Db_Table
     */
    public function getStorage() {
        // v případě, že objekt úložiště neexistuje, je potřeba ho vytvořit
        if (null === $this->_storage) {
            $this->_storage = self::loadStorage($this->_storageName);
        }

        // vrátí instanci úložiště údajů
        return $this->_storage;
    }

    /**
     * Vrátí formulář
     *
     * @param string $mode Modus
     * @return Zend_Form
     */
    public function getForm($mode = 'insert') {
        // otestuje, zda žádaný formulář existuje
        if (!isset($this->_formClasses[$mode])) {
            // vyvolá výjimku
            require_once 'Wonnies/Model/Exception.php';
            throw new Wonnies_Model_Exception('Neznámý Formulář');
        }

        // v případě, že objekt formuláře neexistuje, tak ho vytvoří
        if (!isset($this->_forms[$mode])) {
            // inicializuje objekt formuláře a předá mu instanci modelu
            $this->_forms[$mode] = self::loadForm($this->_formClasses[$mode], $this);
        }

        // vrátí instanci formuláře
        return $this->_forms[$mode];
    }

    /**
     * Načítá dokument pro fulltextove vyhledavani
     *
     * @return Zend_Search_Lucene_Document
     */
    public function getDocument() {
        // vrátí dokument
        return self::loadDocument('article' , 'articles');
    }

}
