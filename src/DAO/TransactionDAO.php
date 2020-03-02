<?php


namespace App\DAO;


use App\Basics\Transaction;
use App\Basics\Client;
use App\Config\Doctrine;

class TransactionDAO
{
    public function insert(Transaction $transaction, Client $client) {

        try {

            $doctrine = new Doctrine();
            $entityManager = $doctrine->getEntityManager();

            $clientObj = $entityManager->find(Client::class, $client->getId());
            $transaction->setClient($clientObj);

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

    public function listAllLimit(Transaction $transaction, $limit){

        try {

            $doctrine = new Doctrine();
            $entityManager = $doctrine->getEntityManager();

            $transactionbj = $entityManager->getRepository(Transaction::class)->findBy(
                array('client' => $transaction->getClient()),
                array('create_date'=>'DESC'),
                $limit
            );

            if (empty($transactionbj)) {
                return array(
                    'status'    => 200,
                    'message'   => "SUCCESS",
                    'qtd'       => 0,
                    'result'    => []
                );
            }else {
                $list = [];
                foreach ($transactionbj as $transactionItem){
                    array_push($list, $transactionItem->convertArray());
                }

                return array(
                    'status'    => 200,
                    'message'   => "SUCCESS",
                    'qtd'       => count($list),
                    'result'    => $list
                );
            }

        } catch (\Exception $ex) {
            return array(
                'status'    => 500,
                'message'   => "ERROR",
                'result'    => 'Erro na execução da instrução!',
                'CODE'      => $ex->getCode(),
                'Exception' => $ex->getMessage(),
            );
        }
    }

    public function listToday(Transaction $transaction){

        try {

            $doctrine = new Doctrine();
            $entityManager = $doctrine->getEntityManager();

            $transactionbj = $entityManager->getRepository(Transaction::class)->findBy(
                array('client' => $transaction->getClient()),
                array('create_date'=>'DESC')
            );

            if (empty($transactionbj)) {
                return array(
                    'status'    => 200,
                    'message'   => "SUCCESS",
                    'qtd'       => 0,
                    'result'    =>  array(
                        'today' => [],
                        'previous' => [],
                    )
                );
            }else {

                $today = [];
                $previous = [];
                foreach ($transactionbj as $transactionItem){

                    $date = new \DateTime();

                    if (strtotime($transactionItem->getCreateDate()->format('d/m/Y')) < strtotime(($date->format('d/m/Y')))) {
                        array_push($previous, $transactionItem->convertArray());
                    } else {
                        array_push($today, $transactionItem->convertArray());
                    }
                }

                return array(
                    'status'    => 200,
                    'message'   => "SUCCESS",
                    'result'    =>  array(
                        'today' => $today,
                        'previous' => $previous,
                    )
                );
            }

        } catch (\Exception $ex) {
            return array(
                'status'    => 500,
                'message'   => "ERROR",
                'result'    => 'Erro na execução da instrução!',
                'CODE'      => $ex->getCode(),
                'Exception' => $ex->getMessage(),
            );
        }
    }

    public function balance(Transaction $transaction){

        try {

            $doctrine = new Doctrine();
            $entityManager = $doctrine->getEntityManager();

            $transactionbj = $entityManager->getRepository(Transaction::class)->findBy(
                array('client' => $transaction->getClient()),
                array('create_date'=>'DESC')
            );

            if (empty($transactionbj)) {
                return array(
                    'status'    => 200,
                    'message'   => "SUCCESS",
                    'qtd'       => 0,
                    'result'    =>  array(
                        'today' => [],
                        'previous' => [],
                    )
                );
            }else {

                $input = 0;
                $output = 0;
                foreach ($transactionbj as $transactionItem){

                    if ($transactionItem->getType() === 1){
                        $input += $transactionItem->getValue();
                    } else {
                        $output += $transactionItem->getValue();
                    }
                }

                return array(
                    'status'    => 200,
                    'message'   => "SUCCESS",
                    'result'    =>  array(
                        'balance' => $input - $output
                    )
                );
            }

        } catch (\Exception $ex) {
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