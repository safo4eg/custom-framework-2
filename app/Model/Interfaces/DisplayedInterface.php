<?php

namespace Model\Interfaces;

interface DisplayedInterface
{
    public static function getFieldsInFormattedArray(array $employees_list): array;
}