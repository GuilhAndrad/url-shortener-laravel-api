<?php

declare(strict_types=1);

namespace App\Actions\Url;

use App\Models\Url;

final readonly class IncrementUrlAccessAction
{
    public function handle(Url $url): void
    {
        $url->increment('access_count');
    }
}