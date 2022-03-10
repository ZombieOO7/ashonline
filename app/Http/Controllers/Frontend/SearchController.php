<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Paper;
use App\Models\PaperKeyword;
use App\Models\SearchLog;

class SearchController extends Controller
{
    /**
     * -------------------------------------------------
     * | Auto complete search                          |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function autocomplete(Request $request)
    {
        $title = $request->get('term','');
        if(trim($title) == null) {
            return ['value'=>'','id'=>''];
        }
        $papers = Paper::where('title','ilike', '%'.$title.'%')
                    ->orWhere('content','ilike','%'.$title.'%')
                    ->where('status',1)
                    ->where('deleted_at',null)
                    ->orWhereHas('keywords',function($query) use($title){
                        $query->where('title', 'ilike', '%'.$title.'%');
                    })
                    ->orWhereHas('category',function($q)use($title) {
                        $this->whereHasSubQuery($q,$title);
                    })
                    ->orWhereHas('subject',function($q)use($title) {
                        $this->whereHasSubQuery($q,$title);
                    })
                    ->orWhereHas('examType',function($q)use($title) {
                        $this->whereHasSubQuery($q,$title);
                    })
                    ->orWhereHas('stage',function($q)use($title) {
                        $this->whereHasSubQuery($q,$title);
                    })
                    ->get();
        $data = array();
        foreach ($papers as $paper) {
            $data[] = [ 'value' => @$paper->paper_id ? $paper->paper->title : $paper->title, 'id'=>$paper->id ];
        }
        
        $response = count($data) ? $data : ['value'=>'','id'=>'']; 
        return $response;
    }
    
    /**
     * -------------------------------------------------
     * | Search papers                                 |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function search(Request $request) 
    {
        $clientIP = request()->ip();
        $title = $request->title;

        if(trim($title) == null) {
            $paperData = view('frontend.papers.searched_papers')->render();
            return response()->json(['jsonData'=>$paperData]);
        } else {
            /** Store search logs */
            $logExists = SearchLog::whereTitle($title)->whereIpAddress($clientIP)->first();
            if ($logExists == null) {
                $logsData = [ 'title' => $title, 'ip_address' => $clientIP ];
                $searchLog = new SearchLog();
                $searchLog->fill($logsData)->save();
            }

            // $paperKeywords = $this->paperKeywordQuery($title)->pluck('paper_id');
            // if ($paperKeywords->count() == 0) {
            //     $query = $this->paperQuery($title);
            //     $paperKeywords = $this->paperWhereHasQuery($query,$title)->pluck('id');
            // }

            // $papers = Paper::whereIn('id',$paperKeywords)->get();
            $papers = Paper::where('title','ilike', '%'.$title.'%')
                    ->orWhere('content','ilike','%'.$title.'%')
                    ->where('status',1)
                    ->where('deleted_at',null)
                    ->orWhereHas('keywords',function($query) use($title){
                        $query->where('title', 'ilike', '%'.$title.'%');
                    })
                    ->orWhereHas('category',function($q)use($title) {
                        $this->whereHasSubQuery($q,$title);
                    })
                    ->orWhereHas('subject',function($q)use($title) {
                        $this->whereHasSubQuery($q,$title);
                    })
                    ->orWhereHas('examType',function($q)use($title) {
                        $this->whereHasSubQuery($q,$title);
                    })
                    ->orWhereHas('stage',function($q)use($title) {
                        $this->whereHasSubQuery($q,$title);
                    })
                    ->get();
            $paperData = view('frontend.papers.searched_papers',['papers' => @$papers])->render();
            return response()->json(['jsonData'=>$paperData]);
        }

        
    }

    /**
     * -------------------------------------------------
     * | Paper Query                                   |
     * |                                               |
     * | @param $title                                 |
     * |------------------------------------------------
     */
    public function paperQuery($title) 
    {
        return Paper::where('title','ilike', '%'.$title.'%')->orWhere('content','ilike','%'.$title.'%')->where('status',1)->where('deleted_at',null);
    }

    /**
     * -------------------------------------------------
     * | Paper Keyword Query                           |
     * |                                               |
     * | @param $title                                 |
     * |------------------------------------------------
     */
    public function paperKeywordQuery($title) 
    {
        return PaperKeyword::where('title', 'ilike', '%'.$title.'%');
    }

    /**
     * -------------------------------------------------
     * | Paper Where Has Query                         |
     * |                                               |
     * | @param $query,$title                          |
     * |------------------------------------------------
     */
    public function paperWhereHasQuery($query,$title)
    {
        $query->orWhereHas('category',function($q)use($title) {
            $this->whereHasSubQuery($q,$title);
        });

        $query->orWhereHas('subject',function($q)use($title) {
            $this->whereHasSubQuery($q,$title);
        });

        $query->orWhereHas('examType',function($q)use($title) {
            $this->whereHasSubQuery($q,$title);
        });

        return $query->orWhereHas('stage',function($q)use($title) {
            $this->whereHasSubQuery($q,$title);
        });
    }

    /**
     * -------------------------------------------------
     * | Where Has Sub Query                           |
     * |                                               |
     * | @param $query,$title                          |
     * |------------------------------------------------
     */
    public function whereHasSubQuery($query,$title) 
    {
        return $query->where('title','ilike', '%'.$title.'%')->orWhere('content','ilike','%'.$title.'%')->where('status',1)->where('deleted_at',null);
    }
}
