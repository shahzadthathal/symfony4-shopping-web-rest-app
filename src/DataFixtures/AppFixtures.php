<?php
namespace App\DataFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\ProductBundleItem;
use App\Entity\Order;
use App\Entity\OrderItem;

class AppFixtures extends Fixture
{
	private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
         $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

    	#Create user
    	$user = new User();
        $user->setEmail('admin@app.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setFullName('Admin');
        $user->setCreatedAt(date("Y-m-d H:i:s"));
        $user->setPassword($this->passwordEncoder->encodePassword(
             $user,
             '123456'
         ));
		$manager->persist($user);
        
        $user2 = new User();
        $user2->setEmail('john@app.com');
        $user2->setRoles(['ROLE_USER']);
        $user2->setFullName('John Smith');
        $user2->setApiToken('0587365e7ec362d52ffb-1558893137');
        $user2->setCreatedAt(date("Y-m-d H:i:s"));

        $user2->setPassword($this->passwordEncoder->encodePassword(
             $user2,
             '123456'
         ));

        $manager->persist($user2);
        $manager->flush();



        #Create products
        
        #Product without discount
        $product1 = new Product();
        $title = 'My awesome product 1';
        $slug = str_replace(" ","-",strtolower($title));
        $product1->setTitle($title);
        $product1->setSlug($slug);
        $product1->setPrice(80);
        $product1->setDescription('My awesome product description');
        $product1->setCreatedAt(date("Y-m-d H:i:s"));
        $product1->setUpdatedAt(date("Y-m-d H:i:s"));
        $manager->persist($product1);

        #Product with concreate discount
        $product3 = new Product();
        $title = 'My awesome product 2';
        $slug = str_replace(" ","-",strtolower($title));
        $product3->setTitle($title);
        $product3->setSlug($slug);
        $product3->setPrice(150);
        $product3->setIsDiscount('Yes');
        $product3->setDiscountType('Concrete');
        $product3->setDiscount('1');
        $product3->setDescription('My awesome product description');
        $product3->setCreatedAt(date("Y-m-d H:i:s"));
        $product3->setUpdatedAt(date("Y-m-d H:i:s"));
        $manager->persist($product3);
        $manager->flush();

        #Product with percentage discount
        $product4 = new Product();
        $title = 'My awesome product 3';
        $slug = str_replace(" ","-",strtolower($title));
        $product4->setTitle($title);
        $product4->setSlug($slug);
        $product4->setPrice(80);
        $product4->setIsDiscount('Yes');
        $product4->setDiscountType('Percentage');
        $product4->setDiscount('10');
        $product4->setDescription('My awesome product description');
        $product4->setCreatedAt(date("Y-m-d H:i:s"));
        $product4->setUpdatedAt(date("Y-m-d H:i:s"));
        $manager->persist($product4);
        $manager->flush();


        #Set Product bundle
        $productBundle = new Product();
        $title = 'My awesome product bundle 1';
        $slug = str_replace(" ","-",strtolower($title));
        $productBundle->setTitle($title);
        $productBundle->setSlug($slug);
        $productBundle->setPrice(120);
        $productBundle->setIsProductBundle("Yes");
        $productBundle->setDescription('My awesome product bundle description');
        $productBundle->setCreatedAt(date("Y-m-d H:i:s"));
        $productBundle->setUpdatedAt(date("Y-m-d H:i:s"));
        $manager->persist($productBundle);
        $manager->flush();      

        #Set product bunle items
        #First product
        $productBundleItem = new ProductBundleItem();
        $productBundleItem->setProductBundleId($productBundle->getId());
        $productBundleItem->setProductId($product1->getId());
        $manager->persist($productBundleItem);

        #Second product
        $productBundleItem2 = new ProductBundleItem();
        $productBundleItem2->setProductBundleId($productBundle->getId());
        $productBundleItem2->setProductId($product3->getId());
        $manager->persist($productBundleItem2);
        
        $manager->flush();


        #Insert some more products for pagination in api
        for($i=5; $i<=20; $i++){
            $product = new Product();
            $title = 'My awesome product '.$i;
            $slug = str_replace(" ","-",strtolower($title));
            $product->setTitle($title);
            $product->setSlug($slug);
            $product->setPrice(200);
            $product->setDescription('My awesome product description '.$i);
            $product->setCreatedAt(date("Y-m-d H:i:s"));
            $product->setUpdatedAt(date("Y-m-d H:i:s"));
            $manager->persist($product);
        }

        $manager->flush();
        
    }
}