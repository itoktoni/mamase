<?php

use App\Dao\Enums\MenuType;
use App\Dao\Facades\EnvFacades;
use App\Dao\Models\Product;
use App\Dao\Models\Routes;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

use Buki\AutoRoute\AutoRouteFacade as AutoRoute;
use Coderello\SharedData\Facades\SharedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Plugins\Query;
use Plugins\Template;

Route::get('/', function () {

    return redirect('home');

})->name('one');

Route::get('wa', function () {
    $api_key = '0e8c5fe9c8005932fbb05c0f6b817665daa293f7'; // API KEY Anda
    $id_device = '7211'; // ID DEVICE yang di SCAN (Sebagai pengirim)
    $url = 'https://api.watsap.id/send-media'; // URL API
    $no_hp = '08111040159'; // No.HP yang dikirim (No.HP Penerima)
    $pesan = '😁 Halo Terimakasih 🙏'; // Caption/Keterangan Gambar
    $tipe = 'image'; // Tipe Pesan Media Gambar
    $link = 'https://domain.com/gambarnya.jpg'; // Link atau URL FILE MEDIA (.jpg, .jpeg, .png)

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT, 0); // batas waktu response
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_POST, 1);

    $data_post = [
        'id_device' => $id_device,
        'api-key' => $api_key,
        'no_hp' => $no_hp,
        'pesan' => $pesan,
        'tipe' => $tipe,
        'link' => $link,
    ];
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data_post));
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($curl);
    curl_close($curl);
    echo $response;
});

Route::get('debug', function () {
    echo $_SERVER['HTTP_USER_AGENT'];
    echo '<br>';
    $ua = strtolower($_SERVER["HTTP_USER_AGENT"]);
    $isMob = is_numeric(strpos($ua, "mobile"));
    return json_encode($isMob);

})->name('debug');

Route::get('print/{code}.pdf', function($code){
    $data = [
        'item' => Product::with(['has_category', 'has_brand', 'has_location'])->find($code)
    ];
    $pdf = PDF::loadView('pages.product.print', $data);
    return base64_encode($pdf->setPaper(array( 0 , 0 , 150 , 110 ))->stream());
})->name('print');

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
Route::get('/home', 'HomeController@index')->middleware(['auth', 'access'])->name('home');
Route::get('/doc', 'HomeController@doc')->middleware(['auth', 'access'])->name('doc');
Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('clear-compiled');
    Artisan::call('config:cache');
    dd("Cache is cleared");
});
Auth::routes();

Route::match(['POST', 'GET'], 'change-password', 'UserController@changePassword', ['name' => 'change-password'])->middleware('auth');

$routes = Query::groups();
// $routes = Template::routes();

Route::prefix('admin')->group(function () use ($routes) {
    if ($routes) {
        foreach ($routes as $group) {
            Route::group(['prefix' => $group->field_primary, 'middleware' => [
                'auth',
                'access',
            ]], function () use ($group) {
                // -- nested group
                if ($menus = $group->has_menu) {
                    foreach ($menus as $menu) {

                        if($menu->field_type == MenuType::Menu){

                            Route::group(['prefix' => 'default'], function () use ($menu) {
                                try {
                                    AutoRoute::auto($menu->field_primary, $menu->field_controller, ['name' => $menu->field_primary]);
                                    if ($links = $menu->has_link) {

                                    }
                                } catch (\Throwable$th) {
                                    //throw $th;
                                }
                            });


                        } elseif($menu->field_type == MenuType::Group){

                            if ($links = $menu->has_link) {
                                Route::group(['prefix' => $menu->field_primary], function () use ($links) {
                                    foreach ($links as $link) {

                                        try {
                                            AutoRoute::auto($link->field_primary, $link->field_controller, ['name' => $link->field_primary]);
                                        } catch (\Throwable$th) {
                                            //throw $th;
                                        }

                                    }
                                });
                            }
                        }
                    }
                }
                // end nested group

            });
        }
    }
});

