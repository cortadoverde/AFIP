<?php

namespace Cortadoverde\AFIP;

class Padron
{

  protected $client = null;

  protected $auth_service = null;

  protected $cuit;

  protected $url_homologacion;

  protected $url_produccion;

  protected $id;

  public function __construct( $auth, $cuit,  $endpoint = false )
  {
    $this->endpoint = $this->url_homologacion;
    if ( ! $endpoint || in_array( $endpoint, ['produccion', 'prod'] ) ) {
      $this->endpoint = $this->url_produccion;
    }
    $this->auth_service = $auth;

    $this->cuit   = $cuit;

    $this->client = new PadronSOAP( $this->endpoint );

    $this->client->endpointPadron = $this->endpoint;
  }

  public function getCUIT( $dni )
  {

    $multiplicadores = Array('3', '2', '7','6', '5', '4', '3', '2');

    $cuits = [];
    foreach( [20, 27] AS $num ) {
      $calculo = (substr($num,0,1)*5)+(substr($num,1,1)*4);
      for($i=0;$i<8;$i++) {
        $calculo += substr($dni,$i,1) * $multiplicadores[$i];
      }
      $resto = ($calculo)%11;
      if( $resto <= 1 ) {
        if( $resto == 0 ) {
          $cuits[] = $num . $dni . $resto;
        } else {
          $cuits[] = $num . $dni . ( ( $num == 20 ) ? 9 : 4 );
        }
      } else {
        $cuits[] = $num . $dni . ( 11 - $resto );
      }
    }
    return $cuits;

  }


  public function find( $idPersona )
  {
    $data  = [];
    $cuits = [$idPersona];
    if( strlen( $idPersona) <= 8 ) {
      $cuits = $this->getCUIT( $idPersona );
    }

    foreach( $cuits AS $cuit ) {
      try {
        $data[] = $this->getPersona( $cuit );
      } catch (\Exception $e) {

      }
    }

    return $data[0];
  }
  protected function addAuth( $request )
  {
    return array_merge( $this->getAuthBlock(), $request );
  }

  protected function getAuthBlock()
  {
    $credenciales = $this->auth_service->getCredenciales( $this->id );

    return [
      'token' => $credenciales->getToken(),
      'sign'  => $credenciales->getSign(),
    ];
  }

  public function dummy()
  {
    $request = [];
    $request = $this->addAuth( $request );

    return $this->client->dummy( $request );
  }

}
