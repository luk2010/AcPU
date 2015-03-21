<?php

/*
	File : PayPal.php
	Copyright @ Atlanti's Corp - 2015
*/

class PayPal 
{
	private $username;
	private $userpassword;
	private $apisignature;
	private $isSandBoxed;
	
	// -- Live Session Variables
	private $CurBuyAmount;
	private $CurCurrency;
	private $CurShipping;
	private $CurTaxes;
	private $CurReturnPage;
	private $CurReturnFail;
	private $CurValidate;
	private $CurItemDesc;
	private $CurBusiness;
	
	// -- Handlers for actions
	private $HandlerValid;
	private $HandlerInvalid;
	private $HandlerError;
	
	/////////////////////////////////////////////////////
	/// @brief Constructs a new PayPal object and 
	/// configure it to performs API calls.
	///
	/// @param $user : The name of the user that will be send
	/// to PayPal.
	///
	/// @param $pass : The password the user should 
	/// use to access the API.
	/// 
	/// @param $sig : The signature from the API. 
	/////////////////////////////////////////////////////
	public function __construct($user, $pass, $sig) {
		$this->username 	= $user;
		$this->userpassword = $pass;
		$this->apisignature = $sig;
		$this->isSandBoxed  = false;
		
		$this->Reset();
	}
	
	/////////////////////////////////////////////////////
	/// @brief Reset the Commands parameters.
	/////////////////////////////////////////////////////
	public function Reset() {
		$this->CurBuyAmount  = 0.00;
		$this->CurCurrency   = "EUR";
		$this->CurShipping   = 0.00;
		$this->CurTaxes      = 0.00;
		$this->CurReturnPage = "";
		$this->CurReturnFail = "";
		$this->CurValidate   = "";
		$this->CurBusiness   = $this->username;
		$this->CurItemDesc   = "";
	}
	
	/////////////////////////////////////////////////////
	/// @brief Sets to true if you want the PayPal object
	/// to run in SandBox mode.
	/////////////////////////////////////////////////////
	public function SetSandBoxed($sb) {
		$this->isSandBoxed = $sb;
		return $this;
	}
	
	/////////////////////////////////////////////////////
	/// @brief Make a PayPal form with all the configured
	/// options.
	/////////////////////////////////////////////////////
	public function MakePayPalForm() {
		$ret = "";
		
		if($this->isSandBoxed === true) {
			$ret .= "<form action=\"https://www.sandbox.paypal.com/cgi-bin/webscr\" method=\"post\">";
			$ret .= "<input type='hidden' value=\"" . "1" . "\" name=\"test_ipn\" />";
		}
		else
			$ret .= "<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\">";
		
		$ret .= "<input type='hidden' value=\"" . $this->CurBuyAmount  . "\" name=\"amount\" />";
		$ret .= "<input type='hidden' value=\"" . $this->CurCurrency   . "\" name=\"currency_code\" />";
		$ret .= "<input type='hidden' value=\"" . $this->CurShipping   . "\" name=\"shipping\" />";
		$ret .= "<input type='hidden' value=\"" . $this->CurTaxes      . "\" name=\"tax\" />";
		$ret .= "<input type='hidden' value=\"" . $this->CurReturnPage . "\" name=\"return\" />";
		$ret .= "<input type='hidden' value=\"" . $this->CurReturnFail . "\" name=\"cancel_return\" />";
		$ret .= "<input type='hidden' value=\"" . $this->CurValidate   . "\" name=\"notify_url\" />";
		$ret .= "<input type='hidden' value=\"" . "_xlick"      	   . "\" name=\"cmd\" />";
		$ret .= "<input type='hidden' value=\"" . $this->CurBusiness   . "\" name=\"business\" />";
		$ret .= "<input type='hidden' value=\"" . $this->CurItemDesc   . "\" name=\"item_name\" />";
		$ret .= "<input type='hidden' value=\"" . "1"            	   . "\" name=\"no_note\" />";
		$ret .= "<input type='hidden' value=\"" . "FR"           	   . "\" name=\"lc\" />";
		$ret .= "<input type='hidden' value=\"" . "PP_BuyNowBF"  	   . "\" name=\"bn\" />";
		
		$ret .= "<input alt=\"Effectuez vos paiements via PayPal : une solution rapide, gratuite et sécurisée\" name=\"submit\" src=\"https://www.paypal.com/fr_FR/FR/i/btn/btn_buynow_LG.gif\" type=\"image\" /><img src=\"https://www.paypal.com/fr_FR/i/scr/pixel.gif\" border=\"0\" alt=\"\" width=\"1\" height=\"1\" />";
		$ret .= "</form>";
		
		return $ret;
	}
	
