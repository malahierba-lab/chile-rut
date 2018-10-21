# Chile RUT

## Introducción

Esta librería permite trabajar con el número de identificación que se utiliza en Chile para personas, tanto naturales como jurídicas, pudiendo realizar las tareas de validación y formato.

Se ha desarrollado pensando en [Laravel](https://laravel.com).

### Aclaración sobre el alcance

Sólo valida el número de identificación respecto a cumplir con el algoritmo que se utiliza, **no comprueba la existencia real de dicho RUT**.

## Instalación

### A travéz de composer

1. Requiere el paquete `malahierba-lab/chile-rut`

  * Para Laravel 5.x
```bash
composer require malahierba-lab/chile-rut
```

  * Para Laravel 4.2.x
```bash
composer require malahierba-lab/chile-rut 4.2
```

2. Ejecuta composer para actualizar dependencias:
```bash
composer install
```
   o
```bash
composer update
```

**Importante:** Si estás usando actualmente la versión `dev-master` **debes cambiarlo** por una de las versiones indicadas de acuerdo a la versión de Laravel que estés utilizando.

### Agregar service provider

Agrega el *Service Provider* dentro del arreglo `providers` del archivo *app/config/app.php*

* Para Laravel 5.x
```php
'providers' => [
  Malahierba\ChileRut\ChileRutServiceProvider::class
],
```
* Para Laravel 4.2
```php
'Malahierba\ChileRut\ChileRutServiceProvider'  
```

### Agregar alias

Opcionalmente (pero altamente recomendado) puedes crear un alias dentro del archivo *app/config/app.php* en el arreglo `aliases` para poder invocar las funcionalidades directamente.

* Para Laravel 5.x
```php
'aliases' => [
  'RUT' => Malahierba\ChileRut\Facades\ChileRut::class  
]
```
* Para Laravel 4.2
```php
'RUT' => 'Malahierba\ChileRut\Facades\ChileRut'
```

Si no deseas usar un _Facade_, sino la clase misma, no olvides incorporarlo en la clase donde desees usarlo:

```php
use Malahierba\ChileRut\ChileRut;
```

## Utilización

### Validar un RUT

Para validar un RUT chileno se usa `RUT::check($rut_a_validar)`. Ej:

```php
if (RUT::check('12.345.678-9'))
  echo 'es verdadero';
else
  echo 'es falso';
```

Recuerda que en caso de no usar el _Facade_, debes usar la clase misma:

```php
$chilerut = new ChileRut; //o \Malahierba\ChileRut\ChileRut en caso de que no hayas importado la clase
if ($chilerut::check('12.345.678-9'))
    echo 'es verdadero';
  else
    echo 'es falso';
```

### Validar un RUT con Laravel

Ejemplo de validación de petición usando regla de validación personalizada:

```php
use Malahierba\ChileRut\ChileRut;
use Malahierba\ChileRut\Rules\ValidChileanRut;

$request->validate([
    'rut' => ['required', 'string', new ValidChileanRut(new ChileRut)],
]);
```

> Ref: [Laravel: Custom Validation Rules](https://laravel.com/docs/validation#custom-validation-rules)

### Calcular dígito verificador

En caso de que tengamos un rut sin dígito verificador y necesitemos calcularlo, se usa: `RUT::digitoVerificador($rut)`. Ej:

```php
$digitoVerificador = RUT::digitoVerificador(12345678);
```

> Obs: En el caso en que el dígito verificador sea `K`, se determinó que esta función siempre retorne un `string` para ser consistentes con su uso y poder realizar comparaciones con mayor control.

## Formatos de RUT soportados

Son soportados los siguientes formatos para trabajar con él:

| Formato     | Descripción                        |
|-------------|------------------------------------|
|`x.xxx.xxx-x`| Con separador de miles y con guión |
|`xxxxxxx-x`  | Sin separador de miles y con guión |
|`xxxxxxx`    | Sin separador de miles y sin guión |

> Obs: Cualquiera sea el formato podrá comenzar con cero(s). Ej: `0x.xxx.xxx-x` está soportado.

## Licencia

Esta librería se distribuye con licencia MIT, favor leer el archivo [LICENSE](LICENSE) para mayor referencia.
