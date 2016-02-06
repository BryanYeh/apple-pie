<?php
use Helpers\Hooks;

Hooks::addHook('sidebar','Modules\Online\Controllers\Online@index');