<?php


namespace App\Helpers;


use App\Models\Image;

class ImageHelpers extends BaseHelper
{
    protected $ImageManagement;
    public function __construct(Image $ImageManagement)
    {
        $this->ImageManagement = $ImageManagement;
        parent::__construct();
    }

    public function ImageList()
    {
        return $this->ImageManagement::orderBy('id', 'desc');
    }
    public function detail($id)
    {
        return $this->ImageManagement::where('id', $id)->first();
    }
    public function delete($id)
    {
        $stage = $this->detail($id);
        $stage->delete();
    }

}
