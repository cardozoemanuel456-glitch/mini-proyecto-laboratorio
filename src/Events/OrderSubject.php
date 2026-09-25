<?php
/**
 * ============================================================================
 *  AVISOS AL CREARSE UN PEDIDO — OBSERVER (comportamiento)
 * ============================================================================
 *  Refactor aplicado en la rama feat/patron-observer. Reemplaza a la vieja
 *  OrderEvents::pedidoCreado(), que llamaba a mano a EmailNotification,
 *  SmsNotification y al dashboard, una detras de otra.
 *
 *  OrderSubject conoce la interfaz OrderObserver, nunca las clases
 *  concretas. Sumar un aviso nuevo es sumar una clase + un subscribe(),
 *  sin tocar este archivo.
 * ============================================================================
 */
final class OrderSubject
{
    /** @var OrderObserver[] */
    private array $observers = [];

    public function subscribe(OrderObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    public function notify(Order $order): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($order);
        }
    }
}
