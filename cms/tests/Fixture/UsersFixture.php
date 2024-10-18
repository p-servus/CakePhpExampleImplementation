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
    static public $userDataList = [
        'admin' => [
            'id'                => 1,
            'password'          => 'admin-password-123',
            'token'             => 'admin-token-123',
            'isAdmin'           => true,
            'canViewApplicants' => false,
            'canEditApplicants' => false,
            'created'           => '2024-10-14 14:23:23',
            'modified'          => '2024-10-14 14:23:23',
        ],
        'user-with-noPermissions' => [
            'id'                => 2,
            'password'          => 'user-with-noPermissions-password-123',
            'token'             => 'user-with-noPermissions-token-123',
            'isAdmin'           => false,
            'canViewApplicants' => false,
            'canEditApplicants' => false,
            'created'           => '2024-10-14 14:23:23',
            'modified'          => '2024-10-14 14:23:23',
        ],
        'user-with-canViewApplicants' => [
            'id'                => 3,
            'password'          => 'user-with-canViewApplicants-password-123',
            'token'             => 'user-with-canViewApplicants-token-123',
            'isAdmin'           => false,
            'canViewApplicants' => true,
            'canEditApplicants' => false,
            'created'           => '2024-10-14 14:23:23',
            'modified'          => '2024-10-14 14:23:23',
        ],
        'user-with-canViewApplicants-and-canEditApplicants' => [
            'id'                => 4,
            'password'          => 'user-with-canViewApplicants-and-canEditApplicants-password-123',
            'token'             => 'user-with-canViewApplicants-and-canEditApplicants-token-123',
            'isAdmin'           => false,
            'canViewApplicants' => true,
            'canEditApplicants' => true,
            'created'           => '2024-10-14 14:23:23',
            'modified'          => '2024-10-14 14:23:23',
        ],
        'user-with-canEditApplicants' => [
            'id'                => 5,
            'password'          => 'user-with-canEditApplicants-password-123',
            'token'             => 'user-with-canEditApplicants-token-123',
            'isAdmin'           => false,
            'canViewApplicants' => false,
            'canEditApplicants' => true,
            'created'           => '2024-10-14 14:23:23',
            'modified'          => '2024-10-14 14:23:23',
        ],
        'a-verry-special-username' => [
            'id'                => 6,
            'password'          => 'a-verry-special-username-password-123',
            'token'             => 'a-verry-special-username-token-123',
            'isAdmin'           => false,
            'canViewApplicants' => false,
            'canEditApplicants' => true,
            'created'           => '2024-10-14 14:23:23',
            'modified'          => '2024-10-14 14:23:23',
        ],
        'other-user' => [
            'id'                => 7,
            'password'          => 'other-user-password-123',
            'token'             => 'other-user-token-123',
            'isAdmin'           => false,
            'canViewApplicants' => false,
            'canEditApplicants' => false,
            'created'           => '2024-10-14 14:23:23',
            'modified'          => '2024-10-14 14:23:23',
        ],
    ];

    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [];

        foreach (self::$userDataList as $username => $userData) {
            $this->records[] = [
                'id'                => $userData['id'],
                'username'          => $username,
                'password'          => User::HashPassword($userData['password']),
                'token'             => User::HashToken   ($userData['token']   ),
                'isAdmin'           => $userData['isAdmin'],
                'canViewApplicants' => $userData['canViewApplicants'],
                'canEditApplicants' => $userData['canEditApplicants'],
                'created'           => $userData['created'],
                'modified'          => $userData['modified'],
            ];
        }
        
        parent::init();
    }
}
