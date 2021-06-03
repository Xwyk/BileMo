<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    const USER_PERSONAL_LIST = "USER_PERSONAL_LIST";
    const USER_EDIT = "USER_EDIT";
    const USER_SHOW = "USER_SHOW";


    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::USER_EDIT, self::USER_PERSONAL_LIST, self::USER_SHOW])
            && ($subject instanceof User || $subject === null);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $client = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$client instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::USER_EDIT:
            case self::USER_SHOW:
                if (!$subject instanceof User) {
                    return false;
                }
                return $subject->getClient() !== $client;
            case self::USER_PERSONAL_LIST:
                return false;
        }

        return false;
    }
}
