<?php

class Application_Model_DbTable_Kits extends Zend_Db_Table_Abstract {

    protected $_id = 'id';
    protected $_name = 'kits';

    public function getKit($id) {
        $id = (int) $id;
        $row = $this->fetchRow(' id =' . $id);
        if (!$row) {
            throw new Exception("ID daneho Kitu nebylo nalezeno");
        }
        return $row;
    }


    

//    public function getAlbumByTitle($title) {
//        $row = $this->fetchRow(' title =' . $title);
//        if (!row) {
//            throw new Exception("Nazev daneho kitu nebyl nalezen");
//        }
//        return $row->toArray();
//    }
    
//        public function addKit($title, $description, $date) {
//        $data = array(
//            'title' => $title,
//            'description' => $description,
//            'date' => $date,
//        );
//        $this->insert($data);
//    }

//    public function updateAlbum($id, $title, $description, $date) {
//        $data = array(
//            'title' => $title,
//            'description' => $description,
//            'date' => $date,
//        );
//        $this->update($data, ' id =' . (int) $id);
//    }

//    public function deleteAlbum($id) {
//        $this->delete('id =' . (int) $id);
//    }
//
//    public function deleteAlbumByTitle($title) {
//        $this->delete('title =' . $title);
//    }

 

}

