<?php

namespace Plugins;

class Alert
{
    const create = 'Created';
    const update = 'Saved';
    const delete = 'Deleted';
    const failed = 'Failed';
    const error = 'Error';
    const success = 'success';
    const warning = 'warning';
    const danger = 'danger';
    const primary = 'primary';

    public static function create($data = null)
    {
        session()->put(self::success, $data ?? 'Data has been ' . self::create . ' !');
    }

    public static function update($data = null)
    {
        session()->put(self::success, $data ?? 'Data has been ' . self::update . ' !');
    }

    public static function delete($data = null)
    {
        session()->put(self::success, $data ?? 'Data has been ' . self::delete . ' !');
    }

    public static function error($data = null)
    {
        session()->put(self::error, env('APP_ENV', 'local') == 'production' ? 'Data got error !' : $data . ' !');
    }
}
