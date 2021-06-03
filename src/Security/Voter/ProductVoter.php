<?php

namespace App\Security\Voter;

use App\Entity\Product;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ProductVoter extends Voter
{

    const PRODUCTS_LIST = "PRODUCTS_LIST";
    const PRODUCT_SHOW = "PRODUCT_SHOW";

    protected function supports(string $attribute, $subject): bool
    {
        return in_array(
            $attribute,
            [
                self::PRODUCTS_LIST,
                self::PRODUCT_SHOW
            ]) && (
                $subject instanceof Product || $subject === null
            );
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $client = $token->getUser();

        if (!$client instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::PRODUCTS_LIST:
            case self::PRODUCT_SHOW:
                return true;
        }

        return false;
    }
}
