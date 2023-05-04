<?php

namespace Src\Auth;
use Src\Session;

class Auth
{
    // хранение любого класса, который implements interface IdentityInterface;
    private static IdentityInterface $employee;

    //инициализация класса пользователя
    public static function init(IdentityInterface $employee): void
    {
        self::$employee = $employee;
        if(self::employee()) {
            self::login(self::employee());
        }
    }

    // вход пользователя по модели
    public static function login(IdentityInterface $employee): void
    {
        self::$employee = $employee;
        Session::set('id', self::$employee->getId());
        Session::set('role', self::$employee->getRole());
    }

    //аутентификация пользователя и вход по учетным данным
    public static function attempt(array $credentials): bool
    {
        if($employee = self::$employee->attemptIdentity($credentials)) {
            self::login($employee);
            return true;
        }
        return false;
    }

    //возврат текущего аутентифицированного пользователя
    public static function employee()
    {
        $id = Session::get('id') ?? 0;
        return self::$employee->findIdentity($id);
    }

    // проверка является ли текущий пользователь аутентифицированым
    public static function check(): bool
    {
        if(self::employee()) {
            return true;
        }
        return false;
    }

    public static function logout(): bool
    {
        Session::clear('id');
        return true;
    }
}