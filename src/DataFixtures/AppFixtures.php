<?php

namespace App\DataFixtures;
use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\KernelInterface;


class AppFixtures extends Fixture
{
    /**
     * @var string
     */
    private $data;    

    /**
     * @var string
     */
    private $json_file_path; 

    private $container;
    
    public function __construct(KernelInterface $kernel)
    {
        $this->json_file_path = $kernel->getProjectDir() . "/var/electronic-catalog.json";
    }  

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
                 
        $this->ReadJson();
        $this->loadProducts($manager);
        $this->loadCategories($manager);
    }
    public function ReadJson()
    {
        $json_data = file_get_contents($this->json_file_path);
        $this->data = json_decode($json_data);
    }        

    public function loadProducts(ObjectManager $manager)
    {
        $products_data = $this->data->products;
        foreach ($products_data as $item) {
            $product = new Product();
            $product->setName($item->name);
            $product->setCategory($item->name);
            $product->setSku($item->sku);
            $product->setPrice($item->price);
            $product->setQuantity($item->quantity);
        }
    }

    public function loadUsers(ObjectManager $manager)
    {

    }

    public function loadCategories(ObjectManager $manager)
    {
        
    }    
            



}