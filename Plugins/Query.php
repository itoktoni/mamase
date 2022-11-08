<?php

namespace Plugins;

use App\Dao\Enums\EnvType;
use App\Dao\Enums\TicketContract;
use App\Dao\Enums\TicketStatus;
use App\Dao\Models\Location;
use App\Dao\Models\Product;
use App\Dao\Models\SystemGroup;
use App\Dao\Models\SystemMenu;
use App\Dao\Models\SystemPermision;
use App\Dao\Models\TicketSystem;
use App\Dao\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Query
{
    public static function groups($role = false)
    {
        if (env('APP_ENV') == EnvType::Production) {
            if (Session::has('groups')) {
                $cache = Session::get('groups');
                if ($role && !empty($cache)) {
                    $cache = $cache->where('system_role_code', auth()->user()->role);
                }
                return $cache;
            }
        }

        $groups = [];
        try {
            $groups = SystemGroup::with([
                'has_menu' => function ($query) {
                    $query->orderBy('system_menu_sort', 'DESC');
                },
                'has_menu.has_link' => function ($query) {
                    $query->orderBy('system_link_sort', 'DESC');
                },
            ])
                ->leftJoin('system_group_connection_role', 'system_group_connection_role.system_group_code', 'system_group.system_group_code')
                ->orderBy('system_group_sort', 'DESC')
                ->get();
            Session::put('groups', $groups, 12000);
        } catch (\Throwable$th) {
            //throw $th;
        }

        if ($role) {
            $groups = $groups->where('system_role_code', auth()->user()->role);
        }

        return $groups;
    }

    public static function permision()
    {
        if (env('APP_ENV') == EnvType::Production) {
            if (Session::has('permision')) {
                return Session::get('permision');
            }
        }

        $permision = [];
        try {
            $permision = SystemPermision::get();
            Session::put('permision', $permision, 1200);
        } catch (\Throwable$th) {
            //throw $th;
        }

        return $permision;
    }

    public static function upsert($model, $where, $data)
    {
        $batch = $model->where($where)->first();
        if ($batch) {
            $batch->update($data);
        } else {
            $model->create($data);
        }
    }

    public static function autoNumber($tablename, $fieldid, $prefix = 'AUTO', $codelength = 10)
    {
        $db = DB::table($tablename);
        $db->select(DB::raw('max(' . $fieldid . ') as maxcode'));
        $db->where($fieldid, "like", "$prefix%");

        $ambil = $db->first();
        $data = $ambil->maxcode;

        if ($db->count() > 0) {
            $code = substr($data, strlen($prefix));
            $countcode = ($code) + 1;
        } else {
            $countcode = 1;
        }
        $newcode = $prefix . str_pad($countcode, $codelength - strlen($prefix), "0", STR_PAD_LEFT);
        return $newcode;
    }

    public static function getProduct()
    {
        $product = Product::with(['has_location', 'has_location.has_building', 'has_location.has_floor'])
        ->get()
            ->mapWithKeys(function ($item) {
                $name = $item->field_name;
                if($item->field_serial_number){
                    $name = $name.' ('.$item->field_serial_number.') ';
                }
                if($location = $item->has_location){
                    $location_name = $location->field_name ?? '';
                    $name = $name . ' - ' . $location_name;
                }

                if($building = $item->has_location->has_building ?? false){
                    $building_name = $building->field_name ?? '';
                    $name = $name . ' - ' . $building_name;
                }

                if($floor = $item->has_location->has_floor ?? false){
                    $floor_name = $floor->field_name ?? '';
                    $name = $name . ' - ' . $floor_name;
                }

                $id = $item->field_primary ?? '' . '';
                return [$id => $name];
            });

        return $product;
    }

    public static function getLocation()
    {
        $location = Location::with(['has_building', 'has_floor'])
        ->get()
            ->mapWithKeys(function ($item) {
                $name = $item->field_name;
                if($item->has_building){
                    $name = $name.' - '.$item->has_building->field_name;
                }
                if($item->has_floor){
                    $name = $name.' - '.$item->has_floor->field_name;
                }
                $id = $item->field_primary . '';
                return [$id => $name];
            });

        return $location;
    }

    public static function getRole($role)
    {
        return null;
    }

    public static function getUserWhatsapp(){
        return User::select(User::field_primary(), User::field_name())
        ->whereNotNull(User::field_phone())->get()->pluck(User::field_name(), User::field_primary());
    }

    public static function getTotalTicket()
    {
        return 0;
        TicketSystem::select(TicketSystem::field_primary())->count();
    }

    public static function getTotalProcessTicket($percent = false)
    {
        return 0;
        $process = TicketSystem::select(TicketSystem::field_primary())
            ->where(TicketSystem::field_status(), '!=', TicketStatus::Open)
            ->where(TicketSystem::field_status(), '!=', TicketStatus::Finish)
            ->count();
        if ($percent) {
            return ($process / self::getTotalTicket()) * 100;
        }

        return $process;
    }

    public static function getTotalCloseTicket($percent = false)
    {
        return 0;
        $close = TicketSystem::select(TicketSystem::field_primary())->where(TicketSystem::field_status(), TicketStatus::Finish)->count();
        if ($percent) {
            return ($close / self::getTotalTicket()) * 100;
        }

        return $close;
    }

    public static function getTotalOpenTicket($percent = false)
    {
        return 0;
        $open = TicketSystem::select(TicketSystem::field_primary())->where(TicketSystem::field_status(), TicketStatus::Open)->count();
        if ($percent) {
            return ($open / self::getTotalTicket()) * 100;
        }

        return $open;
    }

    public static function getImplementor($type, $model)
    {
        if ($type == TicketContract::Kontrak) {
            return $model->has_vendor->field_name ?? '';
        } else {
            return $model->has_implementor->field_name ?? '';
        }
    }

    public static function getMenu()
    {
        // $get_query = DB::table('system_group_user_connection_group_module')
        // ->join('system_group_module', 'system_group_module.system_group_module_code', '=', 'system_group_user_connection_group_module.system_group_module_code')
        // ->join('system_group_module_connection_module', 'system_group_module_connection_module.system_group_module_code', '=', 'system_group_module.system_group_module_code')
        // ->join('system_module', 'system_module.system_module_code', '=', 'system_group_module_connection_module.system_module_code')
        // ->leftJoin('system_module_connection_action', 'system_module_connection_action.system_module_code', '=', 'system_module.system_module_code')
        // ->leftJoin('system_action', 'system_action.system_action_code', '=', 'system_module_connection_action.system_action_code')
        // ->where('system_group_user_code', auth()->user()->role)
        // ->get();

        $get_query = SystemMenu::with('has_link')->get();

        return $get_query;
    }
}
