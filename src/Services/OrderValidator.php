<?php

final class OrderValidator
{
    public function validate(string $paciente, float $monto): void
    {
        if (trim($paciente) === '') {
            throw new InvalidArgumentException('Falta el paciente');
        }

        if ($monto <= 0) {
            throw new InvalidArgumentException('Monto invalido');
        }
    }
}