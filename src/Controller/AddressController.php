<?php

namespace App\Controller;
use App\Basics\Address;
use App\DAO\AddressDAO;

class AddressController
{
    public function searchCep(Address $address){

        if (empty($address->getCep())) {
            return array('status' => 400, 'message' => "ERROR", 'result' => 'Cep não informado!');
            die;
        }
        $addressDAO = new AddressDAO();
        return $addressDAO->searchCep($address);
    }
}