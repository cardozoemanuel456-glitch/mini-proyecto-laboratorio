<?php

final class EmailNotification implements Notification
{
    public function __construct(private string $to)
    {
    }

    public function send(string $message): void
    {
        echo "[EMAIL] para {$this->to} | Pedido del laboratorio: {$message}<br>";
    }
}