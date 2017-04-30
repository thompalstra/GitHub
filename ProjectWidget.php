<?php
class ProjectWidget{
    public static function createDirs(){
        $out = '';
        $dirs = array_filter(glob('*'), 'is_dir');

        $groups = [];
        foreach($dirs as $dir){
            if($dir[0] == '_') { continue; }
            $sn = substr($dir, 0, strpos($dir, '-'));
            if(!empty($sn)){
                if(!isset($groups[$sn])){
                    $groups[$sn][] = $dir;
                } else {
                    $groups[$sn][] = $dir;
                }
            } else {
                $groups[0][] = $dir;
            }
        }

        foreach($groups as $key => $group){
            $name = ($key === 0) ? 'General' : $key;
            $line = "<div class='group-header' data-group='$key'><h4>$name</h4>";
            $line .= "<div class='toggle-inner'>";
            foreach($group as $dir){
                $sn = substr($dir, 0, strpos($dir, '-'));

                $bgC = \Helper::getRandomHex();

                $line .= "<div class='go-visit' style='background-color:$bgC'>";
                $line .= "<a href='//$dir.git/' target='_blank'>";
                $line .= "<h2 style='color: white; text-align: center; text-shadow: 0px 0px 4px rgba(150, 150, 150, 1);'>".$dir."</h2>";

                $line .= "<div class='go-visit-pop'></div>";
                $line .= "</a>";
                $line .= "</div>";
            }
            $line .= "</div>";
            $line .= "</div>";
            $out .= $line;
        }
        return $out;
    }
}


?>
