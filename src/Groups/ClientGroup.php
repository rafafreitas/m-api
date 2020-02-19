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

        $client = new Client();
        $client->setName(isset($data['name'])?$data['name']: null);

        $return = $clientController->insert($account, $client);

        $workOut = new WorkOut();

        return $workOut->managerResponseToken($response, $return, 'user');

    });

});