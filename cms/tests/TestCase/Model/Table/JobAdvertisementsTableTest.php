<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\JobAdvertisementsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\JobAdvertisementsTable Test Case
 */
class JobAdvertisementsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\JobAdvertisementsTable
     */
    protected $JobAdvertisements;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.JobAdvertisements',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('JobAdvertisements') ? [] : ['className' => JobAdvertisementsTable::class];
        $this->JobAdvertisements = $this->getTableLocator()->get('JobAdvertisements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->JobAdvertisements);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\JobAdvertisementsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
