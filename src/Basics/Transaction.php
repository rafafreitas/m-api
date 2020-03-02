<?php


namespace App\Basics;

/**
 * @Entity
 * @Table(name="transactions")
 */
class Transaction
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
    private $title;

    /**
     * @Column(type="float")
     */
    private $value;

    /**
     * @Column(type="integer")
     */
    private $type;

    /**
     * @Column(type="datetime")
     */
    private $create_date;

    /**
     * Muitas transações tem um cliente
     * @ManyToOne(targetEntity="Client", inversedBy="transaction")
     * @JoinColumn(name="client_id", referencedColumnName="id")
     */
    private $client;

    /**
     * Transaction constructor.
     */
    public function __construct()
    {
        $this->create_date = new \DateTime();
    }

    public function convertArray(){
        return array(
            "id" => $this->id,
            "title" => $this->title,
            "value" => $this->value,
            "type" => $this->type,
            "create_date" => ($this->create_date) ? $this->create_date->format('d/m/Y') : null,
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
     * @return Transaction
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Transaction
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return Transaction
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return Transaction
     */
    public function setType($type)
    {
        $this->type = $type;
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
     * @return Transaction
     */
    public function setCreateDate($create_date)
    {
        $this->create_date = $create_date;
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
     * @return Transaction
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }
}