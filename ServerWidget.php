<?php
class ServerWidget{
    public static function createRamPeakWidget(){
        $peak = memory_get_peak_usage();
        $real = memory_get_usage(true);
        $perc = ($real / 100);
        $peakPerc = ($peak / $perc);

        $out = "<div class='dashboard-widget gauge ram-peak'>";
            $out .= "<div class='inner'>";
                $out .= "<h4 class='widget-title'>RAM<span class='sub'>(peak)</span></h4>";
                $out .= "<div class='gauge-value' data-value='$peakPerc'></div>";
                $out .= "<div class='gauge-inner'></div>";
                $out .= "<div class='gauge-indicator' data-value='0'></div>";
            $out .= "</div>";
        $out .= "</div>";

        return $out;
    }
    public static function createRamCurrentWidget(){
        $real = memory_get_usage(true);
        $current = memory_get_usage();
        $perc = ($real / 100);
        $realPerc = $current / $perc;

        $out = "<div class='dashboard-widget gauge ram-current'>";
            $out .= "<div class='inner'>";
            $out .= "<h4 class='widget-title'>RAM<span class='sub'>(current)</span></h4>";
                $out .= "<div class='gauge-value' data-value='$realPerc'></div>";
                $out .= "<div class='gauge-inner'></div>";
                $out .= "<div class='gauge-indicator' data-value='0'></div>";
            $out .= "</div>";
        $out .= "</div>";

        return $out;
    }
    public static function createServerLoadWidget(){
        $cpuData = self::get_server_load();
        $i = 0;
        $max = count($cpuData) - 1;
        $h = "calc(280px * " . ceil(( ($max + 1) / 4)) . ")";
        $out = "<div style='height:$h; display: inline-block; width: 100%; margin-bottom: -12.5%'>";
        foreach($cpuData as $core => $load){
            $end = ($core == $max) ? true : false;
            $text = ($end == true) ? 'TOTAL' : "CPU<span class='sub'>(#$core)";
            $out .= "<div class='col dt3'>";
            $out .= "<div class='filler'></div>";
                $out .= "<div class='dashboard-widget gauge ram-current'>";
                    $out .= "<div class='inner'>";
                    $out .= "<h4 class='widget-title'>$text</span></h4>";
                        $out .= "<div class='gauge-value' data-value='$load'></div>";
                        $out .= "<div class='gauge-inner'></div>";
                        $out .= "<div class='gauge-indicator' data-value='0'></div>";
                    $out .= "</div>";
                $out .= "</div>";
            $out .= "</div>";
            $i++;
        }
        $out .= "</div>";
        return $out;
    }


    public static function get_server_load()
    {
        $data       = [];
        $wmi        = new COM("winmgmts:\\");
        $cpu_cores  = $wmi->execquery("SELECT PercentProcessorTime FROM Win32_PerfFormattedData_PerfOS_Processor");
        $i = 0;
        foreach ($cpu_cores as $core) {
            $data[$i] = $core->PercentProcessorTime;
            $i++;
        }
        return $data;
    }

    public static function createDriveSpaceWidget(){
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
            $precision = 2;

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
                    $out .= "<div class='value' style='background-color: $color;'></div>";
                    $out .= "<div class='indicator'>$free/$total</div>";
                $out .= "</div>";
            $out .= "</div>";
        }

        return $out;
    }
}
?>
