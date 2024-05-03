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
use App\Dao\Models\ProductTech;
use App\Dao\Models\ProductType;
use App\Dao\Models\Supplier;
use App\Dao\Models\Unit;
use App\Dao\Repositories\ProductRepository;
use App\Http\Requests\ProductRequest;
use App\Http\Services\CreateService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateService;
use Coderello\SharedData\Facades\SharedData;
use Plugins\Response;
use Plugins\Template;
use App\Http\Controllers\MasterController;
use Plugins\Query;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Ramsey\Uuid\Uuid;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\RawbtPrintConnector;
use Mike42\Escpos\CapabilityProfile;

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
        $unit = Unit::getOptions();
        $supplier = Supplier::getOptions();
        $kontrak = KontrakType::getOptions();
        $teknisi = Query::getUserByRole(RoleType::Teknisi);

        self::$share = [
            'status' => $status,
            'category' => $category,
            'location' => $location,
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

    public function getPrint($code)
    {
        try {
            $profile = CapabilityProfile::load("POS-5890");

            /* Fill in your own connector here */
            $connector = new RawbtPrintConnector();

            /* Information for the receipt */
            $items = array(
                new item("Example item #1", "4.00"),
                new item("Another thing", "3.50"),
                new item("Something else", "1.00"),
                new item("A final item", "4.45"),
            );
            $subtotal = new item('Subtotal', '12.95');
            $tax = new item('A local tax', '1.30');
            $total = new item('Total', '14.25', true);
            /* Date is kept the same for testing */
        // $date = date('l jS \of F Y h:i:s A');
            $date = "Monday 6th of April 2015 02:56:25 PM";

            /* Start the printer */
            // $logo = EscposImage::load("resources/rawbtlogo.png", false);
            $printer = new Printer($connector, $profile);


            // /* Print top logo */
            // if ($profile->getSupportsGraphics()) {
            //     $printer->graphics($logo);
            // }
            // if ($profile->getSupportsBitImageRaster() && !$profile->getSupportsGraphics()) {
            //     $printer->bitImage($logo);
            // }

            /* Name of shop */
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text("ExampleMart Ltd.\n");
            $printer->selectPrintMode();
            $printer->text("Shop No. 42.\n");
            $printer->feed();


            /* Title of receipt */
            $printer->setEmphasis(true);
            $printer->text("SALES INVOICE\n");
            $printer->setEmphasis(false);

            /* Items */
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setEmphasis(true);
            $printer->text(new item('', '$'));
            $printer->setEmphasis(false);
            foreach ($items as $item) {
                $printer->text($item->getAsString(32)); // for 58mm Font A
            }
            $printer->setEmphasis(true);
            $printer->text($subtotal->getAsString(32));
            $printer->setEmphasis(false);
            $printer->feed();

            /* Tax and total */
            $printer->text($tax->getAsString(32));
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text($total->getAsString(32));
            $printer->selectPrintMode();

            /* Footer */
            $printer->feed(2);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Thank you for shopping\n");
            $printer->text("at ExampleMart\n");
            $printer->text("For trading hours,\n");
            $printer->text("please visit example.com\n");
            $printer->feed(2);
            $printer->text($date . "\n");

            /* Barcode Default look */

            $printer->barcode("ABC", Printer::BARCODE_CODE39);
            $printer->feed();
            $printer->feed();


        // Demo that alignment QRcode is the same as text
            $printer2 = new Printer($connector); // dirty printer profile hack !!
            $printer2->setJustification(Printer::JUSTIFY_CENTER);
            $printer2->qrCode("https://rawbt.ru/mike42", Printer::QR_ECLEVEL_M, 8);
            $printer2->text("rawbt.ru/mike42\n");
            $printer2->setJustification();
            $printer2->feed();


            /* Cut the receipt and open the cash drawer */
            $printer->cut();
            $printer->pulse();
            $printer->close();

        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            $printer->close();
        }
    }

}
