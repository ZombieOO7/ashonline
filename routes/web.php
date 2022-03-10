<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

// checking guard if user is admin then it will redirect to admin login
Route::get('/admin', 'HomeController@checkGuard');
// CMS PAGES
Route::get('epaper/privacy-policy', 'HomeController@getPrivacyPolicy')->name('cms_privacy');
Route::get('epaper/terms-conditions', 'HomeController@getTermsConditions')->name('cms_terms');

Route::get('/', 'HomeController@firstPage')->name('firstpage');
Route::get('/contact-us', 'NewFrontend\CMSController@contactUs')->name('contact-us');

// For notification
Route::get('notification', 'HomeController@getNotification')->name('notification');

Route::get('/epaper', 'HomeController@index')->name('home');

Route::group(['namespace'=>'Frontend','prefix' => 'epaper'], function () {

    /** Papers routes starts here */
    Route::group([ 'prefix' => 'papers'], function () {
        Route::get('/','    @index')->name('papers');
        Route::get('/tuition','TutionController@index')->name('tution');
        Route::get('/about','AboutController@index')->name('about');
        Route::post('/subscribe','SubscriberController@store')->name('subscribe');
        Route::get('/{paper}','PaperCategoryController@detail')->name('paper.detail');
        Route::post('/search','PaperCategoryController@search')->name('paper.filter');
        Route::get('/{category}/{slug}','PaperCategoryController@paperDetails')->name('paper-details');
    });
    Route::get('autocomplete','SearchController@autocomplete')->name('autocomplete');
    Route::get('search-papers','SearchController@search')->name('search-papers');

    /** Papers routes ends here */

    Route::get('/tuition','TutionController@index')->name('tution');
    Route::get('/about','AboutController@index')->name('about');
    Route::get('/cart','CartController@cart')->name('cart');
    Route::post('/add-to-cart','CartController@addToCart')->name('add-to-cart');
    Route::post('/check-to-cart','CartController@checkProductIsPurchased')->name('check-to-cart');
    Route::post('/remove-paper','CartController@removePaperFromCart')->name('remove-paper');
    Route::post('/clear-cart','CartController@clearCart')->name('clear-cart');
    Route::post('/apply-code','CouponController@applyCode')->name('apply-code');
    Route::get('/mail/{id?}','OrderController@sendMail')->name('sendmail');

    Route::post('cart-payment', 'CartController@payment')->name('cart_payment');

    Route::get('/download/{uuid}/{slug}/{versionid?}','OrderController@download')->name('download');
    Route::get('checkout', 'OrderController@checkout')->name('checkout');
    Route::post('payment', 'OrderController@makePayment')->name('make_payment');
    Route::get('thank-you/{uuid}', 'OrderController@thankYou')->name('thank_you');
    Route::get('feedback/{uuid}', 'ReviewController@feedback')->name('feedback');
    Route::post('review', 'ReviewController@store')->name('post-review');
    Route::get('review-demo/{uuid}', 'ReviewController@demo')->name('review-demo');
    Route::post('review_store', 'ReviewController@reviewStore')->name('review_store');


    // Paypal
    Route::get('paypal/payment', 'OrderController@payment')->name('paypal_payment');
    Route::get('cancel/{token?}', 'OrderController@cancel')->name('payment.cancel');
    Route::get('payment/success', 'OrderController@success')->name('payment.success');
    Route::get('thank-you', 'ReviewController@thankYou')->name('review/thank_you');
    Route::get('review/load-more', 'ReviewController@loadMore')->name('review/loadmore');

    // FAQS
    Route::get('faqs/{slug}', 'FaqController@index')->name('faq');

    // Order payment paypal routes
    Route::post('checkout/order/request', 'PaypalController@createOrderRequest')->name('checkout/order/request');
    Route::post('approve/checkout/request', 'PaypalController@approveOrderRequest')->name('approve/checkout/request');

    // Contact us
    // Route::get('contact-us', 'ContactUsController@index')->name('contact_us');
    Route::post('contact-us/store', 'ContactUsController@store')->name('contact_us.store');
    Route::get('contact-us/refreshCapatcha','ContactUsController@refreshCapatcha')->name('refreshCapatcha');

    // For Resources
    Route::get('resources/{restype}/{catSlug?}', 'ResourceController@index')->name('resources/index');
    Route::get('resource/download/{uuid}/{filetype}', 'ResourceController@downloadFile')->name('resource/download/file');
    Route::get('resource/detail/{slug}', 'ResourceController@show')->name('resource/detail');

    // For Blog
    Route::get('blogs/{catSlug?}', 'BlogController@index')->name('blogs/index');
    // Route::get('blog/detail/{slug}', 'BlogController@show')->name('blogs/detail');
    
    Route::get('paywithpaypal', array('as' => 'paywithpaypal','uses' => 'PaypalController@payWithPaypal',));
    Route::get('paypal', array('as' => 'paypal','uses' => 'PaypalController@postPaymentWithpaypal'));
    Route::get('paypal-status', array('as' => 'paypal-status','uses' => 'PaypalController@getPaymentStatus',));
    
    Route::get('{slug}', 'BlogController@show')->name('blogs/detail');

});

