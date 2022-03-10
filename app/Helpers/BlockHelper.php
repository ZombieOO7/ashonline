<?php

namespace App\Helpers;

use App\Models\Block;

class BlockHelper extends BaseHelper
{
    protected $block;
    public function __construct(Block $block)
    {
        $this->block = $block;
        parent::__construct();
    }

    /**
     * ------------------------------------------------------
     * | Get Block details                                  |
     * |                                                    |
     * | @param $type,$subtype                              |
     * |-----------------------------------------------------
     */
    public function getBlockDetails($type, $subtype, $projectType)
    {
        $data = $this->block::whereType($type)
            ->whereSubType($subtype)
            ->whereProjectType($projectType)
            ->first();
        return $data;
    }

    /**
     * ------------------------------------------------------
     * | Find block by using slug                           |
     * |                                                    |
     * | @param $slug                                       |
     * |-----------------------------------------------------
     */
    public function findBySlug($slug)
    {
        return $this->block::whereSlug($slug)->firstOrFail();
    }

    /**
     * ------------------------------------------------------
     * | Find block by using id                             |
     * |                                                    |
     * | @param $id                                         |
     * |-----------------------------------------------------
     */
    public function findById($id)
    {
        return $this->block::findOrFail($id);
    }
}
