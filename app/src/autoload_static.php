<?php

class Autoload_Static
{
    public static function files()
    {

        return array(
            
            'SysSoftIntegra\\Model\\BancoAdo' => __DIR__  . '/../model/BancoAdo.php',
            'SysSoftIntegra\\Model\\CapituloAdo' => __DIR__  . '/../model/CapituloAdo.php',
            'SysSoftIntegra\\Model\\ComprobanteAdo' => __DIR__  . '/../model/ComprobanteAdo.php',
            'SysSoftIntegra\\Model\\ConceptoAdo' => __DIR__  . '/../model/ConceptoAdo.php',
            'SysSoftIntegra\\Model\\ConfigEmpresaAdo' => __DIR__  . '/../model/ConfigEmpresaAdo.php',
            'SysSoftIntegra\\Model\\CuotaAdo' => __DIR__  . '/../model/CuotaAdo.php',
            'SysSoftIntegra\\Model\\EmpresaAdo' => __DIR__  . '/../model/EmpresaAdo.php',
            'SysSoftIntegra\\Model\\ImpuestoAdo' => __DIR__  . '/../model/ImpuestoAdo.php',
            'SysSoftIntegra\\Model\\IngresosAdo' => __DIR__  . '/../model/IngresosAdo.php',
            'SysSoftIntegra\\Model\\ListarIngenierosAdo' => __DIR__  . '/../model/ListarIngenierosAdo.php',
            'SysSoftIntegra\\Model\\NotaCreditoAdo' => __DIR__  . '/../model/NotaCreditoAdo.php',
            'SysSoftIntegra\\Model\\PersonaAdo' => __DIR__  . '/../model/PersonaAdo.php',
            'SysSoftIntegra\\Model\\RolAdo' => __DIR__  . '/../model/RolAdo.php',
            'SysSoftIntegra\\Model\\UniversidadAdo' => __DIR__  . '/../model/UniversidadAdo.php',
            'SysSoftIntegra\\Model\\UsuarioAdo' => __DIR__  . '/../model/UsuarioAdo.php',
            'SysSoftIntegra\\Model\\EmpleoAdo' => __DIR__  . '/../model/EmpleoAdo.php',
            'SysSoftIntegra\\Model\\CursoAdo' => __DIR__  . '/../model/CursoAdo.php',

            'SysSoftIntegra\\Src\\Sunat' => __DIR__  . '/Sunat.php',
            'SysSoftIntegra\\Src\\SoapResult' => __DIR__  . '/SoapResult.php',
            'SysSoftIntegra\\Src\\SoapBuilder' => __DIR__  . '/SoapBuilder.php',
            'SysSoftIntegra\\Src\\NumberLleters' => __DIR__  . '/NumberLleters.php',
            'SysSoftIntegra\\Src\\GenerateXml' => __DIR__  . '/GenerateXml.php',
            'SysSoftIntegra\\Pdf\\PdfIngreso' => __DIR__  . '/../pdf/PdfIngreso.php',
            'SysSoftIntegra\\Src\\Tools' => __DIR__  . '/Tools.php',
            'SysSoftIntegra\\Src\\Response' => __DIR__  . '/Response.php',
            'SysSoftIntegra\\DataBase\\Database' => __DIR__  . '/../database/DataBaseConexion.php',
            'Phpspreadsheet\\Vendor\\Autload' => __DIR__ . '/../sunat/lib/phpspreadsheet/vendor/autoload.php',
            'RobRichards\\XMLSecLibs\\XMLSecurityDSig' => __DIR__ . '/../sunat/lib/robrichards/src/XMLSecurityDSig.php',
            'RobRichards\\XMLSecLibs\\XMLSecurityKey' => __DIR__ . '/../sunat/lib/robrichards/src/XMLSecurityKey.php'
        );
    }
}
