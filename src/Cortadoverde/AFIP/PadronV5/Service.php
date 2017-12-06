<?php

namespace Cortadoverde\AFIP\PadronV5;

use Cortadoverde\AFIP\Padron;

class Service extends Padron
{

  protected $url_produccion   = "https://aws.afip.gov.ar/sr-padron/webservices/personaServiceA5?WSDL";
  protected $url_homologacion = "https://awshomo.afip.gov.ar/sr-padron/webservices/personaServiceA5?WSDL";
  protected $id               = 'ws_sr_padron_a5';

  protected $client = null;

  protected $endpoint = null;

  protected $auth_service = null;

  protected $cuit;

  public function getPersona( $cuit)
  {
    $idPersona = (int) str_replace('-','', $cuit);
    $request = [
      'cuitRepresentada' => $this->cuit,
      'idPersona' => $idPersona
    ];
    $request = $this->addAuth( $request );

    return $this->client->getPersona( $request );
  }
}
