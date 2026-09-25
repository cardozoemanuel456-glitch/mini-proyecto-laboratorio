<?php

/**
 * Unico lugar del sistema que traduce el string "tipoPaciente" (que llega
 * desde el formulario) a una PricingStrategy concreta.
 *
 * Antes del refactor este mismo if/switch estaba repetido en Order.php,
 * PriceCalculator.php (dos veces), OrderService.php, OrderController.php
 * y views/orders.php. Ahora esos archivos llaman a este metodo en vez de
 * repetir la regla.
 */
final class PricingStrategyFactory
{
    public static function forPatientType(string $patientType): PricingStrategy
    {
        return match ($patientType) {
            'obra_social' => new InsuranceStrategy(),
            'jubilado'    => new RetireeStrategy(),
            'prepaga'     => new PrepaidStrategy(),
            default       => new PrivatePatientStrategy(),
        };
    }
}
