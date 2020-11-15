<?php

/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 10/03/2019
 * Time: 21:45
 */

declare(strict_types=1);

namespace Greenter\Data;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;

class SharedStore
{
    public function getCompany($ruc,$nomcomercial,$razonsocial,$ubigeo,$departamento,$provincia,$distrito,$direccion,$telefono,$email): Company
    {
        return (new Company())
            ->setRuc($ruc)
            ->setNombreComercial($nomcomercial)
            ->setRazonSocial($razonsocial)
            ->setAddress((new Address())
                ->setUbigueo($ubigeo)
                ->setDistrito($distrito)
                ->setProvincia($provincia)
                ->setDepartamento($departamento)
                ->setUrbanizacion('')
                ->setCodLocal('0000')
                ->setDireccion($direccion))
            ->setEmail($telefono)
            ->setTelephone($email);
    }

    public function getClientPerson(): Client
    {
        $client = new Client();
        $client->setTipoDoc('1')
            ->setNumDoc('48285071')
            ->setRznSocial('NIPAO GUVI')
            ->setAddress((new Address())
                ->setDireccion('Calle fusión 453, SAN MIGUEL - LIMA - PERU'));

        return $client;
    }

    public function getClient(): Client
    {
        $client = new Client();
        $client->setTipoDoc('1')
            ->setNumDoc('75801515')
            ->setRznSocial('CORREA GAMARRA RAHAMSIS WILLIAMS')
            ->setAddress((new Address())
                ->setDireccion(''))
            ->setEmail('client@corp.com')
            ->setTelephone('01-445566');

        return $client;
    }

    public function getClientRuc(): Client
    {
        $client = new Client();
        $client->setTipoDoc('6')
            ->setNumDoc('10467654981')
            ->setRznSocial('YARANGA QUISPE ALEXANDER ANDERSON')
            ->setAddress((new Address())
                ->setDireccion(''))
            ->setEmail('client@corp.com')
            ->setTelephone('01-445566');

        return $client;
    }

    public function getSeller(): Client
    {
        $client = new Client();
        $client->setTipoDoc('1')
            ->setNumDoc('44556677')
            ->setRznSocial('VENDEDOR 1')
            ->setAddress((new Address())
                ->setDireccion('AV INFINITE - LIMA - LIMA - PERU'));

        return $client;
    }
}
