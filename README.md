# Manual de Usuario: HalalFlash Theme

**Versión del Tema:** 5.4
**Descripción:** Plantilla personalizada para sitio de noticias HalalFlash.
**Autor:** Zumito

## Introducción
**HalalFlash** es un tema de WordPress diseñado para sitios de alto contenido editorial. Su característica principal es una **Grilla de Noticias Destacada** en la portada que organiza visualmente los últimos 5 artículos de una categoría específica.

## Características Clave
* **Grilla Dinámica:** Muestra 1 noticia principal grande y 4 laterales automáticamente.
* **Cabecera Informativa:** Barra superior con fecha/hora automática y widgets.
* **Gestión de Redes Sociales:** Integración nativa sin plugins adicionales.
* **Sitios Relacionados:** Módulo en el pie de página para enlaces externos.
* **Diseño Responsivo:** Adaptado a móviles y tablets.

# Instalación y Activación

## Requisitos
* WordPress 6.0 o superior.
* PHP 7.4 o superior.

## Pasos de Instalación
1. Descargue el archivo `.zip` del tema HalalFlash.
2. En su panel de administración, vaya a **Apariencia > Temas**.
3. Haga clic en **Añadir nuevo** > **Subir tema**.
4. Seleccione el archivo y proceda a instalar.
5. **Active** el tema.

## Configuración Inicial Recomendada
Una vez activado, se recomienda:
1. Crear una categoría llamada "Portada" o "Destacados" (para la grilla).
2. Asignar el menú principal en **Apariencia > Menús**.
3. Configurar los widgets básicos en la barra lateral.

# Personalización del Tema

Todas las opciones visuales y funcionales se gestionan desde **Apariencia > Personalizar**.

## 1. Grid de Noticias (Portada)
Esta es la sección más importante para la página de inicio.
* **Ubicación:** Panel "Grid de Noticias".
* **Categoría a mostrar:** Seleccione la categoría de la cual el tema extraerá las 5 noticias para la grilla principal.
    * *Nota:* Si no selecciona ninguna, mostrará las últimas 5 entradas de todo el blog.
    * **Orden:** La noticia más reciente ocupará el espacio grande (Big), seguida por las dos de la izquierda y luego las dos de la derecha.

## 2. Redes Sociales
Configure los iconos que aparecen en la esquina superior derecha (barra roja).
* **Ubicación:** Panel "Redes Sociales".
* **Redes sociales dinámicas:** Use el botón "Añadir elemento" para agregar una red.
    * **Icono:** Seleccione de la lista (Facebook, Instagram, TikTok, WhatsApp, X, YouTube, LinkedIn, Email, Teléfono).
    * **URL:** Enlace a su perfil.

## 3. Sitios Relacionados (Footer)
Gestiona los enlaces con iconos que aparecen en la parte inferior del sitio.
* **Ubicación:** Panel "Sitios Relacionados".
* **Funcionalidad:** Similar a las redes sociales, permite añadir enlaces de interés (ej. "Sitio Web", "Noticia", "Empresa") que se mostrarán en una fila horizontal antes del copyright.

## 4. Control del Blog
Ajustes para el listado de noticias que aparece *debajo* de la grilla.
* **Ubicación:** Panel "Control del Blog".
* **Mostrar listado del blog:** Casilla para ocultar/mostrar la lista cronológica de noticias. Desactívela si solo desea mostrar la grilla y widgets.
* **Artículos por página:** Define cuántas noticias se muestran en la paginación de la home (por defecto 10).

# Áreas de Contenido: Menús y Widgets

## Menús
El tema soporta una ubicación de menú principal:
* **Ubicación:** "Menú Principal" (`main_menu`).
* **Visualización:**
    * **Escritorio:** Barra de navegación horizontal debajo del logo.
    * **Móvil:** Menú desplegable tipo acordeón (botón hamburguesa).

## Áreas de Widgets (Sidebars)
El tema cuenta con 5 zonas de widgets gestionables desde **Apariencia > Widgets**:

### 1. Barra Superior (Header) (`top_header_widget`)
* **Ubicación:** Centro de la franja roja superior.
* **Uso recomendado:** Texto corto o widgets de terceros (ej. selector de idiomas GTranslate).
* **Estilo:** El tema aplica automáticamente un fondo blanco sutil y esquinas redondeadas a los elementos aquí ubicados.

### 2. Sidebar Principal (`main_sidebar`)
* **Ubicación:** Columna derecha en la portada, archivos y páginas internas (excepto si la plantilla lo oculta).
* **Uso:** Buscador, Categorías, Posts recientes, Calendario.
* **Estilo:** Títulos con subrayado rojo y cajas con sombra.

### 3. Footer 1, 2 y 3
* **Ubicación:** Tres columnas en el pie de página (fondo azul).
* **Uso:** Menús de navegación secundarios, texto legal o contacto.

# Gestión Editorial

## Cómo funciona la Grilla de Portada
La grilla de la página de inicio es automática y se basa en la fecha de publicación.

1. **Requisito:** La entrada debe tener una **Imagen Destacada** asignada.
2. **Categoría:** Asegúrese de marcar la categoría que configuró en el Personalizador (ej. "Destacados").
3. **Posiciones:**
    * **Posición 1 (Grande Central):** Es el último post publicado en esa categoría.
    * **Posiciones 2 y 3 (Columna Izquierda):** Son el 2º y 3º posts más recientes.
    * **Posiciones 4 y 5 (Columna Derecha):** Son el 4º y 5º posts más recientes.

## Artículos Relacionados
Al final de cada noticia individual (`single.php`), el tema muestra automáticamente un bloque "Te puede interesar".
* **Lógica:** Muestra 3 noticias de la misma categoría que la noticia actual.
* **Exclusión:** No repetirá la noticia que el usuario está leyendo.

## Páginas Estáticas
Las páginas (como "Quiénes Somos" o "Contacto") tienen un diseño con barra lateral derecha (`sidebar`).
* Si desea una página de ancho completo, asegúrese de no colocar widgets en la "Sidebar Principal" (aunque esto afectará a todo el sitio), o requiera una modificación técnica del archivo `page.php`.

## Fecha y Hora
No necesita configurar la fecha y hora de la barra superior; esta se genera automáticamente mediante JavaScript en el navegador del visitante, mostrando la hora local del usuario.

