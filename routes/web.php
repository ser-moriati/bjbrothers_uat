<?php

use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




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

Route::get('pdf_quotation', function () {
    return view('pdf_quotation');
    // return view('welcome');
});

Route::get('/', function () {
    return redirect('/home');
    // return view('welcome');
});
// Route::get('/', 'CategoryController@index')->middleware('auth');

Route::get('/login', 'Web\LoginController@showMemberLoginForm');
Route::get('/search', 'Web\ProductController@search');
Route::get('/register', 'Web\RegisterController@showMemberRegisterForm');

Route::post('/login', 'Web\LoginController@memberLogin');
Route::get('/logout', 'Web\LoginController@logout');
Route::post('/register', 'Web\RegisterController@createMember');

Route::prefix('reset_password')->group(function () {
    Route::get('/', 'Web\PasswordController@resetPassword');
    Route::get('/send', 'Web\PasswordController@resetPasswordSendMail');
});


Route::prefix('home')->group(function () {
    Route::get('/', 'Web\HomeController@index');
});
Route::prefix('forgot')->group(function () {
    Route::get('/sendEmail', 'Web\ForgotController@sendEmail');
    Route::post('/sendEmail', 'Web\ForgotController@sendEmail');
    Route::post('/update/{id}', 'Web\ForgotController@update');
    Route::get('/{id}', 'Web\ForgotController@index');
});
Route::get('/customer', 'Web\CustomerController@index');
Route::prefix('project')->group(function () {
    Route::get('/', 'Web\ProjectController@index');
    Route::get('/{id}', 'Web\ProjectController@detail');
});
Route::prefix('portfolio')->group(function () {
    Route::get('/', 'Web\PortfolioController@index');
    Route::get('/{id}', 'Web\PortfolioController@index');
});
Route::prefix('promotion')->group(function () {
    Route::get('/', 'Web\PromotionController@index');
    Route::get('/{id}', 'Web\PromotionController@detail');
});
Route::prefix('news')->group(function () {
    Route::get('/', 'Web\NewsController@index');
    Route::get('/{id}', 'Web\NewsController@detail');
});
Route::prefix('category')->group(function () {
    Route::get('/{name}', 'Web\CategoryController@index');
});
Route::prefix('subcategory')->group(function () {
    Route::get('/get_by_cate/{id}', 'Web\SubCategoryController@get_by_cate');
    Route::get('/{name}', 'Web\SubCategoryController@index');
});
Route::prefix('brand')->group(function () {
    Route::get('/{id}', 'Web\BrandController@index');
});
Route::prefix('product')->group(function () {
    Route::get('/{name_code}', 'Web\ProductController@index');
    Route::post('/color', 'Web\ProductController@getidcolor');
    Route::post('/size', 'Web\ProductController@getidsize');
});
Route::prefix('address')->group(function () {
    Route::get('/', 'Web\AddressController@index');
    Route::get('/{id}', 'Web\AddressController@index');
});
Route::prefix('safety')->group(function () {
    Route::get('/', 'Web\SafetyController@index');
    Route::get('/cate/{id}', 'Web\SafetyController@cate');
    Route::get('/{cate_id}/{id}', 'Web\SafetyController@detail');
});
Route::prefix('technical')->group(function () {
    Route::get('/', 'Web\TechnicalController@index');
    Route::get('/cate/{id}', 'Web\TechnicalController@cate');
    Route::get('/{cate_id}/{id}', 'Web\TechnicalController@detail');
});
Route::prefix('maintenance')->group(function () {
    Route::get('/', 'Web\MaintenanceController@index');
    Route::get('/cate/{id}', 'Web\MaintenanceController@cate');
    Route::get('/{cate_id}/{id}', 'Web\MaintenanceController@detail');
});
Route::prefix('install')->group(function () {
    Route::get('/', 'Web\InstallController@index');
    Route::get('/cate/{id}', 'Web\InstallController@cate');
    Route::get('/{cate_id}/{id}', 'Web\InstallController@detail');
});
Route::prefix('ecatalogue')->group(function () {
    Route::get('/', 'Web\EcatalogueController@index');
});

