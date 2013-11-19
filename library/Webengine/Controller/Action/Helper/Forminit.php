<?php

/**
 * helper obsahujici inicializaci formu
 *
 * @author     Jan Dosedel
 */
class Webengine_Controller_Action_Helper_Forminit extends Zend_Controller_Action_Helper_Abstract {

    protected $_run = false;

    /**
     * 
     *
     * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function preDispatch() {
        if ($this->_run) {
            return;
        }
        $contactform = new Application_Form_Contact();
        $contactform2 = new Application_Form_Contact2();
        //ziskame si view daneho controlleru, kde je volan helper
        $view = $this->getActionController()->view;
        //priradime prom do viewcka
        $view->contactform = $contactform;
        $view->contactform2 = $contactform2;
        $this->_run = true;
    }

}
