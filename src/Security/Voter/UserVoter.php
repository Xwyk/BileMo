<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    const USERS_LIST  = "USERS_LIST";
    const USER_ADD    = "USER_ADD";
    const USER_DELETE = "USER_DELETE";
    const USER_SHOW   = "USER_SHOW";


    protected function supports(string $attribute, $subject): bool
    {
        return in_array(
            $attribute,
            [
                self::USERS_LIST,
                self::USER_ADD,
                self::USER_SHOW,
                self::USER_DELETE
            ]) && (
                $subject instanceof User || $subject === null
            );
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $client = $token->getUser();

        if (!$client instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::USER_DELETE:
            case self::USER_SHOW:
                if (!$subject instanceof User) {
                    return false;
                }
                // return if user's client is connected client
                return $subject->getClient() === $client;
            case self::USER_ADD:
            case self::USERS_LIST:
                return true;
        }
        return false;
    }
}
