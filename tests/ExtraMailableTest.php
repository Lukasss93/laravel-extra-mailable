<?php

namespace Lukasss93\ExtraMailable\Tests;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use InvalidArgumentException;
use Lukasss93\ExtraMailable\Tests\Mailables\FooMailable;
use PHPUnit\Framework\TestCase;

class ExtraMailableTest extends TestCase
{
    public function test_static_constructor(): void
    {
        $mail = FooMailable::create(123);

        self::assertInstanceOf(Mailable::class, $mail);
        self::assertEquals(123, $mail->foo);
    }

    public function test_sendto_invalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The $to parameter must be iterable.');

        Mail::fake();

        FooMailable::create(123)->sendTo(456);

        Mail::assertNotSent(FooMailable::class);
    }

    public function test_sendto_no_one(): void
    {
        Mail::fake();

        FooMailable::create(123)->sendTo(null);

        Mail::assertNotSent(FooMailable::class);
    }

    public function test_sendto_array_mail(): void
    {
        Mail::fake();

        FooMailable::create(123)->sendTo(['foo@bar.org', 'bar@foo.org']);

        Mail::assertSent(FooMailable::class, 2);
    }

    public function test_sendto_string_mail(): void
    {
        Mail::fake();

        FooMailable::create(123)->sendTo('foo@bar.org;bar@foo.org');

        Mail::assertSent(FooMailable::class, 2);
    }

    public function test_sendtowhen_false(): void
    {
        Mail::fake();

        FooMailable::create(123)->sendToWhen(false, 'foo@bar.org');

        Mail::assertNotSent(FooMailable::class);
    }

    public function test_sendtowhen_true(): void
    {
        Mail::fake();

        FooMailable::create(123)->sendToWhen(true, 'foo@bar.org');

        Mail::assertSent(FooMailable::class);
    }

    public function test_empty_callable(): void
    {
        Mail::fake();

        FooMailable::create(123)
            ->onEmptyRecipients(fn () => print('empty!'))
            ->sendTo([]);

        Mail::assertNotSent(FooMailable::class);
        $this->expectOutputString('empty!');
    }

    public function test_before_callable(): void
    {
        Mail::fake();

        FooMailable::create(123)
            ->onBeforeSendingMails(fn () => print('before!'))
            ->sendTo('foo@bar.org');

        Mail::assertSent(FooMailable::class);
        $this->expectOutputString('before!');
    }

    public function test_after_callable(): void
    {
        Mail::fake();

        FooMailable::create(123)
            ->onAfterSendingMails(fn () => print('after!'))
            ->sendTo('foo@bar.org');

        Mail::assertSent(FooMailable::class);
        $this->expectOutputString('after!');
    }
}
