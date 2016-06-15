<?php

namespace App;

use Itav\Component\Serializer\Serializer;

class ProductRepo
{

    private $file = __DIR__ . '/storage/product.json';
    private $serializer;

    public function __construct()
    {
        $this->serializer = new Serializer();
    }

    /**
     * 
     * @param \App\Product $product
     * @return string | bool
     */
    public function save(Product $product)
    {
        $rows = json_decode(file_get_contents($this->file), true);
        $data = $this->serializer->normalize($product);
        $foundKey = false;
        foreach($rows as $key => $item){
            if($item['id'] == $product->getId()){
                $foundKey = $key;
                break;
            }
        }
        if(false !== $foundKey){
            unset($rows[$foundKey]);
        }
        $rows[] = $data;
        
        file_put_contents($this->file, json_encode($rows));
        return $product->getId();        
    }

    /**
     * 
     * @param int $id
     * @return \App\Product
     */
    public function find($id)
    {
        $rows = json_decode(file_get_contents($this->file), true);
        foreach($rows as $item){
            if($item['id'] == $id){
                return $this->serializer->unserialize($item, Product::class);
            }
        } 
        return null;
    }
    /**
     * 
     * @return Product[]
     */
    public function findAll()
    {
        $rows = json_decode(file_get_contents($this->file), true);
        $results = [];
        foreach($rows as $item){
            $results[] =  $this->serializer->unserialize($item, Product::class);
        } 
        return $results;
    }   
}