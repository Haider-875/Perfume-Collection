<?php

namespace App\Services;

class PakistanGeoService
{
    public static function getProvinces(): array
    {
        return [
            'Punjab' => [
                'Lahore', 'Karachi (Sindh)', 'Faisalabad', 'Rawalpindi', 'Multan', 'Gujranwala', 
                'Sialkot', 'Bahawalpur', 'Sargodha', 'Sheikhupura', 'Jhang', 'Rahim Yar Khan', 
                'Gujrat', 'Kasur', 'Sahiwal', 'Okara', 'Wah Cantonment', 'Dera Ghazi Khan', 
                'Chiniot', 'Kamoke', 'Hafizabad', 'Murree', 'Chakwal', 'Attock', 'Vehari', 
                'Mandi Bahauddin', 'Jhelum', 'Khanewal', 'Muzaffargarh', 'Bahawalnagar', 'Toba Tek Singh'
            ],
            'Sindh' => [
                'Karachi', 'Hyderabad', 'Sukkur', 'Larkana', 'Nawabshah (Shaheed Benazirabad)', 
                'Mirpur Khas', 'Jacobabad', 'Shikarpur', 'Khairpur', 'Badin', 'Thatta', 
                'Dadu', 'Tando Allahyar', 'Tando Muhammad Khan', 'Ghotki', 'Umerkot'
            ],
            'Islamabad Capital Territory' => [
                'Islamabad'
            ],
            'Khyber Pakhtunkhwa' => [
                'Peshawar', 'Mardan', 'Abbottabad', 'Swat (Mingora)', 'Kohat', 'Dera Ismail Khan', 
                'Haripur', 'Mansehra', 'Nowshera', 'Swabi', 'Charsadda', 'Bannu', 'Malakand'
            ],
            'Balochistan' => [
                'Quetta', 'Gwadar', 'Turbat', 'Khuzdar', 'Hub', 'Sibi', 'Loralai', 'Zhob', 'Chaman', 'Pishin'
            ],
            'Azad Jammu & Kashmir' => [
                'Muzaffarabad', 'Mirpur', 'Rawalakot', 'Kotli', 'Bhimber', 'Bagh', 'Palandri'
            ],
            'Gilgit-Baltistan' => [
                'Gilgit', 'Skardu', 'Hunza', 'Chilas', 'Ghizer', 'Astore'
            ],
        ];
    }

    public static function getAllCities(): array
    {
        $cities = [];
        foreach (static::getProvinces() as $province => $cityList) {
            foreach ($cityList as $city) {
                $cleanCity = explode(' (', $city)[0];
                $cities[] = $cleanCity;
            }
        }
        return array_unique($cities);
    }
}
