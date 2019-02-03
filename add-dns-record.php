<?php
	
	#reference code from https://community.cloudflare.com/t/how-to-create-dns-in-php-using-cloudflare-api/25633/2
	
	function cloudflare_add_record($apikey,$email,$domain,$zoneid,$a_record,$value,$proxy=false,$ttl=1,$type='A'){
		// A-record creates for the DNS system.
					$ch = curl_init("https://api.cloudflare.com/client/v4/zones/".$zoneid."/dns_records");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'X-Auth-Email: '.$email.'',
					'X-Auth-Key: '.$apikey.'',
					'Cache-Control: no-cache',
				    // 'Content-Type: multipart/form-data; charset=utf-8',
				    'Content-Type:application/json',
					'purge_everything: true'
					
					));
				
					// -d curl parametresi.
					$data = array(
					
						'type' => ''.$type.'',
						'name' => ''.$record_name.'',
						'content' => ''.$value.'',
						'zone_name' => ''.$domain.'',
						'zone_id' => ''.$zoneid.'',
						'proxiable' => 'true',
						'proxied' => $proxy,
						'ttl' => $ttl
					);
					
					$data_string = json_encode($data);

					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);	
					//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_string));

					$sonuc = curl_exec($ch);

					curl_close($ch);	

					return $sonuc;

	}
	

	$apikey = ''; // Global API
	$email = '';  // Email Adress
	$domain = ''; // Domain Name
	$zoneid = ''; // Login Cloudflare -> Overview -> Zone ID
	
	$record_name = 'test'
	$value = '8.8.8.8'
	
	# Example
	#echo cloudflare_add_record($apikey,$email,$domain,$zoneid,$record_name,$value)
	
	#domain -> NS Cloudflare -> Directadmin
	#ns1-103-27-200-112 A 103.27.200.112
	#ns1-103-27-200-112.abc.com
?>