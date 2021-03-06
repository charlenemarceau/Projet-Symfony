<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class RecipeVoter extends Voter
{
    protected function supports(string $attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['RECIPE_EDIT', 'RECIPE_DELETE'])
            && $subject instanceof \App\Entity\Recipe;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'RECIPE_EDIT':
                return $user == $subject->getUser();
            case 'RECIPE_DELETE':
                return $user == $subject->getUser();
        }

        return false;
    }
}
