<?php

declare(strict_types=1);

namespace App\Actions\Url;

use App\Models\Url;
use Illuminate\Support\Facades\DB;

final readonly class DeleteUrlAction
{
    public function handle(Url $url): bool
    {
        return DB::transaction(function () use ($url) {
            return (bool) $url->delete();
        });
    }
}
