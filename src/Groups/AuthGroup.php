<?php
/**
 * Created by PhpStorm.
 * User: Rafael Freitas
 * Date: 18/02/2020
 * Time: 16:28
 */

use App\Basics\Account;
use App\Config\Authorization;
use App\Controller\AuthController;
use App\Utils\WorkOut;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app->group('/auth', function (){

    $this->post('', function (ServerRequestInterface $request, ResponseInterface $response, $args) {

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

    $this->get('/checkEmail/{email}', function (ServerRequestInterface $request, ResponseInterface $response, $args) {

        $authController = new AuthController();
        $account = new Account();
        $account->setEmail($args['email']);

        $workOut = new WorkOut();

        $return = $authController->checkEmail($account);

        return $workOut->managerResponse($response, $return, 'result');
        die;
    });

    $this->post('/forgotIt', function (ServerRequestInterface $request, ResponseInterface $response, $args) {

        $data = $request->getParsedBody();
        $account = new Account();
        $account->setEmail(isset($data['email'])?$data['email']: null);
        $account->setGroup(isset($data['group'])?$data['group']: null);

        $authController = new AuthController();
        $workOut = new WorkOut();

        $return = $authController->reset($account);
        return $workOut->managerResponse($response, $return, 'result');
        die;
    });

    $this->post('/changePass', function (ServerRequestInterface $request, ResponseInterface $response, $args) {

        $data = $request->getParsedBody();
        $auth = new Authorization();
        $objJwt = $auth->verificarToken($request);

        if($objJwt['status'] != 200){
            return $response->withJson($objJwt, $objJwt['status']);
            die;
        }

        $account = new Account();
        $account->setId(isset($objJwt['token']->data->conta->id)?$objJwt['token']->data->conta->id : null);
        $new = (isset($data['new_pass'])) ? $data['new_pass']: null;
        $old = (isset($data['old_pass'])) ? $data['old_pass']: null;

        $authController = new AuthController();
        $workOut = new WorkOut();

        $return = $authController->changePass($account, $new, $old);
        return $workOut->managerResponse($response, $return, 'result');
        die;
    });

    $this->get('/getProfile', function (ServerRequestInterface $request, ResponseInterface $response, $args) {

        $auth = new Authorization();
        $objJwt = $auth->verificarToken($request);
        if($objJwt['status'] != 200){
            return $response->withJson($objJwt, $objJwt['status']);
            die;
        }

        $authController = new AuthController();
        $workOut = new WorkOut();
        $account = new Account();
        $account->setId(isset($objJwt['token']->data->conta->id)?$objJwt['token']->data->conta->id : null);

        $return = $authController->getProfile($account);
        return $workOut->managerResponse($response, $return, 'result');
        die;
    });
});