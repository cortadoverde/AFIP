<?php

namespace Cortadoverde\AFIP\Auth\Storage;

interface CredencialesStorage {
    public function loadCredenciales($name);

    public function saveCredenciales($name, $contents);
}
