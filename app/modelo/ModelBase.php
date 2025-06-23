<?php

class ModelBase
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
}
