<?php

require_once(__DIR__."/SharedMemory.php");

class IpTree {

    const KEY_REASON = "reason";
    const KEY_TIME = "time";
    const KEY_COUNT = "count";

    const REASON_NO = "no_reason";
    const REASON_BOTSCOUT = "botscout";
    const REASON_SPAM = "spam";

    private $shared;

    private $isTmp = false;
    private $tree = array();
    private $filePath = array();

    function __construct($filePath=null) {

        if ($filePath == null || empty($filePath)) {
            $this->filePath = tempnam('/tmp', uniqid('treeFile'));
            $this->isTmp = true;
        } else {
            $this->filePath = $filePath;

            $this->shared = new SharedMemory($this->filePath);

            if (!is_file($this->filePath)){
                touch($this->filePath);
            }

            $this->refresh();
        }
    }

    function __destruct() {
        if ($this->isTmp) {
            unlink($this->filePath);
        } else {
            // We don't need this i think...
            $this->update(true);
        }
    }

    public function getTree(){
        return $this->tree;
    }

    public function isIpKnow($ip) {
        $this->refresh();
        $arIp = is_array($ip)?$ip:$this->explodeIP($ip);
        return array_key_exists($arIp[0], $this->tree)
            && array_key_exists($arIp[1], $this->tree[$arIp[0]])
            && array_key_exists($arIp[2], $this->tree[$arIp[0]][$arIp[1]])
            && array_key_exists($arIp[3], $this->tree[$arIp[0]][$arIp[1]][$arIp[2]]);
    }

    public function addInfoFor($ip, $nfos) {
        $this->refresh();

        $arIp = is_array($ip)?$ip:$this->explodeIP($ip);
        if ($this->isIpKnow($ip)) {
            foreach ($nfos as $key => $val) {
                $this->tree[$arIp[0]][$arIp[1]][$arIp[2]][$arIp[3]][$key] = $val;
            }
        }

        $this->update();
    }

    public function getInfoOf($ip, $key=null) {
        $this->refresh();

        $arIp = is_array($ip)?$ip:$this->explodeIP($ip);
        if ($this->isIpKnow($ip)) {
            if ($key == null) {
                return $this->tree[$arIp[0]][$arIp[1]][$arIp[2]][$arIp[3]];
            } else {
                if (array_key_exists($key, $this->tree[$arIp[0]][$arIp[1]][$arIp[2]][$arIp[3]])) {
                    return $this->tree[$arIp[0]][$arIp[1]][$arIp[2]][$arIp[3]][$key];
                } else {
                    return false;
                }
            }
        }
        return false;
    }

    public function addIp($ip, $reason=self::REASON_NO, $time=null, $count=1) {
        if (empty($time)) $time = time();


        $this->refresh();
        $split = is_array($ip)?$ip:$this->explodeIP($ip);

        if (!array_key_exists($split[0], $this->tree)) {
            $this->tree[$split[0]] = array();
        }
        if (!array_key_exists($split[1], $this->tree[$split[0]])) {
            $this->tree[$split[0]][$split[1]] = array();
        }
        if (!array_key_exists($split[2], $this->tree[$split[0]][$split[1]])) {
            $this->tree[$split[0]][$split[1]][$split[2]] = array();
        }
        if (!array_key_exists($split[3], $this->tree[$split[0]][$split[1]][$split[2]])) {
            $this->tree[$split[0]][$split[1]][$split[2]][$split[3]] = array(
                self::KEY_TIME => $time,
                self::KEY_REASON => $reason,
                self::KEY_COUNT => $count
            );
        }

        $this->update();
    }

    public function removeIp($ip) {

        $this->refresh();
        $split = is_array($ip)?$ip:$this->explodeIP($ip);

        // Ensure this ip is know
        if ($this->isIpKnow($ip)) {
            unset($this->tree[$split[0]][$split[1]][$split[2]][$split[3]]);

            if (empty($this->tree[$split[0]][$split[1]][$split[2]])){
                unset($this->tree[$split[0]][$split[1]][$split[2]]);
            }
            if (empty($this->tree[$split[0]][$split[1]])){
                unset($this->tree[$split[0]][$split[1]]);
            }
            if (empty($this->tree[$split[0]])){
                unset($this->tree[$split[0]]);
            }
        }

        $this->update();
    }

    private function refresh($force=false) {
        if ($force || $this->needFileRefresh()) {
            $this->readFile();
        }
        if (!$this->shared->has("tree")){
            $this->update();
        }
        $this->tree = $this->shared->tree;
    }

