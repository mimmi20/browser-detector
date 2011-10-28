<?php
require_once LIB_PATH . 'Zend' . DS  . 'Acl.php';
require_once LIB_PATH . 'Zend' . DS  . 'Acl' . DS . 'Resource.php';
require_once LIB_PATH . 'Zend' . DS  . 'Acl' . DS . 'Role.php';
require_once MODEL_PATH . 'Acl.php';

/**
 * Acl-Objekt
 *
 * @author Thomas Kroehs <thomas.kroehs@unister-gmbh.de>
 */
class Unister_Acl extends Zend_Acl
{
    /**
     * @var Array Liste von Ressourcen
     */
    protected $resources;

    /**
     * @var Array Baum der Ressourcen
     */
    protected $resources_tree;

    /**
     * @var Array Liste der Basis-Rollen
     */
    protected $base_roles;

    /**
     * Ermittelt die verfuegbaren Ressourcen
     */
    private function parseResources()
    {
        unset($this->resources);
        unset($this->resources_tree);
        $this->resources = array();
        $this->resources_tree = array();

        $controller_dir = APP_PATH.'controllers'.DS;
        $dh = opendir($controller_dir);
        $controllers = array();
        while (false !== ($file = readdir($dh))){
            if (preg_match('/([a-zA-Z0-9]*)Controller\.php/',$file,$hits)){
                $controllers[] = $hits[1];
            }
        }
        closedir($dh);
        foreach ($controllers as $contr){
            $this->resources[strtolower($contr)]    = array(
                'controller'    => $contr,
                'action'        => null,
                'res_name'        => strtolower($contr),
            );
            if (!isset($this->resources_tree[$contr]) || !is_array($this->resources_tree[$contr])) {
                $this->resources_tree[$contr] = array();
                $this->resources_tree[$contr][] = array(
                    'controller'    => $contr,
                    'action'        => null,
                    'res_name'        => strtolower($contr),
                );
                $cClassName = $contr.'Controller';
                $cMethods = get_class_methods($cClassName);
                foreach ($cMethods as $cm){
                    if (preg_match('/([a-zA-Z0-9]*)Action/',$cm,$hits)){
                        $this->resources[strtolower($contr).'_'.strtolower($hits[1])] = array(
                            'controller'    => $contr,
                            'action'        => $hits[1],
                            'res_name'        => strtolower($contr).'_'.strtolower($hits[1]),
                        );
                        $this->resources_tree[$contr][] = array(
                            'controller'    => $contr,
                            'action'        => $hits[1],
                            'res_name'        => strtolower($contr).'_'.strtolower($hits[1]),
                        );
                    }
                }
            }
        }
    }

    /**
     * Konstruktor
     */
    public function __construct()
    {
        $this->resources = array();
        $this->resources_tree = array();

        // Rollen
        $acl_db = new Model_Acl();
        $roles = $acl_db->getRoles();

        if (is_array($roles)) {
            // Basis-Rollen
            foreach ($roles as $role){
                if ($role->rolletyp == 'Basis'){
                    try{
                        $this->addRole(new Zend_Acl_Role($role->name));
                    }catch (Exception $e){
                    }
                }
            }

            // Benutzer-Rollen
            foreach ($roles as $role){
                if ($role->rolletyp == 'Benutzer'){
                    try{
                        $parents = (trim($role->elternrollen) != '') ? explode(',',$role->elternrollen) : null;
                        if (!is_null($parents)){
                            $this->addRole(new Zend_Acl_Role($role->name),$parents);
                        }else{
                            $this->addRole(new Zend_Acl_Role($role->name));
                        }
                    }catch (Exception $e){
                    }
                }
            }
        }

        // Ressourcen
        $res_list = $acl_db->getResourcesRoles();
        if (is_array($res_list)) {
            foreach ($res_list as $res){
                if (!$this->has($res->ressource)) {
                    $this->add(new Zend_Acl_Resource($res->ressource));
                }
                switch ($res->recht) {
                case 'allow':
                    $this->allow($res->rolle,$res->ressource);
                    break;
                case 'deny':
                    $this->deny($res->rolle,$res->ressource);
                    break;
                default:
                    break;
                }
            }
        }
    }

    /**
     * Aktualisiert die Liste der Ressourcen in der Datenbank
     */
    public function updateRessourceTree(){
        $acl_db = new Model_Acl();
        $this->parseResources();
        $acl_db->updateResourceTree($this->resources);
        return;
    }

    /**
     * Aktualisiert die Liste der Ressourcen in der Datenbank und gibt den Baum zurueck
     */
    public function getRessourceTree(){
        $this->updateRessourceTree();
        return $this->resources_tree;
    }
}