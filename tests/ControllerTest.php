<?php

namespace Spatie\SlashCommand\Test;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Spatie\SlashCommand\Exceptions\InvalidHandler;
use Spatie\SlashCommand\Exceptions\InvalidRequest;
use Spatie\SlashCommand\Exceptions\RequestCouldNotBeHandled;

class ControllerTest extends TestCase
{
    use WithoutMiddleware;

    /** @test */
    public function it_throws_an_exception_if_no_handler_can_handle_the_request()
    {
        $this->app['config']->set('laravel-slack-slash-command.handlers', []);

        $this->expectException(RequestCouldNotBeHandled::class);

        $response = $this->call('POST', 'test-url', ['token' => 'test-token']);

        if (isset($response->exception)) {
            throw $response->exception;
        }
    }

    /** @test */
    public function it_throws_an_exception_if_an_non_existing_handler_class_is_given()
    {
        $this->app['config']->set('laravel-slack-slash-command.handlers', ['NonExistingClassName']);

        $this->expectException(InvalidHandler::class);

        $response = $this->call('POST', 'test-url', ['token' => 'test-token']);

        if (isset($response->exception)) {
            throw $response->exception;
        }
    }
}
