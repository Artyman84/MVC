<?php


namespace app\models;


use core\Model;

/**
 * Class TasksModel
 * @package app\models
 */
class TasksModel extends Model {

    /**
     * @var string
     */
    protected $table = 'tasks';

    /**
     * @var string
     */
    protected $pk = 'id';


    /**
     * @param array $data
     * @return bool
     */
    public function validate($data) {

        $this->errors = [];

        if( !trim($data['name']) ) {
            $this->errors['name'] = 'Name can\'t be empty';
        }

        if (!trim($data['email'])) {
            $this->errors['email'] = 'Email can\'t be empty';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Email is not valid';
        }

        if( !trim($data['text']) ) {
            $this->errors['text'] = 'Text can\'t be empty';
        }

        return empty($this->errors);
    }
}