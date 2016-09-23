<?php
define("BOT_TOKEN", "251140608:AAHavKfqor2GyqYMf9p_DN6IJQw1KBVut3Q");
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
$caption = '';
$type = "text";

$randRes = array("NAGA",
"Io no capire",
"Sono disoccupato",
"Hahahahahahahahahahahahah NO.",
"Non ci credo! Ma dai!!!",
"E inveceeeeeee.",
"Se non bestemmio, guarda!"
);

$randJoke = array("Prima ho girato l'angolo, poi l'ho rimesso a posto.",
"Qual è il colmo per un muratore? Dover stare attendo al cemento armato!",
"Attento, se mangi un avocado, finiscilo tutto, altrimenti ti fa causa! E' legale.",
"Cosa fa un gallo in mezzo al mare? Galleggia.",
"A casa ho un mobile che tutti credono sia antico. Penso sia solo un'antica credenza.",
"Ho appena messo una bistecca alla destra del letto e una frittura di calamari a sinistra, perchè voglio addormentarmi tra 2 secondi.",
"Per me il segno peggiore è la bilancia, si fa mettere i piedi in testa da tutti."
);


if(isset($message['text'])){
	//$response = "Ho ricevuto il seguente messaggio di testo: " . $message['text'];
	if(strpos($text, "ciao") !== false){
		$response = "Ciao? Buongiorno semmai, coglione!";
	}
	elseif(strpos($text, 'mouse') !== false){
		$response = "Uso il NAGAAAAAAAA, ovvio.";
	}
	elseif(strpos($text, "battuta") !== false){
		$response = $randJoke[rand(0, count($randJoke) - 1)];
	}
	elseif(strpos($text, "costantini") !== false){
		$type = "video";
		$response = new CURLFile(realpath("video_costa.mov"));
		$caption = "Sssshh...";
	}
	elseif(strpos($text, "vian") !== false){
		$type = "foto";
		$response = new CURLFile(realpath("vian.jpg"));
		$caption = "Beo come el soe... de notte.";
	}
	else{
		$response = $randRes[rand(0, count($randRes) - 1)];
	}
}
elseif(isset($message['audio'])){
	$response = "Sì sì, parla pure, ti ascolto.";
}
elseif(isset($message['document'])){
	$response = "Cosa stracazzo mi stai inviando?";
}
elseif(isset($message['photo'])){
	$response = "Non ho gli occhi, come stracazzo faccio a vederla? Pirla.";
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


switch($type){
	
	case "text":
	
		header("Content-Type: application/json");
		$parameters = array('chat_id' => $chatId, 'text' => $response);
		$parameters["method"] = "sendMessage";
		echo json_encode($parameters);
		
	break;
	
	case "foto":
	
		$parameters = array('chat_id' => $chatId, 'photo' => $response, 'caption' => $caption);
		$botUrl = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendPhoto";
	
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: multipart/form-data"));
		curl_setopt($ch, CURLOPT_URL, $botUrl); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
	
		$output = curl_exec($ch);
		
	break;
	
	case "video":
	
		$parameters = array('chat_id' => $chatId, 'video' => $response, 'caption' => $caption);
		$botUrl = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendVideo";
	
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: multipart/form-data"));
		curl_setopt($ch, CURLOPT_URL, $botUrl); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
	
		$output = curl_exec($ch);
	
	break;
}





















