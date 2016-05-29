<?php

namespace App;

class Product
{
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    private $id;
    private $name;
    private $status;
    private $description;
    private $priceNet;
    private $taxValue;
    private $priceGross;
    /**
     *
     * @var Tax
     */
    private $tax;
    
    public function __construct()
    {
        $this->id = uniqid();
        $this->status = self::STATUS_ACTIVE;
        $this->tax = new Tax();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPriceNet()
    {
        return $this->priceNet;
    }

    public function getTaxValue()
    {
        return $this->taxValue;
    }

    public function getPriceGross()
    {
        return $this->priceGross;
    }

    public function getTax()
    {
        return $this->tax;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setPriceNet($priceNet)
    {
        $this->priceNet = $priceNet;
        return $this;
    }

    public function setTaxValue($taxValue)
    {
        $this->taxValue = $taxValue;
        return $this;
    }

    public function setPriceGross($priceGross)
    {
        $this->priceGross = $priceGross;
        return $this;
    }

    /**
     * 
     * @param Tax $tax
     * @return \App\Product
     */
    public function setTax($tax) {
        $this->tax = $tax;
        return $this;
    }  
}