// Feedback
Route::get('/rating-demo','HomeController@sendRatingMail')->name('send-rating-mail');
Route::post('/get-feedback','HomeController@getFeedBack')->name('get-feedback');

// Legal And Other Documents
Route::get('/legal-and-other-documents','HomeController@legalAndOtherDocument')->name('legal.and.other.documents');

//Benefits
Route::get('/benefits','NewFrontend\CMSController@benefits')->name('benefits');

//Testimonials
Route::get('/testimonials','NewFrontend\CMSController@testimonials')->name('testimonials');
Route::get('/testimonial/data', 'NewFrontend\CMSController@getData')->name('testimonials.datatable');

//Practice


Route::get('/emock','HomeController@eMock')->name('e-mock');

// E-Mock Routes
Route::group(['namespace'=>'Frontend','prefix' => 'emock'], function () {
    // Mock Detail Page
    Route::get('/detail/{uuid}','MockController@detail')->name('mock-detail');
    // Mock Categories
    Route::get('categories', 'MockController@category')->name('emock-categories');
    // Get Mock Exam by Exam Board 
    Route::get('exam/{board?}','MockController@boardExam')->name('emock-exam');
    // Get Mock Exam Data table by Exam Board 
    Route::post('get-board-exam-data','MockController@getData')->name('get-board-exam-data');
    //cms pages
    Route::get('/eabout','AboutController@emockabout')->name('emockabout');
});
// Ace Mock parent routes
Route::group(['prefix' => 'emock'], function () {
    Route::group(['middleware' => ['guest:parent','guest:student']],function () {
        Route::get('sign-up', 'Auth\ParentLoginController@parentSignUpForm')->name('parent-sign-up');
        Route::get('child-sign-up/{parentId?}','Auth\ParentLoginController@childSignUpForm')->name('child-sign-up');
        Route::post('parent/login', 'Auth\ParentLoginController@login')->name('user.login.post');
        Route::post('parent/register', 'Auth\ParentLoginController@register')->name('parent.register.post');
        Route::post('child/register', 'Auth\ParentLoginController@childRegister')->name('child.register.post');
        Route::get('password/reset', 'Auth\Frontend\ForgotPasswordController@showLinkRequestForm')->name('parent.password.reset');
        Route::post('password/email', 'Auth\Frontend\ForgotPasswordController@sendResetLinkEmail')->name('user.password.email');
        Route::get('parent/password/reset/{token}', 'Auth\Frontend\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Auth\Frontend\ResetPasswordController@updatePassword')->name('parent.password.reset');
        Route::get('parent/verify/{token}', 'Auth\ParentLoginController@verifyMail')->name('parent.email.verify');
        Route::get('thank-you','Auth\ParentLoginController@thankYou')->name('parent-thank-you');
        Route::post('checkUserlogin','Auth\ParentLoginController@checkUserlogin')->name('check-user-login');
    });
    Route::group(['namespace'=>'Frontend','middleware' => ['parentActive','parent', 'auth:parent']], function () {
        Route::get('profile', 'UserController@profile')->name('parent-profile');
        Route::post('profile-update', 'UserController@updateProfile')->name('profile-update');
        Route::post('check-old-password', 'UserController@checkOldPassword')->name('check-old-password');
        Route::get('child-profile', 'UserController@childProfile')->name('child-profile');
        Route::post('child-profile-update', 'UserController@updateChildProfile')->name('child-profile-update');
        Route::post('child-profile-updates', 'UserController@updateChildProfile')->name('child-profile-updates');
        Route::get('new-child-add/{parentIds?}','UserController@newChildAdd')->name('new-child-add');
        Route::post('new-child/register', 'UserController@newChildRegister')->name('new-child.register.post');

        // Cart Routes
         // Route::get('cart','CartController@eMockCart')->name('emock-cart');
        Route::post('/add-to-cart','CartController@eMockAddToCart')->name('emock-add-to-cart');
        Route::post('/remove-exam','CartController@removeExamFromCart')->name('remove-exam');
        Route::post('/clear-cart','CartController@clearEmockCart')->name('clear-emock-cart');
        Route::post('/apply-code','CartController@applyCode')->name('emock-apply-code');

        // Order Routes
        // Route::get('checkout', 'OrderController@eMockCheckout')->name('emock-checkout');
        Route::post('emock-payment', 'OrderController@eMockmakePayment')->name('emock_make_payment');
        // Route::get('thank-you/{id?}', 'OrderController@eMockThankYou')->name('emock-thank-you');

        // Order payment paypal routes
        Route::post('checkout/order/request', 'PaypalController@createMockOrderRequest')->name('checkout/order/request');
        Route::post('approve/checkout/request', 'PaypalController@approveMockOrderRequest')->name('approve/checkout/request');

        // order history and activate mock
        Route::get('purchased-mock', 'MockController@purchasedMock')->name('purchased-mock');
        Route::get('purchased-paper', 'MockController@purchasedPaper')->name('purchased-paper');
        // assign mock to child
        Route::post('assign-mock','MockController@assignMock')->name('activate.mock');
        // view child result
        Route::get('view-child-result/{mock_test_id?}/{student_id?}', 'MockController@ViewChildResult')->name('view-child-result');
        // view all questions
        Route::get('view-questions-result/{uuid}', 'MockController@viewQuestionsResult')->name('view-questions-result');
        // view incorrect questions
        Route::get('view-incorrect-questions-result/{uuid}', 'MockController@viewIncorrectQuestionsResult')->name('view-incorrect-questions-result');

        // mock invoices
        Route::get('invoice', 'MockController@invoice')->name('invoice');
        // invoice detail
        Route::get('view-invoice/{uuid?}', 'UserController@invoiceDetail')->name('view.invoice');
        // download invoice
        Route::get('download-invoice/{uuid?}', 'UserController@downloadInvoice')->name('download.invoice');
        // view invoice detail
        Route::get('view-payment-invoice/{uuid?}', 'UserController@paymentInvoiceDetail')->name('view.payment.invoice');
        // download invoice detail
        Route::get('download-payment-invoice/{uuid?}', 'UserController@downloadPaymentInvoice')->name('download.payment.invoice');
        Route::post('get-order-invoice', 'MockController@getMockInvoiceData')->name('get.order.invoice');
        Route::post('get-payment-invoice', 'MockController@getPaperInvoiceData')->name('get.payment.invoice');

        // print answer sheet and activate mock
        Route::get('/print-preview-ans-sheet/{id}','MockController@printpreviewans')->name('print-preview-ans-sheet');
        Route::get('mevaluation/{id}','MockController@mevaluation')->name('mevaluation');
        // Route::get('sevaluation/{mockId?}/{studentId?}','MockController@sevaluation')->name('sevaluation');
        Route::post('seval-ajax-next-question', 'MockController@sevalPrevNextQuestions')->name('seval-ajax-next-question');
        Route::post('seval-next-sub-question/{type}', 'MockController@sevalPrevNextSubQuestion')->name('seval-next-sub-question');
        Route::post('seval-next-main-question/{type}', 'MockController@sevalPrevNextMainQuestion')->name('seval-next-main-question');
        Route::post('seval-mark-question-answer', 'MockController@sevalMarkQuestionAnswer')->name('seval-mark-question-answer');
        Route::post('seval-complete-mock-marking', 'MockController@sevalCompleteMockMarking')->name('seval-complete-mock-marking');
        // Route::get('seval-result/{id}', 'MockController@sevalResult')->name('seval-result');
        Route::get('seval-result/{id}', 'MockController@evaluateMockResult')->name('seval-result');

        // purchased mock review/rate
        Route::post('preview-n-rate', 'MockController@pReviewRate')->name('preview-n-rate');

    });
    Route::group(['namespace'=>'Practice','middleware' => ['parentActive','parent', 'auth:parent']], function () {
        Route::get('weekly-assessments/{studentId?}','ParentController@weeklyAssessment')->name('parent.weekly-assessments');
        Route::get('practice-by-topic/{studentId?}','ParentController@practiceByTopic')->name('parent.practice-by-topic');
    });
    Route::group(['namespace'=>'Frontend','middleware' => ['student', 'auth:student']], function () {
        // get student mocks
        Route::get('my-mocks', 'MockController@studentMocks')->name('student-mocks');
        Route::get('mock-exam/{uuid}', 'MockController@mockExam')->name('mock-exam'); // need to remove this code
        // get student profile
        Route::get('student-profile', 'UserController@studentProfile')->name('student-profile');
        Route::get('mock-result/{uuid}', 'MockController@mockResult')->name('mock-result');
        Route::get('mock-exam-review/{uuid}', 'MockController@mockExamReview')->name('mock-exam-review');
        Route::get('mock-exam/{uuid?}/{subjectId?}', 'MockController@mockExam2')->name('mock-exam-2');

        // for child check exam
        Route::post('checkExam','MockController@checkExam')->name('check-exam');
        // get student attempt mock exam info 
        Route::get('mock-info/{uuid?}','MockTestPaperController@examInfo')->name('mock-info');
        // get student attempt paper info
        Route::get('mock-paper-info/{uuid?}','MockTestPaperController@mockPaperInfo')->name('mock-paper-info');
        // get student attempt paper section 
        Route::post('mock-paper-section','MockTestPaperController@mockPaperSection')->name('mock-paper-section');
        Route::get('exam-paper','MockTestPaperController@examPaper')->name('exam-paper');
        // get student attempt paper section detail page
        Route::get('exam-paper/section/{uuid?}/{sectionId?}','MockTestPaperController@sectionDetail')->name('section.detail');
        Route::get('exam/{uuid?}/{sectionId?}','MockTestPaperController@startExam')->name('start.exam');
        Route::post('ajax-next-question', 'MockTestPaperController@prevNextQuestion')->name('ajax-next-question');
        Route::get('go-to-section/{paperId?}/{sectionId?}','MockTestPaperController@goToSection')->name('go-to-section');
        Route::post('ajax-store-question-ans', 'MockTestPaperController@storeQuestion')->name('ajax-store-question-ans');
        Route::get('paper-complete-info/{paperId?}','MockTestPaperController@paperResult')->name('paper-result');
        Route::get('paper-review/{paperId?}','MockTestPaperController@paperReview')->name('paper-review');
        Route::post('complete-mock', 'MockTestPaperController@completeMock')->name('complete-mock');
        Route::get('update-test-status','MockTestPaperController@updateTestStatus')->name('update-test-status');
        Route::post('save-remaining-time','MockTestPaperController@saveRemainingTime')->name('save-remaining-time');
        Route::post('ajax-review-next-question', 'MockTestPaperController@reviewPrevNextQuestion')->name('ajax-review-next-question');
        Route::post('jump-to-question','MockTestPaperController@goToQuestion')->name('go.to.question');
        Route::post('review-jump-to-question','MockTestPaperController@reviewGoToQuestion')->name('review.go.to.question');
        
    });
    Route::get('email-report/{uuid?}','Admin\StudentTestController@emailReport')->name('parent-email-report');
    // school page
    Route::group(['namespace'=>'Frontend','prefix' => 'school'], function () {
        Route::get('/','SchoolController@schoolList')->name('school-list');
        Route::get('school-mock','SchoolController@getSchoolMock')->name('school-mock');
        Route::get('school-data','SchoolController@getData')->name('school-datatable');
        Route::get('/{slug?}','SchoolController@schoolPage')->name('school');
    });

    Route::group(['namespace'=>'Frontend','middleware' => ['check_user_role:parent,student']], function () {
        // mock exam info
        Route::get('mock-paper-result/{uuid?}','MockTestPaperController@examResult')->name('mock-paper-result');
        Route::get('paper-result/{uuid?}','MockTestPaperController@viewPaperResult')->name('view-paper-result');
        Route::get('view-questions/{uuid?}/{sectionId?}', 'MockTestPaperController@viewQuestion')->name('view-questions');
        Route::get('incorrect-questions/{uuid?}/{sectionId?}','MockTestPaperController@viewQuestion')->name('view-incorrect-questions');
        Route::get('evaluate-paper/{paperId?}','MockTestPaperController@evaluation')->name('evaluation');
        Route::post('question-detail','MockTestPaperController@questionDetail')->name('question-detail');
        Route::post('evaluate-jump-to-question','MockController@evaluateGoToQuestion')->name('evaluate.go.to.question');
    });
    Route::group(['namespace'=>'Practice','middleware' => ['check_user_role:parent,student']], function () {
        Route::post('assessment-question-detail','TestAssessmentController@questionDetail')->name('assessment-question-detail');
    });


});
Route::group(['namespace'=>'Frontend','middleware' => ['parentActive','parent', 'auth:parent']], function () {
    Route::get('checkout', 'OrderController@eMockCheckout')->name('emock-checkout');
    Route::get('cart','CartController@eMockCart')->name('emock-cart');
    Route::get('thank-you/{id?}', 'OrderController@eMockThankYou')->name('emock-thank-you');
});
Route::get('parent/logout', 'Auth\ParentLoginController@logout')->name('user.logout');

