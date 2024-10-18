<?php
declare(strict_types=1);

namespace App\Test\TestCase\Api\Controller;

use App\Controller\UsersController;
use App\Test\TestCase\Controller\Api\ApiIntegrationTestCase;

/**
 * App\Controller\Api\UsersController Test Case
 *
 * @uses \App\Controller\Api\UsersController
 */
class UsersControllerTest extends ApiIntegrationTestCase
{
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



    public function assertUserCanNotIndex(?string $username): void
    {
        $this->assertUserCanNotRequestWithMethodGet($username, '/api/users.json');

        //TODO: check response
    }

    public function assertUserCanIndex(?string $username): void
    {
        $this->assertUserCanRequestWithMethodGet($username, '/api/users.json');

        //TODO: check response
        // $responseData = json_decode((string)$this->_response->getBody(), true);
        $this->assertResponseContains('a-verry-special-username');
    }

    public function assertUserCanNotView(?string $username): void
    {
        $this->assertUserCanNotRequestWithMethodGet($username, '/api/users/6.json');
        
        //TODO: check response
        // the following throws Exception: Possibly related to `Authentication\Authenticator\UnauthenticatedException`: "Authentication is required to continue"  
        // $this->assertResponseNotContains('a-verry-special-username');
    }

    public function assertUserCanView(?string $username): void
    {
        $this->assertUserCanRequestWithMethodGet($username, '/api/users/6.json');
        
        //TODO: check response
        // $responseData = json_decode((string)$this->_response->getBody(), true);
        $this->assertResponseContains('a-verry-special-username');
    }

    public function assertUserCanNotAdd(?string $username): void
    {
        $user = [
            'username' => 'jane-doe',
            'password' => 'password123',
        ];

        $this->assertUserCanNotRequestWithMethodPost($username, '/api/users.json', $user);

        //TODO: check response
        // the following throws Exception: Possibly related to `Authentication\Authenticator\UnauthenticatedException`: "Authentication is required to continue"
        // $this->assertResponseNotContains($user['username']);
    }

    public function assertUserCanAdd(?string $username): void
    {
        $user = [
            'username' => 'jane-doe',
            'password' => 'password123',
        ];

        $this->assertUserCanRequestWithMethodPost($username, '/api/users.json', $user);
        
        $responseData = json_decode((string)$this->_response->getBody(), true);

        $expected = [
            'user' => [
                'id'       => $responseData['user']['id'],

                'username' => $user['username'],

                'created'  => $responseData['user']['created'],
                'modified' => $responseData['user']['created'],
            ],
            'newToken' => $responseData['newToken'],
            'hint'     => 'Please store this token in a safe location!!! Because of security reasons, only a hash of it will be stored here! If you lost the token, you have to create a new one!',
            'status'   => 'OK',
            'message'  => 'The user has been saved.',
        ];

        $this->assertEquals($expected, $responseData);
    }


    
    public function testUnauthorisedUserCanNotIndex(): void
    {
        $this->assertUserCanNotIndex(null);
    }

    public function testUnauthorisedUserCanNotView(): void
    {
        $this->assertUserCanNotView(null);
    }

    public function testUnauthorisedUserCanAddBecauseEveryoneCanAddAUserToRegister(): void
    {
        $this->assertUserCanAdd(null);
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


    
    public function testUserWithNoPermissionsCanNotIndex(): void
    {
        $this->assertUserCanNotIndex('user-with-noPermissions');
    }

    public function testUserWithNoPermissionsCanNotView(): void
    {
        $this->assertUserCanNotView('user-with-noPermissions');
    }

    public function testUserWithNoPermissionsCanAddBecauseEveryoneCanAddAUserToRegister(): void
    {
        $this->assertUserCanAdd('user-with-noPermissions');
    }
}
