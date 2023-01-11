<?php

namespace Tests\Unit\Services\Sms;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Request;
use Tests\TestCase;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Promise\RejectedPromise;

use App\Services\Sms\SmsService;

class SmsServiceTest extends TestCase
{
    public function test_method_send()
    {
        Http::fake();

        $response = app(SmsService::class)->send('3732128406', 'Hello World!');

        Http::assertSent(function (Request $request): bool {
            return $request->url() == 'send' && $request['phone'] == '3732128406' && $request['message'] == 'Hello World!';
        });

        $this->assertEquals(200, $response->status());
    }

    public function test_method_send_force_exception()
    {
        Http::fake([
            '/send' => fn ($request) => new RejectedPromise(new ConnectException('Connection error', $request)),
        ]);


        $response = app(SmsService::class)->send('3732128406', 'Hello World!');

        $this->assertFalse($response);
    }
}
