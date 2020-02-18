<?php

use App\Basics\Address;
use App\Utils\WorkOut;
use App\Controller\AddressController;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app->group('/locations', function (){

    $this->get('/cep/{value}', function (ServerRequestInterface $request, ResponseInterface $response, $args) {

        $address = new Address();
        $workOut = new WorkOut();
        $address->setCep(isset($args['value']) ? $workOut->removeMask($args['value'], 'cep') : null);

        $addressController = new AddressController();
        $return = $addressController->searchCep($address);

        if ($return['status'] !== 200){
            return $response->withJson($return, $return['status']);
            die;
        }else{
            return $response->withJson($return['address'], $return['status']);
            die;
        }
    });

});