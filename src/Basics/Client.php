<?php


namespace App\Basics;

/**
 * @Entity
 * @Table(name="clients")
 */
class Client
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Column(type="text")
     */
    private $name;

    /**
     * @Column(type="string", length=14, unique=true, nullable=true)
     */
    private $cpf;

    /**
     * @Column(type="string", length=14, nullable=true)
     */
    private $phone;

    /**
     * @Column(type="string", length=14, nullable=true)
     */
    private $sex;

    /**
     * @Column(type="date", nullable=true)
     */
    private $birth;

    /**
     * @Column(type="text", nullable=true)
     */
    private $picture;

    /**
     * Um cliente tem muitos endereços
     * @OneToMany(targetEntity="Address", mappedBy="client")
     */
    private $address;

    /**
     * Um cliente possui uma conta.
     * @OneToOne(targetEntity="account")
     * @JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $account;

    /**
     * Um cliente tem muitas transações
     * @OneToMany(targetEntity="Transaction", mappedBy="client")
     */
    private $transactions;

    public function convertArray(){
        return array(
            "id" => $this->id,
            "name" => $this->name,
            "cpf" => $this->cpf,
            "phone" => $this->phone,
            "sex" => $this->sex,
            "birth" => ($this->birth) ? $this->birth->format('d/m/Y') : null,
            "picture" => $this->picture,
            "account" => $this->account->convertArray()
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
     * @return Client
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Client
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param mixed $cpf
     * @return Client
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     * @return Client
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param mixed $sex
     * @return Client
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBirth()
    {
        return $this->birth;
    }

    /**
     * @param mixed $birth
     * @return Client
     */
    public function setBirth($birth)
    {
        $this->birth = $birth;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param mixed $picture
     * @return Client
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     * @return Client
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param mixed $account
     * @return Client
     */
    public function setAccount($account)
    {
        $this->account = $account;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * @param mixed $transactions
     * @return Client
     */
    public function setTransactions($transactions)
    {
        $this->transactions = $transactions;
        return $this;
    }
}