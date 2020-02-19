<?php


namespace App\Controller;


use App\Basics\Account;
use App\Basics\Address;
use App\Basics\Client;
use App\DAO\AddressDAO;
use App\DAO\AuthDAO;
use App\DAO\ClientDAO;
use App\Utils\WorkOut;

class ClientController
{

    public function checkCpf(Client $client){
        if (is_null($client->getCpf())) {
            return array('status' => 400, 'message' => "ERROR", 'result' => 'CPF não informado!');
        }

        $clientDAO = new ClientDAO();
        return $clientDAO->checkCpf($client);
    }

    public function insert(Account $account, Client $client)
    {
        $authController = new AuthController();
        $result = $authController->validateAccount($account);
        if ($result['status'] !== 200) return $result;

        if (is_null($client->getName())) return array('status' => 400, 'message' => "ERROR", 'result' => 'Nome não informado!');

        $clientDAO = new ClientDAO();
        return $clientDAO->insert($account, $client);

    }

}