<?php

namespace App\Controller;

use App\Basics\Account;
use App\DAO\AuthDAO;

class AuthController
{

    public function validateAccount(Account $account){
        if (is_null($account->getEmail())) {
            return array('status' => 400, 'message' => "ERROR", 'result' => 'E-Mail não informado!');
        }
        else if (is_null($account->getPass())) {
            return array('status' => 400, 'message' => "ERROR", 'result' => 'Senha não informada!');
        }
        else if (is_null($account->getGroup())) {
            return array('status' => 400, 'message' => "ERROR", 'result' => 'Grupo não informado!');
        }
        else{
            return array('status' => 200);
        }
    }

    public function checkEmail(Account $account){
        if (is_null($account->getEmail())) {
            return array('status' => 400, 'message' => "ERROR", 'result' => 'E-mail não informado!');
        }

        $authDAO = new AuthDAO();
        return $authDAO->checkEmail($account);
    }

    public function login(Account $account)
    {
        $result = $this->validateAccount($account);
        if ($result['status'] !== 200) return $result;

        $authDAO = new AuthDAO();
        return $authDAO->login($account);
    }

    public function reset(Account $account)
    {
        // Account
        if (empty($account->getEmail())) {
            return array('status' => 400, 'message' => "ERROR", 'result' => 'E-Mail não informado!');
            die;
        }

        $authDAO = new AuthDAO();
        return $authDAO->reset($account);

    }

    public function changePass(Account $account, $new, $old)
    {
        if (empty($account->getId())) {
            return array('status' => 400, 'message' => "ERROR", 'result' => 'ID não informado!');
            die;
        }
        if (empty($new)) {
            return array('status' => 400, 'message' => "ERROR", 'result' => 'Nova senha não informada!');
            die;
        }
        if (empty($old)) {
            return array('status' => 400, 'message' => "ERROR", 'result' => 'Senha anterior não informada!');
            die;
        }

        $authDAO = new AuthDAO();
        return $authDAO->changePass($account, $new, $old);

    }

    public function getProfile(Account $account)
    {
        if (empty($account->getId())) {
            return array('status' => 400, 'message' => "ERROR", 'result' => 'ID não informado!');
            die;
        }

        $authDAO = new AuthDAO();
        return $authDAO->getProfile($account);

    }
}