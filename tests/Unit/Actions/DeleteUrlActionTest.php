<?php

declare(strict_types=1);

use App\Models\Url;
use App\Actions\Url\DeleteUrlAction;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('It can delete a URL record', function () {
    $url = Url::factory()->create();
    $action = new DeleteUrlAction();

    $action->handle($url);

    $this->assertDatabaseMissing('urls', ['id' => $url->id]);
});
