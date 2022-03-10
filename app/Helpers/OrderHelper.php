<?php

namespace App\Helpers;

use App\Helpers\PdfHelper;
use App\Models\Admin;
use App\Models\MockTest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Paper;
use App\Models\PaperVersion;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Mail;
use setasign\FpdiProtection\FpdiProtection;

class OrderHelper extends BaseHelper
{
    protected $order, $orderItem, $paper, $footerY;
    public function __construct(BaseHelper $helper,Order $order, OrderItem $orderItem, Paper $paper, PaperVersion $paperVersion, MockTest $mockTest)
    {
        $this->order = $order;
        $this->orderItem = $orderItem;
        $this->paper = $paper;
        $this->paperVersion = $paperVersion;
        $this->helper = $helper;
        $this->mockTest = $mockTest;
        parent::__construct();
    }

    /**
     * -------------------------------------------------------
     * | Get Order                                           |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function getOrder($id)
    {
        return $this->order::where('id', $id)
            ->with('items')
            ->with('biilingAddress')
            ->first();
    }

    /**
     * -------------------------------------------------------
     * | Fetch Order                                         |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function fetchOrder()
    {
        return $this->order::orderBy('created_at', 'desc')
            ->withTrashed()
            ->first();
    }

    /**
     * -------------------------------------------------------
     * | Get cart items count                                |
     * |                                                     |
     * -------------------------------------------------------
     */
    public static function getCartItemsCount()
    {
        $product = session()->get('cartProducts');
        return $product ? count($product) : 0;
    }

