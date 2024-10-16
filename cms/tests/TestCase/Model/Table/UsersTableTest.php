<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersTable
     */
    protected $Users;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Users') ? [] : ['className' => UsersTable::class];
        $this->Users = $this->getTableLocator()->get('Users', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Users);

        parent::tearDown();
    }

    public function testCanSaveApplicant(): void
    {
        $user = $this->Users->newEntity([
            'username' => 'jane-doe',
            'password' => 'password123',
            'token' => '1234',
        ], [
            // Enable modification of password.
            // Enable modification of token.
            'accessibleFields' => [
                'password' => true,
                'token'    => true,
            ],
        ]);

        $result = $this->Users->save($user);
        $expected = $user;

        $this->assertEquals($expected, $result);
    }

    public function testCanNotSaveTwoUsersWithSameUsername(): void
    {
        $username = 'same-username';

        $user_1 = $this->Users->newEntity([
            'username' => $username,
            'password' => 'password123',
            'token' => '1234',
        ], [
            // Enable modification of password.
            // Enable modification of token.
            'accessibleFields' => [
                'password' => true,
                'token'    => true,
            ],
        ]);

        $user_2 = $this->Users->newEntity([
            'username' => $username,
            'password' => 'password456',
            'token' => '5678',
        ], [
            // Enable modification of password.
            // Enable modification of token.
            'accessibleFields' => [
                'password' => true,
                'token'    => true,
            ],
        ]);

        $result_1 = $this->Users->save($user_1);
        $expected_1 = $user_1;

        $result_2 = $this->Users->save($user_2);
        $expected_2 = false;

        $this->assertEquals($expected_1, $result_1);
        $this->assertEquals($expected_2, $result_2);
    }

    public function testCanNotSaveUserWithoutUsername(): void
    {
        $user = $this->Users->newEntity([
            // 'username' => 'jane-doe',
            'password' => 'password123',
            'token' => '1234',
        ], [
            // Enable modification of password.
            // Enable modification of token.
            'accessibleFields' => [
                'password' => true,
                'token'    => true,
            ],
        ]);

        $result = $this->Users->save($user);
        $expected = false;

        $this->assertEquals($expected, $result);
    }

    public function testCanNotSaveUserWithoutPassword(): void
    {
        $user = $this->Users->newEntity([
            'username' => 'jane-doe',
            // 'password' => 'password123',
            'token' => '1234',
        ], [
            // Enable modification of password.
            // Enable modification of token.
            'accessibleFields' => [
                'password' => true,
                'token'    => true,
            ],
        ]);

        $result = $this->Users->save($user);
        $expected = false;

        $this->assertEquals($expected, $result);
    }

    public function testCanNotSaveUserWithoutToken(): void
    {
        $user = $this->Users->newEntity([
            'username' => 'jane-doe',
            'password' => 'password123',
            // 'token' => '1234',
        ], [
            // Enable modification of password.
            // Enable modification of token.
            'accessibleFields' => [
                'password' => true,
                'token'    => true,
            ],
        ]);

        $result = $this->Users->save($user);
        $expected = false;

        $this->assertEquals($expected, $result);
    }

    public function testCanNotSaveUserWithEmptyUsername(): void
    {
        $user = $this->Users->newEntity([
            'username' => '',
            'password' => 'password123',
            'token' => '1234',
        ], [
            // Enable modification of password.
            // Enable modification of token.
            'accessibleFields' => [
                'password' => true,
                'token'    => true,
            ],
        ]);

        $result = $this->Users->save($user);
        $expected = false;

        $this->assertEquals($expected, $result);
    }

    public function testCanNotSaveUserWithEmptyPassword(): void
    {
        $user = $this->Users->newEntity([
            'username' => 'jane-doe',
            'password' => '',
            'token' => '1234',
        ], [
            // Enable modification of password.
            // Enable modification of token.
            'accessibleFields' => [
                'password' => true,
                'token'    => true,
            ],
        ]);

        $result = $this->Users->save($user);
        $expected = false;

        $this->assertEquals($expected, $result);
    }

    public function testCanNotSaveUserWithEmptyToken(): void
    {
        $user = $this->Users->newEntity([
            'username' => 'jane-doe',
            'password' => 'password123',
            'token' => '',
        ], [
            // Enable modification of password.
            // Enable modification of token.
            'accessibleFields' => [
                'password' => true,
                'token'    => true,
            ],
        ]);

        $result = $this->Users->save($user);
        $expected = false;

        $this->assertEquals($expected, $result);
    }
}
