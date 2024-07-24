<?php

namespace App\Http\Controllers;

use App\Dao\Enums\BooleanType;
use App\Dao\Enums\KontrakType;
use App\Dao\Enums\ProductStatus;
use App\Dao\Enums\RoleType;
use App\Dao\Models\Brand;
use App\Dao\Models\Category;
use App\Dao\Models\Product;
use App\Dao\Models\ProductModel;
use App\Dao\Models\ProductTech;
use App\Dao\Models\ProductType;
use App\Dao\Models\Supplier;
use App\Dao\Models\Unit;
use App\Dao\Models\User;
use App\Dao\Models\WorkSheet;
use App\Dao\Repositories\ProductRepository;
use App\Http\Controllers\MasterController;
use App\Http\Requests\ProductRequest;
use App\Http\Services\CreateService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateService;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Coderello\SharedData\Facades\SharedData;
use DateTime;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Plugins\Query;
use Plugins\Response;
use Plugins\Template;
use Ramsey\Uuid\Uuid;
use Spatie\SimpleExcel\SimpleExcelReader;
use Spatie\SimpleExcel\SimpleExcelWriter;

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
        $cek = BooleanType::getOptions();
        ksort($cek);

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
            'cek' => $cek,
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
        $data = $this->get($code, ['has_model', 'has_worksheet', 'has_worksheet.has_type', 'has_worksheet.has_suggestion']);
        return view(Template::form(SharedData::get('template'), 'history'))->with($this->share([
            'model' => $data,
            'worksheets' => $data->has_worksheet ?? false,
        ]));
    }

    public function detail()
    {
        $product = $detail = false;
        $code = request('code');
        if ($code) {
            $product = Product::with([
                'has_category',
                'has_brand',
                'has_model',
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

    public function getExport()
    {
        $filename = 'data-alat.xlsx';

        $writer = SimpleExcelWriter::streamDownload($filename)
            ->addHeader([
                'ID',
                'Serial Number',
                'Nama Ruangan',
                'Nama Alat',
                'Kalibrasi',
            ]);

        $count = 0;
        Product::with(['has_location'])->where(Product::field_category_id(), 2)->chunk(500, function ($products) use ($writer, $count) {
            foreach ($products as $product) {

                $kalibrasi = null;
                if (!empty($product->product_kalibrasi)) {
                    $date = date_create($product->product_kalibrasi);
                    $kalibrasi = date_format($date, "d/m/Y");
                }

                $writer->addRow([
                    isset($product->product_id) ? $product->product_id : '',
                    isset($product->product_serial_number) ? $product->product_serial_number : '',
                    $product->has_location ? $product->has_location->field_name : '',
                    isset($product->product_name) ? $product->product_name : '',
                    $kalibrasi,
                ]);
            }

            $count++;

            if ($count % 1000 === 0) {
                flush(); // Flush the buffer every 1000 rows
            }

        });

        return $writer->toBrowser();
    }

    public function postImport(Request $request)
    {
        $request->validate([
            'import_csv' => 'required|mimes:xlsx',
        ]);

        $file = $request->file('import_csv');

        $check = SimpleExcelReader::create($file, 'xlsx')
            ->noHeaderRow()
            ->getRows()
            ->skip(1)
            ->each(function (array $column) {

                $id = $column[0];
                $serial_number = $column[1];
                $location = $column[2];
                $nama_alat = $column[3];
                $tanggal = $column[4] ?? null;

                if (isset($tanggal) && !empty($tanggal)) {
                    if($tanggal instanceof DateTimeImmutable)
                    {
                        $kalibrasi = $tanggal->format('Y-m-d');
                    }
                    else
                    {
                        $date = date_create_from_format("d/m/Y", $tanggal);
                        $kalibrasi = date_format($date, "Y-m-d");
                    }

                    Product::find($id)->update([
                        Product::field_kalibrasi() => $kalibrasi,
                    ]);
                }
            });

        return redirect()->back()->with('success', 'Import data sukses !');

    }

    public function getPrint($code)
    {
        $product = Product::with(['has_category', 'has_brand', 'has_location'])->find($code);
        $data = [
            'item' => $product,
        ];

        $name = $product->field_name;
        $count = strlen($name);

        $width = 155;
        $height = 113;

        if ($count <= 20) {
            $width = 160;
        }

        if ($count > 20 && $count <= 25) {
            $width = 165;
        }

        if ($count > 25 && $count <= 30) {
            $width = 155;
        }

        $pdf = FacadePdf::loadView(Template::print(SharedData::get('template'), 'print'), $data);
        return $pdf->setPaper(array(0, 0, 155, 160))->stream('rawbt_' . Uuid::uuid4()->toString() . '.pdf');
    }
}
