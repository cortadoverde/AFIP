<?php

namespace Cortadoverde\AFIP;

class PadronSOAP extends \SoapClient
{
    public $endpointPadron;

    public function __doRequest($request, $location, $action, $version, $one_way = 0) {
        $newLocation = $this->endpointPadron;
        return parent::__doRequest($request, $newLocation, $action, $version, $one_way);
    }
}
