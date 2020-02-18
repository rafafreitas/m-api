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
use App\Controller\AuthController;
use App\Utils\WorkOut;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app->group('', function (){

    $this->post('/login', function (ServerRequestInterface $request, ResponseInterface $response, $args) {

        $data = $request->getParsedBody();
        $account = new Account();
        $account->setEmail(isset($data['email'])?$data['email']: null);
        $account->setPass(isset($data['pass'])?sha1($data['pass']): null);
        $account->setGroup(isset($data['group'])?$data['group']: null);
        $account->setActive(true);

        $file = UPLOAD_CLI . 'logs/' . 'log.txt';
        $WorkOut = new WorkOut();
        file_put_contents($file, 'REQUEST GET = /login/ ' . " => "  .  $WorkOut->getData()  . PHP_EOL,FILE_APPEND);

        $authController = new AuthController();
        $return = $authController->login($account);

        if ($return['status'] !== 200){
            return $response->withJson($return, $return['status']);
            die;
        }else{
            $auth = new Authorization();
            $jwt = $auth->gerarToken($return['user']);

            return $response->withHeader('Authorization', $jwt)
                ->withJson($return['user'], 200);
            die;
        }
    });

    $this->post('/client', function (ServerRequestInterface $request, ResponseInterface $response, $args) {

        $data = $request->getParsedBody();
        $account = new Account();
        $account->setEmail(isset($data['email'])?$data['email']: null);
        $account->setPass(isset($data['pass'])?sha1($data['pass']): null);
        $account->setGroup(1);
        $account->setActive(true);

        $authController = new AuthController();

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
        $retorno = $authController->insertClient($account, $client, $address);


    });

});