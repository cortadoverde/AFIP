<?php

namespace Cortadoverde\AFIP\Auth;

/**
 * Representa valores de las credenciales. Tratar como *value object*,
 * inmutable.
 */
class Credenciales
{
  private $token;
  private $sign;
  private $expirationTime;
  private $generationTime;

  public function __construct($token, $sign, $generationTime, $expirationTime)
  {
      $this->token = $token;
      $this->sign = $sign;
      $this->generationTime = $generationTime;
      $this->expirationTime = $expirationTime;
  }

  public function getToken()
  {
      return $this->token;
  }

  public function getSign()
  {
      return $this->sign;
  }

  public function getGenerationTime()
  {
      return $this->generationTime;
  }

  public function getExpirationTime()
  {
      return $this->expirationTime;
  }
}
