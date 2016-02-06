<?php
use Helpers\Hooks;

Hooks::addHook('sidebar','Modules\Online\Controllers\Online@index');
Hooks::addHook('routes','Modules\Online\Controllers\Online@routes');
