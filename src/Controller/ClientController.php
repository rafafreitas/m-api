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

    public function insert(Account $account, Client $client, Address $address)
    {
        $authController = new AuthController();
        $result = $authController->validateAccount($account);
        if ($result['status'] !== 200) return $result;

        if (is_null($client->getName())) return array('status' => 400, 'message' => "ERROR", 'result' => 'Nome não informado!');

        if (is_null($client->getCpf())) return array('status' => 400, 'message' => "ERROR", 'result' => 'CPF não informada!');

        if (is_null($client->getPhone())) return array('status' => 400, 'message' => "ERROR", 'result' => 'Telefone não informado!');

        if (is_null($address->getCep())) return array('status' => 400, 'message' => "ERROR", 'result' => 'Cep não informado!');

        if (is_null($address->getNumber())) return array('status' => 400, 'message' => "ERROR", 'result' => 'Número do endereço não informado!');

        $addressDAO = new AddressDAO();
        $getCep = $addressDAO->searchCep($address);

        if ($getCep['status'] !== 200)
            return array('status' => 400, 'message' => "ERROR", 'result' => 'Cep não localizado!');

        $address->setStreet($getCep['endereco']['logradouro']);
        $address->setNeighborhood($getCep['endereco']['bairro']);
        $address->setCity($getCep['endereco']['cidade']);
        $address->setState($getCep['endereco']['uf']);
        $address->setLatitude($getCep['endereco']['latitude']);
        $address->setLongitude($getCep['endereco']['longitude']);

        $workOut = new WorkOut();
        $client->setCpf($workOut->removeMask($client->getCpf(), 'cpf'));
        $client->setPhone($workOut->removeMask($client->getPhone(), 'phone'));

        $clientDAO = new ClientDAO();
        return $clientDAO->insert($account, $client, $address);

    }

}