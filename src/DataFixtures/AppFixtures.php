<?php
namespace App\DataFixtures;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{   
    /**
     * @var string
     */
    private $json_file_path; 
    
    /**
     * @var array
     */
    private $category_data;

    /**
     * @var array
     */
    private $users_data; 
    
    /**
     * @var array
     */
    private $products_data;    

    /**
     * @var object
     */
    private $passwordEncoder;        

    public function __construct(KernelInterface $kernel, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->json_file_path = $kernel->getProjectDir() . "/var/electronic-catalog.json";
        $this->passwordEncoder = $passwordEncoder;
    }  

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
                 
        $this->ReadJson();
        $this->loadCategories($manager);
        $this->loadProducts($manager);
        $this->loadUsers($manager);
    }
    public function ReadJson()
    {
        $json_data = file_get_contents($this->json_file_path);
        $data = json_decode($json_data);
        $this->products_data = $data->products;
        foreach ($this->products_data as $item) {
            $this->category_data[] = $item->category;
        }

        $this->users_data = $data->users;        

    }        

    public function loadProducts(ObjectManager $manager)
    {
        foreach ($this->products_data as $item) {
            $product = new Product();
            $product->setName($item->name);  
            $categoryReference = $this->getReference('cat_'.$item->category);        
            $product->setCategory($categoryReference);
            $product->setSku($item->sku);
            $product->setPrice($item->price);
            $product->setQuantity($item->quantity);
            $manager->persist($product);
        }

        $manager->flush();
    }

    public function loadUsers(ObjectManager $manager)
    {
        foreach ($this->users_data as $item) {
            $user = new User();
            $username = str_replace(' ', '_', $item->name);
            $user->setUsername($username);
            $user->setEmail($item->email);
            $user->setName($item->name);
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    $username
                )
            );
            $manager->persist($user);
        }
        
        $manager->flush();
    }

    public function loadCategories(ObjectManager $manager)
    {
        $result = array_unique($this->category_data);

        foreach ($result as $item) {
            $cat = new Category();
            $cat->setName($item);
            $this->addReference('cat_'.$item, $cat);
            $manager->persist($cat);
        }
        
        $manager->flush();
    }    
}