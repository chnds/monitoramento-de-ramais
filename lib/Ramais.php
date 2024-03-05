<?php

class Ramais
{
    private $ramaisFile;
    private $filasFile;

    public function __construct($ramaisFile, $filasFile)
    {
        $this->ramaisFile = $ramaisFile;
        $this->filasFile = $filasFile;
    }

    public function obterStatusRamais()
    {
        $filas = file($this->filasFile);
        $statusRamais = [];

        foreach ($filas as $linha) {
            if (strstr($linha, 'SIP/')) {
                if (strstr($linha, '(Ring)')) {
                    $partes = explode(' ', trim($linha));
                    list($tech, $ramal) = explode('/', $partes[0]);
                    $statusRamais[$ramal] = 'chamando';
                } elseif (strstr($linha, '(In use)')) {
                    $partes = explode(' ', trim($linha));
                    list($tech, $ramal) = explode('/', $partes[0]);
                    $statusRamais[$ramal] = 'ocupado';
                } elseif (strstr($linha, '(Not in use)')) {
                    $partes = explode(' ', trim($linha));
                    list($tech, $ramal) = explode('/', $partes[0]);
                    $statusRamais[$ramal] = 'disponivel';
                }
            }
        }

        return $statusRamais;
    }

    public function obterInfoRamais()
    {
        $ramais = file($this->ramaisFile);
        $statusRamais = $this->obterStatusRamais();
        $infoRamais = [];

        foreach ($ramais as $linha) {
            $partes = array_filter(explode(' ', trim($linha)));
            $arr = array_values($partes);

            if (trim($arr[5]) == "OK") {
                list($name, $username) = explode('/', $arr[0]);
                $online = true;
            } elseif (trim($arr[1]) == '(Unspecified)' && trim($arr[4]) == 'UNKNOWN') {
                list($name, $username) = explode('/', $arr[0]);
                $online = false;
            } else {
                continue; // Ignorar ramais com estado inválido
            }

            $status = isset($statusRamais[$name]) ? $statusRamais[$name] : 'desconhecido';

            $infoRamais[$name] = [
                'nome' => $name,
                'ramal' => $username,
                'online' => $online,
                'status' => $status
            ];
        }

        return $infoRamais;
    }

}
