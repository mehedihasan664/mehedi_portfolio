<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminCredential extends Model
{
    protected $guarded = [];

    protected $hidden = ['password'];

    public static function email(): string
    {
        return (string) (static::query()->first()?->email ?: config('portfolio.admin_email'));
    }

    public static function credentialsMatch(string $email, string $password): bool
    {
        return hash_equals(mb_strtolower(static::email()), mb_strtolower($email))
            && static::passwordMatches($password);
    }

    public static function passwordMatches(string $password): bool
    {
        $credential = static::query()->first();

        if ($credential) {
            return Hash::check($password, $credential->password);
        }

        return hash_equals((string) config('portfolio.admin_password'), $password);
    }

    public static function changePassword(string $password): void
    {
        static::query()->updateOrCreate(
            ['id' => 1],
            [
                'email' => static::email(),
                'password' => Hash::make($password),
            ],
        );
    }

    public static function changeEmail(string $email): void
    {
        $oldEmail = static::email();
        $credential = static::query()->first();

        static::query()->updateOrCreate(
            ['id' => 1],
            [
                'email' => mb_strtolower($email),
                'password' => $credential?->password ?: Hash::make((string) config('portfolio.admin_password')),
            ],
        );

        DB::table('password_reset_tokens')->where('email', mb_strtolower($oldEmail))->delete();
    }
}
