<?php

namespace App\Helpers;

use App\Models\PaperCategory;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PaperCategoryHelper extends BaseHelper
{

    protected $paperCategory, $stage;
    public function __construct(PaperCategory $paperCategory, Stage $stage)
    {
        $this->paperCategory = $paperCategory;
        $this->stage = $stage;
        parent::__construct();
    }
    /**
     * ------------------------------------------------------
     * | Get Paper Category List                            |
     * |                                                    |
     * |-----------------------------------------------------
     */

    public function PaperCategoryList()
    {
        return $this->paperCategory;
    }

    /**
     * ------------------------------------------------------
     * | Paper Category detail by id                        |
     * |                                                    |
     * | @param $id                                         |
     * |-----------------------------------------------------
     */
    public function detailById($id)
    {
        return $this->paperCategory::whereId($id)->first();
    }

    /**
     * ------------------------------------------------------
     * | Paper Category store                               |
     * |                                                    |
     * | @param Request $request,$uuid                      |
     * |-----------------------------------------------------
     */
    public function store(Request $request, $uuid = null)
    {
        $request['slug'] = $this->createSlug($request->title);
        $paperCategory = PaperCategory::updateOrCreate(['id'=>@$request->id],$request->all());
        // check if reqest has beneifits or not
        if ($request->benefits) {
            $this->storeBenefitsOrProduct(0, $request->benefits, $paperCategory);
        }
        // check if reqest has products or not
        if ($request->products) {
            $this->storeBenefitsOrProduct(1, $request->products, $paperCategory);
        }

        return $paperCategory;
    }

    /**
     * ------------------------------------------------------
     * | Store Paper category products and benefits         |
     * |                                                    |
     * | @param $rCquest,$papercategory                     |
     * |-----------------------------------------------------
     */

    public function storeBenefitsOrProduct($type, $benefitsOrProduct, $paperCategory)
    {
        $type == 0 ? $paperCategory->keyBenefits()->delete() : $paperCategory->keyProducts()->delete();
        data_set($benefitsOrProduct, '*.type', $type);
        $type == 0 ? $paperCategory->keyBenefits()->createMany($benefitsOrProduct) : $paperCategory->keyProducts()->createMany($benefitsOrProduct);
    }

    /**
     * ------------------------------------------------------
     * | Store Image                                        |
     * |                                                    |
     * | @param $rCquest,$papercategory                     |
     * |-----------------------------------------------------
     */
    public function storeImage($request, $paperCategory)
    {
        $folderName = config('constant.paper_category.folder_name') . $paperCategory->id;
        // check if request has id or not
        if ($request->id != null):
            $this->deleteImage($paperCategory->StoragePath, $folderName);
        endif;
        $avatarImage = $request->file('image');
        $imageFunction = $this->uploadImage($avatarImage, $folderName, config('constant.avatar_img_width'), config('constant.avatar_img_height'));
        //Update paper$paperCategory records
        $paperCategory = $this->paperCategory::updateOrCreate([
            'id' => $paperCategory->id,
        ], [
            'image' => @$imageFunction[1],
            'image_path' => config('constant.storage_path') . $folderName . '/' . @$imageFunction[0],
            'thumb_path' => config('constant.storage_path') . $folderName . '/thumb/' . @$imageFunction[0],
            'mime_type' => $request->file('image')->getMimeType(),
            'extension' => $request->file('image')->getClientOriginalExtension(),
        ]);
        return $request;
    }

    /**
     * ------------------------------------------------------
     * | Update status                                      |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function statusUpdate($uuid)
    {
        $paperCategory = $this->detail($uuid);
        $status = $paperCategory->status == config('constant.status_active_value') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $cat = $this->paperCategory::where('id', $paperCategory->id)->with('blogGuidance')->first();
        // 
        if($status == config('constant.status_inactive_value')) {
            $cat->blogGuidance()->update(['status' => $status]);
            // Update papers status
            $paperCategory->papers()->update(['status' => $status]);
        }
        $cat->update(['status' => $status]);
        return $status;
    }

    /**
     * ------------------------------------------------------
     * | Paper Category detail by uuid                      |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function detail($uuid)
    {
        return $this->paperCategory::where('uuid', $uuid)->first();
    }

    /**
     * ------------------------------------------------------
     * | Delete Paper Category                              |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function delete($uuid)
    {
        $paperCategory = $this->detail($uuid);
        $this->removeDirectory($paperCategory->id);
        $paperCategory->delete();
    }

    /**
     * ------------------------------------------------------
     * | Remove folder                                      |
     * |                                                    |
     * | @param $folder                                     |
     * |-----------------------------------------------------
     */
    public function removeDirectory($folder)
    {
        $publicPath = str_replace('public', '', public_path());
        $path = $publicPath . config('constant.paper_category.directory_path') . $folder;
        // check if directory is exist or not
        if (File::isDirectory($path)) {
            File::deleteDirectory($path);
        }
    }
    /**
     * ---------------------------------------------------------------
     * | Delete multiple paper category                              |
     * |                                                             |
     * | @param Request $request                                     |
     * | @return Void                                                |
     * ---------------------------------------------------------------
     */
    public function multiDelete(Request $request)
    {
        $paperCategory = $this->paperCategory::whereIn('id', $request->ids);
        // check if action is too delete record
        if ($request->action == config('constant.delete')) {
            $paperCategory->delete();
        } else {
            $status = $request->action == config('constant.inactive') ? config('constant.status_inactive_value') : config('constant.status_active_value');
            if($status == config('constant.status_active_value')) {
                foreach($paperCategory->get() as $item) {
                    $item->blogGuidance()->update(['status' => $status]);
                }
            }
            $paperCategory->update(['status' => $status]);
        }
    }

    /**
     * ------------------------------------------------------
     * | Get Paper Category List with papers                |
     * | in frontend                                        |
     * |-----------------------------------------------------
     */
    public static function getPaperCategoryList()
    {
        return PaperCategory::active()
            ->notDeleted()
            ->orderBy('position', 'ASC')
            ->get();
    }

    public static function getPaperCategoryListForAbout()
    {
        return PaperCategory::active()
            ->notDeleted()
            ->orderBy('sequence', 'ASC')
            ->get();
    }

    /**
     * ------------------------------------------------------
     * | Get Paper Category detail with papers using slug   |
     * | in frontend                                        |
     * |-----------------------------------------------------
     */
    public static function detailBySlug($slug)
    {
        return PaperCategory::orderBy('title', 'asc')
            ->where('slug', $slug)
            ->active()->notDeleted()->with('papers')->get();
    }

    /**
     * ------------------------------------------------------
     * | Paper category detail by slug                      |
     * |                                                    |
     * | @param $id                                         |
     * |-----------------------------------------------------
     */
    public function detailByOnlySlug($slug)
    {
        return $this->paperCategory::whereSlug($slug)->firstOrFail();
    }

    /**
     * ------------------------------------------------------
     * | Paper category type list                           |
     * |                                                    |
     * | @param $id                                         |
     * |-----------------------------------------------------
     */
    public function typeList()
    {
        return [
            '' => 'Select Type',
            '1' => 'Grade',
            '2' => 'SATs',
        ];
    }

    /**
     * ------------------------------------------------------
     * | Paper category Stage list                          |
     * |                                                    |
     * | @param $id                                         |
     * |-----------------------------------------------------
     */
    public function stageList()
    {
        $stages = $this->stage::active()->notDeleted()->pluck('title', 'id');
        return $stages;
    }

    /**
     * ------------------------------------------------------
     * | Get Paper Category List for header with papers     |
     * | in frontend                                        |
     * |-----------------------------------------------------
     */
    public static function footerPaperCategoryList()
    {
        return PaperCategory::orderBy('sequence', 'asc')
            ->active()
            ->notDeleted()
            ->get();
    }
}
