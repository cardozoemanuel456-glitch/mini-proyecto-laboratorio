<?php

/**
 * Contrato para cualquier interesado en enterarse de que se creo un pedido.
 * OrderSubject depende de esta interfaz, nunca de las clases concretas.
 */
interface OrderObserver
{
    public function update(Order $order): void;
}
