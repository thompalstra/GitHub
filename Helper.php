<?php
class Helper{
    public static function getRandomHex(){
        $a = range('a', 'f');
        $b = range(0,9);

        $r = array_merge($a, $b);
        $out = '#';
        $i = 0;
        while($i < 6){
            $out .= $r[array_rand($r,1)];
            $i++;
        }
        return $out;
    }
}

?>
