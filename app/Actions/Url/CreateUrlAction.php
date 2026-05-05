<?php

declare(strict_types=1);

namespace App\Actions\Url;

use App\Models\Url;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final readonly class CreateUrlAction
{
    public function handle(array $data): Url
    {
        return DB::transaction(function () use ($data) {
            $url = Url::query()->create([
                'url' => $data['url'],
                'short_code' => $this->generateUniqueCode(),
            ]);

            return $url;
        });
    }
    
    private function generateUniqueCode(): string
    {
        do {
            $code = Str::random(6);
            $exists = Url::query()
                ->where('short_code', $code)
                ->lockForUpdate()
                ->exists();
        } while ($exists);

        return $code;
    }
}
