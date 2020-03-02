<?php
/**
 * Created by PhpStorm.
 * User: Rafael Freitas
 * Date: 18/02/2020
 * Time: 16:28
 */

use App\Basics\Transaction;
use App\Config\Authorization;
use App\Controller\TransactionController;
use App\Utils\WorkOut;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app->group('/transactions', function (){

    $this->post('', function (ServerRequestInterface $request, ResponseInterface $response, $args) {

        $auth = new Authorization();
        $objJwt = $auth->validateToken($request);
        if($objJwt['status'] != 200){
            return $response->withJson($objJwt, $objJwt['status']);
            die;
        }

        $data = $request->getParsedBody();
        $transaction = new Transaction();
        $workOut = new WorkOut();
        $transaction->setClient(isset($objJwt['token']->data->us_id)?$objJwt['token']->data->us_id : null);
        $transaction->setTitle(isset($data['title'])?$data['title']: null);
        $transaction->setValue(isset($data['value'])? $workOut->removeMask($data['value'], 'money'): null);
        $transaction->setType(isset($data['type'])?$data['type']: null);

        $transactionController = new TransactionController();
        $return = $transactionController->insert($transaction);

        return $workOut->managerResponse($response, $return, 'result');
        die;

    });

});