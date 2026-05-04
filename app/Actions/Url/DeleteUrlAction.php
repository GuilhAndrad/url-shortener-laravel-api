<?php

declare(strict_types=1);

namespace App\Actions\Url;

use App\Models\Url;

final readonly class DeleteUrlAction
{
    public function handle(Url $url): bool
    {
        return (bool) $url->delete();
    }
}