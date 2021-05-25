<?php

namespace Lukasss93\ExtraMailable\Tests\Mailables;

use Illuminate\Mail\Mailable;
use Lukasss93\ExtraMailable\ExtraMailable;

class FooMailable extends Mailable
{
    use ExtraMailable;

    public ?int $foo;

    public function __construct(int $foo)
    {
        $this->foo = $foo;
    }

    public function build(): self
    {
        return $this->text("This is a $this->foo foo mailable.");
    }
}
