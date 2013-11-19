<?php
/**
 * Rozhraní pro "tovarni" tridu
 *
 * @author     Jan Dosedel
 */
interface Webengine_Model_Interfaces_Factory
{

 static public function loadModel($name);
 static public function loadModelFromModul($name, $modul);
 static public function getLoader($module);

}
