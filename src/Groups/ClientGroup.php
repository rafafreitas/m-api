<?php
/**
 * Created by PhpStorm.
 * User: Rafael Freitas
 * Date: 18/02/2020
 * Time: 16:28
 */

use App\Basics\Account;
use App\Basics\Client;
use App\Basics\Address;
use App\Config\Authorization;
use App\Controller\ClientController;
use App\Utils\WorkOut;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app->group('/client', function (){

    $this->post('', function (ServerRequestInterface $request, ResponseInterface $response, $args) {

        $data = $request->getParsedBody();
        $account = new Account();
        $account->setEmail(isset($data['email'])?$data['email']: null);
        $account->setPass(isset($data['pass'])?sha1($data['pass']): null);
        $account->setGroup(1);
        $account->setActive(true);

        $clientController = new ClientController();

        $workOut = new WorkOut();
        $client = new Client();
        $client->setName(isset($data['nome'])?$data['nome']: null);
        $client->setCpf(isset($data['cpf'])?$workOut->removeMask($data['cpf'], 'cpf'): null);
        $client->setPhone(isset($data['phone'])?$workOut->removeMask($data['phone'], 'phone'): null);
        $client->setSex(isset($data['sex'])?$data['sex']: null);
        $client->setBirth(isset($data['birth'])?$workOut->removeMask($data['birth'], 'birth'): null);

        $address = new Address();
        $address->setCep(isset($data['cep'])? $workOut->removeMask($data['cep'], 'cep') : null);
        $address->setNumber(isset($data['number'])?$data['number']: null);
        $address->setComplement(isset($data['complement'])?$data['complement']: null);

        $return = $clientController->insert($account, $client, $address);

        $workOut = new WorkOut();

        return $workOut->managerResponseToken($response, $return, 'user');

    });

});