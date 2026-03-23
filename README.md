<p align="center">
  <img src="assets/img/Logo.png" alt="Logo Supermercado Piolín" width="120">
</p>

<h1 align="center">🛒 Sistema de Gestión de Inventario & E-commerce Full Stack</h1>

<p align="center">
  <strong>Aplicación web integral para la administración de inventarios, logística de transporte y comercio electrónico de un supermercado real.</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-MariaDB-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
  <img src="https://img.shields.io/badge/JavaScript-ES6-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript">
  <img src="https://img.shields.io/badge/XAMPP-Local%20Server-FB7A24?style=for-the-badge&logo=xampp&logoColor=white" alt="XAMPP">
</p>

---

## 📋 Tabla de Contenidos

- [Contexto del Proyecto](#-contexto-del-proyecto)
- [Sobre el Autor](#-sobre-el-autor)
- [Stack Tecnológico](#-stack-tecnológico)
- [Arquitectura y Seguridad](#-arquitectura-y-seguridad)
- [Funcionalidades Clave](#-funcionalidades-clave)
- [Modelo de Base de Datos](#-modelo-de-base-de-datos)
- [Guía de Instalación](#-guía-de-instalación)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [Capturas de Pantalla](#-capturas-de-pantalla)
- [Roadmap](#-roadmap)
- [Contacto](#-contacto)

---

## 🏪 Contexto del Proyecto

Este software nace como una **solución tecnológica real** diseñada para digitalizar las operaciones de mi negocio familiar, **Supermercado Piolín**, un comercio minorista con inventario físico activo.

A diferencia de un proyecto académico teórico, esta plataforma enfrenta **problemas reales de negocio**:

- Control de inventario con descuento automático de stock por cada venta procesada.
- Generación de facturas electrónicas con trazabilidad completa.
- Gestión de flota de transporte (conductores, vehículos, calificaciones).
- Experiencia de compra E-commerce con carrito, checkout de dos columnas y confirmación visual de marca.

> **💡 Impacto:** El proyecto demuestra la capacidad de identificar una necesidad real, diseñar una solución técnica desde cero y llevarla a producción en un entorno local funcional.

---

## 👨‍💻 Sobre el Autor

| Campo | Detalle |
|-------|---------|
| **Nombre** | Brayan David García |
| **Formación Actual** | 🎓 Tecnólogo en Análisis y Desarrollo de Software (ADSO) — **SENA** |
| **Título Previo** | 🏅 Técnico en Desarrollo de Software — **SENA** |
| **Cadena de Formación** | Técnico → Tecnólogo ADSO (en curso) |
| **Objetivo** | Contrato de Aprendizaje en una empresa del sector TI |
| **Correo** | brayandavid1720@gmail.com |

> Mi trayectoria de formación en cadena (Técnico → Tecnólogo) en el SENA me ha permitido consolidar bases sólidas tanto en la lógica de programación como en el desarrollo de aplicaciones web completas, pasando de la teoría a la implementación de soluciones con impacto real.

---

## 🛠 Stack Tecnológico

### Frontend
| Tecnología | Uso |
|------------|-----|
| **HTML5 Semántico** | Estructura accesible y SEO-friendly |
| **CSS3 + Variables Nativas** | Sistema de diseño con paleta corporativa (`--primary`, `--dark-nav`) |
| **Bootstrap 5.3** | Framework responsivo, Grid System, componentes interactivos |
| **Bootstrap Icons** | Iconografía vectorial profesional |
| **Google Fonts** | Tipografía premium (Montserrat + Inter) |
| **JavaScript ES6** | Sidebar colapsable, animaciones, validaciones de formulario |

### Backend
| Tecnología | Uso |
|------------|-----|
| **PHP 8.x** | Lógica de negocio, control de sesiones, procesamiento de formularios |
| **MySQLi (Procedural + OOP)** | Consultas preparadas, transacciones ACID, manejo de excepciones |

### Base de Datos
| Tecnología | Uso |
|------------|-----|
| **MariaDB 10.4** | Motor relacional con soporte para Foreign Keys (InnoDB) |
| **phpMyAdmin 5.2** | Administración visual del esquema relacional |

### Entorno de Desarrollo
| Tecnología | Uso |
|------------|-----|
| **XAMPP** | Servidor local Apache + MariaDB |
| **Git** | Control de versiones |

---

## 🏗 Arquitectura y Seguridad

### Estructura Modular MVC-Inspirada

El proyecto fue reestructurado profesionalmente siguiendo principios de **separación de responsabilidades**:

```
📦 Arquitectura de Capas
├── config/          → Capa de Configuración (conexión única a BD)
├── includes/        → Capa de Presentación (plantillas reutilizables)
│   ├── header.php         → Layout para clientes (Tienda)
│   ├── footer.php         → Cierre global de layouts
│   ├── admin_header.php   → Layout exclusivo Dashboard (Sidebar)
│   └── admin_footer.php   → Scripts y cierre del Dashboard
├── productos/       → Capa de Lógica de Negocio (Carrito, Checkout, Pagos)
├── gestion_productos/→ Capa CRUD Administrativa (ABM de inventario)
└── assets/          → Recursos estáticos organizados (CSS, JS, IMG)
```

### Medidas de Seguridad Implementadas

| Medida | Implementación |
|--------|---------------|
| **Prepared Statements** | Todas las consultas críticas usan `mysqli_prepare()` y `bind_param()` para prevenir SQL Injection |
| **Escape de Caracteres** | `htmlspecialchars()` en toda salida HTML para evitar XSS |
| **Sanitización de Inputs** | `mysqli_real_escape_string()` en formularios de inserción/edición |
| **Validación de Sesión por Rol** | Middleware de autenticación que bloquea las vistas administrativas si no se tiene rol `empleado` |
| **Transacciones ACID** | El proceso de compra usa `mysqli_begin_transaction()` con `rollback` automático ante fallos |
| **Protección de Integridad Referencial** | Captura del error MySQL `1451` para evitar eliminación de productos con historial de ventas |
| **Charset UTF-8mb4** | Soporte completo para caracteres especiales y emojis en toda la cadena |

---

## ⚡ Funcionalidades Clave

### 🛍️ Módulo de Tienda (Clientes)
- ✅ Landing Page dinámica con productos recientes extraídos de la BD
- ✅ Catálogo interactivo con tarjetas hover y botones de compra
- ✅ Vista de detalle de producto a dos columnas (imagen + ficha técnica)
- ✅ Carrito de compras con sesiones PHP (agregar, incrementar, vaciar)
- ✅ Checkout moderno: resumen de compra + formulario de envío
- ✅ Animación de marca corporativa ("Pedido en Camino") con fade-out a factura
- ✅ Historial de compras personal con consultas `INNER JOIN`
- ✅ Generación de reportes PDF

### 📊 Dashboard Administrativo (Empleados)
- ✅ Panel de control exclusivo con Sidebar oscuro profesional
- ✅ Sidebar retráctil (colapsable con botón `☰` en escritorio y móvil)
- ✅ CRUD completo de productos (Crear, Leer, Editar, Eliminar con protección FK)
- ✅ Subida de imágenes con soporte para JPG, PNG, GIF y **WebP**
- ✅ Renombramiento único automático de archivos (`uniqid()`)
- ✅ Gestión de transportadores (registrar, editar, sistema de calificación por estrellas)
- ✅ Descuento automático de stock por cada compra procesada

### 🔐 Autenticación y Roles
- ✅ Sistema de login diferenciado: clientes vs. empleados
- ✅ Registro de nuevos clientes desde formulario público
- ✅ Redirección inteligente según rol al iniciar sesión
- ✅ Protección de rutas administrativas mediante validación de sesión

---

## 🗄 Modelo de Base de Datos

La base de datos `proyecto_ventas` implementa un esquema relacional normalizado con **6 tablas** interconectadas mediante llaves foráneas:

```
┌──────────────────┐     ┌──────────────────┐
│     cliente       │     │     empleado      │
│──────────────────│     │──────────────────│
│ PK: numIdentif.  │     │ PK: identificac. │
│    nombres        │     │    nombres        │
│    apellidos      │     │    telefono       │
│    telefono       │     │    email          │
│    correo         │     │    contraseña     │
│    contraseña     │     │    ROL            │
│    ROL            │     └──────────────────┘
└────────┬─────────┘              │
         │ FK                     │ FK
         ▼                        ▼
┌──────────────────────────────────────────┐
│                  venta                    │
│──────────────────────────────────────────│
│ PK: numeroFactura                        │
│    fechaVenta, metodoPago, estado         │
│    comentarios, FK_Cliente, FK_Empleado   │
│    FK_IdTransportador                     │
└────────────────────┬─────────────────────┘
                     │ FK
                     ▼
┌──────────────────────────────────────────┐
│             producto_venta                │
│──────────────────────────────────────────│
│ PK: idProductoVenta                      │
│    FK_NumeroFactura → venta              │
│    FK_CodigoBarras  → producto           │
│    cantidad                              │
└────────────────────┬─────────────────────┘
                     │ FK
                     ▼
┌──────────────────┐     ┌──────────────────┐
│     producto      │     │  transportador   │
│──────────────────│     │──────────────────│
│ PK: codigoBarras │     │ PK: idTransport. │
│    nombre         │     │    nombre         │
│    categoria      │     │    telefono       │
│    precio         │     │    correo         │
│    stock          │     │    vehiculo       │
│    descripcion    │     │    placa          │
│    imagen         │     │    calificacion   │
└──────────────────┘     └──────────────────┘
```

---

## 🚀 Guía de Instalación

### Prerrequisitos

- [XAMPP](https://www.apachefriends.org/) (Apache + MariaDB + PHP 8.x)
- Navegador web moderno (Chrome, Firefox, Edge)
- [Git](https://git-scm.com/) (opcional, para clonar)

### Pasos

**1. Clonar el repositorio**
```bash
cd C:\xampp\htdocs
git clone https://github.com/brayan11-ga/Proyecto-Piolin.git PROYECTO
```

**2. Importar la base de datos**
```
1. Abrir XAMPP → Iniciar Apache y MySQL
2. Ir a http://localhost/phpmyadmin
3. Crear nueva base de datos: "proyecto_ventas"
4. Pestaña "Importar" → Seleccionar archivo:
   📂 PROYECTO/DataBase/proyecto_ventas.sql
5. Click en "Continuar"
```

**3. Verificar la conexión**

El archivo de configuración se encuentra en `config/conexion.php`:
```php
$host     = "localhost";
$usuario  = "root";
$password = "";          // Password por defecto de XAMPP
$database = "proyecto_ventas";
```

**4. Acceder a la aplicación**
```
🌐 Tienda:      http://localhost/PROYECTO/
🔐 Admin Login: http://localhost/PROYECTO/ingresar/ingresar.php
```

| Rol | Credenciales de Prueba |
|-----|----------------------|
| **Admin** | brayandavid1720@gmail.com / `200617el` |
| **Cliente** | laura.martinez@example.com / `clave123` |

---

## 📁 Estructura del Proyecto

```
PROYECTO/
├── 📂 acerca/                → Página "Acerca de" (empresa)
├── 📂 admin/                 → Panel principal del Dashboard
├── 📂 agregar_productos/     → Formularios e inserción de productos
├── 📂 assets/
│   ├── css/main.css          → Hoja de estilos maestra
│   ├── img/                  → Repositorio de imágenes (productos + UI)
│   └── js/                   → Scripts (sidebar, ocultar, interacciones)
├── 📂 cerrar_sesion/         → Destrucción segura de sesión
├── 📂 config/
│   └── conexion.php          → Archivo centralizado de conexión a BD
├── 📂 DataBase/
│   └── proyecto_ventas.sql   → Dump completo del esquema + datos de prueba
├── 📂 formulario/            → Registro de nuevos clientes
├── 📂 gestion_productos/     → CRUD productos, transportadores, edición
├── 📂 includes/              → Plantillas compartidas (header, footer, admin)
├── 📂 ingresar/              → Login con validación de roles
├── 📂 pdf/                   → Motor de generación de reportes PDF
├── 📂 productos/             → Catálogo, detalle, carrito, checkout, factura
├── 🌐 index.php              → Landing Page principal
├── 📄 .gitignore             → Exclusiones de Git
└── 📄 README.md              → Este archivo
```

---

## 🗺 Roadmap (Próximos Pasos)

Mejoras planificadas que demuestran visión a futuro y capacidad de evolución del producto:

| Prioridad | Mejora | Descripción |
|-----------|--------|-------------|
| 🔴 Alta | **Hashing de Contraseñas** | Migrar a `password_hash()` y `password_verify()` con algoritmo bcrypt |
| 🔴 Alta | **Panel de Ventas en Dashboard** | Gráficas de ingresos mensuales usando Chart.js o ApexCharts |
| 🟡 Media | **Búsqueda en Tiempo Real** | Implementar buscador AJAX con autocompletado en el catálogo |
| 🟡 Media | **Notificaciones de Stock Bajo** | Alertas automáticas cuando un producto baje de cierto umbral |
| 🟢 Baja | **Pasarela de Pagos Real** | Integración con MercadoPago, PayU o ePayco |
| 🟢 Baja | **API RESTful** | Exponer endpoints JSON para consumo desde aplicaciones móviles |
| 🟢 Baja | **Migración a MVC** | Refactorizar hacia un patrón MVC formal o framework (Laravel) |

---

## 📞 Contacto

<p align="center">
  <strong>Brayan David García</strong><br>
  Técnico en Desarrollo de Software | Tecnólogo ADSO (SENA) — En formación<br><br>
  📧 brayandavid1720@gmail.com<br>
  📱 304 413 9270
</p>

---

<p align="center">
  <sub>Desarrollado con ❤️ y PHP por Brayan David García — 2025</sub>
</p>
