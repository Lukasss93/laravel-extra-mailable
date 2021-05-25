<p align="center">
    <img style="max-height:400px" src="https://banners.beyondco.de/Laravel%20Extra%20Mailable.png?theme=dark&packageManager=composer+require&packageName=lukasss93%2Flaravel-extra-mailable&pattern=bamboo&style=style_1&description=Extra+tools+for+Laravel+Mailables&md=1&showWatermark=0&fontSize=125px&images=mail"/>
</p>

# Laravel Larex

[![Version](https://poser.pugx.org/lukasss93/laravel-extra-mailable/v/stable)](https://packagist.org/packages/lukasss93/laravel-extra-mailable)
[![Downloads](https://poser.pugx.org/lukasss93/laravel-extra-mailable/downloads)](https://packagist.org/packages/lukasss93/laravel-extra-mailable)
![PHP](https://img.shields.io/badge/PHP-%3E%3D%207.4-blue)
![Laravel](https://img.shields.io/badge/Laravel-%3E%3D%207.0-orange)
[![License](https://poser.pugx.org/lukasss93/laravel-extra-mailable/license)](https://packagist.org/packages/lukasss93/laravel-extra-mailable)
![Build](https://img.shields.io/github/workflow/status/Lukasss93/laravel-extra-mailable/run-tests)
[![Coverage](https://img.shields.io/codecov/c/github/lukasss93/laravel-extra-mailable?token=XcLU2ccFQ7)](https://codecov.io/gh/Lukasss93/laravel-extra-mailable)

> Extra tools for Laravel Mailables

## 🚀 Installation

You can install the package using composer

```bash
composer require lukasss93/laravel-extra-mailable
```

## 👓 Usage

1. Add the `ExtraMailable` Trait in your `Mailable` class:

```php
<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Lukasss93\ExtraMailable\ExtraMailable;

class MyMail extends Mailable
{
    use ExtraMailable;

    protected int $value;

    public function __construct(int $value = 0)
    {
        $this->value = $value;
    }

    public function build() 
    {
        return $this->markdown('emails.myview', ['myvalue' => $this->value]);
    }
}
```

2. How to use the trait:

```php
<?php

use App\Mail\MyMail;

// send mail to recipient (string)
MyMail::create()->sendTo('foo@bar.org');

// send mail to recipients (string with semicolon separator)
MyMail::create()->sendTo('foo@bar.org;bar@foo.org');

// send mail to recipients (array)
MyMail::create()->sendTo(['foo@bar.org','bar@foo.org']);

// send mail to recipients (User)
MyMail::create()->sendTo(User::first());

// send mail to recipients (User collection)
MyMail::create()->sendTo(User::all());

// you can pass parameters in the create method
MyMail::create(69)->sendTo('foo@bar.org');

// send mail to recipients when condition is true
MyMail::create()->sendToWhen(true, 'foo@bar.org');

// execute custom code when there is no recipients
MyMail::create()
    ->onEmptyRecipients(fn() => print('No emails sent! No recipient found.'))
    ->sendTo([]);
    
// execute custom code before sending emails
MyMail::create()
    ->onBeforeSendingMails(fn() => print('This message will be printed before sending emails'))
    ->sendTo('foo@bar.org');

// execute custom code after sending emails
MyMail::create()
    ->onBeforeSendingMails(fn() => print('This message will be printed after sending emails'))
    ->sendTo('foo@bar.org');
```

## ⚗️ Testing

```bash
composer test
```

## 📃 Changelog

Please see the [CHANGELOG.md](CHANGELOG.md) for more information on what has changed recently.

## 🏅 Credits

- [Luca Patera](https://github.com/Lukasss93)
- [All Contributors](https://github.com/Lukasss93/laravel-extra-mailable/contributors)

## 📖 License

Please see the [LICENSE.md](LICENSE.md) file for more information.
