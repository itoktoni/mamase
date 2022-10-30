<?php

namespace App\Http\Controllers;

use App\Dao\Enums\ProductStatus;
use App\Dao\Models\Location;
use App\Dao\Models\Product;
use App\Dao\Models\User;
use App\Dao\Repositories\ProductRepository;
use App\Http\Controllers\MasterController;
use Barryvdh\DomPDF\Facade as PDF;
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

    public function getPrint(Request $request)
    {

        if ($request->get('type') == 'barcode') {
            return $this->printBarcode();
        }

        $query = self::$repository->setDisablePaginate()->dataRepository();
        return view(Template::print(SharedData::get('template')))->with($this->share([
            'data' => $query,
            'fields' => self::$repository->model->getShowField(),
        ]));
    }

    public function getExcel()
    {
        return Excel::download(new ProductRepository, 'ticket_system.' . date('Ymd') . '.xlsx');
    }

    public function getCsv()
    {
        return self::$repository->excel('ticket_system.' . date('Ymd'));
    }
}
