<?php
declare(strict_types=1);

namespace App\Test\TestCase\Api\Controller\Api;

use App\Controller\Api\ApplicantsController;
use App\Test\TestCase\Controller\Api\ApiIntegrationTestCase;

/**
 * App\Controller\Api\ApplicantsController Test Case
 *
 * @uses \App\Controller\Api\ApplicantsController
 */
class ApplicantsControllerTest extends ApiIntegrationTestCase
{
    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Users',
        'app.Applicants',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\ApplicantsController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\ApplicantsController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\ApplicantsController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\ApplicantsController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\ApplicantsController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }



    public function assertUserCanNotIndex(?string $username): void
    {
        $this->assertUserCanNotRequestWithMethodGet($username, '/api/applicants.json');

        //TODO: check response
    }

    public function assertUserCanIndex(?string $username): void
    {
        $this->assertUserCanRequestWithMethodGet($username, '/api/applicants.json');

        //TODO: check response
        // $responseData = json_decode((string)$this->_response->getBody(), true);
        $this->assertResponseContains('a-very-special-title');
        $this->assertResponseContains('a-very-special-firstName');
        $this->assertResponseContains('a-very-special-lastName');
        $this->assertResponseContains('a-very-special-email@bla.com');
    }

    public function assertUserCanNotView(?string $username): void
    {
        $this->assertUserCanNotRequestWithMethodGet($username, '/api/applicants/2.json');
        
        //TODO: check response
        // the following throws Exception: Possibly related to `Authentication\Authenticator\UnauthenticatedException`: "Authentication is required to continue"
        // $this->assertResponseNotContains('a-very-special-title');
        // $this->assertResponseNotContains('a-very-special-firstName');
        // $this->assertResponseNotContains('a-very-special-lastName');
        // $this->assertResponseNotContains('a-very-special-email@bla.com');
    }

    public function assertUserCanView(?string $username): void
    {
        $this->assertUserCanRequestWithMethodGet($username, '/api/applicants/2.json');
        
        //TODO: check response
        // $responseData = json_decode((string)$this->_response->getBody(), true);
        $this->assertResponseContains('a-very-special-title');
        $this->assertResponseContains('a-very-special-firstName');
        $this->assertResponseContains('a-very-special-lastName');
        $this->assertResponseContains('a-very-special-email@bla.com');
    }

    public function assertUserCanNotAdd(?string $username): void
    {
        $applicant = [
            'title' => 'dr.',
            'firstName' => 'Jane',
            'lastName' => 'Doe',
            'email' => 'jane-doe@bla.com',
        ];

        $this->assertUserCanNotRequestWithMethodPost($username, '/api/applicants.json', $applicant);

        //TODO: check response
        // the following throws Exception: Possibly related to `Authentication\Authenticator\UnauthenticatedException`: "Authentication is required to continue"
        // $this->assertResponseNotContains($applicant['title']);
        // $this->assertResponseNotContains($applicant['firstName']);
        // $this->assertResponseNotContains($applicant['lastName']);
        // $this->assertResponseNotContains($applicant['email']);
    }

    public function assertUserCanAdd(?string $username): void
    {
        $applicant = [
            'title' => 'dr.',
            'firstName' => 'Jane',
            'lastName' => 'Doe',
            'email' => 'jane-doe@bla.com',
        ];

        $this->assertUserCanRequestWithMethodPost($username, '/api/applicants.json', $applicant);
        
        $responseData = json_decode((string)$this->_response->getBody(), true);

        $expected = [
            'applicant' => [
                'id'        => $responseData['applicant']['id'],

                'title'     => $applicant['title'],
                'firstName' => $applicant['firstName'],
                'lastName'  => $applicant['lastName'],
                'email'     => $applicant['email'],

                'created'   => $responseData['applicant']['created'],
                'modified'  => $responseData['applicant']['created'],
            ],
            'status'   => 'OK',
            'message'  => 'The applicant has been saved.',
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

    public function testUnauthorisedUserCanNotAdd(): void
    {
        $this->assertUserCanNotAdd(null);
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

    public function testUserWithNoPermissionsCanNotAdd(): void
    {
        $this->assertUserCanNotAdd('user-with-noPermissions');
    }


    
    public function testUserWithWithCanViewApplicantsPermissionCanIndex(): void
    {
        $this->assertUserCanIndex('user-with-canViewApplicants');
    }

    public function testUserWithWithCanViewApplicantsPermissionCanView(): void
    {
        $this->assertUserCanView('user-with-canViewApplicants');
    }

    public function testUserWithWithCanViewApplicantsPermissionCanNotAdd(): void
    {
        $this->assertUserCanNotAdd('user-with-canViewApplicants');
    }


    
    public function testUserWithWithCanViewApplicantsAndCanEditApplicantsPermissionCanIndex(): void
    {
        $this->assertUserCanIndex('user-with-canViewApplicants-and-canEditApplicants');
    }

    public function testUserWithWithCanViewApplicantsAndCanEditApplicantsPermissionCanView(): void
    {
        $this->assertUserCanView('user-with-canViewApplicants-and-canEditApplicants');
    }

    public function testUserWithWithCanViewApplicantsAndCanEditApplicantsPermissionCanAdd(): void
    {
        $this->assertUserCanAdd('user-with-canViewApplicants-and-canEditApplicants');
    }


    
    public function testUserWithWithCanEditApplicantsPermissionCanNotIndex(): void
    {
        $this->assertUserCanNotIndex('user-with-canEditApplicants');
    }

    public function testUserWithWithCanEditApplicantsPermissionCanNotView(): void
    {
        $this->assertUserCanNotView('user-with-canEditApplicants');
    }

    public function testUserWithWithCanEditApplicantsPermissionCanNotAdd(): void
    {
        $this->assertUserCanNotAdd('user-with-canEditApplicants');
    }
}
