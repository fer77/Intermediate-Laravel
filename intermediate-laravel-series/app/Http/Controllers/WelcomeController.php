<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
  // protected $config;
  // public function __construct(Repository $config)
  // {
  //   $this->config = $config;
  // }
    public function test()
    {
      // constructor injection
      // return $this->config->get('database.default');
      // method injection
      // return $config->get('database.default');
      // facade
      // return Config::get('database.default');
      // config helper function
      return config('database.default');
    }
}
