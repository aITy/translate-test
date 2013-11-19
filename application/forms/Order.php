<?php

class Application_Form_Order extends Zend_Form {

    //inicializacni metoda pro inicializaci formulare
    public function init() {

        $this->setMethod('post');
        $this->setName('order');



        $vyrobce = new Zend_Form_Element_Text('vyrobce');
        $vyrobce->setLabel('Výrobce')
                ->setRequired(true);

        $typ = new Zend_Form_Element_Text('typ');
        $typ->setLabel('Typ')
                ->setRequired(true);

        $druhPaliva = new Zend_Form_Element_Text('palivo');
        $druhPaliva->setLabel('Druh paliva')
                ->setRequired(true);

        $pocetValcu = new Zend_Form_Element_Text('valce');
        $pocetValcu->setLabel('Počet válců')
                ->setRequired(true);

        $obsahCM = new Zend_Form_Element_Text('obsah');
        $obsahCM->setLabel('Obsah v cm3')
                ->setRequired(true);

        $rokVyroby = new Zend_Form_Element_Text('vyroba');
        $rokVyroby->setLabel('Rok vyroby')
                ->setRequired(true);

        $vykonKW = new Zend_Form_Element_Text('vykon');
        $vykonKW->setLabel('Výkon v KW')
                ->setRequired(true);

        $this->addDisplayGroup(array($vyrobce,$typ,$druhPaliva,$pocetValcu,$obsahCM,$rokVyroby,$vykonKW), 'technickeparam',array('legend' => 'Technické parametry vozu'));

        // FAKTURACNI UDAJE

        $zakaznik = new Zend_Form_Element_Text('zakaznik');
        $zakaznik->setLabel('Jméno a příjmení')
                ->setRequired(true);

        $firma = new Zend_Form_Element_Text('firma');
        $firma->setLabel('Název firmy');

        $ico = new Zend_Form_Element_Text('ico');
        $ico->setLabel('IČO');

        $dic = new Zend_Form_Element_Text('dic');
        $dic->setLabel('DIČ');

        $ulice = new Zend_Form_Element_Text('ulice');
        $ulice->setLabel('Ulice, ČP')
                ->setRequired(true);

        $mesto = new Zend_Form_Element_Text('mesto');
        $mesto->setLabel('Město')
                ->setRequired(true);

        $psc = new Zend_Form_Element_Text('psc');
        $psc->setLabel('PSČ')
                ->setRequired(true);

        $telefon = new Zend_Form_Element_Text('telefon');
        $telefon->setLabel('Telefon')
                ->setRequired(true);

        $email = new Zend_Form_Element_Text('zakaznikemail');
        $email->setLabel('E-mail')
                ->addValidator(new Zend_Validate_EmailAddress());

        //textarea
        $poznamka = new Zend_Form_Element_Textarea('poznamka');
        $poznamka->setAttribs(array('cols' => 60, 'rows' => 8))
                ->setLabel('Poznámka');


        $this->addDisplayGroup(array($zakaznik,$firma,$ico,$dic,$ulice,$mesto,$psc,$telefon,$email,$poznamka), 'fakturace',array('legend' => 'Fakturační údaje'));

        //DODACI ADRESA

        $zakaznikd = new Zend_Form_Element_Text('zakaznikd');
        $zakaznikd->setLabel('Jméno a příjmení');

        $firmad = new Zend_Form_Element_Text('firmad');
        $firmad->setLabel('Název firmy');

        $uliced = new Zend_Form_Element_Text('uliced');
        $uliced->setLabel('Ulice, ČP');

        $mestod = new Zend_Form_Element_Text('mestod');
        $mestod->setLabel('Město');

        $pscd = new Zend_Form_Element_Text('pscd');
        $pscd->setLabel('PSČ');

        $telefond = new Zend_Form_Element_Text('telefond');
        $telefond->setLabel('Telefon');

         $this->addDisplayGroup(array($zakaznikd,$firmad,$uliced,$mestod,$pscd,$telefond), 'dodaci',array('legend' => 'Dodací adresa'));

         $control = new Zend_Form_Element_Text('order_control');
        $control->setLabel('Kontrola 5+3 (slovy)')
                ->setRequired(true);


        //tlacitko submit pro dany formular
        $submit = new Zend_Form_Element_Submit('order');
        $submit->setAttrib('id', 'order_button');
        $submit->setLabel('Objednat zboží');

        //$this->addElements(array($email, $messageContent, $captcha, $submit));
        $this->addElements(array($vyrobce, $typ, $druhPaliva, $pocetValcu, $obsahCM, $rokVyroby, $vykonKW, $zakaznik, $firma, $ico, $dic, $ulice, $mesto, $psc, $telefon,
            $email, $poznamka, $zakaznikd, $firmad, $uliced, $mestod, $pscd, $telefond, $control, $submit));
        //akce pro zpracovani formulare
        //  $this->setAction($this->getBaseUrl() . '/index/send');
        $url = new Zend_View_Helper_Url();
        $this->setAction($url->url(array('controller' => 'index', 'action' => 'sendorder'), 'default'));
    }

}