// E-Mock CMS

// E-Mock
Route::group(['namespace'=>'NewFrontend','prefix' => 'emock'], function () {
    //cms pages
    Route::get('/about-us','AboutController@aboutUs')->name('about-us');
    Route::get('/privacy-policy','CMSController@privacyPolicy')->name('privacy-policy');
    Route::get('/termsandconditions','CMSController@termsandconditions')->name('termsandconditions');
    Route::get('/faq/{slug}','CMSController@faq')->name('mock-faq');
    Route::get('/payments-and-security','CMSController@paymentsandsecurity')->name('payments-and-security');
    // Route::get('/contact-us','CMSController@contactUs')->name('contact-us');
    Route::get('show-guidance','CMSController@showGuidance')->name('show-guidance');
    Route::get('purchased-mocks','CMSController@purchasedMock')->name('purchased-mocks');
    Route::get('evaluate-paper-info/{paperId?}','CMSController@evaluationInfo')->name('evaluation-info');
    // For Blog
    Route::get('blogs/{catSlug?}', 'BlogController@index')->name('eblogs/index');
    Route::get('blog/{slug}', 'BlogController@show')->name('eblogs/detail');

    // For Resources
    Route::get('resources/{restype}/{catSlug?}', 'ResourceController@index')->name('eresources/index');
    Route::get('resource/download/{uuid}/{filetype}', 'ResourceController@downloadFile')->name('eresource/download/file');
    Route::get('resource/detail/{slug}', 'ResourceController@show')->name('eresource/detail');
});


