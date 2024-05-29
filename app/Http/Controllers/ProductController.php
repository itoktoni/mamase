<?php

namespace App\Http\Controllers;

use App\Dao\Enums\BooleanType;
use App\Dao\Enums\KontrakType;
use App\Dao\Enums\ProductStatus;
use App\Dao\Enums\RoleType;
use App\Dao\Models\Category;
use App\Dao\Models\Brand;
use App\Dao\Models\Location;
use App\Dao\Models\Product;
use App\Dao\Models\ProductModel;
use App\Dao\Models\ProductTech;
use App\Dao\Models\ProductType;
use App\Dao\Models\Supplier;
use App\Dao\Models\Unit;
use App\Dao\Models\User;
use App\Dao\Models\WorkSheet;
use App\Dao\Repositories\ProductRepository;
use App\Http\Requests\ProductRequest;
use App\Http\Services\CreateService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateService;
use Coderello\SharedData\Facades\SharedData;
use Plugins\Response;
use Plugins\Template;
use App\Http\Controllers\MasterController;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Plugins\Query;
use Ramsey\Uuid\Uuid;

class ProductController extends MasterController
{
    public function __construct(ProductRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    protected function beforeForm()
    {
        $status = ProductStatus::getOptions();
        $category = Category::getOptions();
        $product_type = ProductType::getOptions();
        $product_tech = ProductTech::getOptions();
        $brand = Brand::getOptions();
        $location = Query::getLocation();
        $product_model = ProductModel::getOptions();
        $unit = Unit::getOptions();
        $supplier = Supplier::getOptions();
        $user = User::getOptions();
        $kontrak = KontrakType::getOptions();
        $teknisi = Query::getUserByRole(RoleType::Teknisi);

        self::$share = [
            'status' => $status,
            'category' => $category,
            'product_model' => $product_model,
            'location' => $location,
            'user' => $user,
            'supplier' => $supplier,
            'brand' => $brand,
            'teknisi' => $teknisi,
            'unit' => $unit,
            'kontrak' => $kontrak,
            'product_tech' => $product_tech,
            'product_type' => $product_type,
        ];
    }

    public function postCreate(ProductRequest $request, CreateService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, ProductRequest $request, UpdateService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }

    public function getHistory($code)
    {
        $this->beforeForm();
        $this->beforeUpdate($code);
        $data = $this->get($code, ['has_worksheet', 'has_worksheet.has_type', 'has_worksheet.has_suggestion']);
        return view(Template::form(SharedData::get('template'), 'history'))->with($this->share([
            'model' => $data,
            'worksheets' => $data->has_worksheet ?? false,
        ]));
    }

    public function detail()
    {
        $product = $detail = false;
        $code = request('code');
        if($code){
            $product = Product::with([
                'has_category',
                'has_brand',
                'has_location',
            ])->find($code);

            $detail = WorkSheet::with(['has_type', 'has_suggestion'])
                ->where(WorkSheet::field_product_id(), $code)
                ->orderBy('work_sheet_created_at', 'DESC')
                ->limit(5)
                ->get() ?? false;
        }

        return view('pages.product.detail')->with($this->share([
            'product' => $product,
            'worksheets' => $detail,
        ]));
    }

    public function getPrint($code)
    {
        $product = Product::with(['has_category', 'has_brand', 'has_location'])->find($code);
        $data = [
            'item' => $product
        ];

        $name = $product->field_name;
        $count = strlen($name);

        $width = 155;
        $height = 113;


        if($count <= 20 ) {
            $width = 160;
        }

        if($count > 20 && $count <= 25 ) {
            $width = 165;
        }

        if($count > 25 && $count <= 30 ) {
            $width = 155;
        }


        $pdf = FacadePdf::loadView(Template::print(SharedData::get('template'), 'print'), $data);
        return $pdf->setPaper(array( 0 , 0 , 155 , 160 ))->stream(Uuid::uuid4()->toString().'.pdf');
    }
}
