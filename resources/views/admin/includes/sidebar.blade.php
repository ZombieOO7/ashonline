
@php
    $routeName = Route::currentRouteName();
    $currentSlug = Request::route('slug');
    $paperCmsHome = getBlockByType(0,1);
    $generalCmsHome = getBlockByType(3,1);
    $emockCmsHome = getBlockByType(1,1);
    $practiceCmsHome = getBlockByType(2,1);
    $cmsAbout = getBlockByType(0,2);
    $cmsTuition = getBlockByType(0,3);
@endphp
@section('inc_css')
<style>
    .m2--hide{
        display: none !important;
    }
</style>
<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark "
        m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow side_bar">
            {{-- Dashboard --}}
            <li class="m-menu__item  @if ($routeName == 'admin_dashboard') m-menu__item--active @endif"
                aria-haspopup="true">
                <a href="{{ route('admin_dashboard') }}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">{{__('formname.dashboard.title')}}</span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__item  @if ($routeName == 'parent_index' || $routeName == 'parent_create' || $routeName == 'parent_edit' || $routeName == 'parent_import') m-menu__item--active @endif"
            aria-haspopup="true">
                <a href="{{ route('parent_index') }}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-user "></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">{{__('formname.parent.label')}}</span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__item  @if ($routeName == 'student.index' || $routeName == 'student.create' || $routeName == 'admin.student.edit' || $routeName == 'admin.student.show') m-menu__item--active @endif" aria-haspopup="true">
                <a href="{{ route('student.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-icon fas fa-user-graduate"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">{{trans('general.student.student')}}</span>
                        </span>
                    </span>
                </a>
            </li>
            {{-- E paper  --}}
            <li class="m-menu__item m-menu__item--submenu @if ($routeName == 'paper_index' || $routeName == 'paper_create' || 
            $routeName == 'paper_edit' || $routeName == "paper_version" || $routeName == 'paper_category_index' ||  $routeName == 'paper_category_create' 
            || $routeName == 'paper_category_edit' || $routeName == 'subject_index' || $routeName == 'subject_create' || $routeName == 'subject_edit' || 
            $routeName == 'exam_types_index' || $routeName == 'exam_types_create' || $routeName == 'exam_types_edit' || $routeName == 'stage_index' 
            || $routeName == 'stage_view' || $routeName == 'stage_edit' || $routeName == 'stage_create' || $routeName == 'logs_index'
            ) m-menu__item--open @endif" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-edit-1"></i>
                    <span class="m-menu__link-text">{{__('formname.project_type')[0]}}</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu " style="" m-hidden-height="40">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <!-- Start : Master managment -->
                        @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->hasAnyPermission(['page view','page create','page edit','page delete','page multiple delete','page view','page create','page edit','page delete', 'page multiple delete','paper category view','paper category create','paper category edit','paper category delete','paper category multiple delete', 'paper category multiple inactive', 'paper category multiple active', 'paper category active inactive','subject view','subject create','subject edit','subject delete','subject multiple delete', 'subject multiple inactive', 'subject multiple active', 'subject active inactive','exam types view','exam types create','exam types edit','exam types delete','exam types multiple delete', 'exam types multiple inactive', 'exam types multiple active', 'exam types active inactive','stage view','stage create','stage edit','stage delete','stage multiple delete', 'stage multiple inactive', 'stage multiple active', 'stage active inactive'])))
                        <li class="m-menu__item  m-menu__item--submenu @if ( $routeName == 'paper_category_index' ||  $routeName == 'paper_category_create' || $routeName == 'paper_category_edit' || $routeName == 'subject_index' || $routeName == 'subject_create' || $routeName == 'subject_edit' || $routeName == 'exam_types_index' || $routeName == 'exam_types_create' || $routeName == 'exam_types_edit' || $routeName == 'stage_index' || $routeName == 'stage_view' || $routeName == 'stage_edit' || $routeName == 'stage_create' ) m-menu__item--active m-menu__item--active m-menu__item--open @endif " aria-haspopup="true" m-menu-submenu-toggle="hover">
                            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon  flaticon-layers"></i>
                                <span class="m-menu__link-text">{{trans('formname.masters')}}</span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu ">
                                <span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->hasAnyPermission(['paper category view','paper category create','paper category edit','paper category
                                    delete','paper category multiple delete', 'paper category multiple inactive', 'paper category multiple active', 'paper category active inactive'])))
                                    <li class="m-menu__item @if ($routeName == 'paper_category_index' || $routeName == 'paper_category_create' || $routeName == 'paper_category_edit' ) m-menu__item--active @endif"
                                        aria-haspopup="true">
                                        <a href="{{ route('paper_category_index') }}" class="m-menu__link ">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-text">{{__('formname.paper_category.name')}}</span>
                                        </a>
                                    </li>
                                    @endif
                                    @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->hasAnyPermission(['subject view','subject create','subject edit','subject
                                    delete','subject multiple delete', 'subject multiple inactive', 'subject multiple active', 'subject active inactive'])))
                                    <li class="m-menu__item  @if ($routeName == 'subject_index' || $routeName == 'subject_create' || $routeName == 'subject_edit' ) m-menu__item--active @endif"
                                        aria-haspopup="true">
                                        <a href="{{ route('subject_index') }}" class="m-menu__link ">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-text">{{__('formname.subjects.name')}}</span>
                                        </a>
                                    </li>
                                    @endif
                                    @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->hasAnyPermission(['exam types view','exam types create','exam types edit','exam types
                                    delete','exam types multiple delete', 'exam types multiple inactive', 'exam types multiple active', 'exam types active inactive'])))
                                    <li class="m-menu__item  @if ($routeName == 'exam_types_index' || $routeName == 'exam_types_create' || $routeName == 'exam_types_edit' ) m-menu__item--active @endif"
                                        aria-haspopup="true">
                                        <a href="{{ route('exam_types_index') }}" class="m-menu__link ">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-text">{{__('formname.examtypes.name')}}</span>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                        @endif
                        <li class="m-menu__item  @if ($routeName == 'paper_index' || $routeName == 'paper_create' || $routeName == 'paper_edit' || $routeName == "paper_version") m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('paper_index') }}" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-interface-6"></i>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">{{__('formname.test_papers.name')}}</span>
                                    </span>
                                </span>
                            </a>
                        </li>

                        <!-- Paper Search Log Management -->
                        <li class="m-menu__item  @if ($routeName == 'logs_index' ) m-menu__item--active @endif"
                            aria-haspopup="true">
                                <a href="{{ route('logs_index') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon flaticon-file "></i>
                                    <span class="m-menu__link-title">
                                        <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">{{__('formname.paper_search_log')}}</span>
                                        </span>
                                    </span>
                                </a>
                        </li>
                        <li class="m-menu__item @if ($routeName == 'order_reports_index') m-menu__item--active @endif"
                            aria-haspopup="true">
                            <a href="{{route('order_reports_index')}}" class="m-menu__link">
                                <i class="m-menu__link-icon flaticon-graph "></i>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                    <span class="m-menu__link-text">{{__('formname.report.order')}}</span>
                                    </span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="m-menu__item m-menu__item--submenu @if($routeName == 'examboard.index' || 
                $routeName == 'examboard.create' || $routeName == 'examboard.edit' || 
                $routeName == 'examboard.show' || $routeName == 'schools.index' || 
                $routeName == 'schools.create' || $routeName == 'admin.schools.edit' || 
                $routeName == 'admin.schools.show'|| $routeName == 'student_test_detail' ||
                $routeName == 'admin.student.edit' || $routeName == 'admin.student.show' ||
                $routeName == 'student_test_index' || $routeName == 'student_test_show'  || 
                $routeName == 'mock-test.index' || $routeName == 'mock-test.create' || 
                $routeName == 'mock-test.detail' || $routeName == 'mock-test.copy' || 
                $routeName == 'mock-test.edit' || $routeName == 'mock-paper.create' || 
                $routeName == 'mock-paper.edit' || $routeName == 'student_test_papers' || 
                $routeName == 'result-grade.index' ||
                $routeName == 'question.detail' || $routeName == 'question.import' || 
                $routeName == 'question.index' || $routeName == 'question.create' || 
                $routeName == 'question.edit'
                ) m-menu__item--open @endif" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon socicon-appnet"></i>
                    <span class="m-menu__link-text">Ace Mock</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu " style="" m-hidden-height="40">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  @if ($routeName == 'schools.index' || $routeName == 'schools.create' || $routeName == 'admin.schools.edit' || $routeName == 'admin.schools.show') m-menu__item--active @endif"
                        aria-haspopup="true">
                            <a href="{{ route('schools.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-icon fas fa-school"></i>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">{{trans('general.school.school')}}</span>
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item  @if ($routeName == 'question.detail' || $routeName == 'question.import' || $routeName == 'question.index' || $routeName == 'question.create' || $routeName == 'question.edit') m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('question.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-icon fa 	fa-desktop"></i>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">{{__('formname.question_mngt')}}</span>
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item  @if ($routeName == 'mock-test.index' || $routeName == 'mock-test.create' || $routeName == 'mock-test.detail' || $routeName == 'mock-test.copy' || $routeName == 'mock-test.edit' || $routeName == 'mock-paper.create' || $routeName == 'mock-paper.edit') m-menu__item--active @endif"
                        aria-haspopup="true">
                            <a href="{{ route('mock-test.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-list-3"></i>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">{{__('formname.mock-test.label')}}</span>
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item  m-menu__item--submenu  @if ($routeName == 'student_test_detail' || $routeName == 'student_test_index' || $routeName == 'student_test_show' || $routeName == 'student_test_papers') m-menu__item--active  m-menu__item--active m-menu__item--open @endif " aria-haspopup="true" m-menu-submenu-toggle="hover">
                            <a href="{{ route('student_test_index') }}" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon flaticon-profile  "></i>
                                <span class="m-menu__link-text">{{__('formname.student-test.label')}}</span>
                            </a>
                        </li>
                        <li class="m-menu__item  @if ($routeName == 'examboard.index' || $routeName == 'examboard.create' || $routeName == 'examboard.edit' || $routeName == 'examboard.show') m-menu__item--active @endif"
                        aria-haspopup="true">
                            <a href="{{ route('examboard.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-icon fab fa-fort-awesome"></i>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">{{trans('formname.examBoard.label')}}</span>
                                    </span>
                                </span>
                            </a>
                        </li>
                        {{-- <li class="m-menu__item  @if ($routeName == 'result-grade.index') m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('result-grade.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-settings-1"></i>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">{{__('formname.result-grade.label')}}</span>
                                    </span>
                                </span>
                            </a>
                        </li> --}}
                    </ul>
                </div>
            </li>
            <li class="m-menu__item m-menu__item--submenu @if($routeName == 'test-assessment.index' || $routeName == 'test-assessment.create' 
            || $routeName == 'test-assessment.detail' || $routeName == 'test-assessment.copy' || $routeName == 'test-assessment.edit' 
            || $routeName == 'practice-exam.index' || $routeName == 'practice-exam.create' || $routeName == 'practice-exam.detail' 
            || $routeName == 'practice-exam.copy' || $routeName == 'practice-exam.edit' || $routeName == 'student-assessment-report.index' 
            || $routeName == 'student-assessment-report.detail' || $routeName =='student-assessment-report.show' || $routeName =='assessment-datatable' 
            || $routeName =='test-assessment-detail' || $routeName == 'student-topic-report.index' || $routeName == 'student-topic-report.detail' 
            || $routeName =='student-topic-report.show' || $routeName =='test-topic-datatable' || $routeName =='test-topic-detail'
            || $routeName == 'past-paper.index' || $routeName == 'past-paper.detail' || $routeName =='past-paper.show' || $routeName =='past-paper.create' || $routeName =='past-paper.edit'
            || $routeName == 'past-paper-question.index' || $routeName == 'past-paper-question.detail' || $routeName =='past-paper-question.show' || $routeName =='past-paper-question.create' || $routeName =='past-paper-question.edit'
            || $routeName == 'assessment.question.detail' || $routeName == 'assessment.question.import' || $routeName == 'assessment.question.index' 
            || $routeName == 'assessment.question.create' || $routeName == 'assessment.question.edit' || $routeName == 'practice-topic-question.index' 
            || $routeName == 'practice-topic-question.create' || $routeName == 'practice-topic-question.edit' || $routeName == 'practice-topic-question.detail'
            ) m-menu__item--open @endif" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-statistics"></i>
                    <span class="m-menu__link-text">{{__('formname.ace_practice')}}</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu " style="" m-hidden-height="40">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  @if ($routeName == 'assessment.question.detail' || $routeName == 'assessment.question.import' || $routeName == 'assessment.question.index' || $routeName == 'assessment.question.create' || $routeName == 'assessment.question.edit') m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('assessment.question.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-icon fa 	fa-desktop"></i>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">{{__('formname.question_mngt')}}</span>
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item  @if ($routeName == 'test-assessment.index' || $routeName == 'test-assessment.create' || $routeName == 'test-assessment.detail' || $routeName == 'test-assessment.copy' || $routeName == 'test-assessment.edit') m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('test-assessment.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-icon la la-paste"></i>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">{{__('formname.test-assessment.label')}}</span>
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item  @if ($routeName == 'practice-topic-question.index' || $routeName == 'practice-topic-question.create' || $routeName == 'practice-topic-question.edit' || $routeName == 'practice-topic-question.detail') m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('practice-topic-question.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-icon la la-paste"></i>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">{{__('formname.practice-topic-question.label')}}</span>
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item  @if ($routeName == 'practice-exam.index' || $routeName == 'practice-exam.create' || $routeName == 'practice-exam.edit' || $routeName == 'practice-exam.detail') m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('practice-exam.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-icon la la-paste"></i>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">{{__('formname.practice-by-topic.label')}}</span>
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item  @if ($routeName == 'student-assessment-report.index' || $routeName == 'student-assessment-report.detail' || $routeName =='student-assessment-report.show' || $routeName =='assessment-datatable' || $routeName =='test-assessment-detail') m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('student-assessment-report.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-clipboard"></i>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">{{__('formname.student-assessment-report.label')}}</span>
                                    </span>
                                </span>
                            </a>
                        </li>
                        {{-- <li class="m-menu__item  @if ($routeName == 'student-topic-report.index' || $routeName == 'student-topic-report.detail' || $routeName =='student-topic-report.show' || $routeName =='test-topic-datatable' || $routeName =='test-topic-detail') m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('student-topic-report.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-list"></i>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">{{__('formname.student-topic-report.label')}}</span>
                                    </span>
                                </span>
                            </a>
                        </li> --}}
                        <li class="m-menu__item  @if ($routeName == 'past-paper-question.index' || $routeName == 'past-paper-question.create' || $routeName == 'past-paper-question.edit' || $routeName == 'past-paper-question.detail') m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('past-paper-question.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-icon la la-paste"></i>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">{{__('formname.past-paper-question.label')}}</span>
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item  @if ($routeName == 'past-paper.index' || $routeName == 'past-paper.detail' || $routeName =='past-paper.show' || $routeName =='test-topic-datatable' || $routeName =='test-topic-detail') m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('past-paper.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-icon flaticon-list"></i>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">{{__('formname.past-paper.label')}}</span>
                                    </span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- Blog Management --}}
            <li class="m-menu__item  {{-- m2--hide --}} @if (\Request::is('admin/resources/blog*')) m-menu__item--active @endif " aria-haspopup="true">
                <a href="{{ route('resources.index', 'blog') }}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-list-3 "></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">{{__('formname.blog_mgmt')}}</span>
                        </span>
                    </span>
                </a>
            </li>
            <!-- Report Problem -->
            <li class="m-menu__item @if ($routeName == 'report-problem.index') m-menu__item--active @endif " aria-haspopup="true">
                <a href="{{ route('report-problem.index') }}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-clock "></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">{{__('formname.report-problem.label')}}</span>
                        </span>
                    </span>
                </a>
            </li>
            <!-- Image Management -->
            <li class="m-menu__item @if ($routeName == 'images.index') m-menu__item--active @endif " aria-haspopup="true">
                <a href="{{ route('images.index') }}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fas fa-images"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">Image Management</span>
                        </span>
                    </span>
                </a>
            </li>
            <!-- Topic Management -->
            <li class="m-menu__item @if ($routeName == 'topic.index') m-menu__item--active @endif " aria-haspopup="true">
                <a href="{{ route('topic.index') }}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fab fa-tumblr"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">{{__('formname.topic.label')}}</span>
                        </span>
                    </span>
                </a>
            </li>
            <!-- Order Management -->
            <li class="m-menu__item  @if ($routeName == 'order_index' || $routeName == 'order_view' || $routeName == 'order_edit') m-menu__item--active @endif" aria-haspopup="true">
                <a href="{{ route('order_index') }}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-cart"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">{{__('formname.orders.name')}}</span>
                        </span>
                    </span>
                </a>
            </li>

            <!-- Payment Management -->
            <li class="m-menu__item  @if ($routeName == 'payment_index' || $routeName == 'payment_view' || $routeName == 'payment_edit') m-menu__item--active @endif"
            aria-haspopup="true">
                <a href="{{ route('payment_index') }}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-coins"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">{{__('formname.payment.name')}}</span>
                        </span>
                    </span>
                </a>
            </li>

            <!-- Promo Code Management -->
            <li class="m-menu__item  @if ($routeName == 'promo_code_index' || $routeName == 'promo_code_create' || $routeName == 'promo_code_view' || $routeName == 'promo_code_edit' ) m-menu__item--active @endif"
                aria-haspopup="true">
                <a href="{{ route('promo_code_index') }}" class="m-menu__link ">
                    <i class="m-menu__link-icon  fas fa-certificate "></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">{{__('formname.promo_codes.name')}}</span>
                        </span>
                    </span>
                </a>
            </li>

            <!-- Subscription Management -->
            <li class="m-menu__item @if ($routeName == 'subscription.index' || $routeName == 'subscription.edit') m-menu__item--active @endif " aria-haspopup="true">
                <a href="{{ route('subscription.index') }}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-paper-plane"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">{{__('formname.subscription.label')}}</span>
                        </span>
                    </span>
                </a>
            </li>

            <!-- Subscriber list -->
            <li class="m-menu__item @if ($routeName == 'parent-subscriber.index' || $routeName == 'parent-subscriber.show') m-menu__item--active @endif " aria-haspopup="true">
                <a href="{{ route('parent-subscriber.index') }}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fa fa-user"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">{{__('formname.parent-subscriber.label')}}</span>
                        </span>
                    </span>
                </a>
            </li>

            <!-- Review Management -->
            <li class="m-menu__item  @if ($routeName == 'review_index' || $routeName == 'review_view' || $routeName == 'review_edit') m-menu__item--active @endif"
            aria-haspopup="true">
                <a href="{{ route('review_index') }}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-star"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">{{__('formname.review_mngt')}}</span>
                        </span>
                    </span>
                </a>
            </li>

            {{-- Resources Management --}}
            <li class="m-menu__item  m-menu__item--submenu {{-- m2--hide --}} @if (\Request::is('admin/resources/*papers*') || \Request::is('admin/resources/guidance*')) m-menu__item--active  m-menu__item--active m-menu__item--open @endif " aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-app"></i>
                    <span class="m-menu__link-text">{{__('formname.resource.name')}}</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        @forelse (sidebarResourceCategory() as $key => $item)
                            <li class="m-menu__item @if (\Request::is('admin/resources/'.$key.'*')) m-menu__item--active @endif" aria-haspopup="true">
                                <a href="{{ route('resources.index', $key) }}" class="m-menu__link">
                                    <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class="m-menu__link-text">{{ $item }}</span>
                                </a>
                            </li>
                        @empty
                        @endforelse
                    </ul>
                </div>
            </li>
            {{-- Email Template Management --}}
            @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->hasAnyPermission(['email template view','email template create','email template edit','review
            delete','email template multiple delete', 'email template multiple inactive', 'email template multiple active', 'email template active inactive'])))
            <li class="m-menu__item  m-menu__item--submenu @if ($routeName == 'email_template_index' || $routeName == 'email_template_create' || $routeName == 'email_template_edit') m-menu__item--active  m-menu__item--open @endif"
            aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="{{ route('email_template_index') }}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon  flaticon-multimedia-3  "></i>
                    <span class="m-menu__link-text">{{__('formname.email_template.name')}}</span>
                </a>
            </li>
            @endif
            <li class="m-menu__item  m-menu__item--submenu  @if ($routeName == 'report.index' 
            || $routeName == 'contact_us_index' || $routeName == 'contact_us_create' 
            || $routeName == 'contact_us_edit') m-menu__item--active m-menu__item--open @endif"
                aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon 
                    flaticon-graph "></i>
                    <span class="m-menu__link-text">{{trans('formname.reports')}}</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item @if ( $routeName == 'contact_us_index' || $routeName == 'contact_us_create' || $routeName == 'contact_us_edit') m-menu__item--active @endif"
                            aria-haspopup="true">
                            <a href="{{ route('contact_us_index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">{{__('formname.customer_inquiry')}}</span>
                            </a>
                        </li>
                        <li class="m-menu__item @if ($routeName == 'report.index')  m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('report.index') }}" class="m-menu__link">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">{{__('formname.report.general')}}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Common CMS MANAGEMENT -->
            <li class="m-menu__item  m-menu__item--submenu @if(
                $currentSlug == config('constant.blocks.ePaper.tutions.banner_section') ||
                $currentSlug == config('constant.blocks.ePaper.tutions.main_section') ||
                $currentSlug == config('constant.blocks.ePaper.home.designed_by_experts') ||
                $currentSlug == config('constant.blocks.ePaper.tutions.main_section') ||
                $currentSlug == config('constant.blocks.ePaper.tutions.sub_section') ||
                $currentSlug == config('constant.blocks.ePaper.home.banner_section') ||
                $currentSlug == config('constant.blocks.ePaper.home.all_subjects') ||
                $currentSlug == config('constant.blocks.ePaper.home.exam_formats') ||
                $currentSlug == config('constant.blocks.ePaper.home.exam_styles') ||
                $currentSlug == config('constant.blocks.ePaper.about_us.banner_section') ||
                $currentSlug == config('constant.blocks.ePaper.about_us.main_section') ||
                $currentSlug == config('constant.blocks.ePaper.about_us.we_provide') ||
                $currentSlug == config('constant.blocks.ePaper.about_us.mind_behind_scene') ||
                $currentSlug == config('constant.blocks.ePaper.about_us.sub_section') ||
                $currentSlug == config('constant.blocks.aceMock.emock.banner_section')||
                $currentSlug == config('constant.blocks.aceMock.emock.paper_section')||
                $currentSlug == config('constant.blocks.aceMock.emock.how_exam_work_section')|| 
                $currentSlug == config('constant.blocks.aceMock.emock.question_section')||
                $routeName == 'subject-cms.index' || $routeName == 'subject-cms.create' || 
                $routeName == 'subject-cms.edit' || $routeName == 'school-cms.index' || 
                $routeName == 'school-cms.create' || $routeName == 'school-cms.edit' ||
                $currentSlug == config('constant.blocks.aceMock.emock.child_performance_section') ||
                $currentSlug == config('constant.blocks.aceMock.home.banner_section')||
                $currentSlug == config('constant.blocks.aceMock.home.our_module_section')||
                $currentSlug == config('constant.blocks.aceMock.home.about_ash_ace')||
                $currentSlug == config('constant.blocks.aceMock.home.why_choose_ash_ace')||
                $currentSlug == config('constant.blocks.aceMock.home.video_section')||
                $currentSlug == config('constant.blocks.aceMock.home.help_section')||
                $currentSlug == config('constant.blocks.aceMock.home.school_section')||
                $currentSlug == 'evaluate-mock' || $currentSlug == 'purchased-mocks' ||
                $currentSlug == config('constant.blocks.aceMock.home.subscribe_section') ||
                $currentSlug == config('constant.blocks.practice.home.banner_section')||
                $currentSlug == config('constant.blocks.practice.home.our_module_section')||
                $currentSlug == config('constant.blocks.practice.home.about_ash_ace')||
                $currentSlug == config('constant.blocks.practice.home.why_choose_ash_ace')||
                $currentSlug == config('constant.blocks.practice.home.video_section')||
                $currentSlug == config('constant.blocks.practice.home.help_section')||
                $currentSlug == config('constant.blocks.practice.practice.practice_section') ||
                $currentSlug == config('constant.blocks.practice.practice.topic_section') || 
                $currentSlug == config('constant.blocks.practice.practice.past_paper_section') ||
                $currentSlug == config('constant.blocks.practice.practice.practice_section_detail')
                ) m-menu__item--active m-menu__item--open @endif " aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-list-2 "></i>
                    <span class="m-menu__link-text">{{__('formname.cms_mgt')}}</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <!-- Landing page -->
                        <li class="m-menu__item @if (
                            $currentSlug == config('constant.blocks.aceMock.home.banner_section')||
                            $currentSlug == config('constant.blocks.aceMock.home.our_module_section')||
                            $currentSlug == config('constant.blocks.aceMock.home.about_ash_ace')||
                            $currentSlug == config('constant.blocks.aceMock.home.why_choose_ash_ace')||
                            $currentSlug == config('constant.blocks.aceMock.home.video_section')||
                            $currentSlug == config('constant.blocks.aceMock.home.help_section')||
                            $currentSlug == config('constant.blocks.aceMock.home.school_section')||
                            $currentSlug == config('constant.blocks.aceMock.home.subscribe_section')) m-menu__item--active m-menu__item--open @endif "aria-haspopup="true" m-menu-submenu-toggle="hover">
                            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon fab fa-app-store"></i>
                                <span class="m-menu__link-text">Landing Page</span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu ">
                                <span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item @if ($currentSlug == config('constant.blocks.aceMock.home.banner_section') ) m-menu__item--active @endif" aria-haspopup="true">
                                        <a href="{{ route('block_index',['slug' => config('constant.blocks.aceMock.home.banner_section') ]) }}" class="m-menu__link">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-text">{{ Str::limit(@$generalCmsHome[0],19,'..') }}</span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item @if ($currentSlug == config('constant.blocks.aceMock.home.our_module_section') ) m-menu__item--active @endif" aria-haspopup="true">
                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.aceMock.home.our_module_section') ]) }}" class="m-menu__link">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-text">{{ Str::limit(@$generalCmsHome[1],19,'..') }}</span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item  @if ($currentSlug == config('constant.blocks.aceMock.home.about_ash_ace') ) m-menu__item--active @endif"
                                        aria-haspopup="true">
                                        <a href="{{ route('block_index',['slug' => config('constant.blocks.aceMock.home.about_ash_ace') ]) }}" class="m-menu__link">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-text">{{ Str::limit(@$generalCmsHome[2],19,'..') }}</span>
                                        </a>
                                    </li>

                                    <li class="m-menu__item @if ($currentSlug == config('constant.blocks.aceMock.home.why_choose_ash_ace') ) m-menu__item--active @endif"
                                        aria-haspopup="true">
                                        <a href="{{ route('block_index',['slug' => config('constant.blocks.aceMock.home.why_choose_ash_ace') ]) }}" class="m-menu__link">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-text">{{ Str::limit(@$generalCmsHome[3],19,'..') }}</span>
                                        </a>
                                    </li>

                                    <li class="m-menu__item @if ($currentSlug == config('constant.blocks.aceMock.home.video_section') ) m-menu__item--active @endif"
                                        aria-haspopup="true">
                                        <a href="{{ route('block_index',['slug' => config('constant.blocks.aceMock.home.video_section') ]) }}" class="m-menu__link">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-text">{{ Str::limit(@$generalCmsHome[4],19,'..') }}</span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item @if ($currentSlug == config('constant.blocks.aceMock.home.help_section') ) m-menu__item--active @endif"
                                    aria-haspopup="true">
                                        <a href="{{ route('block_index',['slug' => config('constant.blocks.aceMock.home.help_section') ]) }}" class="m-menu__link">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-text">{{ Str::limit(@$generalCmsHome[7],19,'..') }}</span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item @if ($currentSlug == config('constant.blocks.aceMock.home.school_section') ) m-menu__item--active @endif"
                                    aria-haspopup="true">
                                        <a href="{{ route('block_index',['slug' => config('constant.blocks.aceMock.home.school_section') ]) }}" class="m-menu__link">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-text">{{ Str::limit(@$generalCmsHome[5],19,'..') }}</span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item @if ($currentSlug == config('constant.blocks.aceMock.home.subscribe_section') ) m-menu__item--active @endif"
                                    aria-haspopup="true">
                                        <a href="{{ route('block_index',['slug' => config('constant.blocks.aceMock.home.subscribe_section') ]) }}" class="m-menu__link">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-text">{{ Str::limit(@$generalCmsHome[6],19,'..') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="m-menu__item  m-menu__item--submenu @if (
                            $currentSlug == config('constant.blocks.ePaper.home.banner_section') || 
                            $currentSlug == config('constant.blocks.ePaper.home.designed_by_experts') || 
                            $currentSlug == config('constant.blocks.ePaper.home.designed_by_experts') || 
                            $currentSlug == config('constant.blocks.ePaper.home.all_subjects') || 
                            $currentSlug == config('constant.blocks.ePaper.home.exam_formats') || 
                            $currentSlug == config('constant.blocks.ePaper.home.exam_styles')
                            ) m-menu__item--active m-menu__item--open @endif "aria-haspopup="true" m-menu-submenu-toggle="hover">
                            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon flaticon-edit-1"></i>
                                <span class="m-menu__link-text">E Paper</span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu ">
                                <span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item  m-menu__item--submenu @if ($currentSlug == config('constant.blocks.ePaper.home.banner_section') || $currentSlug == config('constant.blocks.ePaper.home.designed_by_experts') || $currentSlug == config('constant.blocks.ePaper.home.designed_by_experts') || $currentSlug == config('constant.blocks.ePaper.home.all_subjects') || $currentSlug == config('constant.blocks.ePaper.home.exam_formats') || $currentSlug == config('constant.blocks.ePaper.home.exam_styles')) m-menu__item--active m-menu__item--open @endif "aria-haspopup="true" m-menu-submenu-toggle="hover">
                                        <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon fa fa-home"></i>
                                            <span class="m-menu__link-text">{{__('formname.home')}}</span>
                                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                                        </a>
                                        <div class="m-menu__submenu ">
                                            <span class="m-menu__arrow"></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.ePaper.home.banner_section') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.ePaper.home.banner_section') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        {{-- <span class="m-menu__link-text">{{  config('constant.block_sections')[config('constant.blocks.ePaper.home.banner_section')] }}</span> --}}
                                                        <span class="m-menu__link-text">{{ Str::limit(@$paperCmsHome[0],19,'..') }}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.ePaper.home.designed_by_experts') ) m-menu__item--active @endif" aria-haspopup="true">
                                                <a href="{{ route('block_index',['slug' => config('constant.blocks.ePaper.home.designed_by_experts') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        {{-- <span class="m-menu__link-text">{{  config('constant.block_sections')[config('constant.blocks.ePaper.home.designed_by_experts')] }}</span> --}}
                                                        <span class="m-menu__link-text">{{ Str::limit(@$paperCmsHome[1],19,'..') }}</span>
                                                    </a>
                                                </li>
                                        
                                                <li class="m-menu__item  @if ($currentSlug == config('constant.blocks.ePaper.home.all_subjects') ) m-menu__item--active @endif"
                                                    aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.ePaper.home.all_subjects') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        {{-- <span class="m-menu__link-text">{{  config('constant.block_sections')[config('constant.blocks.ePaper.home.all_subjects')] }}</span> --}}
                                                        <span class="m-menu__link-text">{{ Str::limit(@$paperCmsHome[2],19,'..') }}</span>
                                                    </a>
                                                </li>
            
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.ePaper.home.exam_formats') ) m-menu__item--active @endif"
                                                    aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.ePaper.home.exam_formats') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        {{-- <span class="m-menu__link-text">{{  config('constant.block_sections')[config('constant.blocks.ePaper.home.exam_formats')] }}</span> --}}
                                                        <span class="m-menu__link-text">{{ Str::limit(@$paperCmsHome[3],19,'..') }}</span>
                                                    </a>
                                                </li>
            
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.ePaper.home.exam_styles') ) m-menu__item--active @endif"
                                                    aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.ePaper.home.exam_styles') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        {{-- <span class="m-menu__link-text">{{  config('constant.block_sections')[config('constant.blocks.ePaper.home.exam_styles')] }}</span> --}}
                                                        <span class="m-menu__link-text">{{ Str::limit(@$paperCmsHome[4],19,'..') }}</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <!-- About Us -->   
                                    <li class="m-menu__item  m-menu__item--submenu  @if ($currentSlug == config('constant.blocks.ePaper.about_us.banner_section') || $currentSlug == config('constant.blocks.ePaper.about_us.main_section') || $currentSlug == config('constant.blocks.ePaper.about_us.we_provide') || $currentSlug == config('constant.blocks.ePaper.about_us.mind_behind_scene') || $currentSlug == config('constant.blocks.ePaper.about_us.sub_section') ) m-menu__item--active m-menu__item--open @endif"aria-haspopup="true" m-menu-submenu-toggle="hover">
                                        <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon fa fa-user"></i>
                                            <span class="m-menu__link-text">{{__('formname.about_us')}}</span>
                                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                                        </a>
                                        <div class="m-menu__submenu ">
                                            <span class="m-menu__arrow"></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.ePaper.about_us.banner_section') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.ePaper.about_us.banner_section') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        {{-- <span class="m-menu__link-text">{{  config('constant.block_sections')[config('constant.blocks.ePaper.about_us.banner_section')] }}</span> --}}
                                                        <span class="m-menu__link-text">{{ Str::limit(@$cmsAbout[0],19,'..') }}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.ePaper.about_us.main_section') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.ePaper.about_us.main_section') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        {{-- <span class="m-menu__link-text">{{  config('constant.block_sections')[config('constant.blocks.ePaper.about_us.main_section')] }}</span> --}}
                                                        <span class="m-menu__link-text">{{ Str::limit(@$cmsAbout[1],19,'..')  }}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.ePaper.about_us.we_provide') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.ePaper.about_us.we_provide') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        {{-- <span class="m-menu__link-text">{{  config('constant.block_sections')[config('constant.blocks.ePaper.about_us.we_provide')] }}</span> --}}
                                                        <span class="m-menu__link-text">{{ Str::limit(@$cmsAbout[2],19,'..')  }}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.ePaper.about_us.mind_behind_scene') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.ePaper.about_us.mind_behind_scene') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        {{-- <span class="m-menu__link-text">{{  config('constant.block_sections')[config('constant.blocks.ePaper.about_us.mind_behind_scene')] }}</span> --}}
                                                        <span class="m-menu__link-text">{{  Str::limit(@$cmsAbout[3],19,'..') }}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.ePaper.about_us.sub_section') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.ePaper.about_us.sub_section') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        {{-- <span class="m-menu__link-text">{{  config('constant.block_sections')[config('constant.blocks.ePaper.about_us.sub_section')] }}</span> --}}
                                                        <span class="m-menu__link-text">{{  Str::limit(@$cmsAbout[4],19,'..') }}</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="m-menu__item  m-menu__item--submenu @if ($currentSlug == config('constant.blocks.ePaper.tutions.banner_section') || $currentSlug == config('constant.blocks.ePaper.tutions.main_section') || $currentSlug == config('constant.blocks.ePaper.tutions.sub_section')) m-menu__item--active m-menu__item--open @endif "aria-haspopup="true" m-menu-submenu-toggle="hover">
                                        <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon fa fa-book"></i>
                                            <span class="m-menu__link-text">{{__('formname.tuition')}}</span>
                                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                                        </a>
                                        <div class="m-menu__submenu ">
                                            <span class="m-menu__arrow"></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.ePaper.tutions.banner_section') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.ePaper.tutions.banner_section') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{  Str::limit(@$cmsTuition[0],19,'..') }}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.ePaper.tutions.main_section') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.ePaper.tutions.main_section') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        {{-- <span class="m-menu__link-text">{{  config('constant.block_sections')[config('constant.blocks.ePaper.tutions.main_section')] }}</span> --}}
                                                        <span class="m-menu__link-text">{{  Str::limit(@$cmsTuition[1],19,'..') }}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.ePaper.tutions.sub_section') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.ePaper.tutions.sub_section') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        {{-- <span class="m-menu__link-text">{{  config('constant.block_sections')[config('constant.blocks.ePaper.tutions.sub_section')] }}</span> --}}
                                                        <span class="m-menu__link-text">{{  Str::limit(@$cmsTuition[2],19,'..') }}</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="m-menu__item  m-menu__item--submenu @if (
                            $currentSlug == config('constant.blocks.aceMock.emock.banner_section')||
                            $currentSlug == config('constant.blocks.aceMock.emock.paper_section')||
                            $currentSlug == config('constant.blocks.aceMock.emock.how_exam_work_section')||
                            $currentSlug == config('constant.blocks.aceMock.emock.question_section')||
                            $routeName == 'subject-cms.index' || $routeName == 'subject-cms.create' || 
                            $routeName == 'subject-cms.edit' || $routeName == 'school-cms.index' || 
                            $routeName == 'school-cms.create' || $routeName == 'school-cms.edit' ||
                            $currentSlug == 'evaluate-mock' || $currentSlug == 'purchased-mocks' || 
                            $currentSlug == config('constant.blocks.aceMock.emock.child_performance_section')
                                ) m-menu__item--active m-menu__item--open @endif "aria-haspopup="true" m-menu-submenu-toggle="hover">
                            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon socicon-appnet"></i>
                                <span class="m-menu__link-text">E Mock</span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu ">
                                <span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item @if ($currentSlug == config('constant.blocks.aceMock.emock.banner_section')||
                                        $currentSlug == config('constant.blocks.aceMock.emock.paper_section')||
                                        $currentSlug == config('constant.blocks.aceMock.emock.how_exam_work_section')||
                                        $currentSlug == config('constant.blocks.aceMock.emock.question_section')||
                                        $currentSlug == config('constant.blocks.aceMock.emock.child_performance_section')) 
                                        m-menu__item--active m-menu__item--open @endif "aria-haspopup="true" m-menu-submenu-toggle="hover">
                                        <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon fa fa-home"></i>
                                            <span class="m-menu__link-text">{{__('formname.home')}}</span>
                                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                                        </a>
                                        <div class="m-menu__submenu ">
                                            <span class="m-menu__arrow"></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.aceMock.emock.banner_section') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.aceMock.emock.banner_section') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{ Str::limit(@$emockCmsHome[0],19,'..') }}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.aceMock.emock.paper_section') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.aceMock.emock.paper_section') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{ Str::limit(@$emockCmsHome[1],19,'..') }}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.aceMock.emock.how_exam_work_section') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.aceMock.emock.how_exam_work_section') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{ Str::limit(@$emockCmsHome[2],19,'..') }}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.aceMock.emock.question_section') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.aceMock.emock.question_section') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{ Str::limit(@$emockCmsHome[3],19,'..') }}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.aceMock.emock.child_performance_section') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.aceMock.emock.child_performance_section') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{ Str::limit(@$emockCmsHome[4],19,'..') }}</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="m-menu__item @if (
                                        $routeName == 'subject-cms.index' || 
                                        $routeName == 'subject-cms.create' || 
                                        $routeName == 'subject-cms.edit') m-menu__item--active @endif"
                                        aria-haspopup="true">
                                        <a href="{{ route('subject-cms.index') }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-file"></i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">{{__('formname.subject')}}</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item @if ($routeName == 'school-cms.index' || $routeName == 'school-cms.create' || $routeName == 'school-cms.edit') m-menu__item--active @endif"
                                    aria-haspopup="true">
                                        <a href="{{ route('school-cms.index') }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon fas fa-school"></i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">{{__('formname.mock-test.school_id')}}</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <!-- Other Pages -->
                                    <li class="m-menu__item  m-menu__item--submenu  @if ($currentSlug == 'privacy-policy' || $currentSlug == 'terms-conditions' || 
                                    $currentSlug == 'contact-us' || $routeName == 'faq_index' || $routeName == 'faq_create' || $routeName == 'faq_view' || 
                                    $routeName == 'faq_edit' || $currentSlug == 'payments-and-security' || $currentSlug == 'benefits' || 
                                    $currentSlug == 'testimonials'|| $currentSlug == 'evaluate-mock' || $currentSlug == 'purchased-mocks') m-menu__item--active m-menu__item--open @endif "aria-haspopup="true" m-menu-submenu-toggle="hover">
                                        <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon fa fa-file"></i>
                                            <span class="m-menu__link-text">{{__('formname.other_pages')}}</span>
                                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                                        </a>
                                        <div class="m-menu__submenu ">
                                            <span class="m-menu__arrow"></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item   @if ($routeName == 'faq_index' || $routeName == 'faq_create' || $routeName == 'faq_view' || $routeName == 'faq_edit' ) m-menu__item--active @endif"
                                                    aria-haspopup="true">
                                                    <a href="{{ route('faq_index') }}" class="m-menu__link ">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                        <span>
                                                        </span></i>
                                                        <span class="m-menu__link-text">{{__('formname.faq.name')}}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == 'privacy-policy' ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('cms_pages',['slug' => 'privacy-policy' ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{__('formname.privacy_polacy')}}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == 'terms-conditions') m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('cms_pages',['slug' => 'terms-conditions' ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{__('formname.term_and_conditions')}}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item  @if ($currentSlug == 'contact-us') m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('cms_pages',['slug' => 'contact-us' ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{__('formname.contact_us')}}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item  @if ($currentSlug == 'payments-and-security') m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('cms_pages',['slug' => 'payments-and-security' ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{__('formname.pay_and_secur')}}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item  @if ($currentSlug == 'benefits') m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('cms_pages',['slug' => 'benefits' ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{__('formname.benefits')}}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item  @if ($currentSlug == 'testimonials') m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('cms_pages',['slug' => 'testimonials' ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{__('formname.testimonials')}}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item  @if ($currentSlug == 'exam-guidance') m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('cms_pages',['slug' => 'exam-guidance' ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{__('formname.exam-guidance')}}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item  @if ($currentSlug == 'purchased-mocks') m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('cms_pages',['slug' => 'purchased-mocks' ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{__('formname.purchased-mocks')}}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item  @if ($currentSlug == 'evaluate-mock') m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('cms_pages',['slug' => 'evaluate-mock' ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{__('formname.evaluate-mock')}}</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="m-menu__item  m-menu__item--submenu @if (
                            $currentSlug == config('constant.blocks.practice.home.banner_section')||
                            $currentSlug == config('constant.blocks.practice.home.our_module_section')||
                            $currentSlug == config('constant.blocks.practice.home.about_ash_ace')||
                            $currentSlug == config('constant.blocks.practice.home.why_choose_ash_ace')||
                            $currentSlug == config('constant.blocks.practice.home.video_section')||
                            $currentSlug == config('constant.blocks.practice.home.help_section')||
                            $currentSlug == config('constant.blocks.practice.practice.practice_section') ||
                            $currentSlug == config('constant.blocks.practice.practice.topic_section') || 
                            $currentSlug == config('constant.blocks.practice.practice.past_paper_section') ||
                            $currentSlug == config('constant.blocks.practice.practice.practice_section_detail') || 
                            $currentSlug == config('constant.blocks.practice.practice.past_paper_section_detail')
                            ) m-menu__item--active m-menu__item--open @endif "aria-haspopup="true" m-menu-submenu-toggle="hover">
                            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon socicon-appnet"></i>
                                <span class="m-menu__link-text">Practice</span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu ">
                                <span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item @if (
                                        $currentSlug == config('constant.blocks.practice.home.banner_section')||
                                        $currentSlug == config('constant.blocks.practice.home.our_module_section')||
                                        $currentSlug == config('constant.blocks.practice.home.about_ash_ace')||
                                        $currentSlug == config('constant.blocks.practice.home.why_choose_ash_ace')||
                                        $currentSlug == config('constant.blocks.practice.home.video_section')||
                                        $currentSlug == config('constant.blocks.practice.home.help_section')) 
                                        m-menu__item--active m-menu__item--open @endif "aria-haspopup="true" m-menu-submenu-toggle="hover">
                                        <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon fa fa-home"></i>
                                            <span class="m-menu__link-text">{{__('formname.home')}}</span>
                                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                                        </a>
                                        <div class="m-menu__submenu ">
                                            <span class="m-menu__arrow"></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.practice.home.banner_section') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.practice.home.banner_section') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{ Str::limit(@$practiceCmsHome[6],19,'..') }}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.practice.home.our_module_section') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.practice.home.our_module_section') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{ Str::limit(@$practiceCmsHome[3],19,'..') }}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.practice.home.about_ash_ace') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.practice.home.about_ash_ace') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{ Str::limit(@$practiceCmsHome[5],19,'..') }}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.practice.home.why_choose_ash_ace') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.practice.home.why_choose_ash_ace') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{ Str::limit(@$practiceCmsHome[4],19,'..') }}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.practice.home.video_section') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.practice.home.video_section') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{ Str::limit(@$practiceCmsHome[1],19,'..') }}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.practice.home.help_section') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.practice.home.help_section') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{ Str::limit(@$practiceCmsHome[2],19,'..') }}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.practice.home.pay_section') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.practice.home.pay_section') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">{{ Str::limit(@$practiceCmsHome[8],19,'..') }}</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="m-menu__item @if (
                                        $currentSlug == config('constant.blocks.practice.practice.practice_section') ||
                                        $currentSlug == config('constant.blocks.practice.practice.topic_section') || 
                                        $currentSlug == config('constant.blocks.practice.practice.past_paper_section') ||
                                        $currentSlug == config('constant.blocks.practice.practice.practice_section_detail') || 
                                        $currentSlug == config('constant.blocks.practice.practice.past_paper_section_detail')
                                        ) m-menu__item--active m-menu__item--open @endif "aria-haspopup="true" m-menu-submenu-toggle="hover">
                                        <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon fa fa-home"></i>
                                            <span class="m-menu__link-text">{{__('formname.other_pages')}}</span>
                                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                                        </a>
                                        <div class="m-menu__submenu ">
                                            <span class="m-menu__arrow"></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.practice.practice.practice_section') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.practice.practice.practice_section') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>    
                                                        <span class="m-menu__link-text">{{ Str::limit(@$practiceCmsHome[9],19,'..') }}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.practice.practice.topic_section') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.practice.practice.topic_section') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>    
                                                        <span class="m-menu__link-text">{{ Str::limit(@$practiceCmsHome[10],19,'..') }}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.practice.practice.past_paper_section') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.practice.practice.past_paper_section') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>    
                                                        <span class="m-menu__link-text">{{ Str::limit(@$practiceCmsHome[11],19,'..') }}</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.practice.practice.practice_section_detail') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.practice.practice.practice_section_detail') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">Practice By Assessment Detail Page</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item @if ($currentSlug == config('constant.blocks.practice.practice.past_paper_section_detail') ) m-menu__item--active @endif" aria-haspopup="true">
                                                    <a href="{{ route('block_index',['slug' => config('constant.blocks.practice.practice.past_paper_section_detail') ]) }}" class="m-menu__link">
                                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="m-menu__link-text">Practice By Past Paper Detail Page</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>

            @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->hasAnyPermission(['web setting view','web setting create','web setting edit','web setting
            delete','web setting multiple delete'])))
            <li class="m-menu__item  @if ($routeName == 'web_setting_index' || $routeName == 'web_setting_create' || $routeName == 'web_setting_edit' ) m-menu__item--active @endif"
                aria-haspopup="true">
                <a href="{{ route('web_setting_index') }}" class="m-menu__link ">
                    <i class="m-menu__link-icon 
                    flaticon-settings "></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">{{trans('formname.web_setting.name')}}</span>
                        </span>
                    </span>
                </a>
            </li>
            @endif
            {{-- @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->hasAnyPermission(['profile view','profile update']))) --}}
            <li class="m-menu__item  @if ($routeName == 'profile') m-menu__item--active @endif"
            aria-haspopup="true">
                <a href="{{ route('profile') }}" class="m-menu__link ">
                    <i class="m-menu__link-icon 
                    flaticon-profile "></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">{{trans('formname.profile')}}</span>
                        </span>
                    </span>
                </a>
            </li>
            {{-- @endif --}}
            <li class="m-menu__item " aria-haspopup="true">
                <a href="{{ route('admin.logout') }}"
                    onclick="event.preventDefault(); document.getElementById('frm-side-logout').submit();"
                    class="m-menu__link">
                    <i class="m-menu__link-icon fa 	fa-sign-out-alt"></i>
                    <span class="m-menu__link-text">{{__('formname.logout')}}</span>
                </a>
                <form id="frm-side-logout" action="{{ route('admin.logout') }}" method="post" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>
<!-- END: Left Aside -->
