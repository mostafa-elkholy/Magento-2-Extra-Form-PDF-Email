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
				 

/*var_dump($params);
die;
*/
$additional = '';
if($params['replacement_type'] == 'Cookware'){
	$additional = '<div class="sub-tit">ltem(s) being replaced</div>
	<ul>
	<li>Please use bubble wrap and an appropriate sized box/envelope to send over the warrantied pots/pans.</li>
	<li>Please include proof of purchase (receipt and/or proof of registration).</li>
	<li>Please include a check for $15 to cover the return shipping cost by only to USPS or UPS carriers. Failure to do so delays processing and the replacement of your item(s).</li>
	<li>Do not put tape on the pots/pans.</li>
	<li>Pots/pans must be cleaned before shipped to us.</li>
	</ul>
	<p>Our warranty excludes some types of damages and/or conditions such as those due to age and/or misuse and/or improper treatment. Replacements for items that are no longer available (discontinued) may be made with similar items of equal
	value, at our option.</p>
	<div class="sub-tit">Manufacturer defects (covered by warranty):</div>
	<p>Any pots/pans that have a manufacturing defect will be shipping back to you on our cost. Manufacturer defects include any damages such as dents on the lids/pots and pans when the item is first received by the customer. This means as soon
	as you open the package there are clear damages before first use of product.</p>
	<div class="sub-tit">Misuses (not covered by warranty):</div>
	<p>Any pots/pans that are treated poorly will require an extra fee. Please look at our warranty policy for more details regarding misuse.</p>
	<ul>
	<li>Misuse of the pots and pans include: Using the pots/pans wrongly (Example: hitting the pots/pans with a hard object, not using the right utensils such as metal, abuse, neglect, commercial use, overheating, etc.).</li>
	<li>Misuse of our pots/pans will require an additional fee.</li>
	<li>Please refer to our <a style="color:#B11113" target="_blank" href="https://gunterwilhelm.com/hassle-free-warranty">warranty policy</a></li>
	</ul>
	<hr>
	<p>Only Gunter Wilhelm Cutlery and Cookware Items purchased directly from Gunter Wilhelm, activities associated with Gunter Wilhelm, or by authorized dealers or representatives of Gunter Wilhelm are covered under warranty. Items purchased,
	from 3rd party dealers, not operated by or authorized by Gunter Wilhelm will not be covered.</p>
	<p>We do not replace wear and tear pots/pans (discoloration, stains, scratches, dents and normal wear and tear).</p>';
}else{
	$additional = '<div class="sub-tit">ltem(s) being replaced</div>
<ul>
<li>Please use bubble wrap and an appropriate sized box/envelope to send over the warrantied knife.</li>
<li>Please include proof of purchase (receipt and/or proof of registration).</li>
<li>Please include a check for $15 to cover the return shipping cost by only to USPS or UPS carriers. Failure to do so delays processing and the replacement of your item(s).</li>
<li>Do not put tape on the knives.</li>
<li>Knives must be cleaned before shipped to us.</li>
<li>We do NOT replace sheaths, blocks, honing steels, diamond sharpeners. Do NOT include them when sending a knife for warranty.</li>
<li>A warranty replacement knife request without providing proof of purchase & ownership will require a $10 fee per knife.</li>
</ul>
<p>Our warranty excludes some types of damages and/or conditions such as those due to age and/or misuse and/or improper treatment. Replacements for items that are no longer available (discontinued) may be made with similar items of equal
value, at our option.</p>
<div class="sub-tit">Manufacturer defects (covered by warranty):</div>
<p>Any knives that have a manufacturing defect will be shipping back to you on our cost. Manufacturer defects include any damages that are observed when receiving the knife. This means as soon as you open the package there are clear damages
before first use of product.</p>
<div class="sub-tit">Misuses (not covered by warranty):</div>
<p>Any knives that are treated poorly will require an extra fee. Please look at our warranty policy for more details regarding misuse.</p>
<ul>
<li>Putting the knives in the dishwasher</li>
<li>Using the knife wrongly (Example: cutting bone using the wrong knife such as a paring knife, opening a can using our knives, throwing the knives, dropping the knives, cutting frozen food, etc.)</li>
<li>Misuse of our knives will require an additional fee.</li>
<li>Please refer to our <a style="color:#B11113" target="_blank" href="https://gunterwilhelm.com/hassle-free-warranty">warranty policy</a></li>
</ul>
<hr>
<p>Only Gunter Wilhelm Cutlery and Cookware Items purchased directly from Gunter Wilhelm, activities associated with Gunter Wilhelm, or by authorized dealers or representatives of Gunter Wilhelm are covered under warranty. Items purchased,
from 3rd party dealers, not operated by or authorized by Gunter Wilhelm will not be covered.</p>
<p>We do not replace diamond steel sharpeners and honing steels. Those are wear and tear items and will not be replaced if sent to us.</p>
<p>We do not replace normal wear and tear, including without limitation straight-edge and serrated blades that are dull, bent, scratched corroded or marked.</p>';
} 
						$htmlMessage = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="initial-scale=1,width=device-width"><meta http-equiv="X-UA-Compatible" content="IE=edge"><style type="text/css">body{background-color:#f5f5f5}.wrapper{border-collapse:collapse;margin:0 auto;text-align:left;width:660px}.main-content{vertical-align:top;background-color:#fff;padding:22.5px}.header{vertical-align:top;background-color:#f5f5f5;padding:22.5px}</style></head><body><table style="" width="100%"><tr><td class="wrapper-inner" align="center"><table class="main" align="center"><tr><td style=""><a class="logo" href="https://gunterwilhelm.com/"><img style="width:200px" src="https://gunterwilhelm.com/media/logo/stores/1/GW-Logo.png" border="0"></a></td></tr><tr><td class="main-content"><p class="greeting">Hello '.$params['name'].',</p>';						
						
						/*Name: ".$params['name']."<br/>
						Date: ".$params['date']."<br/>
						E-mail: ".$params['email']."<br/>
						Phone: ".$params['phone']."<br/>
						Address: ".$params['address']."<br/>
						List each knife being returned for sharpening: ".$params['description']."<br/>";
						
						if(isset($params['secure_safe'])){
							$params['secure_safe'] = "Yes";
							$htmlMessage .= "Secure and safe packaging. <span style='color:#b11113'>DO NOT SHIP IN AN ENVELOP</span>: Yes<br/>";
						}else{
							$params['secure_safe'] = "No";
							$htmlMessage .= "Secure and safe packaging. <span style='color:#b11113'>DO NOT SHIP IN AN ENVELOP</span>: No<br/>";
						}							
						if(isset($params['check_prepaied'])){
							$params['check_prepaied'] = "Yes";
							$htmlMessage .= "A check or prepaid return label back to you.: Yes<br/>";
						}else{
							$params['check_prepaied'] = "No";
							$htmlMessage .= "A check or prepaid return label back to you.: No<br/>";
						}						
						if(isset($params['have_proof_of_ownership'])){
							$params['have_proof_of_ownership'] = "Yes";
							$htmlMessage .= "Do you have proof of ownership? Yes<br/>";
						}else{
							$params['have_proof_of_ownership'] = "No";
							$htmlMessage .= "Do you have proof of ownership? No<br/>";
						}		*/				
 
						$feesMessage = '';
						
						if(isset($params['secure_safe'])){
							$params['secure_safe'] = "Yes";
						}else{
							$params['secure_safe'] = "No";
						}							
						if(isset($params['check_prepaied'])){
							$params['check_prepaied'] = "Yes";
						}else{
							$params['check_prepaied'] = "No";
						}						
						if(isset($params['have_proof_of_ownership'])){
							$params['have_proof_of_ownership'] = "Yes";
						}else{
							$params['have_proof_of_ownership'] = "No";
						}							
						
						$params['number_of_items'] = (int)$params['number_of_items'];
						
						if($params['number_of_items'] == 0){
							$params['number_of_items'] = 1;
						}
						
						
						if($params['have_proof_of_ownership'] == 'Yes'){
							$feesMessage = "<li>Please include a check of the amount $15 To cover  the return shipping (GW only use USPS or UPS). 
							Failure to do so delays processing and the replacement of your item(s).</li>
							<li>Proof of Purchase</li>";
						}else{
							
							$cost = ($params['number_of_items'] * 10) + 15;
							$feesMessage = "<li>Please include a check of the amount $".$cost." To cover  the return shipping (GW only use USPS or UPS) & No proof of purchase fee. 
							Failure to do so delays processing and the replacement of your item(s).</li>";
							
						}

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
                    <img style="width: 300px" src="https://gunterwilhelm.com/pub/media/logo/stores/1/GW--Logo.png">
                </td>
                <td width="30%">
                    <p style="text-align: right;margin:5px;font-weight: bold;">628 Swan Street Ramsey</p>
                    <p style="text-align: right;margin:5px;font-weight: bold">NJ 07446</p>
                    <p style="text-align: right;margin:5px;font-weight: bold">United States</p>
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

                <p style="color: #ec2027;">A warranty replacement knife request without providing proof of purchase & ownership will require a $10 fee per knife.</p>
                <p>Our warranty excludes some types of damages and/or conditions such as those due to age and/or misuse and/or improper treatment. Replacements for items that are no longer available (discontinued) may be made with similar items of equal
                    value, at our option.</p>

                <div class="sub-tit">Manufacturer defects (covered by warranty):</div>
                <p>Any Knives that have a manufacturing defect will be shipping back to you on our cost. Manufacturer defects include any damages that are observed when receiving the knife. This means as soon as you open the package there are clear damages
                    before first use of product.</p>


                <div class="sub-tit">Misuses (not covered by warranty):</div>
                <p>Any knives that are treated poorly will require an extra fee. Please look at our warranty policy for more details regarding misuse.</p>
                <ul>
                    <li>Putting the knives in the dishwasher</li>
                    <li>Using the knife wrongly (Example: cutting bone using the wrong knife such as a paring knife, opening a can using our knives, throwing the knives, dropping the knives, cutting frozen food, etc.)</li>
                    <li>Misuse of our knives will require an additional fee.</li>
                    <li>Please refer to our warranty policy located on our website, www.gunterwilhelm.com, under the FAQ\'s.</li>
                </ul>

                <p><b>Only Gunter Wilhelm Cutlery and Cookware Items purchased directly from Gunter Wilhelm, activities associated with Gunter
Wilhelm, or by authorized dealers or representatives of Gunter Wilhelm are covered under warranty. Items purchased, from
3rd party dealers, not operated by or authorized by Gunter Wilhelm will not be covered.</b></p>

                <p>We do not replace diamond steel sharpeners and honing steels. Those are wear and tear items and will not be replaced if sent to us.</p>

                <p>We do not replace normal wear and tear, including without limitation straight-edge and serrated blades that are dull, bent, scratched corroded or marked.</p>

                <p class="inclide-following" style="color: #ec2027;"><b>Before sending the package to Gunter Wilhelm, please make sure it includes the following:</b></p>

                <ul style="color: #ec2027;">

                    <!--<li>Please include a check for $15 to cover the return shipping cost by only to USPS or UPS carriers. </li>-->
                    '.$feesMessage.'
                </ul>

                <div class="bordered-content" >
                    <h4 style="color: #ec2027;">Important Packaging Information </h4>

                    <ul>
                        <li><b>Please use bubble wrap and an appropriate sized box/envelope to send over the warrantied knife.</b></li>
                        <li><b>Do not put tape on the pots/pans.</b></li>
                        <li><b>Knives must be cleaned before shipped to us.</b></li>
                        <li><b>A check or prepaid return label back to you.</b></li>
                        <li><b>Secure and safe packaging. <span style="color:#b11113">DO NOT SHIP IN AN ENVELOP.</span></b></li>
                    </ul>
                </div>
            </div>



            <table style="margin-bottom: 20px;">
                <tr>
                    <td>
                        <div style="margin: 0;font-size: 18px;color:#dc143c;font-weight:600">Please provide your signature as proof that you have read and understand the warranty form</div>


                    </td>
                </tr>
            </table>

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
<p>Thank you for contacting Gunter Wilhelm and your inquiry about our warranty policy.</p>
<p><a href='".$this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB).$filePDF."'>Download the PDF</a>.</p>
<p>Gunter Wilhelm blades have a lifetime warranty policy that covers manufacturing defects (materials and workmanship).  Lifetime warranty is not a guarantee that the knives are indestructible. Like any other quality products, the knives should be maintained and used as the intended purpose they were designed for.  Misuse, abuse or accidents might damage the knives and/or handles and result in chips, break or injuries. Please use the knives carefully, according to the intended design, clean, maintain and sharpen them professionally. </p>
<p>Damages that were caused as a result of misuse, abuse or accidents are not covered by our lifetime warranty policy.  We offer a replacement option in case of misuse, abuse or accidents. Terms and conditions apply.</p> 
<p>For more information about our lifetime warranty and the exclusions (misuse, abuse and accidents), please visit our website:   https://gunterwilhelm.com/hassle-free-warranty</p>
<p>If you suspect that your blade was damaged as a result of a manufacturing defect, please ship it back to us for inspection, and we will be happy to replace it based on our warranty replacement policy. If your blade was damaged as a result of misuse, abuse or accident, please ship it back to us with the relevant fees, and we will be happy to replace it based on our warranty replacement policy. The link to our warranty replacement form is https:// .  Please read the form carefully, fill out the form and follow the instructions.  </p>
<p>We appreciate your business and thank you for your understanding.  We are looking forward to serving you. </p>
<p>Should you require additional information, please don't hesitate to contact us</p>


   <div style='border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Tahoma, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; background-color: rgb(255, 255, 255);'>
        <font face='Times New Roman' size='3'><span style='border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; font-size: inherit; line-height: inherit; font-family: Calibri, Helvetica, sans-serif, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: inherit;'>Respectfully,</span></font>
    </div>

    <div style='border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Tahoma, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; background-color: rgb(255, 255, 255);'>
        <font face='Times New Roman' size='3'><span style='border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; font-size: inherit; line-height: inherit; font-family: Calibri, Helvetica, sans-serif, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: inherit;'>Team&nbsp;</span>
            <span style='border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; font-size: inherit; line-height: inherit; font-family: Calibri, Helvetica, sans-serif, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: inherit;'>Gunter Wilhelm</span>
        </font>
    </div>

    <div style='border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Tahoma, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; background-color: rgb(255, 255, 255);'>
        <p style='color: rgb(33, 33, 33) !important; font-size: 11pt; font-family: Calibri, sans-serif; margin: 0px;'>
            <font face='Times New Roman' size='3'><b><i><span style='border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; font-size: 14pt; line-height: inherit; font-family: Calibri, sans-serif, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: inherit;'>G<span style='border: 0px; font: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: rgb(192, 0, 0) !important;'>&uuml;</span></span></i></b><b><i><span style='border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; font-size: 14pt; line-height: inherit; font-family: Calibri, sans-serif, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: inherit;'>nter W<span style='border: 0px; font: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: rgb(192, 0, 0) !important;'>i</span>lhelm&reg; C<span style='border: 0px; font: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: rgb(192, 0, 0) !important;'>u</span>tlery &amp; C<span style='border: 0px; font: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: rgb(192, 0, 0) !important;'>o</span>okware</span></i></b></font>
        </p>

        <p style='color: rgb(33, 33, 33) !important; font-size: 11pt; font-family: Calibri, sans-serif; margin: 0px;'>
            <font face='Times New Roman' size='3'><b><i><span style='border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; font-size: 14pt; line-height: inherit; font-family: Calibri, sans-serif, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: inherit;'>Q<span style='border: 0px; font: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: rgb(192, 0, 0) !important;'>U</span>ALITY<span style='border: 0px; font: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: rgb(192, 0, 0) !important;'>&nbsp;</span>M<span style='border: 0px; font: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: rgb(192, 0, 0) !important;'>a</span>de<span style='border: 0px; font: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: rgb(192, 0, 0) !important;'>&nbsp;</span>W<span style='border: 0px; font: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: rgb(192, 0, 0) !important;'>i</span>th P<span style='border: 0px; font: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: rgb(192, 0, 0) !important;'>A</span>SSION</span></i></b></font>
        </p>

        <p style='color: rgb(33, 33, 33) !important; font-size: 11pt; font-family: Calibri, sans-serif; margin: 0px;'>
            <font face='Times New Roman' size='3'><b><span style='border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; font-size: 12pt; line-height: inherit; font-family: Calibri, sans-serif, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: inherit;'>Showroom</span></b>
                <span style='border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; font-size: 12pt; line-height: inherit; font-family: Calibri, sans-serif, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: inherit;'>:&nbsp;<span style='border: 0px; font: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: inherit;' tabindex='0'>628 Swan Street | Ramsey, NJ 07446 | USA</span></span>
            </font>
        </p>

        <p style='color: rgb(33, 33, 33) !important; font-size: 11pt; font-family: Calibri, sans-serif; margin: 0px;'>
            <font face='Times New Roman' size='3'><span style='border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; font-size: 12pt; line-height: inherit; font-family: Calibri, sans-serif, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: inherit;'>Office: 201-569-6866</span></font>
        </p>

        <p style='color: rgb(33, 33, 33) !important; font-size: 11pt; font-family: Calibri, sans-serif; margin: 0px;'>
            <font face='Times New Roman' size='3'><span style='border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; font-size: 12pt; line-height: inherit; font-family: Calibri, sans-serif, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: inherit;'><a data-auth='NotApplicable' data-linkindex='1' data-loopstyle='link' data-safelink='true' href='mailto:david@GunterWilhelm.com' id='LPNoLP' rel='noopener noreferrer' style='border: 0px; font: inherit; margin: 0px; padding: 0px; vertical-align: baseline;' target='_blank'>Sales@GunterWilhelm.com</a>&nbsp;|&nbsp;<a data-auth='NotApplicable' data-linkindex='2' data-loopstyle='link' data-safelink='true' href='http://www.gunterwilhelm.com/' id='LPNoLP' rel='noopener noreferrer' style='border: 0px; font: inherit; margin: 0px; padding: 0px; vertical-align: baseline;' target='_blank'>www.GunterWilhelm.com</a></span></font>
        </p>

        <p style='color: rgb(33, 33, 33) !important; font-size: 11pt; font-family: Calibri, sans-serif; margin: 0px;'>&nbsp;</p>

        <p style='margin-top: 0px; margin-bottom: 0px;'><span style='font-size:14px;'><font face='Times New Roman'><b><i><span style='border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 15.3333px; font-family: &quot;Arial Black&quot;, Arial, sans-serif, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: inherit;'>When #QualityMatters, Gunter Wilhelm gets the call</span></i>
            </b>
            </font>
            </span>
        </p>
        <span style='font-size:12px;'><font face='Times New Roman'><b><i><span style='border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 12.2667px; font-family: &quot;Arial Black&quot;, sans-serif, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: rgb(33, 33, 33) !important;'>Award winning company/products:</span></i>
        </b>
        </font>
        </span>

        <p style='margin-top: 0px; margin-bottom: 0px;'>&nbsp;</p>
    </div>

    <div style='border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Tahoma, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; background-color: rgb(255, 255, 255);'>
        <img src='https://gunterwilhelm.com/pub/media/wysiwyg/gw.png'>
    </div>

    <div style='border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-stretch: inherit; font-size: 13px; line-height: inherit; font-family: Tahoma, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; background-color: rgb(255, 255, 255);'>
        <p style='margin: 0px;'><span style='font-size:14px;'><font face='Times New Roman'><b><i><span style='border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; font-family: &quot;Arial Black&quot;, sans-serif, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: inherit;'>Gunter Wilhelm products are recommended by:</span></i>
            </b>
            </font>
            </span>
        </p>

        <p style='margin: 0px;'>
            <font face='Times New Roman' size='3'><i><span style='border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; font-size: 8pt; line-height: inherit; font-family: Arial, sans-serif, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: rgb(31, 56, 100) !important;'><span style='font-size:12px;'>The White House Chef Tours&trade; | SCA &ndash; Steak Cook-Off Association | NBBQA &ndash; I AM BBQ Conference | MABA &ndash; Mid-Atlantic BBQ Association | Chimney Cartel | BAMA-Q TV | The BBQ League | Chef&rsquo;s Honor Guard | Warrior Chef | BBQ Champ Academy </span>&nbsp;</span></i></font><br
            /> &nbsp;
        </p>

        <p style='margin: 0px;'>
            <img src='https://gunterwilhelm.com/pub/media/wysiwyg/g1.png'>
        </p>

        <p style='margin: 0px;'><br />
            <font face='Times New Roman' size='3'><b style='font-style: italic;'><i><span style='border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; font-size: 8pt; line-height: inherit; font-family: Arial, sans-serif, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: rgb(31, 56, 100) !important;'><span style='font-size:14px;'>Honored to be featured on:</span></span></i></b></font>
        </p>

        <p style='margin: 0px;'>
            <font face='Times New Roman' size='3'><i><i><span style='border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; font-size: 8pt; line-height: inherit; font-family: Arial, sans-serif, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: rgb(31, 56, 100) !important;'><span style='font-size:12px;'>FoxNewsHealth | FORBES | EXAMINER | WholeFoods | The Price Is Right |&nbsp;National Barbecue News | DesigningSpaces | Good Housekeeping Magazine and more</span></span></i></i>
            </font><br /> &nbsp;
        </p>
        <img src='https://gunterwilhelm.com/pub/media/wysiwyg/g2.png'>
        <p style='margin-top: 0px; margin-bottom: 0px;'>&nbsp;</p>

        <p style='margin: 0px;'><span style='font-size:14px;'><font face='Times New Roman'><b><i><span style='border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; font-family: &quot;Arial Black&quot;, sans-serif, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: rgb(31, 56, 100) !important;'>Gunter Wilhelm proudly supports:</span></i>
            </b>
            </font>
            </span>
        </p>

        <p style='margin: 0px;'><span style='font-size:12px;'><font face='Times New Roman'><i><span style='border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; font-family: Arial, sans-serif, serif, EmojiFont; font-optical-sizing: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; vertical-align: baseline; color: rgb(31, 56, 100) !important;'>BBQ &amp; Grilling #FoodSport | ProStart | SkillsUSA | The American Royal |&nbsp;Texas Chrome Hero&#39;s Foundation &amp; more</span></i>
            </font>
            </span>
        </p>
    </div>

                     </td>
                  </tr>
                  <tr>
                     <td class='footer'>
                        <p class='closing'>Thank you, Gunter Wilhelm Chef Knife, Knife Set, Cookware & Kitchen Cutlery!</p>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
   </body>";

				$customerName='GunterWilhelm Warranty Services';
				$message=$htmlMessage;
		
				$userSubject= 'GunterWilhelm Warranty Services';     
				$fromEmail= 'info@gunterwilhelm.com';
				$fromName = 'GunterWilhelm Warranty Services';

/*
						//'to'        => 'matt@phoenix-tape.com',
						//'cc'        => 'elizabeth@phoenix-tape.com',
						//'bcc' 		=> 'phoenix.d5h9k@zapiermail.com',
*/

				$toName = $params['name'];
				$toEmail= $params['email'];
				
				$toEmailcc= 'melkholy@maxmize.com';
				$toEmailbcc= 'melkholy@live.com';
				
				
// Get your post values
 

 

		$email = new \Zend_Mail();
		$email->setSubject($userSubject); 
		$email->setBodyHtml($htmlMessage);     // use it to send html data
		//$email->setBodyText($body);   // use it to send simple text data
		$email->setFrom($fromEmail, $fromName);
		$email->addTo($toEmail, $toName);
		//$email->addCc($toEmailcc, $toName);
		$email->addBcc($toEmailbcc, $toName);
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