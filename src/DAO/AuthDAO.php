<?php
/**
 * Created by PhpStorm.
 * User: Rafael Freitas
 * Date: 19/02/2020
 * Time: 08:35
 */
namespace App\DAO;
use App\Basics\Account;
use App\Basics\Client;
use App\Service\Email;
use App\Config\Doctrine;
class AuthDAO
{
    public function login(Account $account) {

        try {

            $doctrine = new Doctrine();
            $entityManager = $doctrine->getEntityManager();

            $accountObj = $entityManager->getRepository(Account::class)->findBy(array(
                'email'  => $account->getEmail(),
                'pass'  => $account->getPass(),
                'group'  => $account->getGroup(),
                'active'  => $account->getActive(),
            ), array(
                'id' => 'ASC'
            ), 1);

            if (empty($accountObj)) {
                return array('status' => 401, 'message' => "ERROR", 'result' => 'Usuário não existe ou a senha está incorreta!');
            }else{

                switch ($account->getGroup()){
                    case 1:
                        $clientObj = $entityManager->getRepository(Client::class)->findBy(array(
                            'conta'  => $accountObj[0]->getId(),
                        ), array(
                            'id' => 'ASC'
                        ), 1);

                        $clientObj[0]->setConta($accountObj[0]->convertArray());
                        break;
                    default:
                        return array(
                            'status' => 400,
                            'message' => 'Grupo não informado!'
                        );
                        break;
                }

                return array(
                    'status' => 200,
                    'message' => "SUCCESS",
                    'user' => $clientObj[0]->convertArray()
                );
            }

        } catch (\Doctrine\ORM\ORMException $ex) {
            return array(
                'status'    => 500,
                'message'   => "ERROR",
                'result'    => 'Erro na execução da instrução!',
                'CODE'      => $ex->getCode(),
                'Exception' => $ex->getMessage(),
            );
        }
    }

    public function checkEmail(Account $account) {

        try {

            $doctrine = new Doctrine();
            $entityManager = $doctrine->getEntityManager();

            $accountObj = $entityManager->getRepository(Account::class)->findBy(array(
                'email'  => $account->getEmail(),
            ), array(
                'id' => 'ASC'
            ), 1);

            if (!empty($accountObj))
                return array(
                    'status' => 400,
                    'message' => "ERROR",
                    'result' => 'Este e-mail já esta em uso por outra conta!',
                    'account' => $accountObj[0]->convertArray());

            return array('status' => 200, 'message' => "SUCCESS", 'result' => 'Este e-mail não está sendo usado por ninguém!');

        } catch (\Doctrine\ORM\ORMException $ex) {
            return array(
                'status'    => 500,
                'message'   => "ERROR",
                'result'    => 'Erro na execução da instrução!',
                'CODE'      => $ex->getCode(),
                'Exception' => $ex->getMessage(),
            );
        }
    }

    public function reset(Account $account) {

        try {

            $doctrine = new Doctrine();
            $entityManager = $doctrine->getEntityManager();

            $accountObj = $entityManager->getRepository(Account::class)->findBy(array(
                'email' => $account->getEmail(),
                'grupo' => $account->getGroup()
            ), array(
                'id' => 'ASC'
            ), 1);

            if (empty($accountObj)) {
                return array('status' => 401, 'message' => "ERROR", 'result' => 'Usuário não localizado!');
            } elseif(!$accountObj[0]->getActive()) {
                return array('status' => 401, 'message' => "ERROR", 'result' => 'Conta desativada!');
            } else {

                $newPass = strtoupper(uniqid());
                $newPass = str_split($newPass, 6);

                $accountObj[0]->setSenha(sha1($newPass[0]));

                $entityManager->flush();
                $email = new Email('');
                $email->newPass($accountObj[0], $newPass[0]);

                return array(
                    'status' => 200,
                    'message' => "SUCCESS",
                    'result' => 'Senha alterada!'
                );
            }

        } catch (\Doctrine\ORM\ORMException $ex) {
            return array(
                'status'    => 500,
                'message'   => "ERROR",
                'result'    => 'Erro na execução da instrução!',
                'CODE'      => $ex->getCode(),
                'Exception' => $ex->getMessage(),
            );
        }
    }

    public function changePass(Account $account, $new, $old) {

        try {

            $doctrine = new Doctrine();
            $entityManager = $doctrine->getEntityManager();

            $accountObj = $entityManager->find(Account::class, $account->getId());

            if (sha1($old) !== $accountObj->getSenha())
                return array('status' => 400, 'message' => "ERROR", 'result' => 'A senha informada não corresponde com a registrada!');

            $accountObj->setSenha(sha1($new));

            $entityManager->flush();

            return array(
                'status'    => 200,
                'message'   => "SUCCESS",
                'result'    => 'Senha alterada!',
            );

        } catch (\Doctrine\ORM\ORMException $ex) {
            return array(
                'status'    => 500,
                'message'   => "ERROR",
                'result'    => 'Erro na execução da instrução!',
                'CODE'      => $ex->getCode(),
                'Exception' => $ex->getMessage(),
            );
        }
    }

    public function getProfile(Account $account) {

        try {

            $doctrine = new Doctrine();
            $entityManager = $doctrine->getEntityManager();

            $accountObj = $entityManager->getRepository(Account::class)->findBy(array(
                'id'  => $account->getId(),
            ), array(
                'id' => 'ASC'
            ), 1);

            if (empty($accountObj)) {
                return array('status' => 401, 'message' => "ERROR", 'result' => 'Usuário não existe!');
            }else{

                switch ($account->getGroup()){
                    case 1:
                        $clientObj = $entityManager->getRepository(Client::class)->findBy(array(
                            'conta'  => $accountObj[0]->getId(),
                        ), array(
                            'id' => 'ASC'
                        ), 1);

                        $clientObj[0]->setConta($accountObj[0]->convertArray());
                        break;
                    default:
                        return array(
                            'status' => 400,
                            'message' => 'Grupo não informado!'
                        );
                        break;
                }

                return array(
                    'status' => 200,
                    'message' => "SUCCESS",
                    'result' => $clientObj[0]->convertArray()
                );
            }

        } catch (\Doctrine\ORM\ORMException $ex) {
            return array(
                'status'    => 500,
                'message'   => "ERROR",
                'result'    => 'Erro na execução da instrução!',
                'CODE'      => $ex->getCode(),
                'Exception' => $ex->getMessage(),
            );
        }
    }
}