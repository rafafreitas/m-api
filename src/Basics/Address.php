<?php
/**
 * Created by PhpStorm.
 * User: Rafael Freitas
 * Date: 18/02/2019
 * Time: 12:00
 */
namespace App\Basics;
/**
 * @Entity
 * @Table(name="address")
 */
class Address
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Column(type="string", length=14)
     */
    private $cep;

    /**
     * @Column(type="string", length=2, nullable=true)
     */
    private $state;

    /**
     * @Column(type="string", length=120, nullable=true)
     */
    private $city;

    /**
     * @Column(type="string", length=120, nullable=true)
     */
    private $neighborhood;

    /**
     * @Column(type="string", length=255, nullable=true)
     */
    private $street;

    /**
     * @Column(type="string", length=10, nullable=true)
     */
    private $number;

    /**
     * @Column(type="text", nullable=true)
     */
    private $complement;

    /**
     * @Column(type="string", length=30, nullable=true)
     */
    private $latitude;

    /**
     * @Column(type="string", length=30, nullable=true)
     */
    private $longitude;

    /**
     * Muitos enderecos tem um cliente
     * @ManyToOne(targetEntity="Client", inversedBy="address")
     * @JoinColumn(name="client_id", referencedColumnName="id")
     */

    private $client;

    public function convertArray(){
        return array(
            "id" => $this->id,
            "cep" => $this->cep,
            "state" => $this->state,
            "city" => $this->city,
            "neighborhood" => $this->neighborhood,
            "logradouro" => $this->street,
            "number" => $this->number,
            "complement" => $this->complement,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude
        );
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Address
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * @param mixed $cep
     * @return Address
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     * @return Address
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNeighborhood()
    {
        return $this->neighborhood;
    }

    /**
     * @param mixed $neighborhood
     * @return Address
     */
    public function setNeighborhood($neighborhood)
    {
        $this->neighborhood = $neighborhood;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     * @return Address
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComplement()
    {
        return $this->complement;
    }

    /**
     * @param mixed $complement
     * @return Address
     */
    public function setComplement($complement)
    {
        $this->complement = $complement;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     * @return Address
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     * @return Address
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     * @return Address
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }
}