<?php

/**
 * Paciente de obra social. El descuento vive en UN solo lugar del sistema.
 * Antes del refactor, 0.7 estaba escrito a mano en 5 archivos distintos
 * (ver docs/DEUDA-TECNICA.md). Cambiarlo hoy es tocar esta linea, una vez.
 */
final class InsuranceStrategy implements PricingStrategy
{
    public function __construct(private float $discount = 0.30)
    {
    }

    public function calculate(float $amount): float
    {
        return $amount * (1 - $this->discount);
    }
}
