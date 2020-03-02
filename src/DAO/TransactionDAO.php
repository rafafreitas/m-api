<?php


namespace App\DAO;


use App\Basics\Transaction;
use App\Basics\Client;
use App\Config\Doctrine;

class TransactionDAO
{
    public function insert(Transaction $transaction) {

        try {

            $doctrine = new Doctrine();
            $entityManager = $doctrine->getEntityManager();

            $entityManager->persist($transaction);
            $entityManager->flush();

            return array(
                'status'    => 200,
                'message'   => "SUCCESS",
                'result'    => 'Transação inserida!',
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

}