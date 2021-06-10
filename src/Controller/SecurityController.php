<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/api/login_check", name="api_login")
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
