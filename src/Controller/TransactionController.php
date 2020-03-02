<?php


namespace App\Controller;


use App\Basics\Client;
use App\Basics\Transaction;
use App\DAO\TransactionDAO;

class TransactionController
{

    public function insert(Transaction $transaction, Client $client)
    {

        if (is_null($transaction->getTitle())) return array('status' => 400, 'message' => "ERROR", 'result' => 'Identificação não informada!');

        if (is_null($transaction->getType())) return array('status' => 400, 'message' => "ERROR", 'result' => 'Tipo não informado!');

        if (is_null($transaction->getValue())) return array('status' => 400, 'message' => "ERROR", 'result' => 'Valor não informado!');

        if (is_null($client->getId())) return array('status' => 400, 'message' => "ERROR", 'result' => 'Cliente não informado!');

        $transactionDAO = new TransactionDAO();
        return $transactionDAO->insert($transaction, $client);

    }

    public function listAllLimit(Transaction $transaction, $limit)
    {

        if (is_null($transaction->getClient())) return array('status' => 400, 'message' => "ERROR", 'result' => 'Cliente não informado!');

        $transactionDAO = new TransactionDAO();
        return $transactionDAO->listAllLimit($transaction, $limit);

    }

    public function listToday(Transaction $transaction)
    {

        if (is_null($transaction->getClient())) return array('status' => 400, 'message' => "ERROR", 'result' => 'Cliente não informado!');

        $transactionDAO = new TransactionDAO();
        return $transactionDAO->listToday($transaction);

    }

    public function balance(Transaction $transaction)
    {

        if (is_null($transaction->getClient())) return array('status' => 400, 'message' => "ERROR", 'result' => 'Cliente não informado!');

        $transactionDAO = new TransactionDAO();
        return $transactionDAO->balance($transaction);

    }

}