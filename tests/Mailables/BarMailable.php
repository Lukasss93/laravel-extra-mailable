<?php

namespace Lukasss93\ExtraMailable\Tests\Mailables;

use Illuminate\Mail\Mailable;
use Lukasss93\ExtraMailable\ExtraMailable;

class BarMailable extends Mailable
{
    use ExtraMailable;

    public function __construct()
    {
        //
    }

    public function build(): self
    {
        return $this->text("This is a bar mailable.");
    }
}
