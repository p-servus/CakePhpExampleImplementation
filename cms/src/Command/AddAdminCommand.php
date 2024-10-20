<?php
namespace App\Command;

use App\Model\Entity\User;
use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

class AddAdminCommand extends Command
{   
    public function execute(Arguments $args, ConsoleIo $io): int
    {
        $username = $io->ask('Enter the new username:');

        $password = $io->ask('Enter the new password:');
        // $io->out("Enter the new password: ", 0);
        // $password = $this->getInputSilent();

        if ($password === null) {
            $io->error('Failed to read password silent!.');
            return static::CODE_ERROR;
        }

        $newToken = User::NewToken();
        $hint     = 'Please store this token in a safe location!!! Because of security reasons, only a hash of it will be stored here! If you lost the token, you have to create a new one!';
        
        $usersTable = $this->getTableLocator()->get('Users');
        $user = $usersTable->newEntity([
            'username' => $username,
            'password' => $password,
            'token'    => $newToken,
            'isAdmin'  => true,
        ], [
            'accessibleFields' => [
                'password' => true,
                'token' => true,
                'isAdmin' => true,
            ],
        ]);

        if (!$usersTable->save($user)) {
            $io->error('Failed to save the user.');
            return static::CODE_ERROR;
        }
        
        $io->success('The user has been saved successfully.');
        $io->success('    The new Token is "'.$newToken.'".');
        $io->success('    '.$hint);
        return static::CODE_SUCCESS;
    }

    protected function getInputSilent(): ?string
    {
        if (preg_match('/^win/i', PHP_OS)) {
            trigger_error("Failed to read silent: Windows is not supported!");
            return null;
        } else {
            $command = "/usr/bin/env bash -c 'echo OK'";
            if (rtrim(shell_exec($command)) !== 'OK') {
                trigger_error("Failed to read silent: Can't invoke bash");
                return null;
            }

            $command = "/usr/bin/env bash -c 'read -s mypassword && echo -n \$mypassword'";
            $password = shell_exec($command);
            echo "\n";

            return $password;
        }
    }
}
