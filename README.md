#Chile Rut

## Introducción

Esta librería permite trabajar con el número de identificación que se utiliza en chile para personas, tanto naturales como jurídicas, pudiendo realizar las tareas de validación y formato.

Se ha desarrollado pensando en que funcione con **Laravel**.

### Aclaración sobre la validación

Sólo valida el número de identificación respecto a cumplir con el algoritmo que se utiliza, no comprueba la existencia real de dicho rut.

## Instalación

Para instalar esta librería basta con que la agregues a la sección *require* del composer.json de tu proyecto y luego ejecutes *composer update*

    "malahierba-lab/chile-rut": "dev-master"

Luego carga el Service Provider dentro del arreglo *'providers'* del archivo *app/config/app.php*

    'MalahierbaLab\ChileRut\ChileRutServiceProvider'

Opcionalmente (pero altamente recomendado) puedes crear un alias dentro del archivo *app/config/app.php* en el arreglo 'aliases' para poder invocar las funcionalidades directamente.

    'RUT' => 'MalahierbaLab\ChileRut\Facades\ChileRut'

## Utilización

Para validar un rut chileno simplemente usas: RUT::check($rut_a_validar). Ej:

    if (RUT::check('12.345.678-9.))
      echo 'es verdadero';
    else
      echo 'es falso';

## Formatos de RUT soportados

Si tenemos un rut de la forma: x.xxx.xxx-x son soportados los siguientes formatos para trabajar con él:

- x.xxx.xxx-x (con separador de miles y guión)
- xxxxxxx-x (sin separador de miles y guión)
- xxxxxxx (sin separador de miles y sin guión)

OBS: Cualquiera sea el formato podrá comenzar con cero(s). Ej: 0x.xxx.xxx-x está soportado.

## Licencia

Esta librería se distribuye con licencia MIT, favor leer el archivo LICENSE para mayor referencia.