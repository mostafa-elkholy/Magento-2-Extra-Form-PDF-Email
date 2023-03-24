<?php
namespace Sharpeningservices\MailAttachment\Controller\Index;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Zend\Log\Filter\Timestamp;
use Magento\Store\Model\StoreManagerInterface;

class Submit extends \Magento\Framework\App\Action\Action
{
/**
* Recipient email config path
*/
const XML_PATH_EMAIL_RECIPIENT = 'trans_email/ident_custom2/email';
/**
* @var \Magento\Framework\Mail\Template\TransportBuilder
*/
protected $_transportBuilder;

/**
* @var \Magento\Framework\Translate\Inline\StateInterface
*/
protected $inlineTranslation;

/**
* @var \Magento\Framework\App\Config\ScopeConfigInterface
*/
protected $scopeConfig;

/**
* @var \Magento\Store\Model\StoreManagerInterface
*/
protected $storeManager; 
/**
* @var \Magento\Framework\Escaper
*/
protected $_escaper;

protected $fileUploaderFactory;

protected $fileSystem;

protected $_resultRedirectFactory;
/**
* @param \Magento\Framework\App\Action\Context $context
* @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
* @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
* @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
* @param \Magento\Store\Model\StoreManagerInterface $storeManager
*/
public function __construct(
\Magento\Framework\App\Action\Context $context,
\Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
\Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
\Magento\Store\Model\StoreManagerInterface $storeManager,
\Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
Filesystem $fileSystem,

\Magento\Framework\Escaper $escaper
) {
parent::__construct($context);
$this->_transportBuilder = $transportBuilder;
$this->inlineTranslation = $inlineTranslation;
$this->scopeConfig = $scopeConfig;
$this->storeManager = $storeManager;
$this->fileUploaderFactory = $fileUploaderFactory;
$this->fileSystem          = $fileSystem;
$this->_escaper = $escaper;
$this->_resultRedirectFactory=$context->getResultRedirectFactory();
}

/**
* Post user question
*
* @return void
* @throws \Exception
*/
public function execute()
{
    $resultRedirect = $this->_resultRedirectFactory->create(); 
    $params = $this->getRequest()->getPostValue();
        if (!$params) {
            $this->_redirect('*/*/');
            return;
        }
        try {  

	$htmlMessage = 'Your Template Header here';
	
	/* 
	Calculate to what ever you need 
	if you need Help contact melkholy@live.com
	*/	
	$feesMessage = 0;
		

        $varDirectoryPath = $this->fileSystem
            ->getDirectoryWrite(DirectoryList::VAR_DIR)
            ->getAbsolutePath("warranty_pdf/");

        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => $varDirectoryPath,
			'format' => 'A4-P'
            //'format' => $this->helper->getPageFormat()
        ]);
		$mpdf->WriteHTML("<style></style>", \Mpdf\HTMLParserMode::HEADER_CSS);	
 
