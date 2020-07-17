<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

/**
 * Helper for dates
 */
use DateTime;
use DatePeriod;
use DateInterval;

class Common
{
    /**
     * Remove a whitespace in string 
     * 
     * @param string $string
     */
    public static function removeWhiteSpace($string)
    {
        return preg_replace('/\s+/', '', $string);
    }

    /**
     * Make a random unique number
     * 
     * @param $length = length number you want to generate
     */
    public static function randomNumber($length) 
    {
        $result = '';
    
        for($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }
    
        return $result;
    }
    
    /**
     * Upload file to storage
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $requestName
     * @param string $storePath
     * @param object $model
     */
    public static function uploadFile(Request $request, $requestName, $storePath, $model = null)
    {
        if($request->hasFile($requestName)) {
            // Get file name with extension
            $getFileNameWithExtension = $request->file($requestName)->getClientOriginalName();
            
            // Get file name
            $getFileName = pathinfo($getFileNameWithExtension, PATHINFO_FILENAME);

            // Get file extension
            $getFileExtension = $request->file($requestName)->getClientOriginalExtension();

            // File name to store
            $fileNameToStore = self::removeWhiteSpace(strtolower($getFileName)) . '-' . rand() . '.' . $getFileExtension;

            // Path to store
            $path = $request->file($requestName)->storeAs("public/images/$storePath", $fileNameToStore);

            // If there's model, delete the existing image
            if($model) {
                Storage::delete("public/images/$storePath/$model->image");
            }

            return $fileNameToStore;
        } else {
            // if there's no file or user didn't input anything
            if($model) return $model->image; 
            else return $fileNameToStore = null;
        }
    }

    /**
     * Delete file from storage
     * 
     */
    public static function deleteImage($path, $model)
    {
        return Storage::delete("public/images/$path/" . $model->image);
    }

    /**
     * Get dates between two dates
     * 
     * @param string $sd = Start Date
     * @param string $ed = End Date
     */
    public static function getDateRange($sd, $ed)
    {
        $startDate = strtotime($sd);        
        $endDate = strtotime($ed);
        $dates = [];        
        
        if($startDate != null && $endDate != null) {
            for ($i=$startDate; $i<=$endDate; $i+=86400) {  
                $dates[] = date("Y-m-d", $i);  
            }  
        } else {
            $dates[] = date("Y-m-d", $startDate);
        }

        return $dates;
    }

    /**
     * Get month between two dates
     * 
     * @param string $sd = Start Date
     * @param string $ed = End Date
     * @param string $format = 'Y-F' for year and full month name
     */
    public static function getMonth($sd, $ed, $format)
    {
        $startDate    = (new DateTime($sd))->modify('first day of this month');
        $endDate      = (new DateTime($ed))->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($startDate, $interval, $endDate);
        $months = [];

        foreach ($period as $dt) {
            $months[] = $dt->format($format);
        }

        return $months;
    }
}