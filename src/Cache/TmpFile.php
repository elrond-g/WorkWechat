<?php

namespace Elrond\WorkWechat\Cache;

class TmpFile
{

    public function get($key)
    {
        $file = $this->genFileName($key);
        if(file_exists($file))
        {
            $content = file_get_contents($file);
            $params = json_decode($content, true);
            if(time() <= $params['expire'])
                return $params['value'];
            return false;
        }
        return false;

    }

    public function set($key, $value, $expire)
    {
        $params = [
            'value' => $value,
            'expire' => time() + $expire,
        ];

        $file = $this->genFileName($key);
        $content = json_encode($params);
//      echo "<pre>";
//      var_dump([$file, $content]);
//      exit;
        file_put_contents($file, $content);
        return true;
    }

    private function getTmpDir()
    {
        $tmpDir = sys_get_temp_dir();

        return $tmpDir ? : "/tmp";
    }

    private function genFileName($key)
    {
        return $this->getTmpDir() . "/Elrond-WorkWechat-TmpFileCache-$key";
    }
}

