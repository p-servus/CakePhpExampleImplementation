<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * JobAdvertisementsFixture
 */
class JobAdvertisementsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'title' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'created' => '2024-10-13 16:24:10',
                'modified' => '2024-10-13 16:24:10',
            ],
        ];
        parent::init();
    }
}
