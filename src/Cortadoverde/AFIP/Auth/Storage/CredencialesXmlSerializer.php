<?php

namespace Cortadoverde\AFIP\Auth\Storage;

use Cortadoverde\AFIP\Auth\Credenciales;

/**
 * Serializador para credenciales simple, en formato XML.
 */
class CredencialesXmlSerializer
{
    public function parse($raw_credenciales)
    {
        $xml = new \SimpleXmlElement($raw_credenciales);

        return new Credenciales(
            $xml->token . "",
            $xml->sign . "",
            new \DateTimeImmutable($xml->generationTime),
            new \DateTimeImmutable($xml->expirationTime)
        );
    }

    public function serialize($credenciales)
    {
        $xmlRoot = <<<XML
<?xml version='1.0'?>
<credenciales/>
XML;

        $xml = new \SimpleXmlElement($xmlRoot);

        $xml->addChild('token', $credenciales->getToken());
        $xml->addChild('sign', $credenciales->getSign());
        $xml->addChild(
            'generationTime',
            $credenciales->getGenerationTime()->format(\DateTime::W3C)
        );
        $xml->addChild(
            'expirationTime',
            $credenciales->getExpirationTime()->format(\DateTime::W3C)
        );

        return $xml->asXml();
    }
}
