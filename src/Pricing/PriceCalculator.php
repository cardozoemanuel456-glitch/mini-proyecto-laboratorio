<?php
/**
 * ============================================================================
 *  CALCULO DE PRECIOS — STRATEGY (comportamiento)
 * ============================================================================
 *  Refactor aplicado en la rama feat/patron-strategy.
 *
 *  Antes: un switch con todos los algoritmos de precio adentro de esta clase.
 *  Ahora: PriceCalculator COMPONE una PricingStrategy (no la hereda) y le
 *  delega el calculo. Agregar un tipo de paciente nuevo es agregar una
 *  clase (ver PrepaidStrategy.php), no modificar esta.
 * ============================================================================
 */
final class PriceCalculator
{
    public function __construct(private PricingStrategy $strategy)
    {
    }

    public function calculate(float $amount): float
    {
        return $this->strategy->calculate($amount);
    }

    /**
     * Reemplaza a calcularConIva(). El IVA es una operacion aparte del
     * descuento por tipo de paciente, asi que no vuelve a duplicar el 0.7:
     * simplemente reutiliza calculate().
     */
    public function calculateWithTax(float $amount, float $taxRate = 0.21): float
    {
        return $this->calculate($amount) * (1 + $taxRate);
    }
}
