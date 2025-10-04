<?php

// uses(\Tests\TestCase::class)->in('Browser');

test('smoke', function () {
    $routes = [
        '/',
    ];

    visit($routes)
        ->assertNoSmoke()
        ->assertScreenshotMatches();
});
