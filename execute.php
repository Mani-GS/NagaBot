<?php
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if(!$update)
{
  exit;
}

$message = isset($update['message']) ? $update['message'] : "";
$messageId = isset($message['message_id']) ? $message['message_id'] : "";
$chatId = isset($message['chat']['id']) ? $message['chat']['id'] : "";
$firstname = isset($message['chat']['first_name']) ? $message['chat']['first_name'] : "";
$lastname = isset($message['chat']['last_name']) ? $message['chat']['last_name'] : "";
$username = isset($message['chat']['username']) ? $message['chat']['username'] : "";
$date = isset($message['date']) ? $message['date'] : "";
$text = isset($message['text']) ? $message['text'] : "";

$text = trim($text);
$text = strtolower($text);

$response = '';
$randRes = array('NAGA',
'Io no capire',
'Sono disoccupato',
'Hahahahahahahahahahahahah NO.',
'Non ci credo! Ma dai!!!',
'E inveceeeeeee.',
'Se non bestemmio, guarda!'
);



if(isset($message['text'])){
	//$response = "Ho ricevuto il seguente messaggio di testo: " . $message['text'];
	if(strpos($text, 'ciao') !== false){
		$response = "Ciao? Buongiorno semmai, coglione!";
	}
	if(strpos($text, 'mouse') !== false){
		$response = $response . "\n Uso il NAGAAAAAAAA, ovvio."
	}
	
	if(strpos($text, 'ciao') !== true and strpos($text, 'mouse') !== true){
		$response = $randRes[array_rand($randRes)];
	}
}
elseif(isset($message['audio'])){
	$response = "Sì sì, parla pure, ti ascolto.";
}
elseif(isset($message['document'])){
	$response = "Cosa stracazzo mi stai inviando?";
}
elseif(isset($message['photo'])){
	$response = "Madonna ma sei proprio orribile!! D:";
}
elseif(isset($message['sticker'])){
	$response = "Ficcatelo";
}
elseif(isset($message['video'])){
	$response = "Non li guardo i video in streaming, passano sempre virus";
}
elseif(isset($message['voice'])){
	$response = "Te ne stai un po' zitto?";
}
elseif(isset($message['contact'])){
	$response = "Guarda oggi non ho tempo, ti chiamo domani, giuro!";
}
elseif(isset($message['location'])){
	$response = "No no, fanculo è dall'altra parte!";
}
elseif(isset($message['venue'])){
	$response = "...";
}
else{
	$response = "Per favore, parla potabile.";
}


header("Content-Type: application/json");
$parameters = array('chat_id' => $chatId, "text" => $response);
$parameters["method"] = "sendMessage";
echo json_encode($parameters);
