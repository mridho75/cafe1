<?php

function allowedRoles(array $roles)
{
    return in_array(session('role'), $roles);
}
