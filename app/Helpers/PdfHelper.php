<?php
namespace App\Helpers;

use App\Helpers\PdfRotateHelper;

class PdfHelper extends PdfRotateHelper
{
    public $_tplIdx, $file, $txt, $footerY;
    public function file($file, $footerY)
    {
        $this->file = $file;
        $this->footerY = $footerY;
    }

    //Put the watermark
    public function Header()
    {
        global $fullPathToFile;
        $fullPathToFile = $this->file;
        if (is_null($this->_tplIdx)) {
            $this->numPages = $this->setSourceFile($fullPathToFile);
            $this->_tplIdx = $this->importPage(1);
        }
        $this->useTemplate($this->_tplIdx, 0, 0, 200);
    }
    //Text rotated around its origin
    public function RotatedText($x, $y, $txt, $angle)
    {
        $this->txt = $txt;
        $this->Rotate($angle, $x, $y);
        $this->Multicell(200, 5, $txt);
        $this->Rotate(0);
    }

    public $extgstates = array();

    //Set Text transparancy
    public function SetAlpha($alpha, $bm = 'Normal')
    {
        $gs = $this->AddExtGState(array('ca' => $alpha, 'CA' => $alpha, 'BM' => '/' . $bm));
        $this->SetExtGState($gs);
    }

    public function AddExtGState($parms)
    {
        $n = count($this->extgstates) + 1;
        $this->extgstates[$n]['parms'] = $parms;
        return $n;
    }

    public function SetExtGState($gs)
    {
        $this->_out(sprintf('/GS%d gs', $gs));
    }

    public function _enddoc()
    {
        if (!empty($this->extgstates) && $this->PDFVersion < '1.4') {
            $this->PDFVersion = '1.4';
        }

        parent::_enddoc();
    }

    public function _putextgstates()
    {
        for ($i = 1; $i <= count($this->extgstates); $i++) {
            $this->_newobj();
            $this->extgstates[$i]['n'] = $this->n;
            $this->_out('<</Type /ExtGState');
            $parms = $this->extgstates[$i]['parms'];
            $this->_out(sprintf('/ca %.3F', $parms['ca']));
            $this->_out(sprintf('/CA %.3F', $parms['CA']));
            $this->_out('/BM ' . $parms['BM']);
            $this->_out('>>');
            $this->_out('endobj');
        }
    }

    public function _putresourcedict()
    {
        parent::_putresourcedict();
        $this->_out('/ExtGState <<');
        foreach ($this->extgstates as $k => $extgstate) {
            $this->_out('/GS' . $k . ' ' . $extgstate['n'] . ' 0 R');
        }
        $this->_out('>>');
    }

    public function _putresources()
    {
        $this->_putextgstates();
        parent::_putresources();
    }

    public function Footer()
    {
        $this->SetY($this->footerY);
        $this->SetFont('Arial', 'I', 10);
        $this->Multicell(0, 6, $this->txt, 0, 'C');
    }
}
