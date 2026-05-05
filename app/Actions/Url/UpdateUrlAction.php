<?php

declare(strict_types=1);

namespace App\Actions\Url;

use App\Models\Url;
use Illuminate\Support\Facades\DB;

final readonly class UpdateUrlAction
{
    public function handle(Url $url, array $data): Url
    {
        return DB::transaction(function () use ($url, $data) {
            $url->update([
                'url' => $data['url']
            ]);

            return $url;
        });   
          
    }
}