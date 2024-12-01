<?php

namespace Src\Models;

class User {
    public int $id;
    public string $kullaniciadi;
    public string $adisoyadi;
    public string $sifre;

    public function __construct($id, $kullaniciadi, $adisoyadi, $sifre) {
        $this->id = $id;
        $this->kullaniciadi = $kullaniciadi;
        $this->adisoyadi = $adisoyadi;
        $this->sifre = $sifre;
    }
}
