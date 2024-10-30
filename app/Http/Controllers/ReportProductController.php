<?php

namespace App\Http\Controllers;

use App\Dao\Enums\ProductStatus;
use App\Dao\Models\Location;
use App\Dao\Models\Product;
use App\Dao\Models\User;
use App\Dao\Models\WorkSheet;
use App\Dao\Repositories\ProductRepository;
use App\Http\Controllers\MasterController;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Coderello\SharedData\Facades\SharedData;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Plugins\Query;
use Plugins\Template;

class ReportProductController extends MasterController
{
    public function __construct(ProductRepository $repository)
    {
        self::$repository = self::$repository ?? $repository;
    }

    protected function beforeForm()
    {
        $product = Query::getProduct();
        $location = Query::getLocation();
        $user = User::getOptions();
        $status = ProductStatus::getOptions();

        self::$share = [
            'product' => $product,
            'location' => $location,
            'user' => $user,
            'status' => $status,
        ];
    }

    private function printBarcode()
    {
        $data = [
            'data' => Product::with(['has_category', 'has_brand', 'has_location'])->get()
        ];
        $pdf = PDF::loadView(Template::print(SharedData::get('template'), 'print_barcode'), $data);
        return $pdf->setPaper(array( 0 , 0 , 300 , 100 ))->stream();
    }

    private function getQuery($request){
        $query = self::$repository->setDisablePaginate()->dataRepository();
        if($request->get('start_date') || $request->get('end_date')){
            $query->whereHas('has_worksheet', function($query) use($request){
                if($start = $request->get('start_date')){
                    $query->where(WorkSheet::field_reported_at(), '>=', $start);
                }
                if($end = $request->get('end_date')){
                    $query->where(WorkSheet::field_reported_at(), '<=', $end);
                }
                $query->orderBy(WorkSheet::field_reported_at(), 'DESC')->limit(1);
            });
        }
        else{
            $query->with('has_worksheet');
        }

        if($product = $request->get('product_data')){
            $query->whereIn(Product::field_primary(), $product);
        }

        if($location = $request->get('location')){
            $query->where(Product::field_location_id(), $location);
        }

        return $query;
    }

    public function getPrint(Request $request)
    {
        if ($request->get('type') == 'barcode') {
            return $this->printBarcode();
        }

        return view(Template::print(SharedData::get('template')))
        ->with($this->share([
            'data' => $this->getQuery($request)->get(),
            'fields' => self::$repository->model->getShowField(),
        ]));
    }
}