	/////////////////////////////////////////////////////
	/// @brief Performs a Quick answer to Paypal. 
	/// You can (and should) handle errors. You can retrieve
	/// the values in the Array here : 
	/// https://developer.paypal.com/docs/classic/ipn/integration-guide/IPNandPDTVariables/
	/////////////////////////////////////////////////////
	public function PerformAnswer() {
		header('HTTP/1.1 200 OK');
		
		$answer = "";
		$answer .= "cmd=_notify-validate";
		
		foreach ($_POST as $key => $value) {
			$value = urlencode(stripslashes($value));
			$answer .= "&$key=$value";
		}
		
		$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n"; 
		$header .= "Content-Length: " . strlen($answer) . "\r\n\r\n";
		
		if($this->isSandBoxed === true)
			$fp = fsockopen('www.sandbox.paypal.com', 80, $errno, $errstr, 30);
		else
			$fp = fsockopen('www.paypal.com', 80, $errno, $errstr, 30);
		
		$item_name 			= $_POST['item_name'];
		$item_number 		= $_POST['item_number'];
		$payment_status 	= $_POST['payment_status'];
		$payment_amount 	= $_POST['mc_gross'];
		$payment_currency 	= $_POST['mc_currency'];
		$txn_id 			= $_POST['txn_id'];
		$receiver_email 	= $_POST['receiver_email'];
		$payer_email 		= $_POST['payer_email'];
		
		$ValidArgs = array( "ItemName" => $item_name, "ItemCount" => $item_number, 
					   "PayStatus" => $payment_status, "PayAmount" => $payment_amount, 
					   "Currency" => $payment_currency, "TransactionType" => $txn_id, 
					   "ReceiverEmail" => $receiver_email, "PayerEmail" => $payer_email, 
					   "Other" => $_POST );
		
		if(!$fp) {
			// Handle the error.
			$this->HandlerError($answer, $fp);
		}
		else {
			fputs($fp, $header . $answer);
			while(!feof($fp)) {
				$res = fgets($fp, 1024);
				if (strcmp($res, "VERIFIED") == 0) {
					// Handle valid transaction.
					$this->HandlerValid($answer, $ValidArgs);
				} else {
					// Handle error. (Invalid transaction).
					$this->HandlerInvalid($answer, $ValidArgs);
				}
			}
			fclose($fp);
		}
	}
	
	/////////////////////////////////////////////////////
	/// @brief Sets the Handlers for the PerformAnswer 
	/// function. 
	/////////////////////////////////////////////////////
	public function SetHandlers($Valid, $Invalid = null, $Error = null) {
		$this->HandlerValid 	= $Valid;
		$this->HandlerInvalid 	= $Invalid;
		$this->HandlerError 	= $Error;
	}
	
	/////////////////////////////////////////////////////
	/// @brief Sets one of the used property to given value.
	/////////////////////////////////////////////////////
	public function Set($property, $value) {
		if($property == "Amount") {
			$this->CurBuyAmount = $value;
		} else if ($property == "Currency") {
			$this->CurCurrency = $value;
		} else if ($property == "Shipping") {
			$this->CurShipping = $value;
		} else if ($property == "Taxes") {
			$this->CurTaxes = $value;
		} else if ($property == "Business") {
			$this->CurBusiness = $value;
		} else if ($property == "ReturnPage") {
			$this->CurReturnPage = $value;
		} else if ($property == "ReturnPageFail") {
			$this->CurReturnFail = $value;
		} else {
			echo "Bad Property (" . $property . ") given.";
		}
		
		return $this;
	}
}

?>