Route::get('/how_to_order', 'Web\HowToOrderController@index');
Route::get('/policies', 'Web\PoliciesController@index');
Route::get('/faqs', 'Web\FaqsController@index');
Route::get('/shipping_fee', 'Web\ShippingFeeController@index');

Route::prefix('about')->group(function () {
    Route::get('/', 'Web\AboutController@index');
    Route::get('/service', 'Web\AboutController@service');
    Route::get('/customer', 'Web\AboutController@customer');
    Route::get('/certificate', 'Web\AboutController@certificate');
    Route::get('/holiday', 'Web\AboutController@holiday');

});
Route::prefix('contact')->group(function () {
    Route::get('/', 'Web\ContactController@index');
    Route::get('/map', 'Web\ContactController@map');
    
    Route::get('/career', 'Web\ContactController@career');
    Route::get('/dealer', function () {
        return view('/dealer');
    });
    Route::post('send-mail', 'Web\ContactController@send');
});
Route::prefix('newarrival')->group(function () {
    Route::get('/', 'Web\ProductController@newarrival');
});
Route::prefix('PRODUCRECOMMENDED')->group(function () {
    Route::get('/', 'Web\ProductController@product_recommended');
});
Route::get('/checkAuth', function () {
    if(Auth::guard('member')->check()){
        return response(true);
    }
    session()->put('redirect_url', $_SERVER['HTTP_REFERER']);
    return response(false);
    // return view('welcome');
});

Route::prefix('subscribe')->group(function () {
    Route::post('/', 'Web\SubscribeController@insert');
});
Route::prefix('province')->group(function () {
    Route::get('/getProvince/{id}', 'Web\ProvinceController@getProvince');
    Route::get('/getAmphures/{id}', 'Web\ProvinceController@getAmphures');
    Route::get('/getDistrict/{id}', 'Web\ProvinceController@getDistrict');
    Route::get('/getZipcode/{id}', 'Web\ProvinceController@getZipcode');
});


Route::post('/update-session', 'Web\CartController@updateSession');

