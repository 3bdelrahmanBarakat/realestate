<?php

namespace App\Interfaces;


interface UserInterface
{
    public function usersTable();
    public function userPropertiesTable($userId);
}
