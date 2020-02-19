<?php


namespace App\DAO;


use App\Basics\Account;
use App\Basics\Address;
use App\Basics\Client;
use App\Config\Doctrine;

class ClientDAO
{
    public function checkCpf(Client $client) {

        try {

            $doctrine = new Doctrine();
            $entityManager = $doctrine->getEntityManager();

            $clientObj = $entityManager->getRepository(Client::class)->findBy(array(
                'cpf'  => $client->getCpf(),
            ), array(
                'id' => 'ASC'
            ), 1);

            if (!empty($clientObj))
                return array('status' => 400, 'message' => "ERROR", 'result' => 'Este CPF já esta em uso por outra conta!');

            return array('status' => 200, 'message' => "SUCCESS", 'result' => 'Este CPF não está sendo usado por ninguém!');

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

    public function insert(Account $account, Client $client) {

        try {

            $doctrine = new Doctrine();
            $entityManager = $doctrine->getEntityManager();

            $contaObj = $entityManager->getRepository(Account::class)->findBy(array(
                'email'  => $account->getEmail(),
            ), array(
                'id' => 'ASC'
            ), 1);

            if (!empty($contaObj))
                return array('status' => 400, 'message' => "ERROR", 'result' => 'Este e-mail já esta em uso por outra conta!');

            $entityManager->persist($account);
            $entityManager->flush();

            $client->setAccount($account);
            $entityManager->persist($client);
            $entityManager->flush();

            $authDAO = new AuthDAO();

            return $authDAO->login($account);

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