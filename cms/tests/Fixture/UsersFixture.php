<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use App\Model\Entity\User;
use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'username' => 'admin',
                'password' => User::HashPassword('admin-password-123'),
                'token' => User::HashToken('admin-token-123'),
                'isAdmin' => true,
                'canViewApplicants' => true,
                'canEditApplicants' => true,
                'created' => '2024-10-14 14:23:23',
                'modified' => '2024-10-14 14:23:23',
            ],
        ];
        parent::init();
    }
}
