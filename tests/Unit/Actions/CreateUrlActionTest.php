<?php

declare(strict_types=1);

use App\Actions\Url\CreateUrlAction;
use App\Models\Url;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('It can shorten a URL and generate a 6-character code', function () {
    $action = new CreateUrlAction();
    $data = ['url' => 'https://google.com'];

    $result = $action->handle($data);

    expect($result)->toBeInstanceOf(Url::class)
        ->and($result->url)->toBe('https://google.com')
        ->and(strlen($result->short_code))->toBe(6);

    $this->assertDatabaseHas('urls', [
        'url' => 'https://google.com',
        'short_code' => $result->short_code
    ]);
});

it('It generates a unique shortcode even if there is a collision', function () {

    $action = new CreateUrlAction();
    
    Url::factory()->create(['short_code' => 'ABC123']);

    $result = $action->handle(['url' => 'https://example.com']);
    
    expect(Url::where('short_code', $result->short_code)->count())->toBe(1);
});
