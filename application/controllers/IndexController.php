<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $this->showContactFormAction();
    }

    public function indexAction() {

    }

    //inicializace kontaktniho formulare
    public function showContactFormAction() {
        //ziskame si instanci formulare
        $form = $this->getContactForm();
        //nastavime ho do view
        $this->view->form = $form;
        //$this->render('index');
    }

    //akce pro odeslani formulare
    public function sendAction() {
        $form = new Application_Form_Contact();

        if ($this->getRequest()->isPost()) {

            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $captcha = $form->getValue('control');
                if ($captcha === 'osm') {

                    $email = $form->getValue('email');
                    $message = $form->getValue('message_content');

                    $mail = new Zend_Mail('utf-8');
                    $mail->setBodyText($message . "\r\n" . 'Odesláno z: ' . $email);
                    $mail->setFrom($email, 'Kontaktní e-mail');
                    $mail->addTo('rivast@email.cz', 'GoodCAR');
                    //$mail->addTo('dosguard@centrum.cz', 'Honza');
                    $mail->setSubject('Zpráva z GOODCAR.cz');
                    $mail->send();
                    $this->_helper->redirector('contact');
                } else {
                    $form->populate($formData);
                    $this->_helper->redirector('index');
                }
            }
        }
    }

    public function send2Action() {
        $form = new Application_Form_Contact2();
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $captcha = $form->getValue('contact_control');
                if ($captcha == 'osm') {
                    $email = $form->getValue('contact_email');
                    $message = $form->getValue('contact_message_content');

                    $mail = new Zend_Mail('utf-8');
                    $mail->setBodyText($message . "\r\n" . 'Odesláno z: ' . $email);
                    $mail->setFrom($email, 'Kontaktni e-mail');
                    $mail->addTo('rivast@email.cz', 'GoodCAR');
                    //$mail->addTo('dosguard@centrum.cz', 'Honza');
                    $mail->setSubject('Zprava z GOODCAR.cz');
                    $mail->send();
                    $this->_helper->redirector('contact');
                } else {
                    $form->populate($formData);
                    $this->_helper->redirector('contact');
                }
            }
        }
    }

    public function sendorderAction() {
        $form = new Application_Form_Order();

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $captcha = $form->getValue('order_control');
                if ($captcha == 'osm') {
                    //TECHNICKE SPECIFIKACE
                    $vyrobce = $form->getValue('vyrobce');
                    $typ = $form->getValue('typ');
                    $druhPaliva = $form->getValue('palivo');
                    $pocetValcu = $form->getValue('valce');
                    $obsahCM = $form->getValue('obsah');
                    $rokVyroby = $form->getValue('vyroba');
                    $vykonKW = $form->getValue('vykon');
                    //FAKTURACNI UDAJE
                    $zakaznik = $form->getValue('zakaznik');
                    $firma = $form->getValue('firma');
                    $ico = $form->getValue('ico');
                    $dic = $form->getValue('dic');
                    $ulice = $form->getValue('ulice');
                    $mesto = $form->getValue('mesto');
                    $psc = $form->getValue('psc');
                    $telefon = $form->getValue('telefon');
                    $email = $form->getValue('zakaznikemail');
                    $poznamka = $form->getValue('poznamka');
                    //DODACI ADRESA
                    $zakaznikd = $form->getValue('zakaznikd');
                    $firmad = $form->getValue('firmad');
                    $uliced = $form->getValue('uliced');
                    $mestod = $form->getValue('mestod');
                    $pscd = $form->getValue('pscd');
                    $telefond = $form->getValue('telefond');


                    $message = 'Obdrželi jste novou objednávku z goodcar.cz: ' . "\r\n\r\n\r\n" .
                            'Technicka specifikace vozu ' . "\r\n\r\n" .
                            'Výrobce: ' . $vyrobce . "\r\n\r\n" .
                            ' Typ: ' . $typ . "\r\n\r\n" .
                            ' Palivo: ' . $druhPaliva . "\r\n\r\n" .
                            ' Počet válců: ' . $pocetValcu . "\r\n\r\n" .
                            ' Obsah: ' . $obsahCM . "\r\n\r\n" .
                            ' Rok výroby: ' . $rokVyroby . "\r\n\r\n" .
                            ' Výkon KW: ' . $vykonKW . "\r\n\r\n\r\n" .
                            ' Fakturační údaje ' . "\r\n\r\n" .
                            'Jméno a příjmení: ' . $zakaznik . "\r\n\r\n" .
                            ' Firma: ' . $firma . "\r\n\r\n" .
                            ' IČO: ' . $ico . "\r\n\r\n" .
                            ' DIČ: ' . $dic . "\r\n\r\n" .
                            ' Ulice: ' . $ulice . "\r\n\r\n" .
                            ' Město: ' . $mesto . "\r\n\r\n" .
                            ' PSČ: ' . $psc . "\r\n\r\n\r\n" .
                            ' Kontaktní údaje ' . "\r\n\r\n" .
                            'Telefon: ' . $telefon . "\r\n\r\n" .
                            ' E-mail: ' . $email . "\r\n\r\n\r\n" .
                            ' Komentář: ' . "\r\n\r\n" .
                            ' Poznámka: ' . $poznamka . "\r\n\r\n\r\n" .
                            ' Dodací adresa ' . "\r\n\r\n" .
                            ' Jméno a příjmení: ' . $zakaznikd . "\r\n\r\n" .
                            ' Firma: ' . $firmad . "\r\n\r\n" .
                            ' Ulice: ' . $uliced . "\r\n\r\n" .
                            ' Město: ' . $mestod . "\r\n\r\n" .
                            ' PSČ: ' . $pscd . "\r\n\r\n" .
                            ' Telefon: ' . $telefond . "\r\n\r\n"
                    ;

                    $mail = new Zend_Mail('utf-8');
                    $mail->setBodyText($message);
                    $mail->setFrom($email, 'Kontaktní e-mail');
                    $mail->addTo('rivast@email.cz', 'GoodCAR');
                    //$mail->addTo('dosguard@centrum.cz', 'Honza');
                    $mail->setSubject('Objednávka z GOODCAR.cz');
                    $mail->send();

                    $this->_helper->redirector('index');
                } else {
                    $form->populate($formData);
                    $this->_helper->redirector('index');
                }
            }
        }
    }

    //jen pomocna metoda
    public function pom() {
        $this->view->control_message = "Pomocna funkce aktivovana";
        $this->_helper->redirector('index', 'Index');
    }

    public function getContactForm() {
        return new Application_Form_Contact();
    }

    public function servicesAction() {
        
    }

    public function aboutAction() {
        
    }

    public function mythAction() {

    }

    public function contactAction() {
        
    }

    public function kitsAction() {
        $dbKits = new Application_Model_DbTable_Kits();
        $kits = $dbKits->fetchAll();
        //priradime prom do viewcka
        $this->view->kits = $kits;
    }

    public function sidebarAction() {

        if ($this->getRequest()->getParam('action') == 'sidebar') {
            $this->_redirect('/');
        }

        //nastaveni v jakem segmentu se ma dane phtml vykresovat
        $this->_helper->viewRenderer->setResponseSegment('sidebar');
    }

    public function orderAction() {

        $dbKits = new Application_Model_DbTable_Kits();
        $id = $this->getRequest()->getParam('id', 0);
        //ziskame si instanci formulare
        $form = new Application_Form_Order();
        //nastavime ho do view
        $this->view->orderform = $form;
        $this->view->kit = $dbKits->getKit($id);
    }

}