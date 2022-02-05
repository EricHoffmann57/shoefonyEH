<?php

namespace App\Controller;

use App\Entity\Store\Brand;
use App\Entity\Store\Product;
use App\Repository\Store\BrandRepository;
use App\Repository\Store\CommentRepository;
use App\Repository\Store\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StoreController extends AbstractController
{

    public function __construct(
        private ProductRepository $productRepository,
        private BrandRepository $brandRepository,
        private CommentRepository $commentRepository
    )
    {
    }

    /**
     * @Route("/store/product/list", name="store_list_products", methods={"GET"})
     */
    public function productList(): Response
    {
        $products = $this->productRepository->findAll();

        return $this->render('store/product_list.html.twig', [
            'controller_name' => 'StoreController',
            'products' => $products,
            'brandId'  => null
        ]);
    }

    /**
     * @Route("/store/product/{id}/details/{slug}", name="store_detail_product", requirements={"id"="\d+"}, methods={"GET"})
     * @param int $id
     * @param string $slug
     * @param string $brand
     * @return Response
     */
    public function productDetail(int $id, string $slug): Response
    {
        $product = $this->productRepository->find($id);
        $comments = $this->commentRepository->findBy(['product' => $product]);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
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
            'product' => $product,
            'comments' => $comments,
            'slug' => $slug,
        ]);
    }
    #[Route('/store/product/brand/{brandId}', name: 'store_list_products_by_brand', requirements: ['brandId'=>"\d+"],methods: 'GET')]
    public function findProductsByBrand(int $brandId): Response
    {
        $brand = $this->brandRepository->find($brandId);
        if($brand === null) {
            throw new NotFoundHttpException();
        }

        $products = $this->productRepository->findBy(['brand'=>$brand]);

        return $this->render('store/product_list.html.twig', [
            'brand' => $brand,
            'brandId' => $brand->getId(),
            'products' => $products,
        ]);

    }



    public function listBrands(): Response
    {
        $brands = $this->brandRepository->findAll();
        return $this->render('store/_list_brands.html.twig', [
            'brands' => $brands,
            'brandId' => null,
        ]);
    }
}