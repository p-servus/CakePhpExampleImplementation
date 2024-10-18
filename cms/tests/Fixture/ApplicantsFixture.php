<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ApplicantsFixture
 */
class ApplicantsFixture extends TestFixture
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
                'title' => 'dr.',
                'firstName' => 'Neo',
                'lastName' => 'Hacker',
                'email' => 'neo-hacker@bla.com',
                'created' => '2024-10-16 14:18:15',
                'modified' => '2024-10-16 14:18:15',
            ],
            [
                'id' => 2,
                'title' => 'a-very-special-title',
                'firstName' => 'a-very-special-firstName',
                'lastName' => 'a-very-special-lastName',
                'email' => 'a-very-special-email@bla.com',
                'created' => '2024-10-16 14:18:15',
                'modified' => '2024-10-16 14:18:15',
            ],
        ];
        parent::init();
    }
}
