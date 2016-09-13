<?php
require_once('./library/tcpdf/examples/lang/eng.php');
require_once('./library/tcpdf/tcpdf.php');
require_once('./library/fpdi.php');
 
class Pdf_concat extends FPDI {
     var $files = array();
     
     function setFiles($files) {
          $this->files = $files;
     }
 
     function concat() {
          foreach($this->files AS $file) {
               $pagecount = $this->setSourceFile($file);
               for ($i = 1; $i <= $pagecount; $i++) {
                    $tplidx = $this->ImportPage($i);
                    $s = $this->getTemplatesize($tplidx);
                    $this->AddPage('P', array($s['w'], $s['h']));
                    $this->useTemplate($tplidx);
               }
          }
     }
}
$directorio1 = $_SERVER ['DOCUMENT_ROOT'] . '/documentos/Avoco/';
$directorio2 = $_SERVER ['DOCUMENT_ROOT'] . '/documentos/RazonDocumentos/';
$directorio3 = $_SERVER ['DOCUMENT_ROOT'] . '/documentos/RazonUnida/';

$file2merge=array($directorio1.'Avoco1062.pdf', $directorio2.'RazonDocumentos1005.pdf');
$pdf = new Pdf_concat();
$pdf->setFiles($file2merge);
$pdf->concat();
$pdf->Output($directorio3.'newfile.pdf', "F");
?>
