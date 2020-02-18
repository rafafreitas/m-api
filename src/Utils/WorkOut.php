<?php

namespace App\Utils;

use Psr\Http\Message\ResponseInterface;

class WorkOut
{

    public function managerResponse (ResponseInterface $response, $return, $param) {

        return ($return['status'] !== 200) ?
            $response->withJson($return, $return['status']) :
            $response->withJson($return[$param], 200);

    }

    public function getData()
    {
        date_default_timezone_set("America/Recife");
        return date('Y-m-d H:i:s');
    }

    public function removeMask($oldValue, $type)
    {
        switch ($type) {
            case 'cpf':
                $cpf = str_replace(".", "", $oldValue);
                $cpf = str_replace("-", "", $cpf);
                return $cpf;
                break;

            case 'cnpj':
                $cnpj = str_replace(".", "", $oldValue);
                $cnpj = str_replace("-", "", $cnpj);
                $cnpj = str_replace("/", "", $cnpj);
                return $cnpj;
                break;

            case 'phone':
                $telefone = str_replace("(", "", $oldValue);
                $telefone = str_replace(")", "", $telefone);
                $telefone = str_replace(" ", "", $telefone);
                $telefone = str_replace("-", "", $telefone);
                return $telefone;
                break;

            case 'money':
                $money = str_replace("R$ ", "", $oldValue);
                $money = str_replace(".", "", $money);
                $money = str_replace(",", ".", $money);
                return $money;
                break;
            case 'cep':
                $cep = str_replace(".", "", $oldValue);
                $cep = str_replace("-", "", $cep);
                $cep = $this->mask($cep, '#####-###');
                return $cep;
                break;
            case 'cep_only_number':
                $cep = str_replace(".", "", $oldValue);
                $cep = str_replace("-", "", $cep);
                return $cep;
                break;
        }
    }

    function mask($val, $mask)
    {
        $maskared = '';
        if (empty($val)) return $maskared;
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k])) {
                    $maskared .= $val[$k++];
                }
            } else {
                if (isset($mask[$i])) {
                    $maskared .= $mask[$i];
                }
            }
        }
        return $maskared;
    }
}