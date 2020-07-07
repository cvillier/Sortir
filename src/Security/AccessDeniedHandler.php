<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

/**
 * @ORM\Entity(repositoryClass=AccessDeniedHandlerRepository::class)
 */
class AccessDeniedHandler implements AccessDeniedHandlerInterface
{

    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        $content = $accessDeniedException->getMessage();
        return new Response($content, 403);
    }
}
