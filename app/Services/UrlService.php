<?php

namespace App\Services;

use App\Repositories\UrlRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class UrlService
{
    protected $urlRepository;
    
    public function __construct(UrlRepository $urlRepository) {
        $this->urlRepository = $urlRepository;
    }

    public function generateAlias()
    {
        $alias = Str::random(6);
        while ($this->urlRepository->aliasExists($alias)) {
            $alias = Str::random(6);
        }
        return $alias;
    }

    public function createShortenedUrl($originalUrl, $customAlias = null, $expirationTime = 6, $isPrivate = 0)
    {
        $alias = $customAlias ?: $this->generateAlias();
        
        $urlData = [
            'user_id' => auth()->check() ? auth()->id() : null,
            'original_url' => $originalUrl,
            'shortened_alias' => $alias,
            'is_private' => $isPrivate,
            'expired_at' => Carbon::now()->addHours($expirationTime),
        ];

        return $this->urlRepository->create($urlData);
    }

    public function checkUrlExpiry($alias)
    {
        $url = $this->urlRepository->findByAlias($alias);
        if (!$url) {
            return null;
        }

        if ($url->expired_at && Carbon::now()->greaterThan($url->expired_at)) {
            return false;
        }

        return $url;
    }
}