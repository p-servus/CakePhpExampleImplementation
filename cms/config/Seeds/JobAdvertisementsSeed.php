<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * JobAdvertisements seed.
 */
class JobAdvertisementsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            [
                'title'       => 'SoftwareDeveloper',
                'description' => 'programming PHP',
                'created'     => '2024-07-20 08:15:13', //date('Y-m-d H:i:s'),
                'modified'    => '2024-07-20 08:15:13', //date('Y-m-d H:i:s'),
            ],
            [
                'title'       => 'Designer',
                'description' => 'creating logos',
                'created'     => '2024-09-10 13:03:46', //date('Y-m-d H:i:s'),
                'modified'    => '2024-09-10 13:03:46', //date('Y-m-d H:i:s'),
            ],
        ];

        $table = $this->table('job_advertisements');
        $table->insert($data)->save();
    }
}
