<?php

beforeEach()->flaky();

it('shows the branded 404 page in the browser', function () {
    visit('/this-page-does-not-exist')
        ->assertSee('This page does not exist')
        ->assertPresent('@error-home')
        ->assertDontSee('Stack');
});
