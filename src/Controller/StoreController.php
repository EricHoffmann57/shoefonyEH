<?php

namespace App\Controller;

use App\Entity\Store\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StoreController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/store/product/list", name="store_list_product", methods={"GET"})
     */
    public function productList(): Response
    {
        $products = $this->em->getRepository(Product::class)->findAll();

        return $this->render('store/product_list.html.twig', [
            'controller_name' => 'StoreController',
            'products' => $products,
        ]);
    }

    /**
     * @Route("/store/product/{id}/details/{slug}", name="store_detail_product", requirements={"id"="\d+"}, methods={"GET"})
     * @param int $id
     * @param string $slug
     * @return Response
     */
    public function productDetail(int $id, string $slug): Response
    {
        $product = $this->em->getRepository(Product::class)->find($id);
        if ($product === null) {
            throw new NotFoundHttpException();
        }

        if ($slug !== $product->getSlug()) {
            return $this->redirectToRoute('store_detail_product', [
                'controller_name' => 'StoreController',
                'id' => $id,
                'slug' => $product->getSlug(),
            ], Response::HTTP_MOVED_PERMANENTLY);
        }
        return $this->render('store/product_detail.html.twig', [
            'controller_name' => 'StoreController',
            'id' => $id,
            //'slugs' => $product->getSlug(),
            'product' => $product
        ]);
    }

}