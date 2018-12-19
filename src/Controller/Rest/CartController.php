<?php

namespace App\Controller\Rest;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Repository\CartItemRepository;
use App\Repository\CartRepository as CartRepository;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CartController extends FOSRestController {

    /**
     * Creates an Cart resource
     * @Rest\Post("/cart/{id}")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function postCart ( Request $request ): JsonResponse {
        $entityManager = $this->getDoctrine()
                              ->getManager()
        ;
        if ( empty( $request->get( 'productId' ) ) ) {
            return new JsonResponse( [
                                       'productId' => $request->get( 'productId' ),
                                     ], JsonResponse::HTTP_CONFLICT );
        }
        /** @var Product $product */
        $productRepository = $entityManager->getRepository( Product::class );
        $product           = $productRepository->find( $request->get( 'productId' ) );

        /** @var CartRepository $cartRepository */
        $cartRepository = $entityManager->getRepository( Cart::class );
        if ( false === empty( $request->get( 'id' ) ) ) {
            $cart = $cartRepository->find( $request->get( 'id' ) );
            if ( empty( $cart ) ) {
                $cart = new Cart();
                $cart->setUserId( 1 );
                $entityManager->persist( $cart );
                $entityManager->flush();
            }
        } else {
            $cart = new Cart();
            $cart->setUserId( 1 );
            $entityManager->persist( $cart );
            $entityManager->flush();
        }
        /** @var CartItemRepository $itemRepository */
        $itemRepository = $entityManager->getRepository( CartItem::class );
        /** @var CartItem $item */
        $items = $itemRepository->findBy( [
                                            'cart_id'    => $cart->getId(),
                                            'product_id' => $product->getId(),
                                          ],
                                          null,
                                          1 );
        $item  = empty( $items[ 0 ] ) ? new CartItem() : $items[ 0 ];
        $item->setNumber( empty( $item ) ? 1 : $item->getNumber() + 1 );
        $item->setCartId( $cart->getId() );
        $item->setProductId( $product->getId() );
        $entityManager->persist( $item );
        $entityManager->flush();

        return new JsonResponse( [
                                   'item_id'         => $item->getId(),
                                   'number'     => $item->getNumber(),
                                   'product_id' => $item->getProductId(),
                                   'cart_id'    => $item->getCartId(),
                                 ], JsonResponse::HTTP_OK );
    }

    /**
     * Retrieves a collection of cart resource
     * @Rest\Get("/cart/{id}")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getCart ( Request $request ): JsonResponse {
        $entityManager = $this->getDoctrine()
                              ->getManager()
        ;
        if ( empty( $request->get( 'id' ) ) ) {
            return new JsonResponse( [
                                       'productId' => $request->get( 'productId' ),
                                     ], JsonResponse::HTTP_CONFLICT );
        }
        /** @var CartItemRepository $itemRepository */
        $itemRepository = $entityManager->getRepository( CartItem::class );
        /** @var CartItem $item */
        $items       = $itemRepository->findBy( [
                                                  'cart_id' => $request->get( 'id' ),
                                                ] );
        $itemContent = [];
        foreach ( $items as $item ) {
            $itemContent[] = [
              'id'         => $item->getId(),
              'number'     => $item->getNumber(),
              'product_id' => $item->getProductId(),
            ];
        }

        return new JsonResponse( [
                                   'cart_id' => $request->get( 'id' ),
                                   'items'   => $itemContent,
                                 ], JsonResponse::HTTP_OK );
    }
}
