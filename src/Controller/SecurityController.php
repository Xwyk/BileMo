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
     *         type="object",
     *         properties={
     *             @OA\Property(
     *                 property="token",
     *                 type="string"
     *             )
     *         }
     *     )
     * )
     * @OA\RequestBody(
     *     required=false,
     *     @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="username",
     *                   description="Username to login",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="password",
     *                   description="Password to login",
     *                   type="string"
     *               ),
     *           )
     *       )
     * )
     * @OA\Response(
     *     response=401,
     *     description="Invalid credentials",
     *     content={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="code",
     *                     type="integer",
     *                     description="The response code"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="The response message"
     *                 ),
     *                 example={
     *                     "code": 401,
     *                     "message": "Invalid credentials.",
     *                 }
     *             )
     *         )
     *     }
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
