<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ApplicantsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ApplicantsTable Test Case
 */
class ApplicantsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ApplicantsTable
     */
    protected $Applicants;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Applicants',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Applicants') ? [] : ['className' => ApplicantsTable::class];
        $this->Applicants = $this->getTableLocator()->get('Applicants', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Applicants);

        parent::tearDown();
    }

    public function testCanSaveApplicant(): void
    {
        $applicant = $this->Applicants->newEntity([
            'title' => 'dr.',
            'firstName' => 'Jane',
            'lastName' => 'Doe',
            'email' => 'jane-doe@bla.com',
        ]);

        $result = $this->Applicants->save($applicant);
        $expected = $applicant;

        $this->assertEquals($expected, $result);
    }

    public function testCanNotSaveTwoApplicantsWithSameEmail(): void
    {
        $this->markTestIncomplete('TODO: Decide whether several applicants with the same email should exist.');

        // $email = 'same@email.com';

        // $applicant_1 = $this->Applicants->newEntity([
        //     'title' => 'dr. med.',
        //     'firstName' => 'Jane',
        //     'lastName' => 'Doe',
        //     'email' => $email,
        // ]);
        // $applicant_2 = $this->Applicants->newEntity([
        //     'title' => 'dr. phyl',
        //     'firstName' => 'Emil',
        //     'lastName' => 'Parker',
        //     'email' => $email,
        // ]);

        // $result_1 = $this->Applicants->save($applicant_1);
        // $expected_1 = $applicant_1;

        // $result_2 = $this->Applicants->save($applicant_2);
        // $expected_2 = false;

        // $this->assertEquals($expected_1, $result_1);
        // $this->assertEquals($expected_2, $result_2);
    }

    public function testCanSaveApplicantWithoutTitle(): void
    {
        $applicant = $this->Applicants->newEntity([
            // 'title' => 'dr.',
            'firstName' => 'Jane',
            'lastName' => 'Doe',
            'email' => 'jane-doe@bla.com',
        ]);

        $result = $this->Applicants->save($applicant);
        $expected = $applicant;

        $this->assertEquals($expected, $result);
    }

    public function testCanNotSaveApplicantWithoutFirstName(): void
    {
        $applicant = $this->Applicants->newEntity([
            'title' => 'dr.',
            // 'firstName' => 'Jane',
            'lastName' => 'Doe',
            'email' => 'jane-doe@bla.com',
        ]);

        $result = $this->Applicants->save($applicant);
        $expected = false;

        $this->assertEquals($expected, $result);
    }

    public function testCanNotSaveApplicantWithoutLastName(): void
    {
        $applicant = $this->Applicants->newEntity([
            'title' => 'dr.',
            'firstName' => 'Jane',
            // 'lastName' => 'Doe',
            'email' => 'jane-doe@bla.com',
        ]);

        $result = $this->Applicants->save($applicant);
        $expected = false;

        $this->assertEquals($expected, $result);
    }

    public function testCanNotSaveApplicantWithoutEmail(): void
    {
        $applicant = $this->Applicants->newEntity([
            'title' => 'dr.',
            'firstName' => 'Jane',
            'lastName' => 'Doe',
            // 'email' => 'jane-doe@bla.com',
        ]);

        $result = $this->Applicants->save($applicant);
        $expected = false;

        $this->assertEquals($expected, $result);
    }

    public function testCanSaveApplicantWithEmptyTitle(): void
    {
        $applicant = $this->Applicants->newEntity([
            'title' => '',
            'firstName' => 'Jane',
            'lastName' => 'Doe',
            'email' => 'jane-doe@bla.com',
        ]);

        $result = $this->Applicants->save($applicant);
        $expected = $applicant;

        $this->assertEquals($expected, $result);
    }

    public function testCanNotSaveApplicantWithEmptyFirstName(): void
    {
        $applicant = $this->Applicants->newEntity([
            'title' => 'dr.',
            'firstName' => '',
            'lastName' => 'Doe',
            'email' => 'jane-doe@bla.com',
        ]);

        $result = $this->Applicants->save($applicant);
        $expected = false;

        $this->assertEquals($expected, $result);
    }

    public function testCanNotSaveApplicantWithEmptyLastName(): void
    {
        $applicant = $this->Applicants->newEntity([
            'title' => 'dr.',
            'firstName' => 'Jane',
            'lastName' => '',
            'email' => 'jane-doe@bla.com',
        ]);

        $result = $this->Applicants->save($applicant);
        $expected = false;

        $this->assertEquals($expected, $result);
    }

    public function testCanNotSaveApplicantWithEmptyEmail(): void
    {
        $applicant = $this->Applicants->newEntity([
            'title' => 'dr.',
            'firstName' => 'Jane',
            'lastName' => 'Doe',
            'email' => '',
        ]);

        $result = $this->Applicants->save($applicant);
        $expected = false;

        $this->assertEquals($expected, $result);
    }

    public function testCanNotSaveApplicantWithInvalidEmail(): void
    {
        $invalidEmails = [
            // 'jane-doe@bla.com',
            'jane-doebla.com',
            'jane-doe@blacom',
        ];

        foreach ($invalidEmails as $invalidEmail) {
            $applicant = $this->Applicants->newEntity([
                'title' => 'dr.',
                'firstName' => 'Jane',
                'lastName' => 'Doe',
                'email' => $invalidEmail,
            ]);
            
            $result = $this->Applicants->save($applicant);
            $expected = false;

            $this->assertEquals($expected, $result);
        }
    }
}
