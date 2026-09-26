# laboratorio-pedidos — proyecto de práctica

Sistema de gestión de pedidos de un laboratorio de análisis clínicos.
**PHP Vanilla, sin frameworks, sin Composer.** Corre en XAMPP o Laragon tal cual está.

> ⚠️ **Este proyecto estaba roto a propósito.**
> Se refactorizaron 4 de los archivos marcados con comentarios `❌ MAL APLICADO`.
> Los que todavía no se tocaron siguen marcados así:
>
> ```php
> // ❌ MAL APLICADO: qué método está mal y qué principio viola
> // ✅ FORMA CORRECTA: qué patrón corresponde y cómo se estructura
> ```

---

## Cómo levantarlo

1. Copiar la carpeta dentro de `C:\xampp\htdocs\` (o `C:\laragon\www\` si usás Laragon).
2. Iniciar Apache (MySQL **no** hace falta, la persistencia está simulada en memoria).
3. Abrir: `http://localhost/mini-proyecto-laboratorio/public/index.php`

Acciones disponibles:

| URL | Qué hace |
|---|---|
| `public/index.php?accion=crear` | Crea un pedido pasando por la deuda todavía sin refactorizar del controlador |
| `public/index.php?accion=crear-facade&tipo=prepaga&canal=whatsapp&destino=3704111111` | Crea un pedido a través de `OrderFacade`, usando **Strategy + Factory + Observer** juntos |
| `public/index.php?accion=listar` | Lista pedidos desde la vista |
| `public/index.php?accion=reporte` | Genera un reporte con banderas booleanas (pendiente de Decorator) |

Parámetros que acepta `crear-facade`: `id`, `paciente`, `monto`,
`tipo` (`particular` / `obra_social` / `jubilado` / `prepaga`),
`canal` (`email` / `sms` / `whatsapp`), `destino`.

---

## Refactor aplicado en este TP (U1 + U2)

Se aplicaron 4 patrones, cada uno en su propia rama y su propio Pull Request:

| Rama | Patrón | Tipo | Archivo principal |
|---|---|---|---|
| `feat/patron-strategy` | Strategy | Comportamiento | `src/Pricing/` |
| `feat/patron-factory` | Factory Method | Creacional | `src/Notifications/` |
| `feat/patron-observer` | Observer | Comportamiento | `src/Events/` |
| `feat/patron-facade` | **Facade** | Estructural | `src/Services/` |

El detalle de qué deuda se encontró, en qué línea, qué patrón se aplicó y
qué consecuencia negativa asume cada solución está en
[`docs/DEUDA-TECNICA.md`](docs/DEUDA-TECNICA.md).

Deuda identificada pero **todavía no refactorizada** (queda para una
próxima entrega): Adapter en `src/Legacy/LegacyNotifier.php` (Ej. 3),
Decorator en `src/Reports/ReportGenerator.php` (Ej. 4), Singleton en
`src/Database/Connection.php`, Repository en `src/Models/Order.php`, y
MVC en `src/Controllers/OrderController.php` + `views/orders.php`
(Ej. 7 y 8).

---

## Mapa de deudas

| Archivo | Síntoma sembrado | Patrón / principio | Ejercicio | Estado |
|---|---|---|---|---|
| `public/index.php` | Requires manuales, credenciales en el código, ruteo con `if` | Autoload + config externa + tabla de rutas | — | Pendiente |
| `src/Database/Connection.php` | Una conexión nueva por consulta; excepción silenciada | **Singleton** | — | Pendiente |
| `src/Pricing/` | `switch` con todos los algoritmos + lógica duplicada | **Strategy** | Ej. 1 | ✅ Resuelto (`feat/patron-strategy`) |
| `src/Notifications/` | `if` por tipo repetido en 3 archivos | **Factory** | Ej. 2 | ✅ Resuelto (`feat/patron-factory`) |
| `src/Legacy/LegacyNotifier.php` | Clase de terceros modificada + copia y pega | **Adapter** | Ej. 3 | Pendiente |
| `src/Reports/ReportGenerator.php` | Parámetros booleanos (`boolean trap`) | **Decorator** | Ej. 4 | Pendiente |
| `src/Events/` | Avisos encadenados a mano a clases concretas | **Observer** | Ej. 5 | ✅ Resuelto (`feat/patron-observer`) |
| `src/Services/` | Método que hace de todo | **Facade** + SRP | Ej. 6 | ✅ Resuelto (`feat/patron-facade`) |
| `src/Controllers/OrderController.php` | SQL + negocio + HTML en el controlador | **MVC** + SRP | Ej. 7 | Pendiente |
| `src/Models/Order.php` | Modelo que se persiste y calcula precios | **Repository** + Strategy | — | Pendiente |
| `views/orders.php` | Consulta, calcula y no escapa la salida | **MVC** | Ej. 8 | Pendiente |

---

## La medida de la deuda de este proyecto

El descuento de obra social (**0.7**) estaba escrito en **cinco archivos
distintos** al empezar. Después de aplicar Strategy y Facade, quedan
**tres**: `src/Models/Order.php`, `src/Controllers/OrderController.php`
y `views/orders.php`. Bajarlo a cero es justamente el trabajo pendiente
de Repository y MVC.

---

## Mecánica de la clase práctica

```
1. Cada grupo toma UN archivo del mapa de deudas.       (5 min)
2. Lee los comentarios ❌ y ✅.                          (5 min)
3. Refactoriza en una rama propia: feat/patron-<nombre>  (20 min)
4. Abre un Pull Request que responda tres cosas:
     - qué deuda encontró (con la línea exacta)
     - qué patrón aplicó y por qué ese y no otro
     - qué consecuencia negativa tiene su propia solución
5. Otro grupo revisa el PR y comenta.                    (10 min)
```

El PR revisado por otro grupo es evidencia del TP Integrador.

---

## Reglas del refactor

- **No se rompe funcionalidad.** Antes y después, la app hace lo mismo.
- **Un patrón por rama.** Nada de una rama con seis cambios mezclados.
- **Se borra el código viejo.** Dejar el método anterior "por las dudas" es
  deuda nueva.
- **Se documenta la consecuencia negativa.** Un patrón sin contras analizadas
  es sobreingeniería esperando su turno.
