<?php

declare(strict_types=1);

namespace App\Actions\Url;

use App\Models\Url;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SensitiveParameter;

final readonly class CreateUrlAction
{
    public function handle(#[SensitiveParameter] array $data): Url
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
        } while (Url::query()->where('short_code', $code)->exists());

        return $code;
    }
}
