<?php

namespace app\Middleware;

class RateLimitMiddleware
{   

    private $_STORAGE_DIR = "";
    private int $_limit;
    private int $_lockDuration;

    public function __construct(int $limit = 3, int $lockDuration = 30)    
    {
        $this->_limit        = $limit;
        $this->_lockDuration = $lockDuration;
        $this->_STORAGE_DIR  = str_replace('Middleware', 'Storage\\rate_limit', __DIR__);
    }

    public function handle($req, callable $next) {
        
        $this->ensureStorageDir();
        $this->verify();

        return $next($req);
    }

    private function verify() : void
    {
        $id = $this->getIdentifier();
        $file = $this->filePath($id);
        $lockFile = $file . '.lock';
        $now = time();

        $lock = fopen($lockFile, 'c'); // abrir arquivo ou criar.

        $routeFormat = str_replace('/', '_', $_SERVER['REQUEST_URI']);
        $payload = ['route_access' => $routeFormat, 'attempts' => 1];

        // velidação para ver se da erro
        if (!$lock || !flock($lock, LOCK_EX)) return; 

        try {
            
            $data = $this->readData($file) ?? [];

            if(
                isset($data) 
                && 
                is_array($data) 
                && 
                count($data) > 0 
                ) 
            {
                foreach ($data as $key => $value) {
                    
                    if(!isset($value['blocked_until'] ) ) continue;
                    if(!isset($value['route_access'])) continue;

                    if($value['route_access'] == $routeFormat) 
                    {
                        if(!empty($value['blocked_until']) ) 
                        {
                            if($now < $value['blocked_until']) $this->blocked($data[$key]['blocked_until'] - $now);
        
                            // bloqueio expirou, então necessidade de resetar.
                            unset($data[$key]);
                            $data = array_values($data);
                            
                        }
                    }

                    # code...
                }

            }

            //=================================================
          
            $found = false;
            if($data) {
              
                foreach ($data as $key => $value) {

                    if(!isset($value['route_access'])) continue;
                    
                    if($value['route_access'] == $routeFormat) 
                    {
                        $found = true;
                        $data[$key]['attempts'] = isset($value['attempts']) ? (int)$value['attempts'] + 1 : 100;
                        if($value['attempts'] > $this->_limit)
                        {
                            $data[$key]['blocked_until'] = $now + $this->_lockDuration;
                            $this->writeData($file, $data);
                            $this->blocked($this->_lockDuration);
                        }
                    }
                }
                // se found = false, não existe rota de acesso no arquivo, precisa criar uma nova.
                if(!$found) array_push($data, $payload);
                
            }else array_push($data, $payload);;
            
                
            //=================================================
            $this->writeData($file, $data);
            //=================================================


        } catch (\Exception $e) {
            error_log($e->getMessage());
            return;

        }finally {
            flock($lock, LOCK_UN);
            fclose($lock);
            unlink($lockFile);
        }
        
    }


    private function getIdentifier(string $email = "") : string
    {
        $ip = $this->getClientIp();
        return md5($email !== '' ? "{$email}_{$ip}" : $ip);
    }

    private function getClientIp(): string
    {
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
 
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }


    /**
     *  Bloqueiar requisições caso tentativas cheguem no limite.
     */
    private function blocked(int $retryAfter)
    {
        $time = (int) ceil($retryAfter / 60);
 
        http_response_code(429);
        header('Content-Type: application/json; charset=utf-8');
        header("Retry-After: {$retryAfter}");
        header("X-RateLimit-Reset: " . (time() + $retryAfter));
 
        echo json_encode([
            'error'       => true,
            'code'        => 429,
            'message'     => "Muitas tentativas. Tente novamente em alguns estantes",
            'attempt_in' => $retryAfter,
        ], JSON_UNESCAPED_UNICODE);
 
        exit;
    }

    private function filePath(string $identifier): string
    {
        return $this->_STORAGE_DIR . DIRECTORY_SEPARATOR . "rl_{$identifier}";
    }

    private function readData(string $file): array
    {
        if (!file_exists($file)) {
            return [];
        }
 
        return json_decode(file_get_contents($file), true) ?? [];
    }

    private function writeData(string $file, array $data): void
    {   
        file_put_contents($file, json_encode($data), LOCK_EX);
    }

    private function ensureStorageDir(): void
    {
        if (!is_dir($this->_STORAGE_DIR)) {
            mkdir($this->_STORAGE_DIR, 0700, true);
        }
 
        $htaccess = $this->_STORAGE_DIR . DIRECTORY_SEPARATOR . '.htaccess';
        if (!file_exists($htaccess)) {
            file_put_contents($htaccess, "Deny from all\n");
        }
    }


}