Route::prefix('dashboards')->name('dashboards.')->middleware('access')->group(function () {

    Route::get('one', function () {
        return view('index');
    })->name('one');

    Route::get('two', function () {
        return view('dashboard-two');
    })->name('two');

    Route::get('three', function () {
        return view('dashboard-three');
    })->name('three');

    Route::get('four', function () {
        return view('dashboard-four');
    })->name('four');

    Route::get('five', function () {
        return view('dashboard-five');
    })->name('five');

});

// Apps

Route::prefix('apps')->name('apps.')->middleware('access')->group(function () {

    Route::get('chat', function () {
        return view('chat');
    })->name('chat');

    Route::get('inbox', function () {
        return view('inbox');
    })->name('inbox');

    Route::get('todo', function () {
        return view('app-todo');
    })->name('todo');

    Route::get('file-manager', function () {
        return view('file-manager');
    })->name('file-manager');

    Route::get('calendar', function () {
        return view('calendar');
    })->name('calendar');

});

// Elements

Route::prefix('elements')->name('elements.')->middleware('access')->group(function () {

    // Basic

    Route::prefix('basic')->name('basic.')->group(function () {
        Route::get('alert', function () {
            return view('alert');
        })->name('alert');

        Route::get('accordion', function () {
            return view('accordion');
        })->name('accordion');

        Route::get('buttons', function () {
            return view('buttons');
        })->name('buttons');

        Route::get('dropdown', function () {
            return view('dropdown');
        })->name('dropdown');

        Route::get('list-group', function () {
            return view('list-group');
        })->name('list-group');

        Route::get('pagination', function () {
            return view('pagination');
        })->name('pagination');

        Route::get('typography', function () {
            return view('typography');
        })->name('typography');

        Route::get('media-object', function () {
            return view('media-object');
        })->name('media-object');

        Route::get('progress', function () {
            return view('progress');
        })->name('progress');

        Route::get('modal', function () {
            return view('modal');
        })->name('modal');

        Route::get('spinners', function () {
            return view('spinners');
        })->name('spinners');

        Route::get('navs', function () {
            return view('navs');
        })->name('navs');

        Route::get('tab', function () {
            return view('tab');
        })->name('tab');

        Route::get('tooltip', function () {
            return view('tooltip');
        })->name('tooltip');

        Route::get('popovers', function () {
            return view('popovers');
        })->name('popovers');
    });

    // Cards

    Route::prefix('card')->name('card.')->group(function () {
        Route::get('basic', function () {
            return view('basic-cards');
        })->name('basic');

        Route::get('image', function () {
            return view('image-cards');
        })->name('image');

        Route::get('scroll', function () {
            return view('card-scroll');
        })->name('scroll');

        Route::get('other', function () {
            return view('other-cards');
        })->name('other');
    });

    Route::get('avatar', function () {
        return view('avatar');
    })->name('avatar');

    Route::get('icons', function () {
        return view('icons');
    })->name('icons');

    Route::get('colors', function () {
        return view('colors');
    })->name('colors');

    // Plugins

    Route::prefix('plugin')->name('plugin.')->group(function () {
        Route::get('sweet-alert', function () {
            return view('sweet-alert');
        })->name('sweet-alert');

        Route::get('lightbox', function () {
            return view('lightbox');
        })->name('lightbox');

        Route::get('toast', function () {
            return view('toast');
        })->name('toast');

        Route::get('tour', function () {
            return view('tour');
        })->name('tour');

        Route::get('slick-slide', function () {
            return view('slick-slide');
        })->name('slick-slide');

        Route::get('nestable', function () {
            return view('nestable');
        })->name('nestable');
    });

    // Plugins

    Route::prefix('form')->name('form.')->group(function () {
        Route::get('basic', function () {
            return view('basic-form');
        })->name('basic');

        Route::get('custom', function () {
            return view('custom-form');
        })->name('custom');

        Route::get('advanced', function () {
            return view('advanced-form');
        })->name('advanced');

        Route::get('validation', function () {
            return view('form-validation');
        })->name('validation');

        Route::get('wizard', function () {
            return view('form-wizard');
        })->name('wizard');

        Route::get('file-upload', function () {
            return view('file-upload');
        })->name('file-upload');

        Route::get('datepicker', function () {
            return view('datepicker');
        })->name('datepicker');

        Route::get('timepicker', function () {
            return view('timepicker');
        })->name('timepicker');

        Route::get('colorpicker', function () {
            return view('colorpicker');
        })->name('colorpicker');
    });

    // Tables

    Route::prefix('table')->name('table.')->group(function () {
        Route::get('basic', function () {
            return view('tables');
        })->name('basic');

        Route::get('datatable', function () {
            return view('data-table');
        })->name('datatable');

        Route::get('responsive', function () {
            return view('responsive-table');
        })->name('responsive');
    });

    // Tables

    Route::prefix('chart')->name('chart.')->group(function () {
        Route::get('apexchart', function () {
            return view('apexchart');
        })->name('apexchart');

        Route::get('chartjs', function () {
            return view('chartjs');
        })->name('chartjs');

        Route::get('justgage', function () {
            return view('justgage');
        })->name('justgage');

        Route::get('morsis', function () {
            return view('morsis');
        })->name('morsis');

        Route::get('peity', function () {
            return view('peity');
        })->name('peity');
    });

    // Maps

    Route::prefix('map')->name('map.')->group(function () {
        Route::get('google', function () {
            return view('google-map');
        })->name('google');

        Route::get('vector', function () {
            return view('vector-map');
        })->name('vector');
    });
});

