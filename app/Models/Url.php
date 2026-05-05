<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $url
 * @property string $short_code
 * @property int $access_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
#[Fillable(['url', 'short_code', 'access_count'])]
final class Url extends Model 
{
    use HasFactory;

    public static function findByShortCode(string $code): self
    {
        return self::where('short_code', $code)->firstOrFail();
    }
}