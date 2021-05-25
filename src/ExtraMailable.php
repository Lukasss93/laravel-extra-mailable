<?php

namespace Lukasss93\ExtraMailable;

use Closure;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * Trait ExtraMailable
 * @package Lukasss93\ExtraMailable
 * @mixin Mailable
 */
trait ExtraMailable
{
    /** @var callable $emptyRecipients */
    protected $emptyRecipients;

    /** @var callable $beforeSendingMails */
    protected $beforeSendingMails;

    /** @var callable $afterSendingMails */
    protected $afterSendingMails;

    /**
     * Instantiate a Mailable.
     * @param ...$args
     * @return static
     */
    public static function create(...$args): self
    {
        return new self(...$args);
    }

    /**
     * Send mail to selected recipients.
     * @param mixed $to
     */
    public function sendTo($to): void
    {
        if (empty($to)) {

            if ($this->emptyRecipients instanceof Closure) {
                ($this->emptyRecipients)();
            }

            return;
        }

        if (is_string($to)) {
            $to = Str::of($to)->explode(';')->map(fn ($item) => trim($item))->toArray();
        }

        if (!is_iterable($to)) {
            throw new InvalidArgumentException('The $to parameter must be iterable.');
        }

        if ($this->beforeSendingMails instanceof Closure) {
            ($this->beforeSendingMails)();
        }

        foreach ($to as $item) {
            /** @var Mailable $this */
            Mail::to($item)->send($this);
            $this->to = [];
        }

        if ($this->afterSendingMails instanceof Closure) {
            ($this->afterSendingMails)();
        }
    }

    /**
     * Send mail to selected recipients when condition is true.
     * @param bool $condition
     * @param mixed $to
     */
    public function sendToWhen(bool $condition, $to): void
    {
        if ($condition) {
            $this->sendTo($to);
        }
    }

    /**
     * Callback executed if no recipient found.
     * @param callable $callback
     * @return $this
     */
    public function onEmptyRecipients(callable $callback): self
    {
        $this->emptyRecipients = $callback;

        return $this;
    }

    /**
     * Callback executed before sending mail to all recipients.
     * @param callable $callback
     * @return $this
     */
    public function onBeforeSendingMails(callable $callback): self
    {
        $this->beforeSendingMails = $callback;

        return $this;
    }

    /**
     * Callback executed after sending mail to all recipients.
     * @param callable $callback
     * @return $this
     */
    public function onAfterSendingMails(callable $callback): self
    {
        $this->afterSendingMails = $callback;

        return $this;
    }
}
