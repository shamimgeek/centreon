<?php

namespace Controllers\Configuration;

use Models\Configuration\Contact;

class UserController extends \Centreon\Core\Controller
{

    /**
     * List users
     *
     * @method get
     * @route /configuration/user
     */
    public function listAction()
    {
        // Init template
        $di = \Centreon\Core\Di::getDefault();
        $tpl = $di->get('template');

        // Load CssFile
        $tpl->addCss('dataTables.css')
            ->addCss('dataTables.bootstrap.css')
            ->addCss('dataTables-TableTools.css');

        // Load JsFile
        $tpl->addJs('jquery.dataTables.min.js')
            ->addJs('jquery.dataTables.TableTools.min.js')
            ->addJs('bootstrap-dataTables-paging.js')
            ->addJs('jquery.dataTables.columnFilter.js');
        
        // Display page
        $tpl->assign('objectName', 'User');
        $tpl->assign('objectAddUrl', '/configuration/user/add');
        $tpl->assign('objectListUrl', '/configuration/user/list');
        $tpl->display('configuration/list.tpl');
    }

    /**
     * 
     * @method get
     * @route /configuration/user/list
     */
    public function datatableAction()
    {
        $di = \Centreon\Core\Di::getDefault();
        $router = $di->get('router');
        
        $router->response()->json(\Centreon\Core\Datatable::getDatas(
            'user',
            $this->getParams('get')
            )
        );
    }
    
    /**
     * 
     * @method get
     * @route /configuration/user/formlist
     */
    public function formListAction()
    {
        $di = \Centreon\Core\Di::getDefault();
        $router = $di->get('router');
        
        $requestParams = $this->getParams('get');
        
        $contactObj = new Contact();
        $filters = array('contact_name' => $requestParams['q'].'%');
        $contactList = $contactObj->getList('contact_id, contact_name, contact_email', -1, 0, null, "ASC", $filters, "AND");
        
        $finalContactList = array();
        foreach($contactList as $contact) {
            $finalContactList[] = array(
                "id" => $contact['contact_id'],
                "text" => $contact['contact_name'],
                "theming" => \Centreon\Repository\UserRepository::getUserIcon($contact['contact_name'], $contact['contact_email'])
            );
        }
        
        $router->response()->json($finalContactList);
    }
    
    /**
     * Create a new user
     *
     * @method post
     * @route /configuration/user/create
     */
    public function createAction()
    {
        
    }

    /**
     * Update a user
     *
     *
     * @method put
     * @route /configuration/user/update
     */
    public function updateAction()
    {
        
    }
    
    /**
     * Add a user
     *
     *
     * @method get
     * @route /configuration/user/add
     */
    public function addAction()
    {
        
    }
    
    /**
     * Update a user
     *
     *
     * @method get
     * @route /configuration/user/[i:id]
     */
    public function editAction()
    {
        
    }
}