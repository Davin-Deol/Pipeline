<?php
namespace App\MyLibrary;

class StringFormatter
{
    public static function getDifferenceBetweenDateTimeAndNow($seconds)
    {
        $dtF = new \DateTime();
        $dtT = new \DateTime("@$seconds");
        $interval = $dtF->diff($dtT);
        $result = "";
        if ($interval->y > 0)
        { 
            $result = $dtF->diff($dtT)->format('%y years ago');
        }
        else if ($interval->y !== 0)
        { 
            $result = $dtF->diff($dtT)->format('%y year ago');
        }
        else if ($interval->m > 0)
        { 
            $result = $dtF->diff($dtT)->format('%m months ago');
        }
        else if ($interval->m !== 0)
        { 
            $result = $dtF->diff($dtT)->format('%m month ago');
        }
        else if ($interval->d > 0)
        { 
            $result = $dtF->diff($dtT)->format('%a days ago');
        }
        else if ($interval->d !== 0)
        { 
            $result = $dtF->diff($dtT)->format('%a day ago');
        }
        else if ($interval->h > 0)
        { 
            $result = $dtF->diff($dtT)->format('%h hours ago');
        }
        else if ($interval->h !== 0)
        { 
            $result = $dtF->diff($dtT)->format('%h hour ago');
        }
        else if ($interval->i > 0)
        { 
            $result = $dtF->diff($dtT)->format('%i minutes ago');
        }
        else if ($interval->i !== 0)
        { 
            $result = $dtF->diff($dtT)->format('%i minute ago');
        }
        else if ($interval->s > 0)
        { 
            $result = $dtF->diff($dtT)->format('%s seconds ago');
        }
        else if ($interval->s !== 0)
        { 
            $result = $dtF->diff($dtT)->format('%s second ago');
        }
        return $result;
    }
    
    public static function convertRGBToHex($redValue, $greenValue, $blueValue)
    {
        $redValue = dechex($redValue);
        if (strlen($redValue)<2)
            $redValue = '0'.$redValue;

        $greenValue = dechex($greenValue);
        if (strlen($greenValue)<2)
            $greenValue = '0'.$greenValue;

        $blueValue = dechex($blueValue);
        if (strlen($blueValue)<2)
            $blueValue = '0'.$blueValue;

        return '#' . $redValue . $greenValue . $blueValue;
    }
}