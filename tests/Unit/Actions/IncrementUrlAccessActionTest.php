<?php

declare(strict_types=1);

use App\Actions\Url\IncrementUrlAccessAction;
use App\Models\Url;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('It increments the access counter', function () {
    $url = Url::factory()->create(['access_count' => 0]);
    $action = new IncrementUrlAccessAction();

    $action->handle($url);

    expect($url->refresh()->access_count)->toBe(1);
});