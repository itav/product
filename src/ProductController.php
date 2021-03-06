<?php

namespace App;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Itav\Component\Serializer\Serializer;
use Itav\Component\Form;

class ProductController
{

    public function listAction()
    {
        $repo = new ProductRepo();
        $products = $repo->findAll();
        $serializer = new Serializer();
        $vars = [];
        foreach ($products as $product){
            $vars[] = $serializer->normalize($product);
        }
        return json_encode($vars);
    }
    
    public function listTaxAction()
    {
        $repo = new TaxRepo();
        $taxes = $repo->findAll();
        $serializer = new Serializer();
        $vars = [];
        foreach ($taxes as $tax){
            $vars[] = $serializer->normalize($tax);
        }
        return json_encode($vars);
    }    
    
    public function formAction()
    {
        $serializer = new Serializer();
        $product = new Product();
        $select = $this->prepareSelectProduct($product);
        return json_encode($serializer->normalize($select));
    } 

    public function addAction(Application $app, $id = null)
    {
        $product = new Product();
        if ($id) {
            $repo = new ProductRepo();
            $product = $repo->find($id);
        }

        $form = $this->prepareAddForm($app, $product);

        $serializer = new Serializer();
        $formNorm = $serializer->normalize($form);
        return $app['templating']->render('page.php', array('form' => $formNorm));
    }

    public function saveAction(Application $app, Request $request)
    {
        $productData = $request->get('product');
        $taxData = $request->get('tax');
        $serializer = $app['serializer'];
        $product = new Product();
        $tax = new Tax();
        $product = $serializer->unserialize($productData, Product::class, $product);
        $tax = $serializer->unserialize($taxData, Tax::class, $tax);
        $taxRepo = new TaxRepo();
        $tax = $taxRepo->find($tax->getId());
        $product->setTax($tax);
        $valid = $this->validateProduct($product);
        if ($valid) {
            $repo = new ProductRepo();
            $savedId = $repo->save($product);
            var_dump($savedId);
            return '';
        }
        $form = $this->prepareAddForm($app, $product);
        $formNorm = $serializer->normalize($form);
        return $app['templating']->render('page.php', array('form' => $formNorm));
    }

    public function infoAction(Application $app, $id)
    {
        $serializer = new Serializer();
        $repo = new ProductRepo();
        $product = $repo->find($id);

        $form = $this->prepareAddForm($app, $product);
        $form->removeSubmits();
        $formNorm = $serializer->normalize($form);
        return $app['templating']->render('page.php', array('form' => $formNorm));
    }

    public function deleteAction($id)
    {
        
    }

    /**
     * 
     * @param Application $app
     * @param Product $product
     * @return \Itav\Component\Form\Form
     */
    public function prepareAddForm(Application $app, Product $product)
    {

        $id = new Form\Input();
        $id
                ->setType(Form\Input::TYPE_HIDDEN)
                ->setName('product[id]')
                ->setValue($product->getId());

        $name = new Form\Input();
        $name
                ->setLabel('Name:')
                ->setName('product[name]')
                ->setValue($product->getName());
        
        $priceNet = new Form\Input();
        $priceNet
                ->setLabel('Price Net:')
                ->setName('product[price_net]')
                ->setValue($product->getPriceNet());
        
        $taxSelect = $this->prepareTaxSelect($product);
        
        $taxValue = new Form\Input();
        $taxValue
                ->setLabel('Tax Value:')
                ->setName('product[tax_value]')
                ->setValue($product->getTaxValue());

        $priceGross = new Form\Input();
        $priceGross
                ->setLabel('Prive Gross:')
                ->setName('product[price_gross]')
                ->setValue($product->getPriceGross());        
        
        $description = new Form\TextArea();
        $description
                ->setLabel('Description:')
                ->setName('product[description]')
                ->setValue($product->getDescription());
        
        $submit = new Form\Button();
        $submit
                ->setLabel('Zapisz')
                ->setType(Form\Button::TYPE_SUBMIT);

        $fs = new Form\FieldSet();
        $fs->setElements([$id, $name, $priceNet, $taxSelect, $taxValue, $priceGross]);
        
        $fs2 = new Form\FieldSet();
        $fs2->addElement($description);
        
        $form = new Form\Form();
        $form
                ->setName('productAdd')
                ->setAction($app['url_generator']->generate('product_add'))
                ->setMethod('POST');

        $form
                ->addElement($fs)
                ->addElement($fs2)
                ->addElement($submit);
        return $form;
    }

    public function validateProduct($product)
    {
        return true;
    }
    
    /**
     * 
     * @param Product $product
     * @return Form\Select
     */
    public function prepareTaxSelect($product)
    {
        $taxRepo = new TaxRepo();
        $taxes = $taxRepo->findAll();
        $select = new Form\Select();
        $select
                ->setLabel('Select Tax:')
                ->setName('tax[id]');
        $options = [];
        foreach($taxes as $tax){
            $option = new Form\Option();
            $option
                    ->setLabel($tax->getName())
                    ->setValue($tax->getId())
                    ->setSelected($tax->getId() === $product->getTax()->getId());
            $options[] = $option;
        }
        $select->setOptions($options);
        return $select;
    }
    
        /**
     * 
     * @param Product $product
     * @return Form\Select
     */
    public function prepareSelectProduct($product)
    {
        $repo = new ProductRepo();
        $products = $repo->findAll();
        $select = new Form\Select();
        $select
                ->setLabel('Select Product:')
                ->setName('product[id]');
        $options = [];
        foreach ($products as $item) {
            $option = new Form\Option();
            $option
                    ->setLabel($item->getName() ? $item->getName() :  $item->getFirstName() . $item->getLastName())
                    ->setValue($item->getId())
                    ->setSelected($item->getId() === $product->getId());
            $options[] = $option;
        }
        $select->setOptions($options);
        return $select;
    }
    
    public function taxInfoAction(Application $app, Request $request, $id)
    {
        $serializer = new Serializer();
        $repo = new TaxRepo();
        $tax = $repo->find($id);
        if($request->headers->get('Accept') == 'application/json') {
            return $app->json($serializer->normalize($tax));
        }
        $out = print_r($tax, true);

        return $out;
    }
    
}
