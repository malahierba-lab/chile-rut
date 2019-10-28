# Chile Rut

## Introducción

Esta librería permite trabajar con el número de identificación que se utiliza en chile para personas, tanto naturales como jurídicas, pudiendo realizar las tareas de validación y formato.

Se ha desarrollado pensando en **Laravel**.

### Aclaración sobre el alcance

Sólo valida el número de identificación respecto a cumplir con el algoritmo que se utiliza, **no comprueba la existencia real de dicho rut**.

## Instalación

Para instalar esta librería basta con que la agregues a la sección *require* del composer.json de tu proyecto y luego ejecutes *composer update*

Para Laravel 5.x o superior

    "malahierba-lab/chile-rut": "5.1.*"

Para Laravel 4.2

    "malahierba-lab/chile-rut": "4.2.*"

**Importante:** Si estás usando actualmente la versión "dev-master" **debes cambiarlo** por una de las versiones indicadas de acuerdo a la versión de Laravel que estés utilizando.

Luego carga el Service Provider dentro del arreglo *'providers'* del archivo *app/config/app.php*

Para Laravel 5.x

    Malahierba\ChileRut\ChileRutServiceProvider::class

Para Laravel 4.2

    'Malahierba\ChileRut\ChileRutServiceProvider'

Opcionalmente (pero altamente recomendado) puedes crear un alias dentro del archivo *app/config/app.php* en el arreglo 'aliases' para poder invocar las funcionalidades directamente.

Para Laravel 5.x

    'RUT' => Malahierba\ChileRut\Facades\ChileRut::class

Para Laravel 4.2

    'RUT' => 'Malahierba\ChileRut\Facades\ChileRut'

Si no deseas usar un Facade, sino la clase misma, no olvides incorporarlo en la clase donde desees usarlo:

	use Malahierba\ChileRut\ChileRut;

## Utilización

### Validar un rut

Para validar un rut chileno simplemente usas: RUT::check($rut_a_validar). Ej:

    if (RUT::check('12.345.678-9'))
      echo 'es verdadero';
    else
      echo 'es falso';

Recuerda que en caso de no usar el Facade, debes usar la clase misma:

    $chilerut = new ChileRut; //o \Malahierba\ChileRut\ChileRut en caso de que no hayas importado la clase

    if ($chilerut::check('12.345.678-9'))
        echo 'es verdadero';
      else
        echo 'es falso';

### Validar un RUT con Laravel

Ejemplo de validación de petición usando regla de validación personalizada:

```
use Malahierba\ChileRut\ChileRut;
use Malahierba\ChileRut\Rules\ValidChileanRut;

$request->validate([
    'rut' => ['required', 'string', new ValidChileanRut(new ChileRut)],
]);
```

> Ref: [Laravel: Custom Validation Rules](https://laravel.com/docs/validation#custom-validation-rules)

### Calcular dígito verificador

En caso de que tengamos un rut sin digito verificador y necesitemos calcularlo, se usa: RUT::digitoVerificador($rut). Ej:

    $digitoVerificador = RUT::digitoVerificador($rut);

OBS: considerando el caso en que el dígito verificador sea 'K', se determinó que esta función siempre devuelve un string para ser consistentes con su uso y poder realizar comparaciones con mayor control.

## Formatos de RUT soportados

Si tenemos un rut de la forma: x.xxx.xxx-x son soportados los siguientes formatos para trabajar con él:

- x.xxx.xxx-x (con separador de miles y con guión)
- xxxxxxx-x (sin separador de miles y con guión)
- xxxxxxx (sin separador de miles y sin guión)

OBS: Cualquiera sea el formato podrá comenzar con cero(s). Ej: 0x.xxx.xxx-x está soportado.

## Licencia

Esta librería se distribuye con licencia MIT, favor leer el archivo LICENSE para mayor referencia.
