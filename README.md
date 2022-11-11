# Sistema de Evaluacion y Acreditacion de las Carreras
## Agregar el archico con las variables de entorno
El archivo .env se debe ubicar en la ruta ```/config/.env``` con la siguiente estructura:

```env
# el tipo de base de datos pgsql por defecto que es la DB de postgres
DRIVER=pgsql
HOST=
DBNAME=
DBUSER=
PORTDB=
PASSDATABASE=
HOST_MAIL=
MAIL_DIRECCION=
MAIL_PASSWORD=
MAIL_PUERTO=
# Esta varable tiene que estar relaciona con los usurios que van a estar inscritos como el director de planeamiento
# o el administrador que perteneceran por defecto a una faulta y carrera que se llame TICS o como se prefiera
# se debe informar en la siguiente variable y asegurarse que existe en la base de datos
DEFAULTCARRERA=
DEFAULTFACULTAD=
```
## Como utilizar los iconos de bootstrap
La manera mas facil de utilizar los iconos de bootstrap es con un svg donde lo unico que cambia para poder utilizar los direferente iconos en el opcion de ``` <use xlink:href="/public/assets/img/bootstrap-icons.svg#(filetype-pdf) esto cambia por el nombre del icono"/>```

```html
<svg class="bi" width="32" height="32" fill="currentColor"><use xlink:href="/public/assets/img/bootstrap-icons.svg#filetype-pdf"/></svg>
```


