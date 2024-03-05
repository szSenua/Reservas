## Aplicación de Gestión de Reservas y Disponibilidad de Mesas para Restaurantes de Comida Rápida

### Descripción
Esta aplicación web desarrollada en PHP está diseñada para la gestión de reservas y disponibilidad de mesas en una sociedad de restaurantes de comida rápida. Permite a los clientes reservar mesas especificando el restaurante, día y hora, seleccionando una mesa disponible y proporcionando su correo electrónico.

### Funcionalidades Principales
- **Reserva de Mesas**: Los clientes pueden reservar mesas especificando el restaurante, día y hora, seleccionando una mesa disponible y proporcionando su correo electrónico.
- **Disponibilidad de Mesas**: Los jefes de sala pueden consultar la disponibilidad de mesas en un restaurante para un plazo de tiempo determinado.
- **Gestión de Reservas**: Los jefes de sala pueden revisar y anular reservas caducadas, actualizar el estado de una mesa y liberar todas las reservas prescritas en un momento dado.
- **Sugerencias de Restaurantes**: Si no hay mesas disponibles en un restaurante, se sugieren otros restaurantes de la cadena con mesas libres.

### Base de Datos
La aplicación se apoya en una base de datos llamada MIMESA, que consta de dos tablas: MESA y RESERVAS.

### Autenticación
Los jefes de sala deben autenticarse para acceder a las funcionalidades de gestión de mesas. Los usuarios básicos pueden reservar sin autenticación.

### Requisitos Técnicos
- PHP para el backend.
- Base de datos MySQL.
- Sesiones para garantizar la autenticación.

### Estructura Modular
La aplicación utiliza programación modular para facilitar su mantenimiento y escalabilidad.

### Páginas Principales
- **mimesa.php**: Página de inicio con un menú de funcionalidades para clientes y jefes de sala.
- **Otros scripts**: Enlazados entre sí para proporcionar las diferentes funcionalidades de reserva y gestión de mesas.

### Instrucciones de Configuración
1. Importar la base de datos utilizando el script TABLAS_MIMESA.sql.
2. Configurar el entorno de PHP y la conexión a la base de datos.
3. Asegurarse de que las sesiones están habilitadas para la autenticación.

### Notas Adicionales
- La aplicación solo muestra fechas de reserva en los dos meses siguientes a la fecha actual.
- Se utiliza un archivo horas_comidas.txt para las horas de reserva.
- Las reservas caducan después de veinte minutos de la fecha y hora de reserva de la mesa.
