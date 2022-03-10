<?php

/* Admin login routes */


Route::get('login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('login', 'Auth\AdminLoginController@login')->name('admin.login.post');
Route::post('logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
Route::get('password/reset', 'Auth\Admin\ForgotPasswordController@showLinkRequestForm');
Route::post('password/email', 'Auth\Admin\ForgotPasswordController@sendResetLinkEmail');
Route::get('password/reset/{token}', 'Auth\Admin\ResetPasswordController@showResetForm');
Route::post('password/reset', 'Auth\Admin\ResetPasswordController@reset')->name('admin/password/reset');


Route::group(['middleware' => 'admin','namespace'=>'Admin'], function () {
    /** Dashboard route */
    Route::get('/dashboard', 'DashboardController@index')->name('admin_dashboard');
    Route::get('chart/data', 'DashboardController@chartData')->name('chart/data');
    /**User management route list */
    Route::group([ 'prefix' => 'user'], function () {
        Route::group(['middleware' => ['auth:admin']],function () {
            Route::get('/', ['as' => 'user_index', 'middleware' => ['role_or_permission:superadmin|user view'], 'uses' => 'UserController@index']);
            Route::get('create', ['as' => 'user_create', 'middleware' => ['role_or_permission:superadmin|user create'], 'uses' => 'UserController@create']);
            Route::get('edit/{id}', ['as' => 'user_edit', 'middleware' => ['role_or_permission:superadmin|user edit'], 'uses' => 'UserController@create'])->middleware('signed');
            Route::match(['post', 'PUT'], 'user/store', [
                'as' => 'user_store',
                'uses' => 'UserController@store',
            ]);
            Route::post('active_inactive', ['as' => 'user_active_inactive', 'middleware' => ['role_or_permission:superadmin|user multiple active|user multiple inactive'], 'uses' => 'UserController@updateStatus']);
            Route::delete('delete', ['as' => 'user_delete', 'middleware' => ['role_or_permission:superadmin|user delete'], 'uses' => 'UserController@destroyUser']);
            Route::post('multi_delete', ['as' => 'user_multi_delete', 'middleware' => ['role_or_permission:superadmin|user multiple delete'], 'uses' => 'UserController@multideleteUser']);
            Route::get('export', ['as' => 'user_export', 'uses' => 'UserController@exportUsers']);
        });
        Route::get('datatable', ['as' => 'user_datatable', 'uses' => 'UserController@getdata']);
    });

    /**Role management */
    Route::group([ 'prefix' => 'role'], function () {
        Route::group(['middleware' => ['auth:admin']],function () {
            Route::get('/', ['as' => 'role_index', 'middleware' => ['role_or_permission:superadmin|role view'], 'uses' => 'RoleController@index']);
            Route::get('create', ['as' => 'role_create', 'middleware' => ['role_or_permission:superadmin|role create'], 'uses' => 'RoleController@create']);
            Route::get('edit/{id}', ['as' => 'role_edit', 'middleware' => ['role_or_permission:superadmin|role edit'], 'uses' => 'RoleController@create'])->middleware('signed');
            Route::match(['post', 'PUT'], 'role/store', [
                'as' => 'role_store',
                'uses' => 'RoleController@store',
            ]);
            Route::delete('delete', ['as' => 'role_delete', 'middleware' => ['role_or_permission:superadmin|role delete'], 'uses' => 'RoleController@destroyRole']);
            Route::post('multi_delete', ['as' => 'role_multi_delete', 'middleware' => ['role_or_permission:superadmin|role multiple delete'], 'uses' => 'RoleController@multideleteRole']);
        });
        Route::get('datatable', ['as' => 'role_datatable', 'uses' => 'RoleController@getdata']);
    });
    /**Admin management */
    Route::group(['middleware' => ['admin'], 'prefix' => 'admin'], function () {
        Route::group(['middleware' => ['auth:admin']],function () {
            Route::get('/', ['as' => 'admin_index', 'middleware' => ['role_or_permission:superadmin|admin view'], 'uses' => 'AdminController@index']);
            Route::get('/create', ['as' => 'admin_create', 'middleware' => ['role_or_permission:superadmin|admin create'], 'uses' => 'AdminController@create']);
            Route::get('/edit/{id}', ['as' => 'admin_edit', 'middleware' => ['role_or_permission:superadmin|admin edit'], 'uses' => 'AdminController@create'])->middleware('signed');
            Route::match(['post', 'PUT'], 'admin/store', [
                'as' => 'admin_store',
                'uses' => 'AdminController@store',
            ]);
            Route::post('active_inactive', ['as' => 'admin_active_inactive', 'middleware' => ['role_or_permission:superadmin|admin multiple active | admin multiple inactive'], 'uses' => 'AdminController@updateStatus']);
            Route::delete('delete', ['as' => 'admin_delete', 'middleware' => ['role_or_permission:superadmin|admin delete'], 'uses' => 'AdminController@destroyAdmin']);
            Route::post('/multi_delete', ['as' => 'admin_multi_delete', 'middleware' => ['role_or_permission:superadmin|admin multiple delete'], 'uses' => 'AdminController@multideleteAdmin']);
        });
        Route::get('/datatable', ['as' => 'admin_datatable', 'uses' => 'AdminController@getdata']);
    });
    /**Permission route list */
    Route::group([ 'prefix' => 'permission'], function () {
        Route::group(['middleware' => ['auth:admin']],function () {
            Route::get('/', ['as' => 'permission_index', 'middleware' => ['role_or_permission:superadmin|permission view'], 'uses' => 'PermissionController@index']);
            Route::get('create', ['as' => 'permission_create', 'middleware' => ['role_or_permission:superadmin|permission create'], 'uses' => 'PermissionController@create']);
            Route::get('edit/{id}', ['as' => 'permission_edit', 'middleware' => ['role_or_permission:superadmin|permission edit'], 'uses' => 'PermissionController@create'])->middleware('signed');
            Route::match(['post', 'PUT'], 'store', [
                'as' => 'permission_store',
                'uses' => 'PermissionController@store',
            ]);
            Route::delete('delete', ['as' => 'permission_delete', 'middleware' => ['role_or_permission:superadmin|permission delete'], 'uses' => 'PermissionController@destroyPermission']);
            Route::post('multi_delete', ['as' => 'permission_multi_delete', 'middleware' => ['role_or_permission:superadmin|permission multiple delete'], 'uses' => 'PermissionController@multideletePermission']);
        });
        Route::get('/datatable', ['as' => 'permission_datatable', 'uses' => 'PermissionController@getdata']);
    });

    /**CMS route list */
    Route::group([ 'prefix' => 'CMS', 'middleware' => ['auth:admin']], function () {
        Route::get('/', ['as' => 'cms_index','uses' => 'CMSController@index']);
        Route::get('create/{type?}', ['as' => 'cms.create','uses' => 'CMSController@create']);
        Route::get('edit/{type?}/{id}', ['as' => 'cms_edit','uses' => 'CMSController@create'])->middleware('signed');
        Route::match(['post', 'PUT'], 'store', ['as' => 'cms_store', 'uses' => 'CMSController@store']);
        Route::delete('delete', ['as' => 'cms_delete','uses' => 'CMSController@destroyCms']);
        Route::post('multi_delete', ['as' => 'cms_multi_delete', 'uses' => 'CMSController@multideleteCMS']);
        Route::get('/datatable', ['as' => 'cms_datatable', 'uses' => 'CMSController@getdata']);
    });

    /**Contact Us route list */
    Route::group([ 'prefix' => 'contactus'], function () {
        Route::group(['middleware' => ['auth:admin']],function () {
            Route::get('/', ['as' => 'contact_us_index', 'middleware' => ['role_or_permission:superadmin|contact us view'], 'uses' => 'ContactUsController@index']);
            Route::get('create', ['as' => 'contact_us_create', 'middleware' => ['role_or_permission:superadmin|contact us create'], 'uses' => 'ContactUsController@create']);
            Route::get('edit/{id}', ['as' => 'contact_us_edit', 'middleware' => ['role_or_permission:superadmin|contact us edit'], 'uses' => 'ContactUsController@create'])->middleware('signed');
            Route::match(['post', 'PUT'], 'store', [
                'as' => 'contact_us_store',
                'uses' => 'ContactUsController@store',
            ]);
            Route::delete('delete', ['as' => 'contact_us_delete', 'middleware' => ['role_or_permission:superadmin|contact us delete'], 'uses' => 'ContactUsController@destroyContactUs']);
            Route::post('multi_delete', ['as' => 'contact_us_multi_delete', 'middleware' => ['role_or_permission:superadmin|contact us multiple delete'], 'uses' => 'ContactUsController@multideleteContactUs']);
        });
        Route::get('/datatable', ['as' => 'contact_us_datatable', 'uses' => 'ContactUsController@getdata']);
    });
    Route::group([ 'prefix' => 'websetting','middleware' => ['auth:admin']], function () {
        Route::get('/{activeTab?}','SettingController@index')->name('web_setting_index')->middleware(['role_or_permission:superadmin|web setting view']);
        Route::match(['post', 'PUT'],'/store/{id?}','SettingController@store')->name('general_setting_store');
    });
    Route::group([ 'prefix' => 'profile','middleware' => ['auth:admin']], function () {
        Route::get('/','AdminController@profile')->name('profile');//->middleware(['role_or_permission:superadmin|profile view']);
        Route::match(['post', 'PUT'], '/store/{id}','AdminController@store')->name('profile_update');//->middleware(['role_or_permission:superadmin|profile update']);
    });
    Route::group([ 'prefix' => 'papercategory'], function () {
        Route::group(['middleware' => ['auth:admin']],function () {
            Route::get('/','PaperCategoryController@index')->name('paper_category_index')->middleware(['role_or_permission:superadmin|paper category view']);
            Route::get('view/{uuid?}','PaperCategoryController@show')->name('paper_category_view')->middleware(['role_or_permission:superadmin|paper category view']);
            Route::get('create', 'PaperCategoryController@create')->name('paper_category_create')->middleware(['role_or_permission:superadmin|paper category create']);
            Route::get('edit/{id}', 'PaperCategoryController@create')->name('paper_category_edit')->middleware(['role_or_permission:superadmin|paper category edit'],'signed');
            Route::match(['post', 'PUT'],'store','PaperCategoryController@store')->name('paper_category_store');
            Route::delete('delete', 'PaperCategoryController@destroyPaperCategory')->name('paper_category_delete')->middleware(['role_or_permission:superadmin|paper category delete']);
            Route::post('multi_delete', 'PaperCategoryController@multiDeletePaperCategory')->name('paper_category_multi_delete')->middleware(['role_or_permission:superadmin|paper category multiple delete']);
            Route::post('active_inactive', 'PaperCategoryController@updateStatus')->name('paper_category_active_inactive')->middleware(['role_or_permission:superadmin|paper category multiple active|paper category multiple inactive']);
        });
        Route::get('/datatable', 'PaperCategoryController@getdata')->name('paper_category_datatable');
    });
    Route::group([ 'prefix' => 'subject'], function () {
        Route::group(['middleware' => ['auth:admin']],function () {
            Route::get('/','SubjectController@index')->name('subject_index')->middleware(['role_or_permission:superadmin|subject view']);
            Route::get('view/{uuid?}','SubjectController@show')->name('subject_view')->middleware(['role_or_permission:superadmin|subject view']);
            Route::get('create', 'SubjectController@create')->name('subject_create')->middleware(['role_or_permission:superadmin|subject create']);
            Route::get('edit/{id}', 'SubjectController@create')->name('subject_edit')->middleware(['role_or_permission:superadmin|subject edit'],'signed');
            Route::match(['post', 'PUT'],'store','SubjectController@store')->name('subject_store');
            Route::delete('delete', 'SubjectController@destroySubject')->name('subject_delete')->middleware(['role_or_permission:superadmin|subject delete']);
            Route::post('multi_delete', 'SubjectController@multiDeleteSubject')->name('subject_multi_delete')->middleware(['role_or_permission:superadmin|subject multiple delete']);
            Route::post('active_inactive', 'SubjectController@updateStatus')->name('subject_active_inactive')->middleware(['role_or_permission:superadmin|subject multiple active|subject multiple inactive']);
        });
        Route::get('/datatable', 'SubjectController@getdata')->name('subject_datatable');
        Route::post('/sorting', 'SubjectController@sorting')->name('subject_sorting');
    });
    Route::group([ 'prefix' => 'examtypes'], function () {
        Route::group(['middleware' => ['auth:admin']],function () {
            Route::get('/','ExamTypeController@index')->name('exam_types_index')->middleware(['role_or_permission:superadmin|exam types view']);
            Route::get('create', 'ExamTypeController@create')->name('exam_types_create')->middleware(['role_or_permission:superadmin|exam types create']);
            Route::get('edit/{id}', 'ExamTypeController@create')->name('exam_types_edit')->middleware(['role_or_permission:superadmin|exam types edit'],'signed');
            Route::match(['post', 'PUT'],'store','ExamTypeController@store')->name('exam_types_store');
            Route::delete('delete', 'ExamTypeController@destroy')->name('exam_types_delete')->middleware(['role_or_permission:superadmin|exam types delete']);
            Route::post('multi_delete', 'ExamTypeController@multidelete')->name('exam_types_multi_delete')->middleware(['role_or_permission:superadmin|exam types multiple delete']);
            Route::post('active_inactive', 'ExamTypeController@updateStatus')->name('exam_types_active_inactive')->middleware(['role_or_permission:superadmin|exam types multiple active|exam types multiple inactive']);
        });
        Route::get('/datatable', 'ExamTypeController@getdata')->name('exam_types_datatable');
    });
    // Test Paper Management Routes
    Route::group([ 'prefix' => 'papers'], function () {
        Route::group(['middleware' => ['auth:admin']],function () {
            Route::get('/','PaperController@index')->name('paper_index')->middleware(['role_or_permission:superadmin|paper view']);
            Route::get('view/{uuid?}','PaperController@show')->name('paper_view')->middleware(['role_or_permission:superadmin|paper view']);
            Route::get('create', 'PaperController@create')->name('paper_create')->middleware(['role_or_permission:superadmin|paper create']);
            Route::get('edit/{id}', 'PaperController@create')->name('paper_edit')->middleware(['role_or_permission:superadmin|paper edit'],'signed');
            Route::match(['post', 'PUT'],'store','PaperController@store')->name('paper_store');
            Route::delete('delete', 'PaperController@destroyPaper')->name('paper_delete')->middleware(['role_or_permission:superadmin|paper delete']);
            Route::post('multi_delete', 'PaperController@multideletePaper')->name('paper_multi_delete')->middleware(['role_or_permission:superadmin|paper multiple delete']);
            Route::post('active_inactive', 'PaperController@updateStatus')->name('paper_active_inactive')->middleware(['role_or_permission:superadmin|paper multiple active|paper multiple inactive']);
            Route::match(['post', 'PUT'],'storeBlock','PaperController@storeBlock')->name('paper_block_store');
            Route::get('versions/{uuid?}','PaperController@versionDetail')->name('paper_version')->middleware(['role_or_permission:superadmin|paper view']);
            Route::get('orderInfo/{uuid?}','PaperController@orderInfo')->name('paper_info')->middleware(['role_or_permission:superadmin|paper view']);
       });
        Route::post('/imageGet', 'PaperController@imageGet')->name('GetSelectedImage');
        Route::get('/datatable', 'PaperController@getdata')->name('paper_datatable');
        Route::get('/datatables', 'PaperController@getImage')->name('images_datatable');
        Route::get('media/download/{uuid?}', 'PaperController@downloadMedia')->name('download_pdf');
        Route::get('/getColumns','PaperController@getColumns')->name('getColumns');
    });

    // Block Management Routes
    Route::group([ 'prefix' => 'blocks'], function () {
        Route::group(['middleware' => ['auth:admin']],function () {
            Route::get('/{slug}','BlockController@index')->name('block_index');//->middleware(['role_or_permission:superadmin|paper view']);
            Route::match(['post', 'PUT'],'store','BlockController@store')->name('block_store');
        });
    });

    // Purchase Order Mail and Order Management
    Route::group([ 'prefix' => 'orders'], function () {
        Route::group(['middleware' => ['auth:admin']],function () {
            Route::get('/','OrderController@index')->name('order_index')->middleware(['role_or_permission:superadmin|order view']);
            Route::get('view/{uuid?}','OrderController@show')->name('order_view')->middleware(['role_or_permission:superadmin|order view']);
            Route::post('active_inactive', 'OrderController@updateStatus')->name('order_active_inactive')->middleware(['role_or_permission:superadmin|order multiple active|order multiple inactive']);
            Route::post('version-download','OrderController@downloadByVersion')->name('version_download');
            Route::post('send-mail','OrderController@sendMailUser')->name('send_mail');
            // Route::get('/mail/{id?}','OrderController@sendMail')->name('sendmail');
            // Route::get('/download/{orderId}/{paperId}','OrderController@download')->name('download');
        });
        Route::get('/datatable', 'OrderController@getdata')->name('order_datatable');
       // Route::get('media/download/{uuid?}', 'OrderController@downloadMedia')->name('download_pdf');
    });

    // Payment Management
    Route::group([ 'prefix' => 'payments'], function () {
        Route::group(['middleware' => ['auth:admin']],function () {
        Route::get('/','PaymentController@index')->name('payment_index')->middleware(['role_or_permission:superadmin|payment view']);
            Route::get('view/{uuid?}','PaymentController@show')->name('payment_view')->middleware(['role_or_permission:superadmin|payment view']);
            Route::post('active_inactive', 'PaymentController@updateStatus')->name('payment_active_inactive')->middleware(['role_or_permission:superadmin|payment multiple active|payment multiple inactive']);
        });
        Route::get('/datatable', 'PaymentController@getdata')->name('payment_datatable');
    });

    // Review Management
    Route::group([ 'prefix' => 'reviews'], function () {
        Route::group(['middleware' => ['auth:admin']],function () {
        Route::get('/','ReviewController@index')->name('review_index')->middleware(['role_or_permission:superadmin|review view']);
            Route::get('view/{uuid?}','ReviewController@show')->name('review_view')->middleware(['role_or_permission:superadmin|review view']);
            Route::post('active_inactive', 'ReviewController@updateStatus')->name('review_active_inactive')->middleware(['role_or_permission:superadmin|review multiple active|review multiple inactive|review active inactive']);
            Route::post('multi_delete', 'ReviewController@multideleteReview')->name('review_multi_delete')->middleware(['role_or_permission:superadmin|review multiple delete']);
            Route::delete('delete', 'ReviewController@destroy')->name('review_delete');//->middleware(['role_or_permission:superadmin|review delete']);

        });
        Route::get('/datatable', 'ReviewController@getdata')->name('review_datatable');
    });

    // Stages Management
    Route::group([ 'prefix' => 'stages'], function () {
        Route::group(['middleware' => ['auth:admin']],function () {
            Route::get('/','StageController@index')->name('stage_index')->middleware(['role_or_permission:superadmin|stage view']);
            Route::get('create', 'StageController@create')->name('stage_create')->middleware(['role_or_permission:superadmin|stage create']);
            Route::get('edit/{uuid}', 'StageController@create')->name('stage_edit')->middleware(['role_or_permission:superadmin|stage edit'],'signed');
            Route::match(['post', 'PUT'],'store','StageController@store')->name('stage_store');
            Route::delete('delete', 'StageController@destroy')->name('stage_delete')->middleware(['role_or_permission:superadmin|stage delete']);
            Route::post('multi_delete', 'StageController@multidelete')->name('stage_multi_delete')->middleware(['role_or_permission:superadmin|stage multiple delete']);
            Route::post('active_inactive', 'StageController@updateStatus')->name('stage_active_inactive')->middleware(['role_or_permission:superadmin|stage multiple active|stage multiple inactive']);
        });
        Route::get('/datatable', 'StageController@getdata')->name('stage_datatable');
    });

    // CMS Management Routes For Privacy Policy & Terms & Conditions Pages
    Route::group([ 'prefix' => 'cms'], function () {
        Route::group(['middleware' => ['auth:admin']],function () {
            Route::get('/{slug?}','CMSController@detail')->name('cms_pages');//->middleware(['role_or_permission:superadmin|paper view']);
            Route::match(['post', 'PUT'],'store','BlockController@store')->name('block_store');
        });
    });

    // Template management
    Route::group([ 'prefix' => 'emailtemplates'], function () {
        Route::group(['middleware' => ['auth:admin']],function () {
            Route::get('/','EmailTemplateController@index')->name('email_template_index')->middleware(['role_or_permission:superadmin|email template view']);
            Route::get('create', 'EmailTemplateController@create')->name('email_template_create')->middleware(['role_or_permission:superadmin|email template create']);
            Route::get('edit/{uuid}', 'EmailTemplateController@create')->name('email_template_edit')->middleware(['role_or_permission:superadmin|email template edit'],'signed');
            Route::match(['post', 'PUT'],'store','EmailTemplateController@store')->name('email_template_store');
            Route::delete('delete', 'EmailTemplateController@destroy')->name('email_template_delete')->middleware(['role_or_permission:superadmin|email template delete']);
            Route::post('multi_delete', 'EmailTemplateController@multidelete')->name('email_template_multi_delete')->middleware(['role_or_permission:superadmin|email template multiple delete']);
            Route::post('active_inactive', 'EmailTemplateController@updateStatus')->name('email_template_active_inactive')->middleware(['role_or_permission:superadmin|email template multiple active|template multiple inactive']);
        });
        Route::get('/datatable', 'EmailTemplateController@getdata')->name('email_template_datatable');
    });

    // FAQ Management
    Route::group([ 'prefix' => 'faqs'], function () {
        Route::group(['middleware' => ['auth:admin']],function () {
            Route::get('/','FaqController@index')->name('faq_index')->middleware(['role_or_permission:superadmin|stage view']);
            Route::get('create', 'FaqController@create')->name('faq_create')->middleware(['role_or_permission:superadmin|stage create']);
            Route::get('edit/{uuid}', 'FaqController@create')->name('faq_edit')->middleware(['role_or_permission:superadmin|stage edit'],'signed');
            Route::match(['post', 'PUT'],'store','FaqController@store')->name('faq_store');
            Route::delete('delete', 'FaqController@destroy')->name('faq_delete')->middleware(['role_or_permission:superadmin|stage delete']);
            Route::post('multi_delete', 'FaqController@multidelete')->name('faq_multi_delete')->middleware(['role_or_permission:superadmin|stage multiple delete']);
            Route::post('active_inactive', 'FaqController@updateStatus')->name('faq_active_inactive')->middleware(['role_or_permission:superadmin|stage multiple active|stage multiple inactive']);
        });
        Route::get('/datatable', 'FaqController@getdata')->name('faq_datatable');
    });
    // Order Report
    Route::group([ 'prefix' => 'order-report'], function () {
        Route::get('/','ReportController@index')->name('order_reports_index');
        Route::post('generate','ReportController@generate')->name('generate_report');
        Route::get('getdata', 'ReportController@getdata')->name('order_report_data');
        Route::get('getSubjects','ReportController@getSubjects')->name('get_cat_subjects');
    });


    // Promo Code Management
    Route::group([ 'prefix' => 'promo-codes'], function () {
        Route::group(['middleware' => ['auth:admin']],function () {
            Route::get('/','PromoCodeController@index')->name('promo_code_index')->middleware(['role_or_permission:superadmin|stage view']);
            Route::get('create', 'PromoCodeController@create')->name('promo_code_create')->middleware(['role_or_permission:superadmin|stage create']);
            Route::get('edit/{uuid}', 'PromoCodeController@create')->name('promo_code_edit')->middleware(['role_or_permission:superadmin|stage edit'],'signed');
            Route::match(['post', 'PUT'],'store','PromoCodeController@store')->name('promo_code_store');
            Route::delete('delete', 'PromoCodeController@destroy')->name('promo_code_delete')->middleware(['role_or_permission:superadmin|stage delete']);
            Route::post('multi_delete', 'PromoCodeController@multidelete')->name('promo_code_multi_delete')->middleware(['role_or_permission:superadmin|stage multiple delete']);
            Route::post('active_inactive', 'PromoCodeController@updateStatus')->name('promo_code_active_inactive')->middleware(['role_or_permission:superadmin|stage multiple active|stage multiple inactive']);
        });
        Route::get('/datatable', 'PromoCodeController@getdata')->name('promo_code_datatable');

    });
    // For payment setting
    Route::match(['post', 'PUT'],'store','PaymentSettingController@store')->name('payment_setting_store');

    // Promo Code Management
    Route::group([ 'prefix' => 'logs'], function () {
        Route::group(['middleware' => ['auth:admin']],function () {
            Route::get('/','SearchLogController@index')->name('logs_index')->middleware(['role_or_permission:superadmin|stage view']);
            Route::delete('delete', 'SearchLogController@destroy')->name('logs_delete')->middleware(['role_or_permission:superadmin|stage delete']);
            Route::post('multi_delete', 'SearchLogController@multidelete')->name('logs_multi_delete')->middleware(['role_or_permission:superadmin|stage multiple delete']);
        });
        Route::get('/datatable', 'SearchLogController@getdata')->name('search_logs_datatable');
    });
});

Route::group(['middleware' => ['admin', 'auth:admin'],'namespace'=>'Admin'], function () {
    // For Subscription Management
    Route::get('subscriber', 'SubscriberController@index')->name('subscriber.index');
    Route::get('subscriber/datatable', 'SubscriberController@getDatatable')->name('subscriber/datatable');
    Route::post('subscriber/bulk/action', 'SubscriberController@bulkAction')->name('bulk/action');

    // For Resources
    Route::get('resources/datatable', 'ResourceController@getDatatable')->name('resources/datatable');
    Route::get('resources/datatable/guidance', 'ResourceController@getGuidanceDatatable')->name('resources/datatable/guidance');
    Route::post('resources/change/status/{restype}', 'ResourceController@changeStatus')->name('resources/change/status');
    Route::post('resources/bulk/action', 'ResourceController@bulkAction')->name('resources/bulk/action');
    Route::post('resources/{restype}/bulk/action', 'ResourceController@guidanceBulkAction')->name('resources/guidance/bulk/action');
    Route::get('resources/{restype}','ResourceController@index')->name('resources.index');
    Route::get('resources/{restype}/create','ResourceController@create')->name('resources.create');
    Route::post('resources/store','ResourceController@store')->name('resources.store');
    Route::get('resources/{restype}/{uuid}/edit','ResourceController@edit')->name('resources.edit');
    Route::put('resources/{uuid}/update','ResourceController@store')->name('resources.update');
    Route::delete('resources/{restype}/{uuid}/destroy','ResourceController@destroy')->name('resources.destroy');
    Route::get('media/download/{uuid}/{filetype}', 'ResourceController@downloadMedia')->name('resource.download.pdf');
    Route::post('editor/file/save', 'ResourceController@storeCKEditorFile')->name('editor/file/save');
    Route::post('/imageGet', 'ResourceController@imageGet')->name('resource.GetSelectedImage');
    Route::get('/datatables', 'ResourceController@getImage')->name('resource.images_datatable');


    // For Resource Category
    Route::post('resources/category/update','ResourceController@updateCategory')->name('resources/category/update');
    Route::post('/blog/sorting', 'ResourceController@sorting')->name('blog_sorting');


/* ---------------------------------------Ash Mock Routes start ------------------------------------------- */

        /*
        |--------------------------------------------------------------------------
        | For Student
        |--------------------------------------------------------------------------
        */
        Route::get('student/datatable', 'StudentController@getData')->name('admin/student/datatable');
        Route::post('/student/bulk/action', 'StudentController@bulkAction')->name('student/bulk/action');
        Route::get('student/{uuid}/show', 'StudentController@show')->name('admin.student.show');
        Route::get('student/{uuid}/edit', 'StudentController@edit')->name('admin.student.edit');
        Route::put('student/{uuid}/update', 'StudentController@update')->name('admin.student.update');
        Route::post('student/active_inactive/{id?}', 'StudentController@updateStatus')->name('student.active.inactive');
        Route::resource('student', 'StudentController');
        /*
        |--------------------------------------------------------------------------
        | For Schools
        |--------------------------------------------------------------------------
        */
        Route::get('schools/datatable', 'SchoolsController@getData')->name('admin/schools/datatable');
        Route::post('/schools/active_inactive/{id?}', 'SchoolsController@updateStatus')->name('schools/active/inactive');
        Route::post('/schools/bulk/action', 'SchoolsController@bulkAction')->name('schools/bulk/action');
        Route::get('schools/{uuid}/show', 'SchoolsController@show')->name('admin.schools.show');
        Route::get('schools/{uuid}/edit', 'SchoolsController@edit')->name('admin.schools.edit');
        Route::put('schools/{uuid}/update', 'SchoolsController@update')->name('admin.schools.update');
        Route::resource('schools', 'SchoolsController');


        /*
        |--------------------------------------------------------------------------
        | For Question
        |--------------------------------------------------------------------------
        */
        Route::group([ 'prefix' => 'question'], function () {
            Route::get('datatable', 'QuestionController@show')->name('question-datatable');
            Route::get('import', 'QuestionController@import')->name('question.import');
            Route::post('export', 'QuestionController@export')->name('question.export');
            Route::get('select', 'QuestionController@getBlade')->name('question.select');
            Route::post('import/file', 'QuestionController@insert')->name('question.importFile');
            Route::delete('delete/{id?}', ['as' => 'question.destroy', 'uses' => 'QuestionController@destroy']);
            Route::post('div', 'QuestionController@deleteQuestion')->name('question.edit-cloze');
            Route::post('active_inactive/{id?}', 'QuestionController@updateStatus')->name('question.active.inactive');
            Route::get('downloadPdf/{uuid?}','QuestionController@downloadPdf')->name('dowload.passage');
            // Route::resource('question', 'QuestionController')->except('show','destroy');
            Route::get('/','QuestionController@index')->name('question.index');
            Route::get('create/{uuid?}', 'QuestionController@create')->name('question.create');
            Route::get('detail/{uuid?}', 'QuestionController@detail')->name('question.detail');
            Route::match(['post', 'PUT'],'store/{uuid?}','QuestionController@store')->name('question.store');
            Route::get('edit-list-question/{uuid?}/{mockId?}','QuestionController@editQuestion')->name('edit-list-question');
            Route::match(['post', 'PUT'],'question-store/{uuid?}','QuestionController@storeQuestion')->name('question.list.store');
            Route::delete('delete-list-question/{uuid?}','QuestionController@deleteListQuestion')->name('delete-list-question');
            Route::post('upload-passage','QuestionController@uploadPassage')->name('upload-passage');
            Route::delete('delete-passage','QuestionController@deletePassage')->name('delete-passage');
            Route::get('add-list-question/{uuid?}/{mockId?}','QuestionController@addQuestion')->name('add-question');
            Route::post('image-upload', 'QuestionController@uploadImage')->name('question.uploadImage');
        });


        // Parent Management
        Route::group([ 'prefix' => 'parents'], function () {
            Route::get('/','ParentController@index')->name('parent_index');
            Route::get('create', 'ParentController@create')->name('parent_create');
            Route::get('edit/{uuid}', 'ParentController@create')->name('parent_edit');
            Route::match(['post', 'PUT'],'store','ParentController@store')->name('parent_store');
            Route::delete('delete', 'ParentController@destroy')->name('parent_delete');
            Route::post('multi_delete', 'ParentController@multidelete')->name('parent_multi_delete');
            Route::post('active_inactive', 'ParentController@updateStatus')->name('parent_active_inactive');
            Route::get('/datatable', 'ParentController@getdata')->name('parent_datatable');
            Route::post('/bulk/action', 'ParentController@bulkAction')->name('bulk_action');
            Route::get('import', 'ParentController@import')->name('parent_import');
            Route::post('import/file', 'ParentController@insert')->name('parent_importFile');
        });

        // Tution Parent Management
        // Route::group([ 'prefix' => 'tuition-parents'], function () {
        //     Route::get('/','TuitionParentController@index')->name('tuition_parent_index');
        //     Route::get('/datatable', 'TuitionParentController@getdata')->name('tuition_parent_datatable');
        //     Route::get('import', 'TuitionParentController@import')->name('tuition_parent_import');
        //     Route::post('import/file', 'TuitionParentController@insert')->name('tuition_parent_importFile');
        //     Route::get('sync', 'TuitionParentController@sync')->name('tuition_parent_sync');
        // });

        // Student Test Management
        Route::group([ 'prefix' => 'student-test'], function () {
            Route::get('/','StudentTestController@index')->name('student_test_index');
            Route::get('/reset-attempt/{uuid?}','StudentTestController@resetAttempt')->name('reset-attempt');
            Route::get('/datatable', 'StudentTestController@getdata')->name('student_test_datatable');
            Route::get('/mock-datatable', 'StudentTestController@getMockData')->name('student_mock_test_datatable');
            Route::get('/{uuid}/detail', 'StudentTestController@show')->name('student_test_detail');
            Route::get('/{uuid}/papers', 'StudentTestController@papers')->name('student_test_papers');
            Route::get('/{uuid}/{fromDate?}/{toDate?}/mocks', 'StudentTestController@studentMock')->name('student_test_show');
            Route::get('/{uuid}/report', 'StudentTestController@report')->name('student.test.report');
            Route::get('/download-report/{uuid?}','StudentTestController@show')->name('download-report');
            Route::get('email-report/{uuid?}','StudentTestController@emailReport')->name('email-report');
            Route::post('question-detail','StudentTestController@questionDetail')->name('report-question-detail');
            Route::get('view-result-questions/{uuid?}/{sectionId?}/{questionId?}','StudentTestController@viewQuestion')->name('view-result-questions');
            Route::get('view-result-incorrect-questions/{uuid?}/{sectionId?}/{questionId?}','StudentTestController@viewQuestion')->name('view-result-incorrect-questions');
        });

        /**Mock Exam management route list */
        Route::group(['prefix' => 'mock-test'], function () {
            Route::get('/', 'MockTestController@index')->name('mock-test.index');
            Route::get('create', 'MockTestController@create')->name('mock-test.create');
            Route::get('edit/{uuid}', 'MockTestController@create')->name('mock-test.edit')->middleware('signed');
            Route::match(['post', 'PUT'], '/store/{id?}', 'MockTestController@store')->name('mock-test.store');
            Route::delete('delete', 'MockTestController@destroy')->name('mock-test.delete');
            Route::get('datatable', 'MockTestController@getdata')->name('mock-test.datatable');
            Route::post('active_inactive', 'MockTestController@updateStatus')->name('mock-test.active_inactive');
            Route::post('multi_delete', 'MockTestController@multidelete')->name('mock-test.multi_delete');
            Route::post('subject_detail', 'MockTestController@subjectDetail')->name('mock-test.subject-detail');
            Route::post('questionList', 'MockTestController@questionList')->name('mock-test.question-list');
            Route::get('detail/{uuid}','MockTestController@detail')->name('mock-test.detail');
            Route::get('copy/{uuid}','MockTestController@create')->name('mock-test.copy');
            Route::match(['post', 'PUT'], '/copy-exam/{id?}', 'MockTestController@store')->name('mock-test.copy-exam');
            Route::post('/imageGet', 'MockTestController@imageGet')->name('mock-test.GetSelectedImage');
            Route::get('/datatables', 'MockTestController@getImage')->name('mock-test.images_datatable');
            Route::post('/mock-paper', 'MockTestController@generatePaperLayout')->name('mock-test.paper');
            Route::post('/import-questions','MockTestController@importQuestions')->name('mock.import.section');
        });

        /**Mock Exam management route list */
        Route::group(['prefix' => 'mock-paper'], function () {
            Route::get('create/{uuid?}', 'MockTestPaperController@create')->name('mock-paper.create');
            Route::match(['post', 'PUT'], '/store/{id?}', 'MockTestPaperController@store')->name('mock-paper.store');
            Route::get('edit/{uuid?}', 'MockTestPaperController@edit')->name('mock-paper.edit');
            Route::delete('delete/{uuid?}', 'MockTestPaperController@delete')->name('mock-paper.delete');
        });

        /**Subject CMS route list */
        Route::group([ 'prefix' => 'subject-cms', 'middleware' => ['auth:admin']], function () {
            Route::get('/', ['as' => 'subject-cms.index','uses' => 'CMSController@index']);
            Route::get('create', ['as' => 'subject-cms.create','uses' => 'CMSController@create']);
            Route::get('edit/{id}', ['as' => 'subject-cms.edit','uses' => 'CMSController@create'])->middleware('signed');
            Route::match(['post', 'PUT'], 'store', ['as' => 'subject-cms.store', 'uses' => 'CMSController@store']);
        });

        /**School CMS route list */
        Route::group([ 'prefix' => 'school-cms', 'middleware' => ['auth:admin']], function () {
            Route::get('/', ['as' => 'school-cms.index','uses' => 'CMSController@index']);
            Route::get('create', ['as' => 'school-cms.create','uses' => 'CMSController@create']);
            Route::get('edit/{id}', ['as' => 'school-cms.edit','uses' => 'CMSController@create'])->middleware('signed');
            Route::match(['post', 'PUT'], 'store', ['as' => 'school-cms.store', 'uses' => 'CMSController@store']);
            Route::post('/getMock','CMSController@getMock')->name('get-school-mock');
            Route::post('/imageGet', 'CMSController@imageGet')->name('cms.GetSelectedImage');
            Route::get('/datatables', 'CMSController@getImage')->name('cms.images_datatable');

        });

        /**Image management route list */
        Route::group([ 'prefix' => 'images', 'middleware' => ['auth:admin']], function () {
            Route::get('/', ['as' => 'images.index','uses' => 'ImageController@index']);
            Route::match(['post', 'PUT'], 'store', ['as' => 'images.store', 'uses' => 'ImageController@store']);
            Route::get('/datatable', 'ImageController@getdata')->name('Image_datatable');
            Route::get('create', 'ImageController@create')->name('image_create')->middleware(['role_or_permission:superadmin|stage create']);
            Route::get('edit/{id}', 'ImageController@create')->name('image_edit')->middleware(['role_or_permission:superadmin|stage edit'],'signed');
            Route::delete('delete', 'ImageController@destroy')->name('image_delete')->middleware(['role_or_permission:superadmin|stage delete']);
            Route::post('multi_delete', ['as' => 'image_multi_delete', 'uses' => 'ImageController@multideleteImage']);
        });

        Route::group([ 'middleware' => ['auth:admin'], 'prefix' => 'exam-board'], function () {
            Route::get('/','ExamBoardController@index')->name('examboard.index')->middleware(['role_or_permission:superadmin|stage view']);
            Route::get('create', 'ExamBoardController@create')->name('examboard.create')->middleware(['role_or_permission:superadmin|stage create']);
            Route::get('edit/{uuid}', 'ExamBoardController@create')->name('examboard.edit')->middleware(['role_or_permission:superadmin|stage edit'],'signed');
            Route::match(['post', 'PUT'],'store','ExamBoardController@store')->name('examboard.store');
            Route::delete('delete', 'ExamBoardController@destroy')->name('examboard.delete')->middleware(['role_or_permission:superadmin|stage delete']);
            Route::post('multi_delete', 'ExamBoardController@multidelete')->name('examboard.multi_delete')->middleware(['role_or_permission:superadmin|stage multiple delete']);
            Route::post('active_inactive', 'ExamBoardController@updateStatus')->name('examboard.active_inactive')->middleware(['role_or_permission:superadmin|stage multiple active|stage multiple inactive']);
            Route::get('/datatable', 'ExamBoardController@getdata')->name('examboard.datatable');
        });

        Route::group([ 'prefix' => 'report'], function () {
            Route::get('/','ReportController@mockReport')->name('report.index');
            Route::post('generateMock','ReportController@generateMock')->name('generate.mock.report');
            Route::get('getdata', 'ReportController@getdata')->name('report.data');
            Route::get('getSubjects','ReportController@getSubjects')->name('get_cat_subjects');
        });

        Route::post('store-topic','QuestionController@storeTopic')->name('topic.store');
        Route::post('validate-topic', 'QuestionController@validateTitle')->name('validate.topic.title');
        
        // Topic store
        Route::group(['prefix' => 'topic'], function () {
            Route::get('/', 'TopicController@index')->name('topic.index');
            Route::get('create', 'TopicController@create')->name('topic.create');
            Route::get('edit/{uuid}', 'TopicController@create')->name('topic.edit')->middleware('signed');
            Route::match(['post', 'PUT'], '/store/{id?}', 'TopicController@store')->name('topic.store');
            Route::delete('delete', 'TopicController@destroy')->name('topic.delete');
            Route::post('multi_delete', 'TopicController@multidelete')->name('topic.multi_delete')->middleware(['role_or_permission:superadmin|topic multiple delete']);
            Route::get('datatable', 'TopicController@getdata')->name('topic.datatable');
            Route::post('active_inactive', 'TopicController@updateStatus')->name('topic.active_inactive');
            Route::post('validate-topic', 'TopicController@validateTitle')->name('validate.topic.title');
        });

        // Topic store
        Route::group(['prefix' => 'result-grade'], function () {
            Route::get('/', 'ResultGradeController@index')->name('result-grade.index');
            Route::match(['post', 'PUT'], '/store/{id?}', 'ResultGradeController@store')->name('result-grade.store');
        });
/* ---------------------------------------Ash Mock Routes End --------------------------------------------- */

        /**Test Assessment management route list */
        Route::group(['prefix' => 'test-assessment'], function () {
            Route::get('/', 'TestAssessmentController@index')->name('test-assessment.index');
            Route::get('create', 'TestAssessmentController@create')->name('test-assessment.create');
            Route::get('edit/{uuid}', 'TestAssessmentController@create')->name('test-assessment.edit')->middleware('signed');
            Route::match(['post', 'PUT'], '/store/{id?}', 'TestAssessmentController@store')->name('test-assessment.store');
            Route::delete('delete', 'TestAssessmentController@destroy')->name('test-assessment.delete');
            Route::get('datatable', 'TestAssessmentController@getdata')->name('test-assessment.datatable');
            Route::post('active_inactive', 'TestAssessmentController@updateStatus')->name('test-assessment.active_inactive');
            Route::post('multi_delete', 'TestAssessmentController@multidelete')->name('test-assessment.multi_delete');
            Route::post('subject_detail', 'TestAssessmentController@subjectDetail')->name('test-assessment.subject-detail');
            Route::post('questionList', 'TestAssessmentController@questionList')->name('test-assessment.question-list');
            Route::get('detail/{uuid}','TestAssessmentController@detail')->name('test-assessment.detail');
            Route::get('copy/{uuid}','TestAssessmentController@create')->name('test-assessment.copy');
            Route::match(['post', 'PUT'], '/copy-exam/{id?}', 'TestAssessmentController@store')->name('test-assessment.copy-exam');
            Route::post('/imageGet', 'TestAssessmentController@imageGet')->name('test-assessment.GetSelectedImage');
            Route::get('/datatables', 'TestAssessmentController@getImage')->name('test-assessment.images_datatable');
        });

        /**Practice management route list */
        Route::group(['prefix' => 'practice-exam'], function () {
            Route::get('/', 'PracticeExamController@index')->name('practice-exam.index');
            Route::get('create', 'PracticeExamController@create')->name('practice-exam.create');
            Route::get('edit/{uuid}', 'PracticeExamController@create')->name('practice-exam.edit')->middleware('signed');
            Route::match(['post', 'PUT'], '/store/{id?}', 'PracticeExamController@store')->name('practice-exam.store');
            Route::delete('delete', 'PracticeExamController@destroy')->name('practice-exam.delete');
            Route::get('datatable', 'PracticeExamController@getdata')->name('practice-exam.datatable');
            Route::post('active_inactive', 'PracticeExamController@updateStatus')->name('practice-exam.active_inactive');
            Route::post('multi_delete', 'PracticeExamController@multidelete')->name('practice-exam.multi_delete');
            Route::post('get-topic-input', 'PracticeExamController@getTopicInputs')->name('practice-exam.get.inputs');
            Route::get('detail/{uuid}','PracticeExamController@detail')->name('practice-exam.detail');
            Route::get('copy/{uuid}','PracticeExamController@create')->name('practice-exam.copy');
            Route::match(['post', 'PUT'], '/copy-exam/{id?}', 'PracticeExamController@store')->name('practice-exam.copy-exam');
        });

        // Subscription route list
        Route::group(['prefix' => 'subscription'], function () {
            Route::get('/', 'SubscriptionController@index')->name('subscription.index');
            Route::get('create', 'SubscriptionController@create')->name('subscription.create');
            Route::get('edit/{uuid}', 'SubscriptionController@create')->name('subscription.edit')->middleware('signed');
            Route::match(['post', 'PUT'], '/store/{id?}', 'SubscriptionController@store')->name('subscription.store');
            Route::delete('delete', 'SubscriptionController@destroy')->name('subscription.delete');
            Route::post('multi_delete', 'SubscriptionController@multidelete')->name('subscription.multi_delete')->middleware(['role_or_permission:superadmin|topic multiple delete']);
            Route::get('datatable', 'SubscriptionController@getdata')->name('subscription.datatable');
            Route::post('active_inactive', 'SubscriptionController@updateStatus')->name('subscription.active_inactive');
        });

        // Parent Subscribers route list
        Route::group(['prefix' => 'parent-subscriber'], function () {
            Route::get('/', 'ParentSubscriberController@index')->name('parent-subscriber.index');
            Route::get('datatable', 'ParentSubscriberController@getDatatable')->name('parent-subscriber.datatable');
            Route::get('show/{parentId?}', 'ParentSubscriberController@show')->name('parent-subscriber.show');
            Route::get('payment-detail/{uuid}', 'ParentSubscriberController@paymentDetail')->name('parent-payment.detail');
            Route::get('payment-datatable', 'ParentSubscriberController@getPaymentDatatable')->name('parent-payment.datatable');
            Route::post('send-invoice', 'ParentSubscriberController@sendInvoice')->name('send-invoice');
        });

        // Weekly assement result
        Route::group([ 'prefix' => 'student-assessment-report'], function () {
            Route::get('/','StudentAssessmentController@index')->name('student-assessment-report.index');
            Route::get('datatable', 'StudentAssessmentController@getdata')->name('student-assessment-report.datatable');
            Route::get('{uuid}/{fromDate?}/{toDate?}/test', 'StudentAssessmentController@studentAssessment')->name('student-assessment-report.show');
            Route::get('assessment-datatable', 'StudentAssessmentController@getAssessmentData')->name('assessment-datatable');
            Route::get('{uuid}/detail', 'StudentAssessmentController@testAssessmentDetail')->name('test-assessment-detail');
            Route::get('/reset-assessment-attempt/{uuid?}','StudentAssessmentController@resetAttempt')->name('reset-assessment-attempt');
            Route::post('question-detail','StudentAssessmentController@questionDetail')->name('assessment-report-question-detail');
        });

        // practice by topic result
        Route::group([ 'prefix' => 'student-topic-report'], function () {
            Route::get('/','StudentPracticeByTopicController@index')->name('student-topic-report.index');
            Route::get('datatable', 'StudentPracticeByTopicController@getData')->name('student-topic-report.datatable');
            Route::get('{uuid}/{fromDate?}/{toDate?}/test', 'StudentPracticeByTopicController@studentAssessment')->name('student-topic-report.show');
            Route::get('assessment-datatable', 'StudentPracticeByTopicController@getAssessmentData')->name('test-topic-datatable');
            Route::get('{uuid}/detail', 'StudentPracticeByTopicController@testAssessmentDetail')->name('test-topic-detail');
        });

        // Weekly assessment result
        Route::group([ 'prefix' => 'past-paper'], function () {
            Route::get('/','PastPaperController@index')->name('past-paper.index')->middleware(['role_or_permission:superadmin|past paper view']);
            Route::get('create', 'PastPaperController@create')->name('past-paper.create')->middleware(['role_or_permission:superadmin|past paper create']);
            Route::get('edit/{uuid?}', 'PastPaperController@create')->name('past-paper.edit')->middleware(['role_or_permission:superadmin|past paper edit'],'signed');
            Route::get('show/{uuid?}', 'PastPaperController@show')->name('past-paper.show')->middleware(['role_or_permission:superadmin|past paper edit'],'signed');
            Route::match(['post', 'PUT'],'store','PastPaperController@store')->name('past-paper.store');
            Route::delete('delete', 'PastPaperController@destroy')->name('past-paper.delete')->middleware(['role_or_permission:superadmin|past paper delete']);
            Route::post('multi_delete', 'PastPaperController@multidelete')->name('past-paper.multi_delete')->middleware(['role_or_permission:superadmin|past paper multiple delete']);
            Route::post('active_inactive', 'PastPaperController@updateStatus')->name('past-paper.active_inactive')->middleware(['role_or_permission:superadmin|past paper multiple active|past paper multiple inactive']);
            Route::get('/datatable', 'PastPaperController@getdata')->name('past-paper.datatable');
            Route::get('download-media/{uuid?}','PastPaperController@downloadMedia')->name('download-media');
            Route::post('add-question','PastPaperController@addQuestion')->name('add.question');
            Route::get('edit/question/{id?}','PastPaperController@editQuestion')->name('edit.past-paper.question');
            Route::get('add/question/{id?}','PastPaperController@addPaperQuestion')->name('add.past-paper.question');
            Route::delete('delete/question/{id?}','PastPaperController@deleteQuestion')->name('delete.past-paper.question');
            Route::match(['post', 'PUT'],'question-store/{uuid?}','PastPaperController@storeQuestion')->name('past-paper.question.store');
        });
        // Past paper question management 
        Route::group([ 'prefix' => 'past-paper-question'], function () {
            Route::get('/','PastPaperQuestionController@index')->name('past-paper-question.index')->middleware(['role_or_permission:superadmin']);
            Route::get('add','PastPaperQuestionController@create')->name('past-paper-question.add');
            Route::get('edit/{id?}','PastPaperQuestionController@edit')->name('past-paper-question.edit');
            Route::delete('delete/{id?}','PastPaperQuestionController@destroy')->name('past-paper-question.delete');
            Route::get('/datatable', 'PastPaperQuestionController@getData')->name('past-paper-question.datatable');
            Route::match(['post', 'PUT'],'question-store/{uuid?}','PastPaperQuestionController@storeQuestion')->name('past-paper-question.store');
        });
        Route::group([ 'prefix' => 'report-problem'], function () {
            Route::get('/','ReportProblemController@index')->name('report-problem.index');
            Route::get('datatable', 'ReportProblemController@getdata')->name('report-problem.datatable');
        });
        /*
        |--------------------------------------------------------------------------
        | For Weekly Assessment Questions
        |--------------------------------------------------------------------------
        */
        Route::group([ 'prefix' => 'practice-question'], function () {
            Route::get('datatable', 'AssessmentQuestionController@show')->name('assessment.question-datatable');
            Route::get('import', 'AssessmentQuestionController@import')->name('assessment.question.import');
            Route::post('export', 'AssessmentQuestionController@export')->name('assessment.question.export');
            Route::get('select', 'AssessmentQuestionController@getBlade')->name('assessment.question.select');
            Route::post('import/file', 'AssessmentQuestionController@insert')->name('assessment.question.importFile');
            Route::delete('delete/{id?}', ['as' => 'assessment.question.destroy', 'uses' => 'AssessmentQuestionController@destroy']);
            Route::post('div', 'AssessmentQuestionController@deleteQuestion')->name('assessment.question.edit-cloze');
            Route::post('active_inactive/{id?}', 'AssessmentQuestionController@updateStatus')->name('assessment.question.active.inactive');
            Route::get('downloadPdf/{uuid?}','AssessmentQuestionController@downloadPdf')->name('assessment.download.passage');
            // Route::resource('question', 'QuestionController')->except('show','destroy');
            Route::get('/','AssessmentQuestionController@index')->name('assessment.question.index');
            Route::get('create/{uuid?}', 'AssessmentQuestionController@create')->name('assessment.question.create');
            Route::get('detail/{uuid?}', 'AssessmentQuestionController@detail')->name('assessment.question.detail');
            Route::match(['post', 'PUT'],'store/{uuid?}','AssessmentQuestionController@store')->name('assessment.question.store');
            Route::get('edit-list-question/{uuid?}/{mockId?}','AssessmentQuestionController@editQuestion')->name('edit-assessment-list-question');
            Route::match(['post', 'PUT'],'question-store/{uuid?}','AssessmentQuestionController@storeQuestion')->name('assessment.question.list.store');
            Route::delete('delete-list-question/{uuid?}','AssessmentQuestionController@deleteListQuestion')->name('delete-assessment-list-question');
            Route::post('upload-passage','AssessmentQuestionController@uploadPassage')->name('assessment.upload-passage');
            Route::delete('delete-passage','AssessmentQuestionController@deletePassage')->name('assessment.delete-passage');
            Route::get('add-list-question/{uuid?}/{mockId?}','AssessmentQuestionController@addQuestion')->name('assessment.add-question');
        });
        /*
        |--------------------------------------------------------------------------
        | For Practice By Topic Questions
        |--------------------------------------------------------------------------
        */
        Route::group([ 'prefix' => 'practice-topic-question'], function () {
            Route::get('datatable', 'PracticeByTopicQuestionController@show')->name('practice-topic-question.datatable');
            Route::get('import', 'PracticeByTopicQuestionController@import')->name('practice-topic-question.import');
            Route::post('export', 'PracticeByTopicQuestionController@export')->name('practice-topic-question.export');
            Route::get('select', 'PracticeByTopicQuestionController@getBlade')->name('practice-topic-question.select');
            Route::post('import/file', 'PracticeByTopicQuestionController@insert')->name('practice-topic-question.importFile');
            Route::delete('delete/{id?}', ['as' => 'practice-topic-question.destroy', 'uses' => 'PracticeByTopicQuestionController@destroy']);
            Route::post('div', 'PracticeByTopicQuestionController@deleteQuestion')->name('practice-topic-question.edit-cloze');
            Route::post('active_inactive/{id?}', 'PracticeByTopicQuestionController@updateStatus')->name('practice-topic-question.active.inactive');
            Route::get('downloadPdf/{uuid?}','PracticeByTopicQuestionController@downloadPdf')->name('practice-topic-question.download.passage');
            // Route::resource('question', 'QuestionController')->except('show','destroy');
            Route::get('/','PracticeByTopicQuestionController@index')->name('practice-topic-question.index');
            Route::get('create/{uuid?}', 'PracticeByTopicQuestionController@create')->name('practice-topic-question.create');
            Route::get('detail/{uuid?}', 'PracticeByTopicQuestionController@detail')->name('practice-topic-question.detail');
            Route::match(['post', 'PUT'],'store/{uuid?}','PracticeByTopicQuestionController@store')->name('practice-topic-question.store');
            Route::get('edit-list-question/{uuid?}/{mockId?}','PracticeByTopicQuestionController@editQuestion')->name('edit-practice-topic-question');
            Route::match(['post', 'PUT'],'question-store/{uuid?}','PracticeByTopicQuestionController@storeQuestion')->name('practice-topic-question.list.store');
            Route::delete('delete-list-question/{uuid?}','PracticeByTopicQuestionController@deleteListQuestion')->name('delete-practice-topic-question');
            Route::post('upload-passage','PracticeByTopicQuestionController@uploadPassage')->name('practice-topic-question.upload-passage');
            Route::delete('delete-passage','PracticeByTopicQuestionController@deletePassage')->name('practice-topic-question.delete-passage');
            Route::get('add-list-question/{uuid?}/{mockId?}','PracticeByTopicQuestionController@addQuestion')->name('practice-topic-question.add-question');
        });
});
