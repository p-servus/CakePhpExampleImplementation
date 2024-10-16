<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\Event\EventInterface;
use Cake\ORM\Entity;
use Cake\Utility\Security;

/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $token
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'username' => true,
        // 'password' => true,
        // 'token' => true,
        // 'isAdmin' => true,
        // 'canViewApplicants' => true,
        // 'canEditApplicants' => true,
        'created' => true,
        'modified' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var list<string>
     */
    protected array $_hidden = [
        'password',
        'token',
    ];

    protected function _setPassword(string $password) : ?string
    {
        return self::HashPassword($password);
    }

    protected function _setToken(string $token) : ?string
    {
        return self::HashToken($token);
    }

    static public function NewToken(): string {
        // Security::randomString() returns a random HEX-string
        // -> length of a HEX-string 2 times the length of the byte-sequence
        $newToken = Security::randomString(32*2);

        return $newToken;
    }

    static public function HashPassword(string $password) : ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
        return null;
    }

    static public function HashToken(string $token) : ?string
    {
        if (strlen($token) > 0) {
            // hashing tokens needs no salt, bekause tokes has to be lage and random strings
            return Security::hash($token, 'sha256', false);
        }
        return null;
    }
}