// Pages

Route::prefix('pages')->name('pages.')->middleware('access')->group(function () {
    Route::get('login', function () {
        return view('login');
    })->name('login');

    Route::get('register', function () {
        return view('register');
    })->name('register');

    Route::get('recovery-password', function () {
        return view('recovery-password');
    })->name('recovery-password');

    Route::get('recovery-password', function () {
        return view('recovery-password');
    })->name('recovery-password');

    Route::get('lock-screen', function () {
        return view('lock-screen');
    })->name('lock-screen');

    Route::get('profile', function () {
        return view('profile');
    })->name('profile');

    Route::get('timeline', function () {
        return view('timeline');
    })->name('timeline');

    Route::get('invoice', function () {
        return view('invoice');
    })->name('invoice');

    Route::get('pricing-table', function () {
        return view('pricing-table');
    })->name('pricing-table');

    Route::get('search-result', function () {
        return view('search-result');
    })->name('search-result');

    Route::get('blank-page', function () {
        return view('blank-page');
    })->name('blank-page');

    Route::get('email-template-basic', function () {
        return view('email-template-basic');
    })->name('email-template-basic');

    Route::get('email-template-alert', function () {
        return view('email-template-alert');
    })->name('email-template-alert');

    Route::get('email-template-billing', function () {
        return view('email-template-billing');
    })->name('email-template-billing');

    Route::prefix('errors')->name('errors.')->group(function () {
        Route::get('404', function () {
            return view('404');
        })->name('404');

        Route::get('404-2', function () {
            return view('404-2');
        })->name('404-2');

        Route::get('503', function () {
            return view('503');
        })->name('503');

        Route::get('mean-at-work', function () {
            return view('mean-at-work');
        })->name('mean-at-work');
    });
});

Route::post('upload_config', function (Request $request) {

    $file = $request->file('file');
    $field = $request->file('name');
    // $filename = $file->getClientOriginalName();
    $extension = $file->getClientOriginalExtension();
    $name = $field . '.' . $extension;
    $file->storeAs('/public/', $name);

    EnvFacades::setValue($field, $name);

    return $name;

})->name('upload_config');