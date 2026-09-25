<?php

/**
 * EJERCICIO 1 (TP): estrategia nueva para paciente de prepaga.
 * Se agrega una clase; PriceCalculator no se modifico para nada.
 * Eso es lo que demuestra que el Strategy quedo bien aplicado (cumple OCP).
 */
final class PrepaidStrategy implements PricingStrategy
{
    public function __construct(private float $discount = 0.15)
    {
    }

    public function calculate(float $amount): float
    {
        return $amount * (1 - $this->discount);
    }
}