		$mpdf->WriteHTML(' 
<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body style="font-family:Arial, Helvetica, sans-serif">




    <div style="max-width: 100%;padding: 20px;">

        <table style="width:100%;margin-bottom: 40px; height: 120px;">
            <tr>
                <td width="50%">
                    Logo Here
                </td>
                <td width="30%">
                    <p style="text-align: right;margin:5px;font-weight: bold;">Address</p>
                    <p style="text-align: right;margin:5px;font-weight: bold">Address 2</p>
                    <p style="text-align: right;margin:5px;font-weight: bold">Country</p>
                </td>
            </tr>
        </table>

        <table style="width:100%">
            <tr>
                <td style="margin-bottom: 20px;">
                    <strong style="margin: 5px 0 0 0;font-size: 18px;">Replacement Type:</strong>
                    <span style="margin: 0;font-size: 18px;font-weight:800">'.$params['replacement_type'].'</span>

                </td>
            </tr>
        </table>

        <br>

        <table style="width:100%">
            <tr>
                <td style="margin-bottom: 20px;">
                    <strong style="margin: 5px 0 0 0;font-size: 18px;">Full Name:</strong>
                    <span style="margin: 0;font-size: 18px;font-weight:800">'.$params['name'].'</span>

                </td>
            </tr>
        </table>

        <br>

        <table style="width:100%">
            <tr style="display: flex;align-items: center;">
                <td style="width: 50%">
                    <div style="margin-bottom: 20px;">
                        <strong style="margin: 5px 0 0 0;font-size: 18px;">Date:</strong>
                        <span style="margin: 0;font-size: 18px;font-weight:800">'.$params['date'].'</span>

                    </div>
                </td>
                <td style="width: 50%">
                    <div style="margin-bottom: 20px;">
                        <strong style="margin: 5px 0 0 0;font-size: 18px;">Phone:</strong>
                        <span style="margin: 0;font-size: 18px;font-weight:800">'.$params['phone'].'</span>

                    </div>
                </td>
            </tr>
        </table>

        <br>

        <table style="width:100%">
            <tr>
                <td style="width: 100%">
                    <div style="margin-bottom: 20px;">
                        <strong style="margin: 5px 0 0 0;font-size: 18px;">E-mail:</strong>
                        <span style="margin: 0;font-size: 18px;font-weight:800">'.$params['email'].'</span>

                    </div>
                </td>
            </tr>
        </table>

        <br>


        <table style="width:100%">
            <tr>
                <td style="width: 100%">
                    <div style="margin-bottom: 20px;">
                        <strong style="margin: 5px 0 0 0;font-size: 18px;">Address:</strong>
                        <span style="margin: 0;font-size: 18px;font-weight:800">'.$params['address'].'</span>

                    </div>
                </td>
            </tr>
        </table>

        <br>
		
        <table style="width:100%">
            <tr>
                <td style="width: 33.33%">
                    <div style="margin-bottom: 20px;">
                        <strong style="margin: 5px 0 0 0;font-size: 18px;">City:</strong>
                        <span style="margin: 0;font-size: 18px;font-weight:800">'.$params['city'].'</span>

                    </div>
                </td>
                <td style="width: 33.33%">
                    <div style="margin-bottom: 20px;">
                        <strong style="margin: 5px 0 0 0;font-size: 18px;">State:</strong>
                        <span style="margin: 0;font-size: 18px;font-weight:800">'.$params['state'].'</span>

                    </div>
                </td>
                <td style="width: 33.33%">
                    <div style="margin-bottom: 20px;">
                        <strong style="margin: 5px 0 0 0;font-size: 18px;">Zip:</strong>
                        <span style="margin: 0;font-size: 18px;font-weight:800">'.$params['zip'].'</span>

                    </div>
                </td>				
            </tr>
        </table>		
		
		<br>
        
		<table style="width:100%">
            <tr>
                <td style="width: 50%">
                    <div style="margin-bottom: 20px;">
                        <strong style="margin: 5px 0 0 0;font-size: 18px;">Date of Purchase:</strong>
                        <div style="margin: 0;font-size: 18px;font-weight:800">'.$params['date_of_purchase'].'</div>

                    </div>
                </td>
                <td style="width: 50%">
                    <div style="margin-bottom: 20px;">
                        <strong style="margin: 5px 0 0 0;font-size: 18px;">Place of Purchase Name:</strong>
                        <div style="margin: 0;font-size: 18px;font-weight:800">'.$params['place_of_purchase_name'].'</div>

                    </div>
                </td>
            </tr>
        </table>

        <br>
		
		<table style="width:100%">
            <tr>
                <td style="width: 50%">
                    <div style="margin-bottom: 20px;">
                        <strong style="margin: 5px 0 0 0;font-size: 18px;">Number Of Items:</strong>
                        <span style="margin: 0;font-size: 18px;font-weight:800">'.$params['number_of_items'].'</span>

                    </div>
                </td>
                <td style="width: 50%">
                    <div style="margin-bottom: 20px;">
                        <strong style="margin: 5px 0 0 0;font-size: 18px;">Do you have proof of ownership?:</strong>
                        <span style="margin: 0;font-size: 18px;font-weight:800">'.$params['have_proof_of_ownership'].'</span>

                    </div>
                </td>
            </tr>
        </table>

        <br>		

        <table style="width:100%">
            <tr>
                <td style="margin-bottom: 20px;">
                    <strong style="margin: 5px 0 0 0;font-size: 18px;">List each knife being returned for sharpening:</strong>
                    <div style="margin: 0;font-size: 18px;font-weight:800">'.$params['description'].'</div>

                </td>
            </tr>
        </table>

        <br>
		
		
		

        <table style="width:100%">
            <tr>
                <td style="width:100%;text-align: center;">
                    <strong style="color:#dc143c;margin: 30px 0 20px 0;font-size: 24px;text-align: center;display: block;">Important Warranty Information</strong>
                </td>
            </tr>
        </table>


        <div style="width:100%">
            <div class="additional-information-form">

                <p style="color: #ec2027;">Extra Information Here</p>
 		 <p style="color: #ec2027;">Fees: '.$feesMessage.'</p>

                    
 
 



 

            <table width="100%" style="font-family: serif;" cellpadding="10">
                <tr>
                    <td width="50%" style="border: 0mm solid #888888; ">
                        <div style="margin: 5px 0;font-size: 18px;font-weight:600;color:#dc143c">Your Signature:</div>
                    </td>
                    <td width="50%" style="border: 0.1mm solid #888888;">
                        <br/><br/><br/>
                    </td>
                </tr>
            </table>


        </div>
</body>

</html>
 
 ', \Mpdf\HTMLParserMode::HTML_BODY);
		
		

        $date = date('Y-m-d_H-i-s');
        $name = 'warranty_services_' . $date . '.pdf';
		$dest = $varDirectoryPath;
		
		$filePDF = 'var/warranty_pdf/' . $name;
		$mpdf->Output($varDirectoryPath . $name,\Mpdf\Output\Destination::FILE);


				$htmlMessage .= "
<p>Thank you ,</p>
<p><a href='".$this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB).$filePDF."'>Download the PDF</a>.</p>
";

				$customerName='Your website';
				$message=$htmlMessage;
		
				$userSubject= 'Your website  Services';     
				$fromEmail= 'info@domain.com';
				$fromName = 'From name';

 

				$toName = $params['name'];
				$toEmail= $params['email'];
				// you can add extra CC email
				//$toEmailcc= '';
		
				// you can add extra BCC email
				//$toEmailbcc= 'melkholy@live.com';
				
				
// Get your post values
 

 

		$email = new \Zend_Mail();
		$email->setSubject($userSubject); 
		$email->setBodyHtml($htmlMessage);     // use it to send html data
		//$email->setBodyText($body);   // use it to send simple text data
		$email->setFrom($fromEmail, $fromName);
		$email->addTo($toEmail, $toName);
		//$email->addCc($toEmailcc, $toName);
		//$email->addBcc($toEmailbcc, $toName);
		$email->send();
		
		//$mpdf->Output($name,\Mpdf\Output\Destination::DOWNLOAD);
		//die();
		
				//$filePDF = $mpdf->Output($name,\Mpdf\Output\Destination::DOWNLOAD);
				
				//$mpdf = new \Mpdf\Mpdf('utf-8', 'A4-L');


				/*
				$pdf = new \Zend_Pdf(); //Create new PDF file

				$page = $pdf->newPage(\Zend_Pdf_Page::SIZE_A4);

				$pdf->pages[] = $page; 

				$page->setFont(\Zend_Pdf_Font::fontWithName(\Zend_Pdf_Font::FONT_HELVETICA), 20);  //Set Font 

				$page->drawText('Hello world!', 100, 510); 

				$pdfData = $pdf->render(); // Get PDF document as a string 

				header("Content-Disposition: inline; filename=result.pdf"); 

				header("Content-type: application/x-pdf"); 

				echo $pdfData; 
				*/
				//die;
				//unlink($filePath);
                //$this->inlineTranslation->resume();
                $this->messageManager->addSuccess('Thanks for form submit. <a id="pdf_download_href" href="'.$this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB).$filePDF.'" target="_blank">Download the file</a>.');
				$pdf_download = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB).$filePDF;
				
				$registry = \Magento\Framework\App\ObjectManager::getInstance()->create(\Magento\Framework\Registry::class)->register('pdf_download', $pdf_download);
				
                return $resultRedirect->setPath('warranty-replacement-form/index/success/');


            }catch (\Exception $e) {
                    $this->inlineTranslation->resume();
                    $this->messageManager->addError(__('We can\'t process your request right now. Sorry, that\'s all we know.'.$e->getMessage()));
                 return $resultRedirect->setPath('*/*/');
            }
    }


}

?>
