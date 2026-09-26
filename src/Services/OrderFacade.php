<?php
/**
 * ============================================================================
 *  ORDER FACADE — FACADE (estructural)
 * ============================================================================
 *  Reemplaza a OrderService::procesarPedidoCompleto(), que validaba,
 *  calculaba, guardaba, notificaba, generaba reporte e imprimia HTML,
 *  todo en un solo metodo con mas de 6 responsabilidades.
 *
 *  createOrder() ORQUESTA los servicios que ya existen gracias a los otros
 *  patrones (Strategy, Factory, Observer). No decide reglas de negocio: si
 *  empezara a decidir, dejaria de ser una fachada.
 * ============================================================================
 */
final class OrderFacade
{
    public function __construct(
        private OrderValidator $validator,
        private NotificationSender $notifier,
        private OrderSubject $events
    ) {
    }

    public function createOrder(
        int $id,
        string $paciente,
        float $monto,
        string $tipoPaciente,
        string $tipoNotificacion,
        string $destino
    ): Order {
        $this->validator->validate($paciente, $monto);

        $strategy = PricingStrategyFactory::forPatientType($tipoPaciente);
        $total = (new PriceCalculator($strategy))->calculate($monto);

        $order = new Order($id, $paciente, $total, $tipoPaciente);
        $order->guardar();

        $this->notifier->enviar($tipoNotificacion, $destino, "Pedido {$id} por $ {$total}");
        $this->events->notify($order);

        return $order;
    }
}