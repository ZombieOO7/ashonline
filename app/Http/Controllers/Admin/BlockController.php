<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\BlockHelper;
use Exception;
use Illuminate\Http\Request;
use Lang;
use Redirect;

class BlockController extends BaseController
{
    private $helper;
    public $viewconstant = 'admin.papers';
    public function __construct(BlockHelper $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.admin');

    }

    /**
     * -------------------------------------------------------
     * | Block List                                          |
     * |                                                     |
     * | @param $slug                                        |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function index($slug)
    {
        try{
            $block = $this->helper->findBySlug($slug);
            return view('admin.blocks.index', ['block' => @$block, 'title' => @$block->title]);
        }catch (Exception $e)  {
            abort('404');
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Store block details                                 |
     * |                                                     |
     * | @param Request $request                             |
     * | @return Redirect                                    |
     * -------------------------------------------------------
     */
    public function store(Request $request)
    {
        $this->helper->dbStart();
        try {
            $block = $this->helper->findById($request->id);
            $block->fill($request->all())->save();
            $this->helper->dbEnd();
            $msg = Lang::get('admin_messages.action_msg', ['action' => Lang::get('admin_messages.updated'), 'type' => __('admin_messages.content')]);
            return Redirect::route('block_index', ['slug' => @$request->slug])->with('message', @$msg);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            abort('404');
        }
    }
}
