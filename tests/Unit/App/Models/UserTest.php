<?php

namespace Tests\Unit\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Unit\App\Models\Contracts\ModelTestCase;

class UserTest extends ModelTestCase
{
    protected function model(): Model
    {
        return new User;
    }

    protected function expectedTableName(): string
    {
        return 'users';
    }

    protected function expectedTraits(): array
    {
        return [
            HasFactory::class,
            Notifiable::class,
            TwoFactorAuthenticatable::class,
        ];
    }

    protected function expectedFillable(): array
    {
        return [
            'name',
            'email',
            'password',
            'email_verified_at',
        ];
    }

    protected function expectedHidden(): array
    {
        return [
            'password',
            'two_factor_secret',
            'two_factor_recovery_codes',
            'remember_token',
        ];
    }

    protected function expectedCasts(): array
    {
        return [
            'id' => 'int',
            'email_verified_at' => 'datetime:Y-m-d H:i',
            'password' => 'hashed',
            'created_at' => 'datetime:Y-m-d H:i',
            'updated_at' => 'datetime:Y-m-d H:i',
        ];
    }

    #[DataProvider('initialsDataProvider')]
    public function test_initials(string $name, string $expected): void
    {
        $user = new User;
        $user->name = $name;

        $initials = $user->initials();
        $this->assertEquals($expected, $initials);
    }

    /**
     * @return array<string, array{0: string, 1: string}>
     */
    public static function initialsDataProvider(): array
    {
        return [
            'single word name' => ['John', 'J'],
            'two word name' => ['John Doe', 'JD'],
            'multiple words name' => ['John Michael Doe', 'JM'],
            'extra spaces' => ['John   Doe', 'J'], // explode creates empty strings, so only first word is taken
            'leading and trailing spaces' => ['  John Doe  ', ''], // Leading spaces create empty strings at the beginning
            'empty name' => ['', ''],
            'single character name' => ['J', 'J'],
            'name with special characters' => ['José María', 'JM'],
            'name with numbers' => ['John 123', 'J1'],
        ];
    }
}
