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

    public function testCanSaveJobAdvertisement(): void
    {
        $jobAdvertisement = $this->JobAdvertisements->newEntity([
            'title' => 'SoftwareDeveloper',
            'description' => 'Programming PHP!',
        ]);

        $result = $this->JobAdvertisements->save($jobAdvertisement);
        $expected = $jobAdvertisement;

        $this->assertEquals($expected, $result);
    }

    public function testCanNotSaveJobAdvertisementWithoutTitle(): void
    {
        $jobAdvertisement = $this->JobAdvertisements->newEntity([
            // 'title' => 'SoftwareDeveloper',
            'description' => 'Programming PHP!',
        ]);

        $result = $this->JobAdvertisements->save($jobAdvertisement);
        $expected = false;

        $this->assertEquals($expected, $result);
    }

    public function testCanNotSaveJobAdvertisementWithoutDescription(): void
    {
        $jobAdvertisement = $this->JobAdvertisements->newEntity([
            'title' => 'SoftwareDeveloper',
            // 'description' => 'Programming PHP!',
        ]);

        $result = $this->JobAdvertisements->save($jobAdvertisement);
        $expected = false;

        $this->assertEquals($expected, $result);
    }

    public function testCanNotSaveJobAdvertisementWithEmptyTitle(): void
    {
        $jobAdvertisement = $this->JobAdvertisements->newEntity([
            'title' => '',
            'description' => 'Programming PHP!',
        ]);

        $result = $this->JobAdvertisements->save($jobAdvertisement);
        $expected = false;

        $this->assertEquals($expected, $result);
    }

    public function testCanNotSaveJobAdvertisementWithEmptyDescription(): void
    {
        $jobAdvertisement = $this->JobAdvertisements->newEntity([
            'title' => 'SoftwareDeveloper',
            'description' => '',
        ]);

        $result = $this->JobAdvertisements->save($jobAdvertisement);
        $expected = false;

        $this->assertEquals($expected, $result);
    }
}
