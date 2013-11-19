<?php

/**
 * Rozhraní pro jednotlive tridy modelu, resp pro tridy starajici se o praci s entitnimi tridami modelu
 * a komunikaci s tridami pro jejich ukladani (DAO - prozatim pouze Zendovske DB abstrakt. tridy)
 *
 * @author     Jan Dosedel
 */
interface Webengine_Model_Interfaces_Manager {

    /**
     * Načítání úložiště údajů
     *
     * @return object
     */
    public function getStorage();


    //NASLEDUJI CRUD OPERACE

    /**
     * Vložení údajů
     *
     * @param array s atributy entity
     * @throws Webengine_Model_Exception
     * @return string identifikátor nového řádku
     */
    public function create(array $data);

    /**
     * Změna údajů
     *
     * @param array $data údaje určené na změnu
     * @param string $id identifikátor řádku
     * @throws Mabo_Model_Exception
     * @return boolean
     */
    public function update(array $data, $id);

    /**
     * Smazání údajů
     *
     * @param string $id identifikátor řádku
     * @throws Mabo_Model_Exception
     * @return boolean
     */
    public function delete($id);

    /**
     * Načítání jednoho záznamu / read
     *
     * @param string $id identifikátor řádku
     * @return array
     */
    public function fetchObject($id);

    /**
     * Načítání všech záznamů / read all
     *
     * @return array
     */
    public function fetchAllObject();

    /**
     * Pomocna metoda, ktera prevadi objekt na pole
     *
     * @return array
     */
    function object_to_array($object);

    /**
     *  Pomocna metoda, ktera prevadi objpoleekt na objekt
     *
     * @param <type> $array
     * @return <type> object
     */
    function array_to_object($array = array());
}