/* ASH Practice route list */
Route::group(['namespace'=>'Practice','prefix' => 'practice'], function () {
    Route::get('/','PracticeController@index')->name('practice');
/*     Route::get('/past-papers',function(){
        return view('newfrontend.practice.past_paper');
    });
    Route::get('/past-paper-list',function(){
        return view('newfrontend.practice.past_paper_list');
    }); */
    Route::group(['middleware' => ['check_user_role:parent,student']], function () {
        Route::get('/home/{studentId?}','PracticeController@home')->name('practice-home');
        Route::get('/weekly-assessments/{slug?}/{studentId?}','PracticeController@allAssessment')->name('weekly-assessments');
        Route::get('review-test-result/{uuid}', 'PracticeController@reviewTestResult')->name('review-test-result');
        Route::get('review-result/{resultId?}','TestAssessmentController@testAssessmentResult')->name('review-result');
    });
    Route::group(['middleware' => ['student', 'auth:student']], function () {
        Route::get('detail/{testAssessmentId?}','PracticeController@assessmentDetail')->name('assessments-detail');
        Route::get('test-assessment/{uuid?}/{sectionId?}','TestAssessmentController@attemptTest')->name('attempt-test-assessment');
        Route::post('store-answer','TestAssessmentController@storeAnswers')->name('store-answer');
        Route::post('next-question','TestAssessmentController@getQuestion')->name('next-question');
        Route::post('previous-question','TestAssessmentController@getQuestion')->name('previous-question');
        Route::get('result/{resultId?}','TestAssessmentController@testAssessmentResult')->name('submit-paper');
        Route::get('review-paper/{resultId?}','TestAssessmentController@reviewTestPaper')->name('review-paper');
        Route::get('view-questions/{uuid?}/{sectionId?}/{questionId?}', 'TestAssessmentController@viewTestAssessmentQuestion')->name('view-test-questions');
        Route::get('section/{uuid?}/{sectionId?}','TestAssessmentController@sectionDetail')->name('section-detail');
        Route::get('go-to-section/{uuid?}/{sectionId?}','TestAssessmentController@goToSection')->name('next.section.detail');
        Route::get('next-section/{uuid?}/{sectionId?}','TestAssessmentController@nextSection')->name('next.section');
    });

    Route::post('store-report-problem','TestAssessmentController@reportProblem')->name('report-problem');
    Route::post('get-report-problem','TestAssessmentController@getReportProblem')->name('get-report-problem');
    Route::post('get-topic-report-problem','TestAssessmentController@getPracticeByTopicReportProblem')->name('get-topic-report-problem');

    // practice by topic list
    Route::group(['prefix' => 'topic'], function () {
        Route::get('list/{slug?}/{studentId?}','PracticeByTopicController@index')->name('topic-list')->middleware(['check_user_role:parent,student']);
        Route::group(['middleware' => ['student', 'auth:student']], function () {
            Route::get('detail/{uuid?}','PracticeByTopicController@detail')->name('practice-by-topic');
            Route::get('attempt-test/{uuid?}','PracticeByTopicController@attemptTest')->name('attempt-topic-test');
            Route::post('store-answer','PracticeByTopicController@storeAnswers')->name('topic.store-answer');
            Route::post('next-question','PracticeByTopicController@getQuestion')->name('topic.next-question');
            Route::post('go-to-question','PracticeByTopicController@goToQuestion')->name('topic.go-to-question');
            Route::post('previous-question','PracticeByTopicController@getQuestion')->name('topic.previous-question');
            Route::get('result/{resultId?}','PracticeByTopicController@testAssessmentResult')->name('topic.submit-paper');
            Route::get('view-questions/{uuid}', 'PracticeByTopicController@viewTestAssessmentQuestion')->name('topic.view-test-questions');
            Route::get('view-result/{resultId?}','PracticeByTopicController@testAssessmentResult')->name('topic.view-result');
        });
    });

    // practice by past paper list
    Route::group(['prefix' => 'past-paper'], function () {
        Route::get('datatable/{subject?}','PastPaperController@getData')->name('past-paper.datatable.list');
        Route::get('download/{paperId?}','PastPaperController@downloadMedia')->name('past.paper.download');
        Route::get('detail/{paperId?}','PastPaperController@paperDetail')->name('past.paper.detail');
        Route::get('/topic-questions/{slug?}','PastPaperController@topicQuestions')->name('topic.question');
        Route::get('/{subject?}/{grade?}','PastPaperController@index')->name('past-paper-list');
        Route::get('question/datatable/{uuid?}', 'PastPaperController@getQuestionDatatable')->name('past-paper.question.datatable');
    });

});
Route::get('emock/student/download-report/{uuid?}','Admin\StudentTestController@show')->name('download-child-report');
Route::get('download-answer-sheet/{uuid?}', 'Admin\MockTestPaperController@downloadAnswerSheet')->name('mock-paper.answer-sheet');
