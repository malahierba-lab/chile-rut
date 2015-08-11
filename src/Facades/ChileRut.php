<?php namespace Malahierba\ChileRut\Facades;
 
use Illuminate\Support\Facades\Facade;
 
class ChileRut extends Facade {
 
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor() { return 'chilerut'; }
 
}