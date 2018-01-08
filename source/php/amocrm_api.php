<?php

$user=array(
	'USER_LOGIN'=>'moscow@blockchain-conference.info', #Ваш логин (электронная почта)
	'USER_HASH'=>'2b46ce730f043802de7d95b370785406' #Хэш для доступа к API (смотрите в профиле пользователя)
);

$subdomain='lockchainonferenceinfo';
$link='https://'.$subdomain.'.amocrm.ru/private/api/auth.php?type=json';
$curl=curl_init();curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');curl_setopt($curl,CURLOPT_URL,$link);curl_setopt($curl,CURLOPT_POST,true);curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($user));curl_setopt($curl,CURLOPT_HEADER,false);curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt');curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt');curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);$out=curl_exec($curl);$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);curl_close($curl);
$summ=0;

//$responsible_user_id=1770553;
$responsible_user_id=2095588;
$date=date("d.m.Y");

$sdelka=array(
    'name'=>'Заявка с сайта',
    'status_id'=>17898838,
    'price'=>$summ,
	'responsible_user_id'=>$responsible_user_id,
	"tags"=>$tag
);




//if ($questionform){$sdelka['custom_fields'][]=array('id'=>129528,'values'=>array(array('value'=>$questionform)));}


$leads['request']['leads']['add'][]=$sdelka;


$link='https://'.$subdomain.'.amocrm.ru/private/api/v2/json/leads/set';
$curl=curl_init();curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');curl_setopt($curl,CURLOPT_URL,$link);curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($leads));curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));curl_setopt($curl,CURLOPT_HEADER,false);curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt');curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt');curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);$out=curl_exec($curl);$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);

	
if ($code==200){
	$Response=json_decode($out,true);
	$Response=$Response['response']['leads']['add'];
	$idsdelka=$Response[0][id];

		
	if ($name==''){$name=$phone;}


	$contact=array(
	  'name'=>$name,
	  'linked_leads_id'=>array($idsdelka),
	  'responsible_user_id'=>$responsible_user_id
	);


	if ($phone){
		$contact['custom_fields'][]=array(
			'id'=>112511,
			'values'=>array(
				array(
					'value'=>$phone,
					 'enum'=>'MOB'
				)
			)
		);
	}
    if ($email){
		$contact['custom_fields'][]=array(
			'id'=>112513,
			'values'=>array(
				array(
					'value'=>$email,
					 'enum'=>'WORK'
				)
			)
		);
	}

	if($utm_source){
        $contact['custom_fields'][]=array(
            'id'=>388955,
            'values'=>array(
                array(
                    'value'=>$utm_source
                )
            )
        );
        $contact['custom_fields'][]=array(
            'id'=>388957,
            'values'=>array(
                array(
                    'value'=>$utm_medium
                )
            )
        );
        $contact['custom_fields'][]=array(
            'id'=>388959,
            'values'=>array(
                array(
                    'value'=>$utm_campaign
                )
            )
        );
        $contact['custom_fields'][]=array(
            'id'=>388961,
            'values'=>array(
                array(
                    'value'=>$utm_term
                )
            )
        );
        $contact['custom_fields'][]=array(
            'id'=>388963,
            'values'=>array(
                array(
                    'value'=>$utm_content
                )
            )
        );
	}
			
	$set['request']['contacts']['add'][]=$contact;

	
	$link='https://'.$subdomain.'.amocrm.ru/private/api/v2/json/contacts/set';
	$curl=curl_init();curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');curl_setopt($curl,CURLOPT_URL,$link);curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($set));curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));curl_setopt($curl,CURLOPT_HEADER,false);curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt');curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt');curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
	$out=curl_exec($curl);
	$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
   

    
}

   
?>



