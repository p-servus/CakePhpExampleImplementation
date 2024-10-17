<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use App\Test\Fixture\UsersFixture;
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

    protected function setToken(string $token) {
        $this->configRequest([
            'headers' => [
                'Authorization' => 'Token '.$token,
            ],
        ]);
    }

    protected function setTokenForUsername(?string $username) {
        if ($username === null) {
            return;
        }

        $this->setToken(UsersFixture::$userDataList[$username]['token']);
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



    public function assertUserCanNotIndex(?string $username): void
    {
        $this->setTokenForUsername($username);

        $this->get('/api/users.json');
        
        if ($username === null) {
            $this->assertResponseCode(401);
        }
        else {
            $this->assertResponseCode(403);
        }

        //TODO: check response
    }

    public function assertUserCanIndex(?string $username): void
    {
        $this->setTokenForUsername($username);

        $this->get('/api/users.json');

        // with unauthorised user assertResponseSuccess() throws Exception: Possibly related to `Authentication\Authenticator\UnauthenticatedException`: "Authentication is required to continue"
        // $this->assertResponseSuccess();
        $this->assertResponseCode(200);

        $responseData = json_decode((string)$this->_response->getBody(), true);
        
        $this->assertResponseContains('a-verry-special-username');
    }

    public function assertUserCanNotView(?string $username): void
    {
        $this->setTokenForUsername($username);

        $this->get('/api/users/6.json');
        
        if ($username === null) {
            $this->assertResponseCode(401);
        }
        else {
            $this->assertResponseCode(403);
        }
        
        //TODO: check response
        // the following throws Exception: Possibly related to `Authentication\Authenticator\UnauthenticatedException`: "Authentication is required to continue"  
        // $this->assertResponseNotContains('a-verry-special-username');
    }

    public function assertUserCanView(?string $username): void
    {
        $this->setTokenForUsername($username);

        $this->get('/api/users/6.json');
        
        // with unauthorised user assertResponseSuccess() throws Exception: Possibly related to `Authentication\Authenticator\UnauthenticatedException`: "Authentication is required to continue"
        // $this->assertResponseSuccess();
        $this->assertResponseCode(200);
        
        $this->assertResponseContains('a-verry-special-username');
    }

    public function assertUserCanNotAdd(?string $username): void
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

        if ($username === null) {
            $this->assertResponseCode(401);
        }
        else {
            $this->assertResponseCode(403);
        }

        //TODO: check response
    }

    public function assertUserCanAdd(?string $username): void
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

        // with unauthorised user assertResponseSuccess() throws Exception: Possibly related to `Authentication\Authenticator\UnauthenticatedException`: "Authentication is required to continue"
        // $this->assertResponseSuccess();
        $this->assertResponseCode(200);

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


    
    public function testUserWithNoPermissionsCanIndex(): void
    {
        $this->assertUserCanIndex('user-with-noPermissions');
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
