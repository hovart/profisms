<?php

namespace Multi;
class MsisdnListMsisdn
{

    public $Db;

    public function __construct()
    {
        $this->Db = Db::getInstance();
    }
}