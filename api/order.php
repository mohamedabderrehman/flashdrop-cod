<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
function reply(int $code, array $body): never { http_response_code($code); echo json_encode($body, JSON_UNESCAPED_UNICODE); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') reply(405, ['success'=>false,'error'=>'POST required']);
if (isset($_SERVER['HTTP_ORIGIN'])) {
    $origin = parse_url($_SERVER['HTTP_ORIGIN'], PHP_URL_HOST);
    $host = explode(':', $_SERVER['HTTP_HOST'] ?? '')[0];
    if ($origin !== $host) reply(403, ['success'=>false,'error'=>'Invalid origin']);
}
$data = json_decode(file_get_contents('php://input'), true);
if (!is_array($data)) reply(400, ['success'=>false,'error'=>'Invalid JSON']);
$options = json_decode(file_get_contents(__DIR__.'/options.json'), true);
foreach (['fullname','wilaya','baladia','phone','color','size','delivery'] as $key) {
    if (!isset($data[$key]) || !is_string($data[$key]) || strlen(trim($data[$key])) < ($key === 'size' ? 1 : 2) || strlen($data[$key]) > 200)
        reply(422, ['success'=>false,'error'=>'Invalid '.$key]);
    $data[$key] = trim($data[$key]);
}
foreach (['wilaya','color','size','delivery'] as $key) {
    if (!in_array($data[$key], $options[$key], true)) reply(422, ['success'=>false,'error'=>'Unsupported '.$key]);
}
if (!preg_match('/^0[567][0-9]{8}$/', $data['phone'])) reply(422, ['success'=>false,'error'=>'Invalid Algerian phone']);
$quantity = filter_var($data['quantity'] ?? null, FILTER_VALIDATE_INT);
if ($quantity === false || $quantity < 1 || $quantity > 10) reply(422, ['success'=>false,'error'=>'Invalid quantity']);
$data['quantity'] = $quantity;
$data['address'] = $data['address'] ?? '';
if (!is_string($data['address']) || strlen($data['address']) > 500) reply(422, ['success'=>false,'error'=>'Invalid address']);
$key = $_SERVER['HTTP_IDEMPOTENCY_KEY'] ?? '';
if (!preg_match('/^[a-zA-Z0-9-]{16,80}$/', $key)) reply(422, ['success'=>false,'error'=>'Idempotency-Key required']);
// Only opaque hashes and order IDs are stored; never names, phones or addresses.
$stateDir = getenv('ORDER_STATE_DIR') ?: sys_get_temp_dir().'/flashdrop-orders';
if (!is_dir($stateDir) && !mkdir($stateDir,0700,true)) reply(503,['success'=>false,'error'=>'State storage unavailable']);
$file = fopen($stateDir.'/'.hash('sha256',$key).'.json','c+');
if (!$file || !flock($file,LOCK_EX)) reply(503,['success'=>false,'error'=>'State lock unavailable']);
$fingerprint = hash('sha256', json_encode($data));
$previous = json_decode(stream_get_contents($file),true);
if ($previous) {
    if ($previous['fingerprint'] !== $fingerprint) reply(409,['success'=>false,'error'=>'Key reused with another order']);
    if ($previous['state'] === 'success') reply(200,['success'=>true,'order_id'=>$previous['id'],'demo'=>$previous['demo']]);
    // An uncertain network outcome must be reconciled before another send.
    reply(409,['success'=>false,'error'=>'Previous submission needs reconciliation; do not resend']);
}
$demo = (getenv('DEMO_MODE') ?: '1') === '1';
$id = 'FD-'.strtoupper(bin2hex(random_bytes(5)));
$state = ['id'=>$id,'fingerprint'=>$fingerprint,'state'=>'pending','demo'=>$demo];
$persist = function() use ($file, &$state) { rewind($file); ftruncate($file,0); fwrite($file,json_encode($state)); fflush($file); };
if (!$demo) {
    $token = getenv('TELEGRAM_BOT_TOKEN'); $chat = getenv('TELEGRAM_CHAT_ID');
    if (!$token || !$chat || !extension_loaded('curl')) reply(503,['success'=>false,'error'=>'Provider not configured']);
    $persist();
    $text = "Order $id\n"; foreach ($data as $name=>$value) $text .= "$name: $value\n";
    $text .= 'Total: '.($quantity * 3250).' DZD (delivery excluded)';
    $curl = curl_init('https://api.telegram.org/bot'.$token.'/sendMessage');
    curl_setopt_array($curl,[CURLOPT_POST=>true,CURLOPT_POSTFIELDS=>http_build_query(['chat_id'=>$chat,'text'=>$text]),CURLOPT_RETURNTRANSFER=>true,CURLOPT_TIMEOUT=>15,CURLOPT_SSL_VERIFYPEER=>true,CURLOPT_SSL_VERIFYHOST=>2]);
    $raw = curl_exec($curl); $code = curl_getinfo($curl,CURLINFO_HTTP_CODE); curl_close($curl);
    $result = is_string($raw) ? json_decode($raw,true) : null;
    if ($code !== 200 || !($result['ok'] ?? false)) {
        $state['state']='uncertain'; $persist();
        reply(502,['success'=>false,'error'=>'Provider did not confirm delivery; reconciliation required']);
    }
}
$state['state']='success'; $persist(); fclose($file);
reply(200,['success'=>true,'order_id'=>$id,'demo'=>$demo]);
