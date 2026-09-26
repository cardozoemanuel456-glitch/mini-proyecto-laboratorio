# Deuda técnica — laboratorio-pedidos

Diagnóstico y refactor realizados para el TP Integrador U1+U2
(Metodología de Sistemas II, 2º cuatrimestre 2026).

| Síntoma observado | Evidencia (archivo:línea, commit original) | Tipo de deuda | Patrón aplicado | Consecuencia asumida |
|---|---|---|---|---|
| `switch` con todos los algoritmos de precio en una sola clase, `0.7` y `0.5` hardcodeados | `src/Pricing/PriceCalculator.php:29-39` (commit `c657de9`) | Diseño (comportamiento) | **Strategy** — `feat/patron-strategy`, PR #1 | 6 clases nuevas (interfaz + 4 estrategias + factory de estrategias) reemplazan un `switch` de 10 líneas. El descuento de obra social sigue duplicado fuera de esta rama, en `Order.php`, `OrderController.php` y `views/orders.php` (no entraron en el alcance de este TP). |
| `if` por tipo de notificación repetido en `NotificationSender`, `OrderService` y `OrderEvents` | `src/Notifications/NotificationSender.php:30-40` (commit `c657de9`) | Diseño (creacional) | **Factory** — `feat/patron-factory`, PR #3 | Se concentra el `if` en un solo archivo (`NotificationFactory`), pero agregar un canal nuevo sigue exigiendo tocar ese archivo. El patrón no elimina el cambio, lo hace previsible y en un único lugar. |
| Avisos al crear un pedido llamados a mano, uno por uno, a clases concretas (`EmailNotification`, `SmsNotification`) | `src/Events/OrderEvents.php:28-36` (commit `c657de9`) | Diseño (comportamiento) | **Observer** — `feat/patron-observer`, PR #2 | Se pierde trazabilidad directa: leyendo `OrderFacade` ya no se ve a simple vista quién se entera del evento; hay que revisar quién está *subscribed*. |
| Método `procesarPedidoCompleto()` con validación, cálculo, persistencia, notificación, eventos y HTML mezclados en un solo lugar | `src/Services/OrderService.php:34-90` (commit `c657de9`) | Diseño (estructural) | **Facade** — `feat/patron-facade`, PR #5 | La complejidad no desaparece: se reparte en 3 clases colaboradoras (`OrderValidator`, `NotificationSender`, `OrderSubject`) que ahora hay que conocer para entender el flujo completo. |
| Un PR (Factory) borró por error las clases concretas `EmailNotification.php`, `SmsNotification.php` y `NotificationSender.php`, dejando `index.php` con `require_once` apuntando a archivos inexistentes | `public/index.php:37-38,41`, detectado al probar `accion=crear` en local | Proceso (revisión de PR) | Corrección vía commit `fix:` propio, PR #4 | Confirma por qué la revisión cruzada de otro integrante importa: el autor no vio el error porque no probó el flujo completo antes de pushear; quien lo detectó fue quien intentó correr la app, no quien leyó el diff. |
| Todo el equipo, en el trabajo previo a este TP, commiteaba directo sobre `main` sin ramas ni revisión | Flujo de trabajo previo del grupo | Proceso (Unidad 1) | Rama por patrón + Pull Request revisado por otro integrante | Cada cambio tarda más en llegar a `main` porque espera revisión. A cambio, ningún integrante pisa el trabajo de otro y el conocimiento del proyecto deja de vivir en una sola cabeza. |
| Historial de commits sin convención (`"arreglo"`, `"ahora sí anda"`) en el trabajo previo | Historial previo del grupo | Proceso (Unidad 1) | Convención `feat:/fix:/refactor:/docs:` | Exige más disciplina al escribir cada commit. A cambio, se puede ubicar en qué commit se rompió una regla de negocio (como pasó con el fix de Factory, que sí quedó identificable). |

## Métrica del proyecto

El descuento de obra social (`0.7`) aparecía **hardcodeado en 5 archivos**
(`Order.php`, `PriceCalculator.php` dos veces, `OrderService.php`,
`OrderController.php`, `views/orders.php`). Después de aplicar Strategy
solo sobre `PriceCalculator.php` (y borrar `OrderService.php` al aplicar
Facade), quedan **3 ocurrencias sueltas**: `Order.php`,
`OrderController.php` y `views/orders.php`. Quedan pendientes para el TP
siguiente, cuando se apliquen Repository y MVC sobre esos archivos.

## Patrones aplicados en este TP

| Rama | PR | Patrón | Tipo | Archivo principal |
|---|---|---|---|---|
| `feat/patron-strategy` | #1 | Strategy | Comportamiento | `src/Pricing/` |
| `feat/patron-observer` | #2 | Observer | Comportamiento | `src/Events/` |
| `feat/patron-factory` | #3 (+ fix #4) | Factory Method | Creacional | `src/Notifications/` |
| `feat/patron-facade` | #5 | Facade | **Estructural** | `src/Services/` |

Con estos 4 patrones se cubre el mínimo exigido por la consigna (al menos
uno estructural: Facade). Los patrones de `src/Legacy/LegacyNotifier.php`
(Adapter, Ej. 3), `src/Reports/ReportGenerator.php` (Decorator, Ej. 4),
`src/Models/Order.php` (Repository) y `src/Controllers/OrderController.php`
+ `views/orders.php` (MVC, Ej. 7 y 8) quedan identificados en
`docs/MAPA-DE-DEUDAS.md` como trabajo pendiente para próximas entregas.
