<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\UsersController Test Case
 *
 * @uses \App\Controller\UsersController
 */
class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected $tokens = [
        'admin' => 'admin-token-123',
    ];

    protected function setToken(string $token) {
        $this->configRequest([
            'headers' => [
                'Authorization' => 'Token '.$token,
            ],
        ]);
    }

    protected function setTokenForUsername(string $username) {
        $this->setToken($this->tokens[$username]);
    }

    protected function setContentTypeJson() {
        $this->configRequest([
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Users',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\UsersController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\UsersController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\UsersController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\UsersController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\UsersController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function assertUserCanIndex(string $username): void
    {
        $this->setTokenForUsername($username);

        $this->get('/api/users.json');
        $this->assertResponseSuccess();
        $this->assertResponseContains('admin');
    }

    public function assertUserCanView(string $username): void
    {
        $this->setTokenForUsername($username);

        $this->get('/api/users/1.json');
        $this->assertResponseSuccess();
        $this->assertResponseContains('admin');
    }

    public function assertUserCanAdd(string $username): void
    {
        $this->setTokenForUsername($username);

        $user = [
            'username' => 'jane-doe',
            'password' => 'password123',
        ];

        $this->setContentTypeJson();

        $this->post(
            '/api/users.json',
            json_encode($user, JSON_PRETTY_PRINT),
        );
        
        $responseData = json_decode((string)$this->_response->getBody(), true);

        $expected = [
            'user' => [
                'username' => 'jane-doe',
                'created' => $responseData['user']['created'],
                'modified' => $responseData['user']['created'],
                'id' => $responseData['user']['id'],
            ],
            'newToken' => $responseData['newToken'],
            'hint' => 'Please store this token in a safe location!!! Because of security reasons, only a hash of it will be stored here! If you lost the token, you have to create a new one!',
            'status' => 'OK',
            'message' => 'The user has been saved.',
        ];

        $this->assertResponseSuccess();
        $this->assertEquals($expected, $responseData);
    }

    public function testAdminCanIndex(): void
    {
        $this->assertUserCanIndex('admin');
    }

    public function testAdminCanView(): void
    {
        $this->assertUserCanView('admin');
    }

    public function testAdminCanAdd(): void
    {
        $this->assertUserCanAdd('admin');
    }
}
