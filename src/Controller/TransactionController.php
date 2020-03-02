<?php


namespace App\Controller;


use App\Basics\Transaction;
use App\DAO\TransactionDAO;

class TransactionController
{

    public function insert(Transaction $transaction)
    {

        if (is_null($transaction->getTitle())) return array('status' => 400, 'message' => "ERROR", 'result' => 'Identificação não informada!');

        if (is_null($transaction->getType())) return array('status' => 400, 'message' => "ERROR", 'result' => 'Tipo não informado!');

        if (is_null($transaction->getValue())) return array('status' => 400, 'message' => "ERROR", 'result' => 'Valor não informado!');

        if (is_null($transaction->getClient())) return array('status' => 400, 'message' => "ERROR", 'result' => 'Cliente não informado!');

        $transactionDAO = new TransactionDAO();
        return $transactionDAO->insert($transaction);

    }

}