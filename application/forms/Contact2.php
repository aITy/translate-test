<?php

class Application_Form_Contact2 extends Zend_Form {

    //inicializacni metoda pro inicializaci formulare
    public function init() {

        $this->setMethod('post');
        $this->setName('contact2');

        $email = new Zend_Form_Element_Text('contact_email');
        $email->setLabel('Váš e-mail')
                ->setRequired(true)
                ->addValidator(new Zend_Validate_EmailAddress());

        //textarea
        $messageContent = new Zend_Form_Element_Textarea('contact_message_content');
        //atributy textarea (pocet radku/sloupcu)
        $messageContent->setAttribs(array('cols' => 60, 'rows' => 8));
        //nastaveni zobrazovaneho popisku
        $messageContent->setLabel('Váš dotaz');
        //je vyzadovan
        $messageContent->setRequired(true);

        $control = new Zend_Form_Element_Text('contact_control');
        $control->setLabel('Kontrola 5+3 (slovy)')
                ->setRequired(true);

        //tlacitko submit pro dany formular
        $submit = new Zend_Form_Element_Submit('contact_submit');
//        $submit->setAttrib('id', 'submitbutton');
        $submit->setLabel('Odeslat');



        //captcha typu Figlet
//        $captcha = new Zend_Form_Element_Captcha('checker', array(
//                    'label' => 'Zadejte kontrolní otázku',
//                    'captcha' => array(
//                        'captcha' => 'Figlet',
//                        'wordLen' => '5',
//                        'timeout' => '120',
//                        'fsize'=> '4',
//                        'height'=> '20',
//                        'width'=> '100'
//                    )
//                ));
//captcha typu Image
        //ziskame view pro pozdejsi volani metody baseUrl()
        $view = Zend_Layout::getMvcInstance()->getView();

//        $captcha = new Zend_Form_Element_Captcha('checker', array(
//                    'label' => 'Kontrola:',
//                    'required' => true,
//                    'captcha' => array(
//                        'captcha' => 'image',
//                        'wordLen' => 5,
//                        'font' => APPLICATION_PATH . '/../public/captcha/arial.ttf',
//                        'fontSize' => 30,
//                        'imgDir' => APPLICATION_PATH . '/../public/captcha/img',
//                        'imgUrl' => $view->baseUrl() . '/../public/captcha/img',
//                        'timeout' => 120
//                    )
//                ));
        //odesleme nasledujici elementy formulare v poli
        //$this->addElements(array($email, $messageContent, $captcha, $submit));
        $this->addElements(array($email, $messageContent, $control, $submit));
        //akce pro zpracovani formulare
        //  $this->setAction($this->getBaseUrl() . '/index/send');
        $url = new Zend_View_Helper_Url();
        $this->setAction($url->url(array('controller' => 'index', 'action' => 'send2'), 'default'));
    }

}