Route::group(['middleware' => ['member']], function () {
    Route::prefix('account')->group(function () {
        Route::get('/', 'Web\AccountController@index');
        Route::post('update/{id}', 'Web\AccountController@update');
        Route::post('address/update/{id}', 'Web\AccountController@address_update');
        Route::post('address/insert', 'Web\AccountController@address_insert');
        Route::post('address/delete/{id}', 'Web\AccountController@address_delete');
        Route::get('address/{id}', 'Web\AccountController@address_find');
    });
    Route::prefix('password')->group(function () {
        Route::get('/', 'Web\PasswordController@index');
        Route::post('update/{id}', 'Web\PasswordController@update');
        Route::post('checkPassword/{password}', 'Web\PasswordController@checkPassword');
        Route::post('changePassword', 'Web\PasswordController@changePassword');
    });
    Route::prefix('cart')->group(function () {
        Route::get('/', 'Web\CartController@index');
        Route::post('/update-session', 'CartController@updateSession');
        Route::post('/', 'Web\CartController@addCart');
        Route::post('/remove', 'Web\CartController@remove');
        Route::post('/update', 'Web\CartController@update');
        Route::post('/ChangeVat', 'Web\CartController@ChangeVat');
        Route::post('checkprice', 'Web\CartController@Check_price');
    });
    Route::prefix('quotation')->group(function () {
        Route::get('/', 'Web\QuotationController@index');
        Route::post('/', 'Web\QuotationController@addQuotationCart');
        Route::post('/remove', 'Web\QuotationController@remove');
        Route::post('/update', 'Web\QuotationController@update');
        Route::get('/conclude', 'Web\QuotationCusController@conclude');
        Route::get('/confirm/{id}', 'Web\QuotationController@confirm');
        Route::post('/insert', 'Web\QuotationController@insert');
        Route::get('quotationHistory', 'Web\QuotationController@quotationHistory');
        Route::get('quotationHistory/{id}', 'Web\QuotationController@quotationHistoryDetail');
        Route::get('get_modal/{id}', 'Web\QuotationController@get_modal');
    });
    Route::prefix('shipping_payment')->group(function () {
        Route::get('/', 'Web\ShippingPaymentController@index');
        Route::post('/now', 'Web\ShippingPaymentController@index_ordernow');
        Route::post('/insert', 'Web\ShippingPaymentController@insert');
        Route::post('/insert_now', 'Web\ShippingPaymentController@insert_now');
        Route::post('/update_now', 'Web\ShippingPaymentController@update_now');
    });
    
    Route::prefix('order')->group(function () {
        Route::get('/', 'Web\OrderController@index');
        Route::get('/summary/{id}', 'Web\OrderController@summary');
        Route::get('/status/{id}', 'Web\OrderController@status');
        Route::get('confirmPayment', 'Web\OrderController@confirmPayment');
        Route::get('confirmPayment/{id}', 'Web\OrderController@confirmPayment');
        Route::get('cancelPayment/{id}', 'Web\OrderController@cancelPayment');
        Route::post('updateConfirmPayment', 'Web\OrderController@updateConfirmPayment');
        Route::get('updateConfirmPayment/{id}', 'Web\OrderController@updateConfirmPayment');
        Route::post('updatecancelConfirmPayment', 'Web\OrderController@updatecancelConfirmPayment');
        Route::get('updatecancelConfirmPayment/{id}', 'Web\OrderController@updatecancelConfirmPayment');
        Route::get('orderHistory', 'Web\OrderController@orderHistory');
        Route::get('orderHistory/{id}', 'Web\OrderController@orderHistoryDetail');
        Route::get('orderHistory_Payment', 'Web\OrderController@orderHistory_Payment');
        Route::get('orderHistory_Payment/{id}', 'Web\OrderController@orderHistoryDetail');
        Route::get('checkOrder/{order}', 'Web\OrderController@checkOrder');
      
    });
});

Route::prefix('quotation_cus')->group(function () {
    Route::get('/', 'Web\QuotationCusController@index');
    Route::post('/', 'Web\QuotationCusController@addQuotationCusCart');
    Route::post('/remove', 'Web\QuotationCusController@remove');
    Route::post('/update', 'Web\QuotationCusController@update');
    Route::get('/conclude', 'Web\QuotationCusController@conclude');
    Route::get('/confirm/{id}', 'Web\QuotationCusController@confirm');
    Route::post('/insert', 'Web\QuotationCusController@insert');
    Route::get('quotationCusHistory', 'Web\QuotationCusController@quotationCusHistory');
    Route::get('quotationCusHistory/{id}', 'Web\QuotationCusController@quotationCusHistoryDetail');
});




