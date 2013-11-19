<?php

/**
 * Description of LanguageSetup
 * trida pluginu, vzuyivajici yasuvnz modul ActionStack pro vykonavani urcite akce pri kazdem nacteni stranky
 *
 * @author Jan Dosedel
 */
class Webengine_Controller_Plugin_SidebarSetup extends Zend_Controller_Plugin_Abstract {

    protected $_actionStack = null;

    //konstruktor pracuje se singletonem ActionStack controller pluginu
    public function __construct() {      

        //vratime si instanci front controlleru
        $front = Zend_Controller_Front::getInstance();

        //pokud neni zaregistrovany plugin
        if (!$front->hasPlugin('Zend_Controller_Plugin_ActionStack')) {
            //zinstanciujeme novy
            $this->_actionStack = new Zend_Controller_Plugin_ActionStack();
            //a zaregistrujeme ho, (97 je index)
            $front->registerPlugin($this->_actionStack, 97);
        } else {
            $this->_actionStack = $front->getPlugin('Zend_Controller_Plugin_ActionStack');
        }
    }

    //metoda pro opakovani "cinnosti" pri startu
    //Jestlize byla vykonana puvodne volana metoda, ActionStack zabezpeci, ze budoz vykonavany i vsechny ostatni metody v zasobniku
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
        //zkopcime si request tridu
        $sidebarAction = clone($request);
        $sidebarAction->setModuleName('default');
        //(pre)nastavime jmeno akce, ktera se ma provest (ta se stara o vykresleni sidebaru)
        $sidebarAction->setActionName('sidebar');
        //nastaveni  kontroleru, kde se nachazi akce
        $sidebarAction->setControllerName('index');
        //pushnuti do zasobniku
        $this->_actionStack->pushStack($sidebarAction);
    }

}