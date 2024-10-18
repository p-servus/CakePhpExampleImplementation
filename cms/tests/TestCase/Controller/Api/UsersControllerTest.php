<?php
declare(strict_types=1);

namespace App\Test\TestCase\Api\Controller;

use App\Controller\UsersController;
use App\Test\Fixture\UsersFixture;
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
                'modified' => $responseData['user']['modified'],
            ],
            'newToken' => $responseData['newToken'],
            'hint'     => 'Please store this token in a safe location!!! Because of security reasons, only a hash of it will be stored here! If you lost the token, you have to create a new one!',
            'status'   => 'OK',
            'message'  => 'The user has been saved.',
        ];

        $this->assertEquals($expected, $responseData);
    }

    public function assertUserCanNotEditUserWithId(?string $username, int $userId): void
    {
        $user = [
            'username' => 'jane-doe',
            'password' => 'password123',
        ];

        $this->assertUserCanNotRequestWithMethodPut($username, '/api/users/'.$userId.'.json', $user);

        //TODO: check response
        // the following throws Exception: Possibly related to `Authentication\Authenticator\UnauthenticatedException`: "Authentication is required to continue"
        // $this->assertResponseNotContains($user['username']);
    }

    public function assertUserCanEditUserWithId(?string $username, int $userId): void
    {
        $user = [
            'username' => 'jane-doe',
            'password' => 'password123',
        ];

        $this->assertUserCanRequestWithMethodPut($username, '/api/users/'.$userId.'.json', $user);
        
        $responseData = json_decode((string)$this->_response->getBody(), true);

        $expected = [
            'user' => [
                'id'       => $responseData['user']['id'],

                'username' => $user['username'],

                //TODO: why will this be displayed after "edit", bit not after "add"
                'isAdmin'            => $responseData['user']['isAdmin'],
                'canViewApplicants'  => $responseData['user']['canViewApplicants'],
                'canEditApplicants'  => $responseData['user']['canEditApplicants'],

                'created'  => $responseData['user']['created'],
                'modified' => $responseData['user']['modified'],
            ],
            'status'   => 'OK',
            'message'  => 'The user has been saved.',
        ];

        $this->assertEquals($expected, $responseData);
    }

    public function assertUserCanNotEditOwnUser(?string $username): void
    {
        $ownUserId = UsersFixture::$userDataList[$username]['id'];
        
        $this->assertUserCanNotEditUserWithId($username, $ownUserId);
    }

    public function assertUserCanEditOwnUser(?string $username): void
    {
        $ownUserId = UsersFixture::$userDataList[$username]['id'];
        
        $this->assertUserCanEditUserWithId($username, $ownUserId);
    }

    public function assertUserCanNotEditOtherUser(?string $username, string $otherUsername): void
    {
        $otherUserId = UsersFixture::$userDataList[$otherUsername]['id'];
        
        $this->assertUserCanNotEditUserWithId($username, $otherUserId);
    }

    public function assertUserCanEditOtherUser(?string $username, string $otherUsername): void
    {
        $otherUserId = UsersFixture::$userDataList[$otherUsername]['id'];
        
        $this->assertUserCanEditUserWithId($username, $otherUserId);
    }

    public function assertUserCanNotDeleteUserWithId(?string $username, int $userId): void
    {
        $this->assertUserCanNotRequestWithMethodDelete($username, '/api/users/'.$userId.'.json');
        
        //TODO: check response
    }

    public function assertUserCanDeleteUserWithId(?string $username, int $userId): void
    {
        $this->assertUserCanRequestWithMethodDelete($username, '/api/users/'.$userId.'.json');
        
        $responseData = json_decode((string)$this->_response->getBody(), true);

        $expected = [
            'status'   => 'OK',
            'message'  => 'The user has been deleted.',
        ];

        $this->assertEquals($expected, $responseData);
    }

    public function assertUserCanNotDeleteOwnUser(?string $username): void
    {
        $ownUserId = UsersFixture::$userDataList[$username]['id'];
        
        $this->assertUserCanNotDeleteUserWithId($username, $ownUserId);
    }

    public function assertUserCanDeleteOwnUser(?string $username): void
    {
        $ownUserId = UsersFixture::$userDataList[$username]['id'];
        
        $this->assertUserCanDeleteUserWithId($username, $ownUserId);
    }

    public function assertUserCanNotDeleteOtherUser(?string $username, string $otherUsername): void
    {
        $otherUserId = UsersFixture::$userDataList[$otherUsername]['id'];
        
        $this->assertUserCanNotDeleteUserWithId($username, $otherUserId);
    }

    public function assertUserCanDeleteOtherUser(?string $username, string $otherUsername): void
    {
        $otherUserId = UsersFixture::$userDataList[$otherUsername]['id'];
        
        $this->assertUserCanDeleteUserWithId($username, $otherUserId);
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

    public function testUnauthorisedUserCanNotEdit(): void
    {
        $this->assertUserCanNotEditOtherUser(null, 'other-user');
    }

    public function testUnauthorisedUserCanNotDelete(): void
    {
        $this->assertUserCanNotDeleteOtherUser(null, 'other-user');
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

    public function testAdminCanEditOwnUser(): void
    {
        $this->assertUserCanEditOwnUser('admin');
    }

    public function testAdminCanEditOtherUser(): void
    {
        $this->assertUserCanEditOtherUser('admin', 'other-user');
    }

    public function testAdminCanDeleteOwnUser(): void
    {
        $this->assertUserCanDeleteOwnUser('admin');
    }

    public function testAdminCanDeleteOtherUser(): void
    {
        $this->assertUserCanDeleteOtherUser('admin', 'other-user');
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

    public function testUserWithNoPermissionsCanEditOwnUser(): void
    {
        $this->assertUserCanEditOwnUser('user-with-noPermissions');
    }

    public function testUserWithNoPermissionsCanNotEditOtherUser(): void
    {
        $this->assertUserCanNotEditOtherUser('user-with-noPermissions', 'other-user');
    }

    public function testUserWithNoPermissionsCanDeleteOwnUser(): void
    {
        $this->assertUserCanDeleteOwnUser('user-with-noPermissions');
    }

    public function testUserWithNoPermissionsCanNotDeleteOtherUser(): void
    {
        $this->assertUserCanNotDeleteOtherUser('user-with-noPermissions', 'other-user');
    }
}
