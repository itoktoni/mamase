<?php

namespace App\Dao\Repositories;

use App\Dao\Enums\CategoryRequestType;
use App\Dao\Enums\RequestStatusType;
use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\Receive;
use Illuminate\Support\Facades\DB;

class ReceiveRepository extends MasterRepository implements CrudInterface
{
    public function __construct()
    {
        $this->model = empty($this->model) ? new Receive() : $this->model;
    }

    public function dataRepository()
    {
        $query = DB::table('work_sheet_sparepart')
            ->join('sparepart', 'work_sheet_sparepart.sparepart_id', '=', 'sparepart.sparepart_id')
            ->join('request', 'work_sheet_sparepart.request_code', '=', 'request.request_code')
            ->leftJoin('category', 'sparepart.sparepart_category_id', '=', 'category.category_id')
            ->leftJoin('brand', 'brand.brand_id', '=', 'sparepart.sparepart_brand_id')
            ->whereIn('request.request_status', [RequestStatusType::Disetujui, RequestStatusType::Diterima])
            ;

        // dd($query->get());

        $query = env('PAGINATION_SIMPLE') ? $query->simplePaginate(env('PAGINATION_NUMBER')) : $query->paginate(env('PAGINATION_NUMBER'));

        return $query;
    }
}
