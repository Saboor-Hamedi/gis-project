<?php

declare(strict_types=1);

namespace blog\services;

class Message
{
    const MESSAGE_SESSION_KEY = 'flash_message';
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    public function setMessage(string $text, string $type = 'info'): void
    {
        $message = ['text' => $text, 'type' => $type];
        $this->session->set(self::MESSAGE_SESSION_KEY, $message);
    }

    public function getMessage(): ?array
    {
        $message = $this->session->get(self::MESSAGE_SESSION_KEY);
        if ($message) {
            $this->session->remove(self::MESSAGE_SESSION_KEY);
            return $message;
        }
        return null;
    }

    public function displayMessage(): void
    {
        $message = $this->getMessage();
        if ($message) {
            echo "<div class='alert alert-{$message['type']}'>{$message['text']}</div>";
        }
    }

    public function messageWithRoute(string $route, string $text, string $type = 'info'): void
    {
        $this->setMessage($text, $type);
        header("Location: $route");
        exit();
    }
}
