<?php
/**
 * ============================================================================
 *  CONTRATO COMUN DE NOTIFICACIONES
 * ============================================================================
 *  Antes: EmailNotification::enviarEmail() y SmsNotification::mandarSms()
 *  no compartian firma. Por eso quien las usaba necesitaba un if por tipo.
 *
 *  Ahora: todas cumplen el mismo contrato. Quien envia un mensaje ya no
 *  necesita saber si es email, sms o whatsapp.
 * ============================================================================
 */

interface Notification
{
    public function send(string $message): void;
}
