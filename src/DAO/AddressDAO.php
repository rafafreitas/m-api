<?php

namespace App\DAO;
use App\Basics\Address;
use App\Connection\Database;
use App\Service\ViaCep;
use PDO;
use PDOException;
class AddressDAO
{
    public function searchCep(Address $address){
        try {
            $conn = Database::conexao();
            $sql = "SELECT id, cep, uf, cidade, bairro, logradouro, 
                       latitude, longitude, ibge_cod_uf, ibge_cod_cidade, 
                       area_cidade_km2, ddd
                FROM enderecos_full 
                WHERE cep = ?;";
            $stmt = $conn->prepare($sql);

            $stmt->bindValue(1,$address->getCep(), PDO::PARAM_STR);
            $stmt->execute();
            $countAddress = $stmt->rowCount();
            $resultEnderecos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($countAddress != 0) {
                return array(
                    'status'    => 200,
                    'message'   => "SUCCESS",
                    'address'  => array(
                        'id' => null,
                        'cep' => $resultEnderecos[0]['cep'],
                        'street' => $resultEnderecos[0]['logradouro'],
                        'neighborhood' => $resultEnderecos[0]['bairro'],
                        'city' => $resultEnderecos[0]['cidade'],
                        'state' => $resultEnderecos[0]['uf'],
                        'latitude' => $resultEnderecos[0]['latitude'],
                        'longitude' => $resultEnderecos[0]['longitude']
                    )
                );

            }else{
                $viaCep = new ViaCep();
                $addressViaCep = $viaCep->find($address->getCep())->toArray();
                return array(
                    'status'    => 200,
                    'message'   => "SUCCESS",
                    'endereco'  => array(
                        'id' => null,
                        'cep' => $addressViaCep['zipCode'],
                        'street' => $addressViaCep['street'],
                        'neighborhood' => $addressViaCep['neighborhood'],
                        'city' => $addressViaCep['city'],
                        'state' => $addressViaCep['state'],
                        'latitude' => null,
                        'longitude' => null
                    )
                );
            }

        }catch (PDOException $ex) {
            return array(
                'status'    => 500,
                'message'   => "ERROR",
                'result'    => 'Erro na execução da instrução!',
                'CODE'      => $ex->getCode(),
                'Exception' => $ex->getMessage(),
            );
        }
    }
}