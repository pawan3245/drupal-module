<?php
/*$parameters	= array(
		'ssl_transaction_type' =>'ccsale',
        'ssl_amount' => '100',
        'ssl_cvv2cvc2' => '123',
        'ssl_token'	=>'275041651720131'
    );*/
    
    
    /*$parameters    = array(
     * ccsale
     * 4003050500040005
        'ssl_transaction_type' =>'pldpurchase',
        'ssl_amount' => '1200',
        'ssl_card_number' => '4000056655665556',
        'ssl_exp_date' => '0717'
    );
$parameters	= array(
		'ssl_transaction_type' =>'pldpurchase',
        'ssl_amount' => '1100',
        'ssl_card_number' => '4000056655665556',
        'ssl_cvv2cvc2' => '123',
        'ssl_account_type'=>'1',
        'ssl_customer_number'=>'123456789',
        'ssl_exp_date' => '0717',
        'ssl_avs_address'=>'sdfasfasf',
        'ssl_avs_zip'=>'123456789',
        'ssl_city'=>'dsfdsg',
        'ssl_email'=>'xcvcv@dfdsf.com',
        'ssl_invoice_number'=>'sdfas',
        'ssl_phone'=>'34235435546',
        'ssl_state'=>'al',
        'ssl_first_name' => 'Pawan',
        'ssl_last_name' => 'Tiwari'
    );*/
    
   
    
/**
*
Account ID:	    	721547
Merchant Name:	    	EVOLVE TOURS USA
Terminal Name:	    	EVOLVE TOURS USA
MID:	    	8029386516
Currency:	    	USD
* **********/

$response = sendRequest('ccsale','POST',$parameters=array());

echo "<pre>";

print_r($response);die;

function sendRequest($api_method, $http_method = 'GET', $data = null)
    {
		
		
		/*$data	= array(
				'ssl_transaction_type' =>'ccsale',
				'ssl_amount' => '0.01' ,
				'ssl_cvv2cvc2' => '973',
				'ssl_token'	=>'4386096225832007',
				'ssl_avs_address'=> '83 lake bend road',
				'ssl_avs_zip'=>'R3Y0M4',
				'ssl_city'=>'Winnipeg',
				'ssl_email'=>'pawan@signitysolutions.com',
				'ssl_invoice_number'=>time(),
				'ssl_phone'=>'9023386517',
				'ssl_state'=>'BC'
			);*/
			
		$data	= array('ssl_transaction_type' =>'ccsale',
				'ssl_amount' => '0.01',
				'ssl_card_number' =>'4788931352579797',
				'ssl_cvv2cvc2' =>'488' ,
				'ssl_exp_date' =>'0917',
				'ssl_add_token'	=>'Y',
				'ssl_first_name' => 'Amit',
				'ssl_last_name' => 'Dua',				
				'ssl_avs_address'=> '83 lake bend road',
				'ssl_avs_zip'=>'R3Y0M4',
				'ssl_city'=>'Winnipeg',
				'ssl_email'=>'pawan@signitysolutions.com',
				'ssl_invoice_number'=>time(),
				'ssl_phone'=>'9023386517',
				'ssl_state'=>'BC'
				);
		
		
		/*$data	= array('ssl_transaction_type' =>'ccgettoken',
									//'ssl_amount' =>0.1 ,
									//'ssl_amount' =>1 ,
									'ssl_card_number' =>'4028530007322007',
									'ssl_cvv2cvc2' =>'973' ,
									'ssl_exp_date' =>'0717' ,
									//'ssl_get_token'=>'Y',
									'ssl_add_token'	=>'Y',
									'ssl_first_name' =>'signity' ,
									'ssl_last_name' => 'test',
									'ssl_avs_address'=>'scdfdsf' ,
									'ssl_avs_zip'=>'12345678',
									'ssl_city'=>'xcxbcb',
									'ssl_email'=>'pawan@signitysolutions.com',
									'ssl_invoice_number'=>12345678,
									'ssl_phone'=>1234567890,
									'ssl_state'=>'Al',
        
								);*/
								
		$data['ssl_merchant_id'] 	= '675236';
		$data['ssl_user_id'] 		= '675236';
		$data['ssl_pin'] 			= 'FEGLF37M08B4FK9NWKY4ADOGRMKP9QX8IBAGC2ICXLF4NEQN8G10RB5610AOU5UI';
		$data['ssl_test_mode']    	= 'false';
		$data['ssl_show_form'] 					= 'false';
        $data['ssl_result_format'] 				= 'ascii';
        // Standard data
      /*  $data['ssl_merchant_id'] 				= '721547';
        $data['ssl_user_id'] 					= 'EVOLVE';
        $data['ssl_pin'] 						= 'BPKBH3YC1KY0ADI70S17O91HTS9GWFYDT0DJF17XW80SCTDEOE7CS385HUREJXQU';
        $data['ssl_show_form'] 					= 'false';
        $data['ssl_result_format'] 				= 'ascii';
        //$data['ssl_test_mode'] 					= false;*/
       
        // Set request
        
        
		//$request_url = 'https://www.myvirtualmerchant.com/VirtualMerchant/process.do';
         $request_url  = 'https://www.myvirtualmerchant.com/VirtualMerchant/process.do';


        // Create a cURL handle
        $ch = curl_init();

        // Set the request
        curl_setopt($ch, CURLOPT_URL, $request_url);

        // Save the response to a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Set HTTP method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $http_method);

        // This may be necessary, depending on your server's configuration
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // This may be necessary, depending on your server's configuration
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // Send data
        if (!empty($data)) {

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

            // Debugging output
            $dat_return['Posted Data'] = $data;

        }

        // Execute cURL request
        $curl_response = curl_exec($ch);

        // Save CURL debugging info
        $last_respone['Last Response'] = $curl_response;
        $culr_info['Curl Info'] = curl_getinfo($ch);

        // Close cURL handle
        curl_close($ch);

        // Parse response
        $response = parseAsciiResponse($curl_response);

        // Return parsed response
         echo "<pre>";
         print_r($response);
    }

    /**
     * Parse an ASCII response
     * @param string $ascii_string An ASCII (plaintext) Response
     * @return array
     **/
     function parseAsciiResponse($ascii_string)
    {
        $data = array();
        $lines = explode("\n", $ascii_string);
        if (count($lines)) {
            foreach ($lines as $line) {
                $kvp = explode('=', $line);
                $data[$kvp[0]] = $kvp[1];
            }
        }
        return $data;
    }
    
    ?>
