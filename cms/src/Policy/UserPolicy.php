<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Authentication\IdentityInterface as IdentityInterface1;
use Authorization\IdentityInterface as IdentityInterface2;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\ResultInterface;

/**
 * User policy
 */
class UserPolicy implements BeforePolicyInterface
{
    public function before(?IdentityInterface2 $user, mixed $resource, string $action): ResultInterface|bool|null
    {
        if ($user->getOriginalData()->isAdmin) {
            return true;
        }

        // fall through
        return null;
    }

    /**
     * Check if $user can add User
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\User $resource
     * @return bool
     */
    public function canAdd(IdentityInterface1&IdentityInterface2 $user, User $resource)
    {
        return true;
    }

    /**
     * Check if $user can edit User
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\User $resource
     * @return bool
     */
    public function canEdit(IdentityInterface1&IdentityInterface2 $user, User $resource)
    {
        return $this->isMe($user, $resource);
    }

    /**
     * Check if $user can edit Password
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\User $resource
     * @return bool
     */
    public function canEditPassword(IdentityInterface1&IdentityInterface2 $user, User $resource)
    {
        return $this->isMe($user, $resource);
    }

    /**
     * Check if $user can edit Token
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\User $resource
     * @return bool
     */
    public function canEditToken(IdentityInterface1&IdentityInterface2 $user, User $resource)
    {
        return $this->isMe($user, $resource);
    }

    /**
     * Check if $user can edit Permissions
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\User $resource
     * @return bool
     */
    public function canEditPermissions(IdentityInterface1&IdentityInterface2 $user, User $resource)
    {
        return false;
    }

    /**
     * Check if $user can delete User
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\User $resource
     * @return bool
     */
    public function canDelete(IdentityInterface1&IdentityInterface2 $user, User $resource)
    {
        return $this->isMe($user, $resource);
    }

    /**
     * Check if $user can view User
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\User $resource
     * @return bool
     */
    public function canView(IdentityInterface1&IdentityInterface2 $user, User $resource)
    {
        return $this->isMe($user, $resource);
    }

    /**
     * Check if $user can index User
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\User $resource
     * @return bool
     */
    public function canIndex(IdentityInterface1&IdentityInterface2 $user, User $resource)
    {
        return $this->isMe($user, $resource);
    }

    protected function isMe(IdentityInterface1&IdentityInterface2 $user, User $resource)
    {
        return $resource->id === $user->getIdentifier();
    }
}
