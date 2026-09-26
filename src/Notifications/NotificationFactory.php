<?php
/**
 * ============================================================================
 *  FACTORY DE NOTIFICACIONES
 * ============================================================================
 *  Unico lugar del sistema que sabe que clase concreta corresponde a cada
 *  tipo de notificacion. Antes ese "if por tipo" estaba repetido en
 *  NotificationSender, OrderService y OrderController.
 *
 *  Agregar un tipo nuevo (ej. WhatsApp) implica tocar SOLO este archivo
 *  ademas de la clase nueva.
 * ============================================================================
 */

final class NotificationFactory
{
    public static function create(string $type, string $destino): Notification
    {
        return match ($type) {
            'email'    => new EmailNotification($destino),
            'sms'      => new SmsNotification($destino),
            'whatsapp' => new WhatsAppNotification($destino),
            default    => throw new InvalidArgumentException(
                "Tipo de notificacion no soportado: {$type}"
            ),
        };
    }
}
