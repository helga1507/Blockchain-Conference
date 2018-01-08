<?php

$filename = dirname(__FILE__).'/log-post2.txt';
$dh = fopen ($filename,'a+');
fwrite($dh, var_export($_POST,true));
fclose($dh);


if ($_POST) {
    $name = htmlspecialchars($_POST["name"]); 
    $email = htmlspecialchars($_POST["email"]);
    $phone = htmlspecialchars($_POST["phone"]);

    if (!$phone) {
        echo 'Вы заполнили не все поля!';
        die();
    }

    $tag = htmlspecialchars($_POST["tag"]); 
    if(!$tag) $tag="#заказ_звонка";
    $tag .= ',#blockchain-conference.info';
    
    $mes = 'Перезвоните мне. Теги по заявке '.$tag.'. ';
    $mes .= 'email - '.$email.'  name - '.$name.'  phone - '.$phone;
    $tomail = 'moscow@blockchain-conference.info';
    $res = mail($tomail, 'Письмо с сайта blockchain-conference.info', mb_convert_encoding($mes,'KOI8-R','UTF-8'), "From: my@blockchain-conference.info");

    /*$utm_source = trim($_POST["utm_source"]);
    $utm_medium = trim($_POST["utm_medium"]);
    $utm_campaign = trim($_POST["utm_campaign"]);
    $utm_term = trim($_POST["utm_term"]);
    $utm_content = trim($_POST["utm_content"]);*/

    include("amocrm_api.php");

	
}


?>
<?php
// Данные должны быть в кодировке UTF-8! Иначе — это может привести к ошибке.
// Если вы используете кодировку Windows-1251, то можно преобразовать все переменные через $value = iconv("Windows-1251", "UTF-8", $value);
// или указать в доп. полях ключ 'charset' с используемой на сайте кодировкой, сервер Roistat, конвертирует все значения из указанной кодировки в UTF-8.
  
// ...
// Где-то здесь вызывается текущая функция создания сделки, например, функция mail().
// ...
  
$roistatData = array(
    'roistat' => isset($_COOKIE['roistat_visit']) ? $_COOKIE['roistat_visit'] : null,
    'key'     => '8e1c9ce06055c164fa1a9eab8dd2cc38', // API-ключ для интеграции с CRM, указывается в настройках интеграции с CRM.
    'title'   => 'Заказ звонка',
    'comment' => '',
    'name'    => 'Без имени',
    'email'   => $email,
    'phone'   => $phone,
    'is_need_callback' => '0', // После создания в Roistat заявки, Roistat инициирует обратный звонок на номер клиента, если значение параметра рано 1 и в Ловце лидов включен индикатор обратного звонка.
    'callback_phone' => '<Номер для переопределения>', // Переопределяет номер, указанный в настройках обратного звонка.
    'sync'    => '0', // 
    'fields'  => array(
    // Массив дополнительных полей. Если дополнительные поля не нужны, оставьте массив пустым.
    // Примеры дополнительных полей смотрите в таблице ниже.
     "charset" => "Windows-1251", // Сервер преобразует значения полей из указанной кодировки в UTF-8.
    ),
);
  
file_get_contents("https://cloud.roistat.com/api/proxy/1.0/leads/add?" . http_build_query($roistatData));
?>