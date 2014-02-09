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

    public function __construct($model, $dbObject) {

        $this->ModelName = $model;
        $this->dbObject = $dbObject;
        $this->recordSet = new \Edify\Database\Record($this->ModelName, $this->dbObject);
    }

    function create($parameters) {
        return $this->_edit($this->recordSet->newRecord(), $parameters);
    }

    function update($parameters) {
        if (!isset($parameters[$this->recordSet->primaryKey])){
            throw new \Edify\Exceptions\Database("Primary key not set");
        }
        $obj = $this->recordSet->select(Array($this->recordSet->primaryKey => $parameters[$this->recordSet->primaryKey]));
        return $this->_edit($obj, $parameters);
    }
    private function _edit($object, $parameters) {
        $internalAction = 'viewForm';
        if (isset($parameters['_action'])) {  // is the form submitted??
            $internalAction = 'saveForm';
            unset($parameters['_action']);
            $success = $object->assign($parameters);
            if($success){
                $object = $this->recordSet->save($object);
                header("Location: /");
                exit();
            }
        }
        ob_start();
        include $this->viewTemplate;
        $buffer = ob_get_contents();
        ob_end_clean();
        return buffer;
    }

    function retrieve($parameters, $orderby = "") {
        $dataSet = $this->RecordSet->select($parameters, $orderby);
        ob_start();
        include $this->viewTemplate;
        $buffer = ob_get_contents();
        ob_end_clean();
        return buffer;
    }


    function delete($parameters, $orderby) {
        $dataSet = $this->RecordSet->select($parameters, $orderby);
        ob_start();
        include $this->viewTemplate;
        $buffer = ob_get_contents();
        ob_end_clean();
        return buffer;
    }

}
