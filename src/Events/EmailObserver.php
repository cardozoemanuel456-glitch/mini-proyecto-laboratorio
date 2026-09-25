<?php

final class EmailObserver implements OrderObserver
{
    public function update(Order $order): void
    {
        NotificationFactory::create('email', 'paciente@mail.com')
            ->send("Pedido {$order->id} creado");
    }
}
