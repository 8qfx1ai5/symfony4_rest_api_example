<?php

namespace App\Controller\Rest\Cart;

use App\Entity\CartItem;
use App\Repository\CartItemRepository;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ItemController extends FOSRestController {

    /**
     * Replaces Cart resource
     * @Rest\Put("/cart/item/{id}")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function putItem ( Request $request ): JsonResponse {
        $entityManager = $this->getDoctrine()
                              ->getManager()
        ;
        if ( empty( $request->get( 'id' ) ) ) {
            return new JsonResponse( [
                                       'item_id' => $request->get( 'id' ),
                                     ], JsonResponse::HTTP_CONFLICT );
        }

        /** @var CartItemRepository $itemRepository */
        $itemRepository = $entityManager->getRepository( CartItem::class );
        /** @var CartItem $item */
        $item = $itemRepository->find( $request->get( 'id' ) );
        if ( empty( $item ) ) {
            return new JsonResponse( [
                                       'status'  => 'item not found',
                                       'item_id' => $request->get( 'id' ),
                                     ], JsonResponse::HTTP_CONFLICT );
        }
        $item->setNumber( $request->get( 'number' ) );
        $entityManager->remove( $item );
        $entityManager->flush();

        return new JsonResponse( [
                                   'id'         => $item->getId(),
                                   'number'     => $item->getNumber(),
                                   'product_id' => $item->getProductId(),
                                   'cart_id'    => $item->getCartId(),
                                 ], JsonResponse::HTTP_OK );
    }

    /**
     * Removes the Cart resource
     * @Rest\Delete("/cart/item/{id}")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function deleteItem ( Request $request ): JsonResponse {
        $entityManager = $this->getDoctrine()
                              ->getManager()
        ;
        if ( empty( $request->get( 'id' ) ) ) {
            return new JsonResponse( [
                                       'item_id' => $request->get( 'id' ),
                                     ], JsonResponse::HTTP_CONFLICT );
        }

        /** @var CartItemRepository $itemRepository */
        $itemRepository = $entityManager->getRepository( CartItem::class );
        /** @var CartItem $item */
        $item = $itemRepository->find( $request->get( 'id' ) );
        if ( empty( $item ) ) {
            return new JsonResponse( [
                                       'item_id' => $request->get( 'id' ),
                                     ], JsonResponse::HTTP_OK );
        }
        $entityManager->remove( $item );
        $entityManager->flush();

        return new JsonResponse( [
                                   'item_id' => $request->get( 'id' ),
                                 ], JsonResponse::HTTP_OK );
    }
}
