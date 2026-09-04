<?php

namespace Tests\Feature;

use App\Exceptions\FormEmailDeliveryException;
use App\Forms\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Mockery;
use RuntimeException;
use Statamic\Contracts\Forms\Form;
use Statamic\Contracts\Forms\Submission;
use Statamic\Sites\Site;
use Tests\TestCase;

class FormEmailDeliveryExceptionTest extends TestCase
{
    public function test_it_returns_a_safe_json_error_when_email_delivery_fails(): void
    {
        $exception = new FormEmailDeliveryException(
            'contact',
            new RuntimeException('Sensitive SMTP failure detail'),
        );
        $request = Request::create(
            '/!/forms/contact',
            'POST',
            server: ['HTTP_ACCEPT' => 'application/json'],
        );

        $response = $exception->render($request);
        $data = $response->getData(true);

        $this->assertSame(422, $response->getStatusCode());
        $this->assertSame(
            'Pesan Anda sudah tersimpan, tetapi notifikasi email sedang mengalami gangguan. Tim kami akan memeriksanya sesegera mungkin.',
            $data['errors'][0],
        );
        $this->assertStringNotContainsString('Sensitive SMTP failure detail', $response->getContent());
    }

    public function test_it_redirects_a_regular_form_back_with_a_form_error(): void
    {
        $exception = new FormEmailDeliveryException(
            'contact',
            new RuntimeException('Sensitive SMTP failure detail'),
        );
        $request = Request::create(
            '/!/forms/contact',
            'POST',
            server: ['HTTP_REFERER' => 'https://example.com/kontak'],
        );
        $request->setLaravelSession($this->app['session.store']);
        $this->app->instance('request', $request);
        $this->app['url']->setRequest($request);

        $response = $exception->render($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame('https://example.com/kontak', $response->getTargetUrl());
        $this->assertSame(
            'Pesan Anda sudah tersimpan, tetapi notifikasi email sedang mengalami gangguan. Tim kami akan memeriksanya sesegera mungkin.',
            session('errors')->getBag('form.contact')->first('email_delivery'),
        );
    }

    public function test_the_custom_job_wraps_mailer_errors_without_exposing_them(): void
    {
        Mail::shouldReceive('mailer')
            ->once()
            ->with(null)
            ->andThrow(new RuntimeException('Sensitive SMTP failure detail'));

        $form = Mockery::mock(Form::class);
        $form->shouldReceive('handle')->once()->andReturn('contact');

        $submission = Mockery::mock(Submission::class);
        $submission->shouldReceive('form')->once()->andReturn($form);

        $job = new SendEmail($submission, Mockery::mock(Site::class), []);

        try {
            $job->handle();
            $this->fail('The mail delivery exception was not thrown.');
        } catch (FormEmailDeliveryException $exception) {
            $this->assertSame('contact', $exception->formHandle);
            $this->assertStringNotContainsString('Sensitive SMTP failure detail', $exception->getMessage());
            $this->assertSame('Sensitive SMTP failure detail', $exception->getPrevious()?->getMessage());
        }
    }
}
