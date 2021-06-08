<?php

declare(strict_types=1);

use Greenter\Data\DocumentGeneratorInterface;
use Greenter\Data\GeneratorFactory;
use Greenter\Data\SharedStore;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\CdrResponse;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Report\XmlUtils;
use Greenter\See;

include 'GenerateCoinToLetters.php';

final class Util
{
    /**
     * @var Util
     */
    private static $current;
    /**
     * @var SharedStore
     */
    public $shared;

    private function __construct()
    {
        $this->shared = new SharedStore();
    }

    public static function getInstance(): Util
    {
        if (!self::$current instanceof self) {
            self::$current = new self();
        }

        return self::$current;
    }

    public function getSee(?string $endpoint,?string $ruc,?string $usuario,?string $clave)
    {
        $see = new See();
        $see->setService($endpoint);
        //        $see->setCodeProvider(new XmlErrorCodeProvider());
        $certificate = file_get_contents(__DIR__ . '/../resources/cert.pem');
        if ($certificate === false) {
            throw new Exception('No se pudo cargar el certificado');
        }
        $see->setCertificate($certificate);
        /**
         * Clave SOL primario
         * Ruc     = 20191899963
         * Usuario = DEPARTAM
         * Clave   = @Sunatcip1@
         */

         /**
         * Clave SOL secundario
         * Ruc     = 20191899963
         * Usuario = FACTURA1
         * Clave   = Sunat1234
         */
        $see->setClaveSOL($ruc, $usuario, $clave);
        $see->setCachePath(__DIR__ . '/../cache');

        return $see;
    }

    public function showResponse(DocumentInterface $document, CdrResponse $cdr): void
    {
        $filename = $document->getName();

        require __DIR__ . '/../views/response.php';
    }

    public function getErrorResponse($error)
    {
        //         $result = <<<HTML
        //         <h2 class="text-danger">Error:</h2><br>
        //         <b>Código:</b>{$error->getCode()}<br>
        //         <b>Descripción:</b>{$error->getMessage()}<br>
        // HTML;

        //         return $result;
        return json_encode(array(
            "state"=>false,
            "code"=>$error->getCode(),
            "description"=>$error->getMessage()
        ));
    }

    public function writeXml(DocumentInterface $document, ?string $xml): void
    {
        $this->writeFile($document->getName() . '.xml', $xml);
    }

    public function writeCdr(DocumentInterface $document, ?string $zip): void
    {
        $this->writeFile('R-' . $document->getName() . '.zip', $zip);
        $zip = new ZipArchive();
        $zip->open('../files/R-' . $document->getName()  . '.zip');
        $zip->extractTo('../files/');
        $zip->close();
    }

    public function writeFile(?string $filename, ?string $content): void
    {
        if (getenv('GREENTER_NO_FILES')) {
            return;
        }

        $fileDir = __DIR__ . '/../files';

        if (!file_exists($fileDir)) {
            mkdir($fileDir, 0777, true);
        }

        file_put_contents($fileDir . DIRECTORY_SEPARATOR . $filename, $content);
    }

    public function getHashCode(DocumentInterface $document): ?string
    {
        $hash = $this->getHash($document);
        return $hash;
    }

    public function getGenerator(string $type): ?DocumentGeneratorInterface
    {
        $factory = new GeneratorFactory();
        $factory->shared = $this->shared;

        return $factory->create($type);
    }

    /**
     * @param SaleDetail $item
     * @param int $count
     * @return array<SaleDetail>
     */
    public function generator(SaleDetail $item, int $count): array
    {
        $items = [];

        for ($i = 0; $i < $count; $i++) {
            $items[] = $item;
        }

        return $items;
    }

    public function showPdf(?string $content, ?string $filename): void
    {
        $this->writeFile($filename, $content);
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($content));

        echo $content;
    }

    public static function getPathBin(): string
    {
        $path = __DIR__ . '/../vendor/bin/wkhtmltopdf';
        if (self::isWindows()) {
            $path .= '.exe';
        }

        return $path;
    }

    public static function isWindows(): bool
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }

    private function getHash(DocumentInterface $document): ?string
    {
        $see = $this->getSee('','','','');
        $xml = $see->getXmlSigned($document);

        return (new XmlUtils())->getHashSign($xml);
    }


    public function ConvertirNumerosLetras($valor,$simbolo)
    {
        $gcl = new GenerateCoinToLetters();
        return $gcl->getResult($valor,$simbolo);
    }

}
