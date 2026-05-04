<?php

declare(strict_types=1);

use App\Actions\Url\UpdateUrlAction;
use App\Models\Url;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('It can update the URL of an existing record', function () {
    $url = Url::factory()->create(['url' => 'https://link-antigo.com']);
    $action = new UpdateUrlAction();

    $action->handle($url, ['url' => 'https://novo-link.com']);

    expect($url->refresh()->url)->toBe('https://novo-link.com');
});
