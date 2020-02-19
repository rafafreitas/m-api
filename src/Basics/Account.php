<?php

namespace App\Basics;

/**
 * @Entity
 * @Table(name="accounts")
 */
class Account
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Column(type="string", length=120)
     */
    private $email;
    /**
     * @Column(type="text")
     */
    private $pass;
    /**
     * @Column(type="integer")
     */
    private $groupId;
    /**
     * @Column(type="datetime")
     */
    private $create_date;
    /**
     * @Column(type="boolean")
     */
    private $active;

    /**
     * @Column(type="boolean")
     */
    private $social;

    /**
     * Conta constructor.
     * @param $create_date
     */
    public function __construct()
    {
        $this->create_date = new \DateTime();
        $this->social = false;
    }

    public function convertArray(){
        return array(
            "id" => $this->id,
            "email" => $this->email,
            "group" => $this->groupId,
            "create_date" => $this->create_date->format('Y-m-d H:i:s'),
            "active" => $this->active,
            "social" => $this->social
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
     * @return Account
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Account
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @param mixed $pass
     * @return Account
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->groupId;
    }

    /**
     * @param mixed $group
     * @return Account
     */
    public function setGroup($group)
    {
        $this->groupId = $group;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * @param \DateTime $create_date
     * @return Account
     */
    public function setCreateDate($create_date)
    {
        $this->create_date = $create_date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     * @return Account
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSocial()
    {
        return $this->social;
    }

    /**
     * @param bool $social
     * @return Account
     */
    public function setSocial($social)
    {
        $this->social = $social;
        return $this;
    }
}