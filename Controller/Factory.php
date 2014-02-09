<?php

namespace Edify\Controller;

/**
 * 
 */

/**
 * Description of Controller Factory
 *
 * This is a basic controller that will allow you to work with models
 *
 * @author IrishAdo <irishado@php-programmers.net>
 */
class Factory {

    private $modelName = null;
    private $dbObject = null;
    private $recordSet = null;
    private $viewTemplate = null;
    private $templatePath = '';
    private $className = '';

    /**
     * Constructor for the Controller factory
     *
     * The controller factory is a dirty class which will take a model object
     * and allow the execution of the CRUD functions on it with little interaction
     * on the behalf of a developer.  It has no user premissons for example so is
     * considered only a training tool.
     *
     * Please note that the templates that are used for this are/will be generated
     * by the AutoAppGenerator that I will write.
     *
     * @param type $objectName  the name of the object we will be workign with.
     * @param type $className
     * @param type $model
     * @param type $dbObject
     */
    public function __construct($objectName, $className, $model, $dbObject) {
        $this->className = $className;
        $this->templatePath = \Edify\Utils\Loader::getVendorForNameSpacePath($objectName) . 'Templates/Controller/' . $this->className;
        $this->ModelName = $model;
        $this->dbObject = $dbObject;
        $this->recordSet = new \Edify\Database\Record($this->ModelName, $this->dbObject);
    }

    /**
     * The letter C in the term CRUD stand for create
     * so we will call the private _edit function and pass a
     * new empty version of the model object.
     *
     * @param type $parameters
     * @return type
     */
    function create($parameters) {
        return $this->_edit($this->recordSet->newRecord(), $parameters);
    }

    /**
     * The letter U in the term CRUD stand for update
     * so we will call the private _edit function and pass an
     * extracted model object from the database.
     *
     * @param Array $parameters
     * @return type
     */
    function update($parameters) {
        if (!isset($parameters[$this->recordSet->primaryKey])) {
            throw new \Edify\Exceptions\Database("Primary key not set");
        }
        $obj = $this->recordSet->select(Array($this->recordSet->primaryKey => $parameters[$this->recordSet->primaryKey]));
        return $this->_edit($obj, $parameters);
    }

    /**
     * Both the Create and Update functions are almost 99% 
     * identical the main difference would be that you
     * either have a empty object to start with or you
     * have extracted the object from the database.
     *
     * This is a private function that renders the form
     * that allows a user to change properties of an
     * object.
     *
     * It also works out if it should save the object
     * after it assigns the changes to the model object
     * if the assignement of variables was correct.
     * Then it will redirect to the controller list view.
     *
     * @param Object $object
     * @param Array $parameters
     * @return String
     */
    private function _edit($object, $parameters) {
        if (isset($parameters['_action'])) {  // is the form submitted??
            unset($parameters['_action']);
            $success = $object->assign($parameters);
            if ($success) {
                $object = $this->recordSet->save($object);
                header('Location: /' . $this->className . '/');
                exit();
            }
        }
        $lookups = $this->_getLookUps($object);
        $view = new \Edify\View\Obj(
                Array(
            'obj' => $object,
            'lookups'=>$lookups
                ), $this->templatePath .'/view.phtml');
        return $view->fetch();
    }

    /**
     * Take an object and look at the model which will 
     * in a future update list any related tables.  If 
     * there is a related table then extract all of the
     * lookup records and pass to the template builder.
     * 
     * This will allow the template to render a select
     * combo box for the user to select one option.
     * 
     * @param Object $object The model object to get lookup information for.
     */
    private function _getLookUps($object){
        /// TODO
        return Array();
    }

    /**
     * The letter R in the term CRUD stand for retrieve
     * so we will extract all of the results for the type
     * of this model from the database.
     *
     * @param Array $parameters
     * @return String Buffer
     */
    function retrieve($parameters = Array(), $orderby = "") {
        $dataSet = $this->RecordSet->select($parameters, $orderby);
        $view = new \Edify\View\Obj(Array('obj' => $dataSet), $this->templatePath . '/retrieve.phtml');
        return $view->fetch();
    }

    /**
     * Delete a record from the database when the primary
     * key is passed as a parameter.
     *
     * @param Array $parameters
     * @return String buffer of the are you sure?
     * @throws \Edify\Exceptions\Database
     */
    function delete($parameters = Array()) {

        if (!isset($parameters[$this->recordSet->primaryKey])) {
            throw new \Edify\Exceptions\Database("Primary key not set");
        }
        // get the record
        $dataSet = $this->RecordSet->select(Array($this->recordSet->primaryKey => $parameters[$this->recordSet->primaryKey]), $orderby);
        // there should be only one
        if (count($dataSet) != 1) {
            throw new \Edify\Exceptions\Database("Unable to find single instance of that record.");
        }
        // if _action exists and it is 'delete' then
        if (isset($parameters['_action']) && $parameters['_action'] = 'delete') {  // is the form submitted??
            unset($parameters['_action']);
            $this->RecordSet->delete($dataSet[0]);
            header('Location: /' . $this->className . '/');
            exit();
        }
        $view = new \Edify\View\Obj(Array('obj' => $dataSet), $this->templatePath . '/delete.phtml');
        return $view->fetch();
    }

}
