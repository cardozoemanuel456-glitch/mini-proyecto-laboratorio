<?php
/**
 * ============================================================================
 *  NOTIFICACION POR WHATSAPP — Ejercicio 2
 * ============================================================================
 *  Clase nueva. Cumple el mismo contrato que Email y Sms.
 *  Para que el sistema la reconozca, el UNICO archivo que se toca ademas
 *  de este es NotificationFactory.php (una linea nueva en el match).
 * ============================================================================
 */

class WhatsAppNotification implements Notification
{
    public function __construct(private string $numero)
    {
    }

    public function send(string $message): void
    {
        echo "[WHATSAPP] a {$this->numero}: {$message}<br>";
    }
}
