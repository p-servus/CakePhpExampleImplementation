<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api;

use App\Test\Fixture\UsersFixture;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Api\*Controller Test Case
 */
class ApiIntegrationTestCase extends TestCase
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



    public function assertUserCanNotRequestWithMethodGet(?string $username, string $path): void
    {
        $this->setTokenForUsername($username);

        $this->get($path);
        
        if ($username === null) {
            $this->assertResponseCode(401);
        }
        else {
            $this->assertResponseCode(403);
        }

        //TODO: check response
    }

    public function assertUserCanRequestWithMethodGet(?string $username, string $path): void
    {
        $this->setTokenForUsername($username);

        $this->get($path);

        // with unauthorised user assertResponseSuccess() throws Exception: Possibly related to `Authentication\Authenticator\UnauthenticatedException`: "Authentication is required to continue"
        // $this->assertResponseSuccess();
        $this->assertResponseCode(200);
    }

    public function assertUserCanNotRequestWithMethodPost(?string $username, string $path, array $data): void
    {
        $this->setTokenForUsername($username);

        $this->setContentTypeJson();

        $this->post(
            $path,
            json_encode($data, JSON_PRETTY_PRINT),
        );

        if ($username === null) {
            $this->assertResponseCode(401);
        }
        else {
            $this->assertResponseCode(403);
        }
    }

    public function assertUserCanRequestWithMethodPost(?string $username, string $path, array $data): void
    {
        $this->setTokenForUsername($username);

        $this->setContentTypeJson();

        $this->post(
            $path,
            json_encode($data, JSON_PRETTY_PRINT),
        );

        // with unauthorised user assertResponseSuccess() throws Exception: Possibly related to `Authentication\Authenticator\UnauthenticatedException`: "Authentication is required to continue"
        // $this->assertResponseSuccess();
        $this->assertResponseCode(200);
    }
}
