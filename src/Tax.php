<?php


namespace App;

class Tax
{
    const STATUS_ACTIVE = 1;
    const SATUS_DELETED = 2;
    
    private $id;
    private $name;
    private $rate;
    private $status;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getRate()
    {
        return $this->rate;
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

    public function setRate($rate)
    {
        $this->rate = $rate;
        return $this;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }


        
}

