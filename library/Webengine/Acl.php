<?php

/**
 * ACL (Access Control List)
 *
 * @package    Wonnies
 * @author     Jan Dosedel
 */
class Webengine_Acl extends Zend_Acl {

    //staticka promena, ktera uchovava instanci sebe sama (teto tridy)
    protected static $_instance = null;

    /**
     *  Metoda (getter), ktera zpristupnuje instanci teto tridy (singleton)
     *
     * @param <type> $acl - seznam ACL z konfigu
     * @return <type> vraci instanci teto tridy
     */
    public static function getInstance($acl) {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($acl);
            //Zend_Debug::dump(self::$_instance);
            return self::$_instance;
        } else {
            return self::$_instance;
        }
    }

    /**
     * vytvoří ACL s uživatelskými rolemi, zdroji a pravidly,
     *  protected chrani konstruktor pred volanim nove instance pomoci new
     */
    protected function __construct($acl) {

// vloží uživatelské role
        foreach ($acl['roles'] as $role) {
            $this->addRole(new Zend_Acl_Role($role));
        }

        // vloží zdroje
        foreach ($acl['ressources'] as $resource) {
            $this->addResource(new Zend_Acl_Resource($resource));
        }

        // vloží pravidla
        // napr. acl.rules.allow.admin.article / bud priradi vsechny/all nebo kazdou zminenou
        foreach ($acl['rules'] as $function => $rule) {
            foreach ($rule as $role => $rule2) {
                foreach ($rule2 as $resource => $rule3) {
                    if ('all' == $rule3) {
                        $this->$function($role, $resource);
                    } else {
                        $this->$function($role, $resource, $rule3);
                    }
                }
            }
        }
    }

}
