<?php
class ServerWidget{
    public function createRamPeakWidget(){
        $peak = memory_get_peak_usage();
        $real = memory_get_usage(true);
        $perc = ($real / 100);
        $peakPerc = ($peak / $perc);

        $out = "<div class='dashboard-widget gauge ram-peak'>";
            $out .= "<div class='inner'>";
                $out .= "<h4 class='widget-title'>RAM<span class='sub'>(peak)</span></h4>";
                $out .= "<div class='gauge-value' data-value='$peakPerc'></div>";
                $out .= "<div class='gauge-indicator' data-value='0'></div>";
            $out .= "</div>";
        $out .= "</div>";

        return $out;
    }
    public function createRamCurrentWidget(){
        $real = memory_get_usage(true);
        $current = memory_get_usage();
        $perc = ($real / 100);
        $realPerc = $current / $perc;

        $out = "<div class='dashboard-widget gauge ram-current'>";
            $out .= "<div class='inner'>";
            $out .= "<h4 class='widget-title'>RAM<span class='sub'>(current)</span></h4>";
                $out .= "<div class='gauge-value' data-value='$realPerc'></div>";
                $out .= "<div class='gauge-indicator' data-value='0'></div>";
            $out .= "</div>";
        $out .= "</div>";

        return $out;
    }
    public function createServerLoadWidget(){
        $load = self::get_server_load();
        $i = 1;
        foreach($load as $core){
            $out = "<div class='dashboard-widget gauge ram-current'>";
                $out .= "<div class='inner'>";
                $out .= "<h4 class='widget-title'>CPU<span class='sub'>($i)</span></h4>";
                    $out .= "<div class='gauge-value' data-value='$core'></div>";
                    $out .= "<div class='gauge-indicator' data-value='0'></div>";
                $out .= "</div>";
            $out .= "</div>";
            $i++;
        }


        return $out;
    }


    public static function get_server_load()
    {
        $load=array();
        if (stristr(PHP_OS, 'win'))
        {
            $wmi = new COM("Winmgmts://");
            $server = $wmi->execquery("SELECT LoadPercentage FROM Win32_Processor");
            $cpu_num = 0;
            $load_total = 0;
            foreach($server as $cpu)
            {
                $cpu_num++;
                $load_total += $cpu->loadpercentage;
            }

            $load[]= round($load_total/$cpu_num);

        }
        else
        {
            $load = sys_getloadavg();
        }
        return $load;
    }

    public function createDriveSpaceWidget(){
        $range = range('A', 'Z');
        $out = '';
        $fso = new COM('Scripting.FileSystemObject');
        $type = array("Unknown","Removable","Fixed","Network","CD-ROM","RAM Disk");
        foreach ($fso->Drives as $drive) {
            $l = "$drive->DriveLetter:/";
            $free = @disk_free_space($l);
            $total = @disk_total_space($l);
            $dO = $fso->GetDrive($drive);

            if($dO->DriveType == 3){
                $dname = $dO->Sharename;
            }else if($dO->IsReady){
                $dname = $dO->VolumeName;
            }else{
                $dname = "[Drive not ready]";
            }
            $t = $type[$dO->DriveType];
            $name = " $t $l $dname";

            if($free === false || $total === false){
                $out .= "<div class='dashboard-widget progress drive-space'>";
                $out .= "<h4 class='widget-title'>$name</span></h4>";
                $out .= "</div>";
                continue;
            }


            $perc = ($total / 100);
            $perc = intval($free / $perc);

            $base = log($free, 1024);
            $suffixes = array('', 'K', 'M', 'GB', 'T');

            $free = round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];

            $base = log($total, 1024);
            $suffixes = array('', 'K', 'M', 'GB', 'T');

            $total = round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];

            if($free == 'NAN ' || $total == 'NAN '){
                continue;
            }

            if($perc < 75){
                $color = '#1C84A7';
            } else $color = '#CF000F';
            $out .= "<div class='dashboard-widget progress drive-space' data-value='$perc' data-min='0' data-max='100'>";
            $out .= "<h4 class='widget-title'>$name</span></h4>";
                $out .= "<div class='inner'>";
                    $out .= "<div class='value' style='height: 20px; background-color: $color;'></div>";
                    $out .= "<div class='indicator'>$free/$total</div>";
                $out .= "</div>";
            $out .= "</div>";
        }

        return $out;
    }
}
?>
