<?php

/**
 * EJERCICIO 5 (TP) resuelto: observador nuevo. Se agrego esta clase y una
 * linea de subscribe() donde se arma el OrderSubject (ver OrderFacade).
 * OrderSubject.php NO se modifico.
 */
final class SmsObserver implements OrderObserver
{
    public function update(Order $order): void
    {
        NotificationFactory::create('sms', '3704000000')
            ->send("Pedido {$order->id} creado");
    }
}
