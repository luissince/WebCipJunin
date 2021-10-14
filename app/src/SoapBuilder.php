<?php

namespace SysSoftIntegra\Src;

use SoapClient;
use DOMDocument;
use DOMException;

class SoapBuilder extends SoapClient
{
    public $XMLStr = "";

    public function setXMLStr($value)
    {
        $this->XMLStr = $value;
    }
    public function getXMLStr()
    {
        return $this->XMLStr;
    }
    public function __doRequest($request, $location, $action, $version, $one_way = 0)
    {
        $request = $this->XMLStr;
        $dom = new DOMDocument('1.0');
        try {
            $dom->loadXML($request);
        } catch (DOMException $e) {
            die($e->code);
        }
        $request = $dom->saveXML();
        return parent::__doRequest($request, $location, $action, $version, $one_way = 0);
    }
    public function SoapClientCall($SOAPXML)
    {
        return $this->setXMLStr($SOAPXML);
    }

    public function SoapCall($callFunction)
    {
        return $this->__soapCall($callFunction, array());
    }
}
