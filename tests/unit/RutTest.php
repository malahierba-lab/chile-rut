<?php

namespace Malahierba\ChileRut\Tests\Unit;

use Malahierba\ChileRut\Tests\TestCase;
use Malahierba\ChileRut\ChileRut;

class RutTest extends TestCase
{

    /**
     * Verifica la limpieza de formato de RUT
     * @test
     */
    public function it_return_clean_the_format()
    {
        $chilerut = new ChileRut;

        // number - dv
        $this->assertEquals('11111111-1', $chilerut->clean('11.111.111-1'));
        $this->assertEquals('11111111-1', $chilerut->clean('11111111-1'));
        $this->assertEquals('11111111-1', $chilerut->clean('111111111'));
        $this->assertEquals('11111111-1', $chilerut->clean(111111111));
        $this->assertEquals('11111112-K', $chilerut->clean('11.111.112-k'));

        // only number
        $this->assertEquals('11111111', $chilerut->clean('11.111.111', false));
        $this->assertEquals('11111111', $chilerut->clean('11111111', false));
        $this->assertEquals('11111111', $chilerut->clean('11111111', false));

        // left zero
        $this->assertEquals('11111111-1', $chilerut->clean('011.111.111-1'));
        $this->assertEquals('11111111-1', $chilerut->clean('00011.111.111-1'));

        // text
        $this->assertEquals('11111111-1', $chilerut->clean('rut11.111.111-1'));
    }


    /**
     * Verifica que el algoritmo responda correctamente si es un RUT valido o no valido
     * @test
     */
    public function it_verify_rut_correctly()
    {
        $chilerut = new ChileRut;

        // valid
        $this->assertTrue($chilerut->check('11111111-1'));
        $this->assertTrue($chilerut->check('11111112-K'));
        $this->assertTrue($chilerut->check(111111111));

        // invalid
        $this->assertFalse($chilerut->check('11111111-2'));
        $this->assertFalse($chilerut->check('11111112-A'));
        $this->assertFalse($chilerut->check('no_es_rut'));
        $this->assertFalse($chilerut->check('0'));
        $this->assertFalse($chilerut->check(''));
        $this->assertFalse($chilerut->check(null));
    }


    /**
     * Verfica el soporte para distinto número de digitos
     *
     * @test
     */
    public function it_validate_digits_number()
    {
        $chilerut = new ChileRut;

        //supported
        $this->assertTrue($chilerut->check('99.999.999.999-6'));
        $this->assertTrue($chilerut->check('11.111.111.111-8'));
        $this->assertTrue($chilerut->check('1.111.111.111-3'));
        $this->assertTrue($chilerut->check('111.111.111-8'));
        $this->assertTrue($chilerut->check('11.111.111-1'));
        $this->assertTrue($chilerut->check('1.111.111-4'));
        $this->assertTrue($chilerut->check('111.111-6'));
        $this->assertTrue($chilerut->check('11.111-2'));
        $this->assertTrue($chilerut->check('1.111-8'));
        $this->assertTrue($chilerut->check('111-2'));
        $this->assertTrue($chilerut->check('11-6'));
        $this->assertTrue($chilerut->check('1-9'));

        //unsupported
        $this->assertFalse($chilerut->check('1'));
        $this->assertFalse($chilerut->check('100.000.000.000-4'));
        $this->assertFalse($chilerut->check('1.000.000.000.000-9'));
    }


    /**
     * Verifica consistencia entre mayuscula y minisculas
     * @test
     */
    public function it_validate_k_dv()
    {
        $chilerut = new ChileRut;

        //valid
        $this->assertTrue($chilerut->check('11111112-k'));
        $this->assertTrue($chilerut->check('11111112-K'));

        //invalid
        $this->assertFalse($chilerut->check('11111111-K'));
        $this->assertFalse($chilerut->check('11111111-k'));
    }
}