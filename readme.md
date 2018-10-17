# Bipolar

## Requirements
- Don't forget to setup the analytics `json` file at `storage_path('app/analytics/BipolarWeb-2127e4255dbc.json')`

### Lista de comandos
Este es un listado de los comandos necesarios y su explicación que se tienen que activar en el servidor.

`php artisan carts:unbuyed`: Enviar un correo a los carros que no han finalizado una compra.

`php artisan user:wishlists`: Enviar un correo a los que tengan agregado un producto al wishlist

`php artisan tasks:execute`: Ejecutar tareas de descuento pendientes entre el rango de fechas