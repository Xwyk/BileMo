<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use OpenApi\Annotations as OA;

class SecurityController extends AbstractController
{
    /**
     * @Rest\Post(
     *     path = "/api/login_check",
     *     name = "api_login",
     * )
     * @OA\Post  (
     *      description="Authenticate user on app and return JWT token who could be used for bearer authentication"
     * )
     * @OA\Response(
     *     response=200,
     *     description="Returns JWT token",
     *     @OA\JsonContent(
     *         type="array",
     *         @OA\Items(
     *             type="object",
     *             properties={
     *                 @OA\Property(
     *                     type="string",
     *                     propertyNames="bote"
     * )
     *             }
     *         )
     *     )
     * )
     * @OA\Response(
     *     response=403,
     *     description="Invalid credentials"
     * )
     * @return JsonResponse
     */
    public function apiLogin(): JsonResponse
    {
        $user = $this->getUser();

        return new JsonResponse([
            'username' => $user->getUsername(),
            'roles'    => $user->getRoles()
        ]);
    }
}
