<?php

namespace Src\Auth;

interface identityInterface
{
    public function findIdentity(int $id);
    public function getId(): int;
    public function attemptIdentity(array $credentials);
}