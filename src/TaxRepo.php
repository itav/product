<?php

namespace App;

class TaxRepo
{
    /**
     * 
     * @param int $id
     * @return \App\Tax
     */
    public function find($id)
    {
        $result = null;
        $taxes = $this->findAll();
        reset($taxes);
        foreach ($taxes as $tax){
            if($tax->getId() == $id){
                $result = $tax;
                break;
            }
        }
        return $result;
    }
    
    /**
     * 
     * @return Tax[]
     */
    public function findAll()
    {
        $taxes = [];
        $tax = new Tax();
        $tax
                ->setId(1)
                ->setName('vat23')
                ->setRate(23);
        $taxes[] = $tax;
        $tax = new Tax();
        $tax
                ->setId(2)
                ->setName('vat8')
                ->setRate(8);
        $taxes[] = $tax;
        $tax = new Tax();
        $tax
                ->setId(3)
                ->setName('vat0')
                ->setRate(0);
        $taxes[] = $tax;
        $tax = new Tax();
        $tax
                ->setId(4)
                ->setName('zw')
                ->setRate(0);
        $taxes[] = $tax;
        $tax = new Tax();
        $tax
                ->setId(5)
                ->setName('np')
                ->setRate(0);
        $taxes[] = $tax;        
        return $taxes;
    }
}