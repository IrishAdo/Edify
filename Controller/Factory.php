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
    public function __construct($objectName,$className, $model, $dbObject) {
        $this->className = $className;
        $this->templatePath = \Edify\Utils\Loader::getVendorForNameSpacePath($objectName);
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
     * @param type $parameters
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
     * private function that renders the form that
     * allows a user to change properties of an object.
     * It also works out if it should save the object.
     *
     * @param type $object
     * @param type $parameters
     * @return type
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
        $view = new \Edify\View\Obj(Array('obj' => $object), $this->templatePath . 'Templates/Controller/' . $this->className . '/view.phtml');
        return $view->fetch();
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
        $view = new \Edify\View\Obj(Array('obj' => $dataSet), $this->templatePath . 'Templates/Controller/' . $this->className . '/retrieve.phtml');
        return $view->fetch();
    }

    function delete($parameters = Array(), $orderby) {

        if (!isset($parameters[$this->recordSet->primaryKey])) {
            throw new \Edify\Exceptions\Database("Primary key not set");
        }
        $dataSet = $this->RecordSet->select(Array($this->recordSet->primaryKey => $parameters[$this->recordSet->primaryKey]), $orderby);
        if (count($dataSet) != 1) {
            throw new \Edify\Exceptions\Database("Unable to find single instance of that record.");
        }

        if (isset($parameters['_action']) && $parameters['_action'] = 'delete') {  // is the form submitted??
            unset($parameters['_action']);
            $success = $this->RecordSet->delete($dataSet[0]);
            if ($success) {
                $object = $this->recordSet->save($object);
                header('Location: /' . $this->className . '/');
                exit();
            }
        }
        $view = new \Edify\View\Obj(Array('obj' => $dataSet), $this->templatePath . 'Templates/Controller/' . $this->className . '/delete.phtml');
        return $view->fetch();
    }

}