    /**
     * -------------------------------------------------------
     * | Check product is already added into cart or not     |
     * |                                                     |
     * | @param $paperId                                     |
     * | @return Boolean                                     |
     * -------------------------------------------------------
     */
    public function checkProductInCart($paperId)
    {
        $cart = session()->get('cartProducts');
        if ($cart && in_array($paperId, $cart)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * ------------------------------------------------------
     * | Get Order List                                     |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function orderList()
    {
        return $this->order::with('items')->withTrashed();
    }

    /**
     * ------------------------------------------------------
     * | Send Mail to customer                              |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function sendmail($view, $data, $message=null, $subject, $userdata)
    {
        $mail = Mail::send($view, $data, function ($message) use ($userdata, $subject) {
            $message->to($userdata->email)->subject($subject);
        });
       
    }

    /**
     * -------------------------------------------------------
     * | Get cart all products                               |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function getCartAllProducts()
    {
        $cart = session()->get('cartProducts');
        return $cart ? $cart : [];
    }

    /**
     * ------------------------------------------------------
     * | get product detail                                 |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function detail($uuid)
    {
        return $this->order::where('uuid', $uuid)->first();
    }

    /**
     * ------------------------------------------------------
     * | set watermark on pdf                               |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function setWaterMark($file, $paperVersion, $user, $text, $watermarkX, $footerX, $watermarkY, $footerY, $angle, $watermarkcolor, $footerColor, $watermarkfont, $watermarkfontsize, $footerfont, $footerfontsize, $watemarkopacity, $footerOpacity)
    {
        try {
            $this->footerY = $footerY;
            $this->pdf2 = new PdfHelper();
            $this->pdf2->file($file, $footerY);
            $this->pdf2->AddPage();
            $this->pdf2->SetFont('Arial', '', 12);
            $pagecount = $this->pdf2->setSourceFile($file);
            // check if nuber of pages is gratert than or equal to 1
            if ($this->pdf2->numPages >= 1) {
                for ($i = 2; $i <= $this->pdf2->numPages; $i++) {
                    $this->pdf2->_tplIdx = $this->pdf2->importPage($i);
                    $this->pdf2->SetAlpha($watemarkopacity);
                    $this->pdf2->SetFont($watermarkfont, 'B', $watermarkfontsize);
                    $this->pdf2->SetTextColor($watermarkcolor[0], $watermarkcolor[1], $watermarkcolor[2]);
                    $this->pdf2->RotatedText($watermarkX, $watermarkY, $text, $angle);
                    $this->pdf2->SetFont($footerfont, 'I', $footerfontsize);
                    $this->pdf2->SetAlpha($footerOpacity);
                    $this->pdf2->SetTextColor($footerColor[0], $footerColor[1], $footerColor[2]);
                    $this->pdf2->AddPage();
                }
                $this->pdf2->_tplIdx = $this->pdf2->importPage($pagecount);
                $this->pdf2->SetAlpha(0.6);
                $this->pdf2->SetFont('Arial', 'B', 10);
                $this->pdf2->SetTextColor(206, 200, 200);
                $this->pdf2->RotatedText(240, 100, $text, 50);
                $this->pdf2->SetFont('Arial', 'I', 10);
                $this->pdf2->SetAlpha(0.8);
                $this->pdf2->SetTextColor(0, 0, 0);
            }
            $password = $user->email;
            $paperId = ($paperVersion->paper_id==null)?$paperVersion->id:$paperVersion->paper_id;
            $dir =  config('constant.storage_path'). config('constant.paper.folder_name') . $paperId . '/download/';
            // check if directory is exist or not
            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0777, true, true);
            }
            $this->pdf2->Output($dir . $paperVersion->pdf_name, 'F');
            $file2 = config('constant.storage_path'). config('constant.paper.folder_name') . $paperId . '/download/' . $paperVersion->pdf_name;
            $this->pdfEncrypt($file2, $password, $file2);
            return $file2;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * ------------------------------------------------------
     * | set password protected pdf                         |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function pdfEncrypt($origFile, $password, $destFile)
    {
        $pdf = new FpdiProtection();
        $pagecount = $pdf->setSourceFile($origFile);

        for ($loop = 1; $loop <= $pagecount; $loop++) {
            $tplidx = $pdf->importPage($loop);
            $pdf->addPage();
            $pdf->useTemplate($tplidx);
        }
        $pdf->SetProtection(array(), $password);
        $pdf->Output($destFile, 'F');
    }

    /* -------------------------------------------------------
     * | Get cart sub total                                  |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function cartSubTotal($ids)
    {
        return empty($ids) ? '0.00' : $this->paper->whereIn('id', $ids)->sum('price');

    }
    /**
     * ------------------------------------------------------
     * | Get order detail by id                             |
     * |                                                    |
     * | @param $id                                         |
     * |-----------------------------------------------------
     */
    public function orderByUuid($uuid)
    {
        return $this->order->whereUuid($uuid)->firstOrFail();
    }

    /**
     * -------------------------------------------------------
     * | Get Next order number                               |
     * |                                                     |
     * | @return Number                                      |
     * -------------------------------------------------------
     */
    public function getNextOrderNumber()
    {
        $lastOrder = $this->fetchOrder();
        $lastOrder ? $number = substr($lastOrder->order_no, 0, 4) : $number = 0;
        $digits = 7;
        return sprintf('%04d', intval($number) + 1) . '-' . date('Ymd') . '-' . rand(pow(10, $digits - 1), pow(10, $digits) - 1);
    }

    /**
     * -------------------------------------------------------
     * | Get Next invoice number                             |
     * |                                                     |
     * | @return Number                                      |
     * -------------------------------------------------------
     */
    public function getNextInvoiceNumber()
    {
        $lastOrder = $this->fetchOrder();
        $lastOrder ? $number = substr($lastOrder->invoice_no, 7) : $number = 0;
        return 'INV' . date('Y') . sprintf('%07d', intval($number) + 1);
    }

    /**
     * -------------------------------------------------------
     * | Get Order by uuid                                   |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function getOrderByUuid($uuid)
    {
        return $this->order::where('uuid', $uuid)->first();
    }

    /**
     * -------------------------------------------------------
     * | Send Email                                          |
     * |                                                     |
     * | @param $orderId                                     |
     * -------------------------------------------------------
     */
    public function sendMailToUser($orderId = null)
    {
        try {
            $slug = config('constant.email_template.7');
            $template = $this->helper->emailTamplate($slug);
            $subject = $template->subject;
            $order = $this->getOrder($orderId);

            $userdata = $order->biilingAddress;
            $billingInfo = $this->helper->onlyAddress($order->biilingAddress2->toArray());
            $view = 'admin.orders.mail';
            $this->sendMail($view, ['order'=>@$order,'content'=>@$template->body,'billingInfo'=>@$billingInfo], null, @$subject, @$userdata);
            return __('formname.order_email_label');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /*
     * -------------------------------------------------------
     * | Send Email To Admin                                 |
     * |                                                     |
     * | @param $orderId                                     |
     * -------------------------------------------------------
     */
    public function sendMailToAdmin($order)
    {
        try {
            $slug = config('constant.email_template.2');
            $template = $this->helper->emailTamplate($slug);
            $subject = $template->subject;
            $userdata = Admin::first();
            $view = 'admin.orders.details.admin_email';
            $this->sendMail($view, ['order'=>$order,'content'=>$template->body], null, $subject, $userdata);
            return __('formname.order_email_label');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * -------------------------------------------------------
     * | Download watermark paper                            |
     * |                                                     |
     * | @param $orderId                                     |
     * -------------------------------------------------------
     */
    public function downloadPaper($uuid, $slug, $version=null)
    {
        $order = $this->getOrderByUuid($uuid);
        $user = $order->biilingAddress;
        // check if paper order data is greater than next year date or not 
        if (!Carbon::now()->greaterThan(Carbon::parse($order->created_at)->addYear()) || Auth::guard('admin')->user()) {
            $paper = $this->paper::whereSlug($slug)->first();
            // check if version is null or not
            if($version == null){
                $paperVersion = $paper;
            }else{
                $paperVersion = $this->paperVersion::whereUuid($version)->wherePaperId($paper->id)->first();
            }
            $file = $paperVersion->pdf_path;
            // check if exist in directory or not  
            if (file_exists($file)) {
                $text = $paper->edition . ' Edition. This product is licensed solely for the personal and private use of ' . @$user->first_name . ' ' . @$user->last_name . ', ' . @$user->address1 . ', ' . @$user->address2 . ', ' . @$user->city . ', ' . @$user->state . ', ' . @$user->country . ', ' . @$user->postal_code . ', ' . @$user->email;
                $watermarkfont = 'Arial';
                $watermarkfontsize = 10;
                $footerfont = 'Arial';
                $footerfontsize = 8;
                $watemarkopacity = 0.5;
                $footerOpacity = 1;
                $watermarkX = 240;
                $watermarkY = 100;
                $footerX = 10;
                $footerY = -20;
                $angle = 50;
                $watermarkcolor = [0 => 206, 1 => 200, 2 => 200];
                $footerColor = [0 => 0, 1 => 0, 2 => 0];
                $newfile = $this->setWaterMark($file, $paperVersion, $user, $text, $watermarkX, $footerX, $watermarkY, $footerY, $angle, $watermarkcolor, $footerColor, $watermarkfont, $watermarkfontsize, $footerfont, $footerfontsize, $watemarkopacity, $footerOpacity);
                return $paperVersion;
            }
        }
    }
    /**
     * -------------------------------------------------------
     * | Get Order                                           |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function getPaperOrder($orderId,$paperid,$versionId=null)
    {
        return $this->orderItem::where('order_id',$orderId)
                    ->where('paper_id',$paperid)
                    ->where(function($q) use($versionId){
                        if($versionId !=null){
                            $q->where('version_id',$versionId);
                        }
                    })
                    ->first();
    }

    /**
     * -------------------------------------------------------
     * | Get emock cart all products                         |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function getMockCartAllProducts()
    {
        $cart = session()->get('mockCartProducts');
        return $cart ? $cart : [];
    }

    /* -------------------------------------------------------
     * | Get cart sub total                                  |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function mockCartSubTotal($ids)
    {
        return empty($ids) ? '0.00' : $this->mockTest->whereIn('id', $ids)->sum('price');
    }

    /**
     * -------------------------------------------------------
     * | Check product is already added into cart or not     |
     * |                                                     |
     * | @param $paperId                                     |
     * | @return Boolean                                     |
     * -------------------------------------------------------
     */
    public function checkEmockProductInCart($paperId)
    {
        $cart = session()->get('mockCartProducts');
        if ($cart && in_array($paperId, $cart)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * -------------------------------------------------------
     * | Send Email to parent after purchased emock                                      |
     * |                                                     |
     * | @param $orderId                                     |
     * -------------------------------------------------------
     */
    public function sendMailToParent($orderId)
    {
     
        try {
        //    $slug = config('constant.email_template.1');
        //    $template = $this->helper->emailTamplate($slug);
        //    $subject = $template->subject;
           $subject = 'Purchased EMock Billing Details';
          
            $order = $this->getOrder($orderId);
            $userdata = $order->biilingAddress;
           // print_r($userdata);
            $view = 'newfrontend.orders.mail';
            $this->sendMail($view, ['order'=>@$order,'content'=>'purchased emock'], null, @$subject, @$userdata);
            return __('formname.order_email_label');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


}
