<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['website_domain', 'login', 'password', 'two_factor_secret'])]
#[Hidden(['two_factor_secret'])]
class SharedAccount extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'encrypted',
            'two_factor_secret' => 'encrypted',
        ];
    }
}