Route::prefix('admin')->group(function () {
    ///admin/login {
    Auth::routes();
    /// } admin/login account
    Route::group(['middleware' => ['auth']], function () {

        Route::prefix('dashboard')->group(function () {
            Route::get('/', 'DashboardController@index');
        });
        Route::prefix('home')->group(function () {
            Route::get('/', 'HomeController@index');
            Route::post('update/{id}', 'HomeController@update');
            Route::post('select_product', 'HomeController@select_product');
            Route::get('banner', 'HomeController@banner');
            Route::get('add/banner', 'HomeController@add_banner');
            Route::post('insert/banner', 'HomeController@insert_banner');
            Route::get('edit/banner/{id}', 'HomeController@edit_banner');
            Route::post('update_banner', 'HomeController@updatet_banner');
            Route::delete('delete/{id}', 'HomeController@destroy');
        });
        // Route::get('login', 'LoginController@index');
        Route::prefix('category')->group(function () {
            Route::get('/', 'CategoryController@index');
            // Route::get('add', 'CategoryController@add');
            Route::get('edit/{id}', 'CategoryController@edit');
            Route::post('insert', 'CategoryController@insert');
            Route::post('update/{id}', 'CategoryController@update');
            Route::delete('delete/{id}', 'CategoryController@destroy');
            Route::post('changeSort', 'CategoryController@changeSort');
        });
        Route::prefix('size')->group(function () {
            Route::get('/', 'SizeController@index');
            Route::get('add', 'SizeController@add');
            Route::get('edit/{id}', 'SizeController@edit');
            Route::post('insert', 'SizeController@insert');
            Route::post('update/{id}', 'SizeController@update');
            Route::delete('delete/{id}', 'SizeController@destroy');
        });
        Route::prefix('color')->group(function () {
            Route::get('/', 'ColorController@index');
            Route::get('add', 'ColorController@add');
            Route::get('edit/{id}', 'ColorController@edit');
            Route::post('insert', 'ColorController@insert');
            Route::post('update/{id}', 'ColorController@update');
            Route::delete('delete/{id}', 'ColorController@destroy');
        });
        Route::prefix('shipping')->group(function () {
            Route::get('/', 'ShippingController@index');
            Route::get('add', 'ShippingController@add');
            Route::get('edit/{id}', 'ShippingController@edit');
            Route::post('insert', 'ShippingController@insert');
            Route::post('update/{id}', 'ShippingController@update');
            Route::delete('delete/{id}', 'ShippingController@destroy');
            Route::post('uploadGallery', 'ShippingController@uploadGallery');
            Route::get('deleteGallery', 'ShippingController@deleteGallery');
        });
        Route::prefix('bank')->group(function () {
            Route::get('/', 'BankController@index');
            Route::get('add', 'BankController@add');
            Route::get('edit/{id}', 'BankController@edit');
            Route::post('insert', 'BankController@insert');
            Route::post('update/{id}', 'BankController@update');
            Route::delete('delete/{id}', 'BankController@destroy');
            Route::post('uploadGallery', 'BankController@uploadGallery');
            Route::get('deleteGallery', 'BankController@deleteGallery');
        });
        Route::prefix('about')->group(function () {
                Route::post('company_detail/{id}', 'AboutController@company_detail');
            Route::prefix('company')->group(function () {
                Route::get('/', 'AboutController@companyIndex');
                Route::get('add', 'AboutController@companyAdd');
                Route::get('edit/{id}', 'AboutController@companyEdit');
                Route::post('insert', 'AboutController@companyInsert');
                Route::post('update/{id}', 'AboutController@companyUpdate');
                Route::delete('delete/{id}', 'AboutController@companyDestroy');
            });
            Route::prefix('map')->group(function () {
                Route::get('/', 'AboutController@mapIndex');
                Route::get('add', 'AboutController@mapAdd');
                Route::get('edit/{id}', 'AboutController@mapEdit');
                Route::post('insert', 'AboutController@mapInsert');
                Route::post('update/{id}', 'AboutController@mapUpdate');
                Route::delete('delete/{id}', 'AboutController@mapDestroy');
            });
            Route::prefix('service')->group(function () {
                Route::get('/', 'AboutController@serviceIndex');
                Route::get('add', 'AboutController@serviceAdd');
                Route::get('edit/{id}', 'AboutController@serviceEdit');
                Route::post('insert', 'AboutController@serviceInsert');
                Route::post('update/{id}', 'AboutController@serviceUpdate');
                Route::delete('delete/{id}', 'AboutController@serviceDestroy');
            });
            Route::prefix('aboutcatecustomer')->group(function () {
                Route::get('/', 'AboutController@catecustomerIndex');
                Route::get('add', 'AboutController@catecustomerAdd');
                Route::get('edit/{id}', 'AboutController@catecustomerEdit');
                Route::post('insert', 'AboutController@catecustomerInsert');
                Route::post('update/{id}', 'AboutController@catecustomerUpdate');
                Route::delete('delete/{id}', 'AboutController@catecustomerDestroy');
            });
            Route::prefix('aboutcustomer')->group(function () {
                Route::get('/', 'AboutController@aboutcustomerIndex');
                Route::get('add', 'AboutController@aboutcustomerAdd');
                Route::get('edit/{id}', 'AboutController@aboutcustomerEdit');
                Route::post('insert', 'AboutController@aboutcustomerInsert');
                Route::post('update/{id}', 'AboutController@aboutcustomerUpdate');
                Route::delete('delete/{id}', 'AboutController@aboutcustomerDestroy');
            });
            Route::prefix('certificate')->group(function () {
                Route::get('/', 'AboutController@certificateIndex');
                Route::get('add', 'AboutController@certificateAdd');
                Route::get('edit/{id}', 'AboutController@certificateEdit');
                Route::post('insert', 'AboutController@certificateInsert');
                Route::post('update/{id}', 'AboutController@certificateUpdate');
                Route::delete('delete/{id}', 'AboutController@certificateDestroy');
                
            });
            Route::prefix('holiday')->group(function () {
                Route::get('/', 'AboutController@holidayIndex');
                Route::post('update/{id}', 'AboutController@holidayUpdate');
                Route::delete('delete/{id}', 'AboutController@destroy_holiday');
            });
        });
        Route::prefix('contact')->group(function () {

            Route::get('/', 'ContactController@index');
            Route::get('add', 'ContactController@add');
            Route::get('edit/{id}', 'ContactController@edit');
            Route::post('insert', 'ContactController@insert');
            Route::post('update/{id}', 'ContactController@update');
            Route::post('updatet_', 'ContactController@updatet_');
            Route::delete('delete/{id}', 'ContactController@destroy');
        });
        Route::prefix('career')->group(function () {
            Route::get('/', 'CareerController@index');
            Route::get('add', 'CareerController@add');
            Route::get('edit/{id}', 'CareerController@edit');
            Route::post('insert', 'CareerController@insert');
            Route::post('update/{id}', 'CareerController@update');
            Route::delete('delete/{id}', 'CareerController@destroy');
        });
        Route::prefix('promotion')->group(function () {
            Route::get('/', 'PromotionController@index');
            Route::get('add', 'PromotionController@add');
            Route::get('edit/{id}', 'PromotionController@edit');
            Route::post('insert', 'PromotionController@insert');
            Route::post('update/{id}', 'PromotionController@update');
            Route::delete('delete/{id}', 'PromotionController@destroy');
        });
        Route::prefix('news')->group(function () {
            Route::get('/', 'NewsController@index');
            Route::get('add', 'NewsController@add');
            Route::get('edit/{id}', 'NewsController@edit');
            Route::post('insert', 'NewsController@insert');
            Route::post('update/{id}', 'NewsController@update');
            Route::delete('delete/{id}', 'NewsController@destroy');
        });
        Route::prefix('project')->group(function () {
            Route::get('/', 'ProjectController@index');
            Route::get('add', 'ProjectController@add');
            Route::get('edit/{id}', 'ProjectController@edit');
            Route::post('insert', 'ProjectController@insert');
            Route::post('update/{id}', 'ProjectController@update');
            Route::delete('delete/{id}', 'ProjectController@destroy');
            Route::post('uploadGallery', 'ProjectController@uploadGallery');
            Route::get('deleteGallery', 'ProjectController@deleteGallery');
        });
        Route::prefix('projectcategory')->group(function () {
            Route::get('/', 'ProjectCategoryController@index');
            Route::get('add', 'ProjectCategoryController@add');
            Route::get('edit/{id}', 'ProjectCategoryController@edit');
            Route::post('insert', 'ProjectCategoryController@insert');
            Route::post('update/{id}', 'ProjectCategoryController@update');
            Route::delete('delete/{id}', 'ProjectCategoryController@destroy');
        });


        Route::prefix('safety')->group(function () {
            Route::get('/', 'SafetyController@index');
            Route::get('add', 'SafetyController@add');
            Route::get('edit/{id}', 'SafetyController@edit');
            Route::post('insert', 'SafetyController@insert');
            Route::post('update/{id}', 'SafetyController@update');
            Route::delete('delete/{id}', 'SafetyController@destroy');
            Route::post('uploadGallery', 'SafetyController@uploadGallery');
            Route::get('deleteGallery', 'SafetyController@deleteGallery');
        });
        Route::prefix('safetycategory')->group(function () {
            Route::get('/', 'SafetyCategoryController@index');
            Route::get('add', 'SafetyCategoryController@add');
            Route::get('edit/{id}', 'SafetyCategoryController@edit');
            Route::post('insert', 'SafetyCategoryController@insert');
            Route::post('update/{id}', 'SafetyCategoryController@update');
            Route::delete('delete/{id}', 'SafetyCategoryController@destroy');
        });


        Route::prefix('technical')->group(function () {
            Route::get('/', 'TechnicalController@index');
            Route::get('add', 'TechnicalController@add');
            Route::get('edit/{id}', 'TechnicalController@edit');
            Route::post('insert', 'TechnicalController@insert');
            Route::post('update/{id}', 'TechnicalController@update');
            Route::delete('delete/{id}', 'TechnicalController@destroy');
            Route::post('uploadGallery', 'TechnicalController@uploadGallery');
            Route::get('deleteGallery', 'TechnicalController@deleteGallery');
        });
        Route::prefix('technicalcategory')->group(function () {
            Route::get('/', 'TechnicalCategoryController@index');
            Route::get('add', 'TechnicalCategoryController@add');
            Route::get('edit/{id}', 'TechnicalCategoryController@edit');
            Route::post('insert', 'TechnicalCategoryController@insert');
            Route::post('update/{id}', 'TechnicalCategoryController@update');
            Route::delete('delete/{id}', 'TechnicalCategoryController@destroy');
        });


        Route::prefix('maintenance')->group(function () {
            Route::get('/', 'MaintenanceController@index');
            Route::get('add', 'MaintenanceController@add');
            Route::get('edit/{id}', 'MaintenanceController@edit');
            Route::post('insert', 'MaintenanceController@insert');
            Route::post('update/{id}', 'MaintenanceController@update');
            Route::delete('delete/{id}', 'MaintenanceController@destroy');
            Route::post('uploadGallery', 'MaintenanceController@uploadGallery');
            Route::get('deleteGallery', 'MaintenanceController@deleteGallery');
        });
        Route::prefix('maintenancecategory')->group(function () {
            Route::get('/', 'MaintenanceCategoryController@index');
            Route::get('add', 'MaintenanceCategoryController@add');
            Route::get('edit/{id}', 'MaintenanceCategoryController@edit');
            Route::post('insert', 'MaintenanceCategoryController@insert');
            Route::post('update/{id}', 'MaintenanceCategoryController@update');
            Route::delete('delete/{id}', 'MaintenanceCategoryController@destroy');
        });


        Route::prefix('install')->group(function () {
            Route::get('/', 'InstallController@index');
            Route::get('add', 'InstallController@add');
            Route::get('edit/{id}', 'InstallController@edit');
            Route::post('insert', 'InstallController@insert');
            Route::post('update/{id}', 'InstallController@update');
            Route::delete('delete/{id}', 'InstallController@destroy');
            Route::post('uploadGallery', 'InstallController@uploadGallery');
            Route::get('deleteGallery', 'InstallController@deleteGallery');
        });
        Route::prefix('installcategory')->group(function () {
            Route::get('/', 'InstallCategoryController@index');
            Route::get('add', 'InstallCategoryController@add');
            Route::get('edit/{id}', 'InstallCategoryController@edit');
            Route::post('insert', 'InstallCategoryController@insert');
            Route::post('update/{id}', 'InstallCategoryController@update');
            Route::delete('delete/{id}', 'InstallCategoryController@destroy');
        });
        Route::prefix('ecatalogue')->group(function () {
            Route::get('/', 'EcatalogueController@index');
            Route::get('add', 'EcatalogueController@add');
            Route::get('edit/{id}', 'EcatalogueController@edit');
            Route::post('insert', 'EcatalogueController@insert');
            Route::post('update/{id}', 'EcatalogueController@update');
            Route::delete('delete/{id}', 'EcatalogueController@destroy');
        });


        Route::prefix('portfolio')->group(function () {
            Route::get('/', 'PortfolioController@index');
            Route::get('add', 'PortfolioController@add');
            Route::get('edit/{id}', 'PortfolioController@edit');
            Route::post('insert', 'PortfolioController@insert');
            Route::post('update/{id}', 'PortfolioController@update');
            Route::delete('delete/{id}', 'PortfolioController@destroy');
            Route::post('uploadGallery', 'PortfolioController@uploadGallery');
            Route::get('deleteGallery', 'PortfolioController@deleteGallery');
        });
        Route::prefix('portfoliocategory')->group(function () {
            Route::get('/', 'PortfolioCategoryController@index');
            Route::get('add', 'PortfolioCategoryController@add');
            Route::get('edit/{id}', 'PortfolioCategoryController@edit');
            Route::post('insert', 'PortfolioCategoryController@insert');
            Route::post('update/{id}', 'PortfolioCategoryController@update');
            Route::delete('delete/{id}', 'PortfolioCategoryController@destroy');
        });
        Route::prefix('product')->group(function () {
            Route::get('/', 'ProductController@index');
            Route::get('add', 'ProductController@add');
            Route::get('export_excel', 'ProductController@export_excel');
            Route::get('export_excel_sku', 'ProductController@export_excel_sku');
            Route::get('add/{id}', 'ProductController@clone');
            Route::get('edit/{id}', 'ProductController@edit');
            Route::post('importExcel', 'ProductController@importExcel');
            Route::post('importExcelsku', 'ProductController@importExcel_sku');
            Route::post('insert', 'ProductController@insert');
            Route::post('changeStatus', 'ProductController@changeStatus');
            Route::post('changeDescription', 'ProductController@changeDescription');
            Route::post('update/{id}', 'ProductController@update');
            Route::delete('delete/{id}', 'ProductController@destroy');
            Route::get('delete_sku/{id}', 'ProductController@delete_sku');
            Route::post('uploadGallery', 'ProductController@uploadGallery');
            Route::get('deleteGallery', 'ProductController@deleteGallery');
            Route::get('gallery/{id}', 'ProductController@gallery');
            Route::get('subCateByCate/{id}', 'ProductController@subCateByCate');
            Route::get('getSeries/{id}', 'ProductController@getSeries');
            Route::get('clear', 'ProductController@clear');
            Route::post('clear/delete', 'ProductController@cleardelete');
        });
        Route::prefix('order')->group(function () {
            Route::get('/', 'OrderController@index');
            Route::get('gallery/{id}', 'OrderController@gallery');
            Route::post('/update', 'OrderController@update');
            Route::post('/update_detailPayment', 'OrderController@updateConfirmPayment');
            Route::post('/Tracking_Number', 'OrderController@Tracking_Number');
            Route::post('/update_shipping_cost', 'OrderController@update_shipping_cost');
            Route::post('/updateshippingcost', 'OrderController@updateshippingcost');
            Route::post('confirmChangStatus/{id}', 'OrderController@confirmChangStatus');
        });
        Route::prefix('quotation')->group(function () {
            Route::get('/', 'QuotationController@index');
            Route::get('add', 'QuotationController@add');
            Route::get('add/{id}', 'QuotationController@clone');
            Route::get('edit/{id}', 'QuotationController@edit');
            Route::post('insert', 'QuotationController@insert');
            Route::post('changeStatus', 'QuotationController@changeStatus');
            Route::post('update/{id}', 'QuotationController@update');
            Route::delete('delete/{id}', 'QuotationController@destroy');
            Route::post('uploadGallery', 'QuotationController@uploadGallery');
            Route::get('deleteGallery', 'QuotationController@deleteGallery');
            Route::get('gallery/{id}', 'QuotationController@gallery');
            Route::get('pdf/{id}', 'QuotationController@pdf');
            Route::get('subCateByCate/{id}', 'QuotationController@subCateByCate');
        });
        Route::prefix('seo')->group(function () {
            Route::get('/', 'SeoController@index');
            Route::post('/', 'SeoController@insert');
            Route::get('add', 'SeoController@add');
            Route::get('add/{id}', 'SeoController@clone');
            Route::get('edit/{id}', 'SeoController@edit');
            Route::post('changeStatus', 'SeoController@changeStatus');
            Route::post('update/{id}', 'SeoController@update');
            Route::delete('delete/{id}', 'SeoController@destroy');
            Route::post('uploadGallery', 'SeoController@uploadGallery');
            Route::get('deleteGallery', 'SeoController@deleteGallery');
            Route::get('gallery/{id}', 'SeoController@gallery');
            Route::get('subCateByCate/{id}', 'SeoController@subCateByCate');
        });
        Route::prefix('member')->group(function () {
            Route::get('/', 'MemberController@index');
            Route::get('new', 'MemberController@index_membernew');
            Route::post('changeStatus', 'MemberController@changeStatus');
            Route::post('change_role', 'MemberController@change_role');
            Route::post('update', 'MemberController@update');
            Route::delete('delete/{id}', 'MemberController@destroy');
            Route::get('order/{id}', 'MemberController@Order');
        });
        Route::prefix('subscribe')->group(function () {
            Route::get('/', 'SubscribeController@index');
        });
        Route::prefix('subcategory')->group(function () {
            Route::get('/', 'SubCategoryController@index');
            Route::get('add', 'SubCategoryController@add');
            Route::get('edit/{id}', 'SubCategoryController@edit');
            Route::post('insert', 'SubCategoryController@insert');
            Route::post('update/{id}', 'SubCategoryController@update');
            Route::delete('delete_series/{id}', 'SubCategoryController@destroy_series');
            Route::delete('delete/{id}', 'SubCategoryController@destroy');
            Route::post('changeSort', 'SubCategoryController@changeSort');
        });
        Route::prefix('brand')->group(function () {
            Route::get('/', 'BrandController@index');
            Route::get('add', 'BrandController@add');
            Route::get('edit/{id}', 'BrandController@edit');
            Route::post('insert', 'BrandController@insert');
            Route::post('update/{id}', 'BrandController@update');
            Route::delete('delete/{id}', 'BrandController@destroy');
        });
        Route::prefix('shippingcost')->group(function () {
            Route::get('/', 'ShippingCostController@index');
            Route::post('update/{id}', 'ShippingCostController@update');
        });
        Route::prefix('faq')->group(function () {
            Route::get('/', 'FaqController@index');
            Route::get('add', 'FaqController@add');
            Route::get('edit/{id}', 'FaqController@edit');
            Route::post('insert', 'FaqController@insert');
            Route::post('update/{id}', 'FaqController@update');
            Route::delete('delete/{id}', 'FaqController@destroy');
            Route::post('changeSort', 'FaqController@changeSort');
        });
        Route::prefix('User')->group(function () {
            Route::get('/', 'UserController@index');
            Route::get('add', 'UserController@add');
            Route::get('edit/{id}', 'UserController@edit');
            Route::post('insert', 'UserController@insert');
            Route::post('update/{id}', 'UserController@update');
            Route::delete('delete/{id}', 'UserController@destroy');
        });

    });
});

Route::get('/clc', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    // Artisan::call('view:clear');
    // session()->forget('key');
    return "Cleared!";
  
});
// Route::get('/home', 'HomeController@index')->name('home');
