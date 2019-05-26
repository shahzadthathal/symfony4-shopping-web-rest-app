<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Entity\ProductBundleItem;
use App\Form\ProductBundleType;
use App\Repository\ProductRepository;
use App\Repository\ProductBundleItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Utils\Slugger;

/**
 * @Route("/admin/product/bundle")
 */
class ProductBundleController extends AbstractController
{
    /**
     * @Route("/list", name="product_bundle_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findBy(['isProductBundle'=>'Yes'],['id'=>'DESC']);

        return $this->render('admin/product-bundle/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/new", name="product_bundle_new", methods={"GET","POST"})
     */
    public function new(Request $request, Slugger $slugger, ProductRepository $productRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductBundleType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slugify($product->getTitle());
            $product->setSlug($slug);
            $product->setIsProductBundle("Yes");

            $product->setCreatedAt(date("Y-m-d H:i:s"));

            $productsArr = $_POST['productsArr'];

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            if(count($productsArr)>0){
                foreach($productsArr as $productId){
                   $productBundleItem = new ProductBundleItem();
                   $productBundleItem->setProductBundleId($product->getId());
                    $productBundleItem->setProductId($productId);
                    $entityManager->persist($productBundleItem);
                    $entityManager->flush();
                }
            }

            return $this->redirectToRoute('product_bundle_index');
        }

        $productsArr = $productRepository->findBy(['status'=>'Active', 'isProductBundle'=>'No']);
        $productBundlesArr = [];
        return $this->render('admin/product-bundle/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'productsArr'=>$productsArr,
            'productBundlesArr'=>$productBundlesArr
        ]);
    }

    /**
     * @Route("/{id}", name="product_bundle_show", methods={"GET"})
     */
    public function show(Product $product, ProductBundleItemRepository $productBundleItemRepository): Response
    {
        $bunleItems = $productBundleItemRepository->findByProductBundleIdJoinedToProduct($product->getId());

        return $this->render('admin/product-bundle/show.html.twig', [
            'product' => $product,
            'bunleItems' => $bunleItems,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_bundle_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product, Slugger $slugger, ProductRepository $productRepository, ProductBundleItemRepository $productBundleItemRepository): Response
    {
        $form = $this->createForm(ProductBundleType::class, $product);
        $form->handleRequest($request);

        $productBundleItems = $productBundleItemRepository->findBy(['productBundleId'=>$product->getId()]);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $slug = $slugger->slugify($product->getTitle());
            $product->setSlug($slug);
            $product->setUpdatedAt(date("Y-m-d H:i:s"));
            $productsArr = $_POST['productsArr'];

            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->persist($product);
            $entityManager->flush($product);

            if(count($productsArr)>0){

                foreach($productsArr as $productId){

                    $isExist = $productBundleItemRepository->findBy(['productId'=>$productId]);
                    if(!$isExist){
                        $productBundleItem = new ProductBundleItem();
                        $productBundleItem->setProductBundleId($product->getId());
                        $productBundleItem->setProductId($productId);
                        $entityManager->persist($productBundleItem);
                        $entityManager->flush();

                    }
                }
            }

            return $this->redirectToRoute('product_bundle_index', [
                'id' => $product->getId(),
            ]);
        }

        $productsArr = $productRepository->findBy(['status'=>'Active','isProductBundle'=>'No']);
        
        $productBundlesArr = [];
        foreach($productBundleItems as $item){
            $productBundlesArr[] = $item->getProductId();
        }

        return $this->render('admin/product-bundle/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'productsArr'=>$productsArr,
            'productBundlesArr'=>$productBundlesArr
        ]);
    }

    /**
     * @Route("/{id}", name="product_bundle_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Product $product, ProductBundleItemRepository $productBundleItemRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            
            $productBundleItems = $productBundleItemRepository->findBy(['productBundleId'=>$product->getId()]);

            $entityManager->remove($product);
            

            foreach($productBundleItems as $item){
                $entityManager->remove($item);
            }

            $entityManager->flush();
        }

        return $this->redirectToRoute('product_bundle_index');
    }
}
