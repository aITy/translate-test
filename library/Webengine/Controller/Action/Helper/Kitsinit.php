<?php

/**
 * 
 *
 * @author     Jan Dosedel
 */
class Webengine_Controller_Action_Helper_Kitsinit extends Zend_Controller_Action_Helper_Abstract {

    protected $_run = false;
   
    //metoda je vyvolana po kazde akce v Action controlleru
    public function postDispatch() {
        if ($this->_run) {
            return;
        }
        $dbKits = new Application_Model_DbTable_Kits();
        $kits = $dbKits->fetchAll();
        //ziskame si view daneho controlleru, kde je volan helper
        $view = $this->getActionController()->view;
        //priradime prom do viewcka
        $view->kits = $kits;
        $this->_run = true;
    }

}
