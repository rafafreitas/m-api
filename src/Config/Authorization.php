<?php


namespace App\Config;

use Firebase\JWT\JWT;

define('SECRET_KEY','sua_senha');
define('ALGORITHM','HS256');
class Authorization
{
    public function createToken($obj){
        $tokenId    = base64_encode(random_bytes (32));
        $issuedAt   = time();
        $notBefore  = $issuedAt + 10;
        $expire     = $notBefore + 8640000;
        $serverName = 'http://m-api.rafafreitas.com/';
        ///
        $data = [
            'iat'  => $issuedAt,
            'jti'  => $tokenId,
            'iss'  => $serverName,
            'nbf'  => $notBefore,
            'exp'  => $expire,
            'data' => $obj
        ];

        $secretKey = SECRET_KEY;
        $jwt = JWT::encode(
            $data, //Data to be encoded in the JWT
            $secretKey,
            ALGORITHM
        );
        return $jwt;
    }

    public function validateToken($request) {
        $authorization = $request->getHeaderLine("Authorization");

        if (trim($authorization) == "") {
            return array('status' => 401, 'message' => 'ERROR', 'result' => 'Token não informado');
        } else {
            try {
                JWT::$leeway = 60;
                $token = JWT::decode($authorization, SECRET_KEY, array('HS256'));
                return array('status' => 200, 'token' => $token);
            } catch (Firebase\JWT\ExpiredException $ex) {
                return array(
                    'status' => 401,
                    'result' => 'Acesso não autorizado',
                    'message' => $ex->getMessage()
                );
            }
        }
    }
}