    private function needFileRefresh() {
        if (($this->shared->has("lastUpdate") && $this->shared->lastUpdate<filemtime($this->filePath)) || !$this->shared->has("lastUpdate")){
            return true;
        }
        return false;
    }

    private function update($force=false) {
        $this->shared->tree = $this->tree;
        if ($force || $this->needFileUpdate()) {
            $this->writeFile();
        }
        $this->shared->lastUpdate = time();
    }

    private function needFileUpdate() {
        if (($this->shared->has("lastUpdate") && $this->shared->lastUpdate>(filemtime($this->filePath)+120)) || !$this->shared->has("lastUpdate")){
            $file = fopen($this->filePath, 'r');
            if (flock($file, LOCK_EX | LOCK_NB)) {
                flock($file, LOCK_UN);
                fclose($file);
                return true;
            }
        }
        return false;
    }

    private function readFile() {
        $ipArray = $this->getListIpFrom();
        for ($i=0; is_array($ipArray) && $i<count($ipArray); $i++) {
            $split = $this->multiexplode(array('.',':'), $ipArray[$i]);
            $arLength = count($split);
            if ($arLength >= 4) {
                $this->trimArray($split);
                if (!array_key_exists($split[0], $this->tree)) {
                    $this->tree[$split[0]] = array();
                }
                if (!array_key_exists($split[1], $this->tree[$split[0]])) {
                    $this->tree[$split[0]][$split[1]] = array();
                }
                if (!array_key_exists($split[2], $this->tree[$split[0]][$split[1]])) {
                    $this->tree[$split[0]][$split[1]][$split[2]] = array();
                }
                if (!array_key_exists($split[3], $this->tree[$split[0]][$split[1]][$split[2]])) {
                    $this->tree[$split[0]][$split[1]][$split[2]][$split[3]] = array(
                        self::KEY_TIME => ($arLength<5)?time():$split[4],
                        self::KEY_REASON => ($arLength<6)?self::REASON_NO:$split[5],
                        self::KEY_COUNT => ($arLength<7)?0:$split[6]
                    );
                }
            }
        }
    }

    private function getListIpFrom() {
        if (!file_exists($this->filePath)) {
            return false;
        }

        $file = fopen($this->filePath, "r");
        for ($c=0; $c<=10 && !flock($file, LOCK_SH | LOCK_NB); $c++) {
            if ($c >= 10) {
                trigger_error("Unable to read file ".$this->filePath, E_USER_NOTICE);
                return false;
            }
            usleep(100);
        }

        $ipString = file_get_contents($this->filePath);

        flock($file, LOCK_UN);
        fclose($file);

        if ($ipString !== false) {
            $ipArray = explode(PHP_EOL, $ipString);
            return $ipArray;
        }
        return false;
    }

    public function writeFile() {
        $txt = "";
        foreach ($this->tree as $ipFirst => $stayFirst) {
            if (is_array($stayFirst)) {
                foreach ($stayFirst as $ipSecond => $staySecond) {
                    if (is_array($staySecond)) {
                        foreach ($staySecond as $ipThird => $stayThird) {
                            if (is_array($stayThird)) {
                                foreach ($stayThird as $ipFourth => $infos) {

                                    $line = $ipFirst . '.' . $ipSecond . '.' . $ipThird . '.' . $ipFourth;
                                    if (array_key_exists(self::KEY_TIME, $infos)) {
                                        $line .= ':'.$infos[self::KEY_TIME];
                                    } else {
                                        $line .= ':';
                                    }
                                    if (array_key_exists(self::KEY_REASON, $infos)) {
                                        $line .= ':'.$infos[self::KEY_REASON];
                                    } else {
                                        $line .= ':';
                                    }
                                    if (array_key_exists(self::KEY_COUNT, $infos)) {
                                        $line .= ':'.$infos[self::KEY_COUNT];
                                    } else {
                                        $line .= ':';
                                    }

                                    $txt .= $line.PHP_EOL;
                                }
                            }
                        }
                    }
                }
            }
        }
        file_put_contents($this->filePath, $txt, LOCK_EX);
        touch($this->filePath);
    }

    private function explodeIP($ip) {
        $arIp = explode('.', $ip);
        $this->trimArray($arIp);
        return $arIp;
    }

    private function multiexplode ($delimiters,$string) {
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }

    private function trimArray(&$array) {
        for ($i=0; $i<count($array); $i++) {
            $array[$i] = trim($array[$i]);
        }
    }
} 
