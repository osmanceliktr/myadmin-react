<?php

namespace Src\Models;

class User {
    public int $id;
    public string $username;
    public string $nameSurname;
    public string $password;

    public function __construct($id, $username, $nameSurname, $password) {
        $this->id = $id;
        $this->username = $username;
        $this->nameSurname = $nameSurname;
        $this->password = $password;
    }
}
