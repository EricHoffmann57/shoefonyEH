<?php

declare(strict_types=1);
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class StoreController extends AbstractController
{
    #[Route('/store/product/{id}/details/{slug}', name: 'store_show_product', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Request $request, int $id, string $slug): Response
    {
        return $this->render('store/index.html.twig', [
            'controller_name' => 'StoreController',
            'id' => $id,
            'slug' => $slug,
            'from_routing' => $this->generateUrl('store_show_product', [
                'id' => $id,
                'slug' => $slug
            ]),
            'ip' => $request->getClientIp(),
            'url' => $request->getUri()
        ]);
    }
}
