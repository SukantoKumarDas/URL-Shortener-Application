<?php
// app/Repositories/UrlRepository.php

namespace App\Repositories;

use App\Models\Url;
use Illuminate\Support\Str;

class UrlRepository
{
    public function findByAlias($alias)
    {
        return Url::where('shortened_alias', $alias)->first();
    }

    public function create(array $data)
    {
        return Url::create($data);
    }

    public function aliasExists($alias)
    {
        return Url::where('shortened_alias', $alias)->exists();
    }
}