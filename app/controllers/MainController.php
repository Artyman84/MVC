<?php

namespace app\controllers;

use core\Controller;
use core\Request;
use core\Session;
use core\Db;
use app\models\TasksModel;

/**
 * Class MainController
 * @package app\controllers
 */
class MainController extends Controller {

    /**
     * Default action
     */
    public function indexAction() {
        $order = Request::getParam('order', 'get');
        $direction = Request::getParam('direction', 'get');

        if( !in_array($order, ['name', 'email', 'status']) ) {
            $order = 'id';
        }

        if( $direction != 'asc' && $direction != 'desc' ) {
            $direction = 'asc';
        }

        $pageNum = Request::getInt('page_num', 'get');
        $pageNum = $pageNum ?: 1;

        $limit = 3;
        $offset = ($pageNum - 1)*$limit;

        list($tasks, $totalCount) = TasksModel::model()->findAll([$order => $direction], $limit, $offset);
        $pageCount = (int)ceil($totalCount/$limit);
        $pageNum = $pageNum > $pageCount ? $pageCount : $pageNum;

        $this->setVars(compact('limit', 'tasks', 'order', 'direction', 'pageNum', 'pageCount', 'totalCount'));
        $this->renderView();
    }

    /**
     * Create task action
     */
    public function createAction() {
        if( $data=Request::getParam('task') ) {
            $data['status'] = 0;
            $taskModel = TasksModel::model();

            if( $taskModel->create($data) ) {
                $this->redirect();
            }

            Session::inst()->setVar('errors', $taskModel->getErrors());
            Session::inst()->setVar('data', $data);
            $this->redirect('main/create');

        }
        $this->renderView('create');
    }

    /**
     * Edit task action
     */
    public function editAction() {
        $session = Session::inst();

        if( !$session->getVar('is_admin') ) {
            $session->setVar('error_message', 'You don\'t have permissions on this page');
            $this->redirect();
        }

        $id = Request::getParam('id', 'get');
        $taskModel = TasksModel::model();
        $task = $taskModel->findOne($id);

        if( $task ) {
            if ($data = Request::getParam('task')) {
                $task = array_merge($task, $data);

                if ( $taskModel->update($task, $id) ) {
                    $this->redirect();
                }

                $session->setVar('errors', $taskModel->getErrors());
            }

            $this->setVars($task);
            $this->renderView('edit');

        } else {
            $this->redirect();
        }
    }


    /**
     * Login action
     */
    public function loginAction() {
        $isAuth = Request::getParam('is_auth');
        $name = Request::getParam('name');
        $password = Request::getParam('password');

        if( $isAuth && $name == 'admin' && $password == '123' ) {
            Session::inst()->setVar('is_admin', true);
            $this->redirect();
        } else {
            Session::inst()->setVar('error_message', 'Auth error');
        }

        $this->redirect();
    }

    /**
     * Logout action
     */
    public function logoutAction() {
        Session::inst()->unsetVar('is_admin');
        $this->redirect();
    }

}