<?php

final class NotificationSender
{
    public function enviar(string $tipo, string $destino, string $mensaje): void
    {
        NotificationFactory::create($tipo, $destino)->send($mensaje);
    }
}