<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Applicant;
use Authentication\IdentityInterface as IdentityInterface1;
use Authorization\IdentityInterface as IdentityInterface2;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\ResultInterface;

/**
 * Applicant policy
 */
class ApplicantPolicy implements BeforePolicyInterface
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
     * Check if $user can add Applicant
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Applicant $resource
     * @return bool
     */
    public function canAdd(IdentityInterface1&IdentityInterface2 $user, Applicant $resource)
    {
        return $this->_canEdit($user);
    }

    /**
     * Check if $user can edit Applicant
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Applicant $resource
     * @return bool
     */
    public function canEdit(IdentityInterface1&IdentityInterface2 $user, Applicant $resource)
    {
        return $this->_canEdit($user);
    }

    /**
     * Check if $user can delete Applicant
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Applicant $resource
     * @return bool
     */
    public function canDelete(IdentityInterface1&IdentityInterface2 $user, Applicant $resource)
    {
        return $this->_canEdit($user);
    }

    /**
     * Check if $user can view Applicant
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Applicant $resource
     * @return bool
     */
    public function canView(IdentityInterface1&IdentityInterface2 $user, Applicant $resource)
    {
        return $this->_canView($user);
    }

    //TODO: dely index action: the following code does not work
    // /**
    //  * Check if $user can index Applicant
    //  *
    //  * @param \Authorization\IdentityInterface $user The user.
    //  * @param \App\Model\Entity\Applicant $resource
    //  * @return bool
    //  */
    // public function canIndex(IdentityInterface1&IdentityInterface2 $user, Applicant $resource)
    // {
    //     return $this->_canView($user);
    // }

    protected function _canView(IdentityInterface1&IdentityInterface2 $user)
    {
        return $user->getOriginalData()->canViewApplicants;
    }

    protected function _canEdit(IdentityInterface1&IdentityInterface2 $user)
    {
        if (!$this->_canView($user)) {
            return false;
        }
        
        return $user->getOriginalData()->canEditApplicants;
    }
}
