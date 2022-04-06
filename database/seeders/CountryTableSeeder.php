<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            [
                'id' => 1,
                'country_code' => 'AD',
                'country_name' => 'Andorra',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 2,
                'country_code' => 'AE',
                'country_name' => 'United Arab Emirates',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 3,
                'country_code' => 'AF',
                'country_name' => 'Afghanistan',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 4,
                'country_code' => 'AG',
                'country_name' => 'Antigua and Barbuda',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 5,
                'country_code' => 'AI',
                'country_name' => 'Anguilla',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 6,
                'country_code' => 'AL',
                'country_name' => 'Albania',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 7,
                'country_code' => 'AM',
                'country_name' => 'Armenia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 8,
                'country_code' => 'AN',
                'country_name' => 'Netherlands Antilles',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 9,
                'country_code' => 'AO',
                'country_name' => 'Angola',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 10,
                'country_code' => 'AQ',
                'country_name' => 'Antarctica',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 11,
                'country_code' => 'AR',
                'country_name' => 'Argentina',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 12,
                'country_code' => 'AS',
                'country_name' => 'American Samoa',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 13,
                'country_code' => 'AT',
                'country_name' => 'Austria',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 14,
                'country_code' => 'AU',
                'country_name' => 'Australia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 15,
                'country_code' => 'AW',
                'country_name' => 'Aruba',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 16,
                'country_code' => 'AX',
                'country_name' => 'Aland Islands',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 17,
                'country_code' => 'AZ',
                'country_name' => 'Azerbaijan',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 18,
                'country_code' => 'BA',
                'country_name' => 'Bosnia and Herzegovina',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 19,
                'country_code' => 'BB',
                'country_name' => 'Barbados',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 20,
                'country_code' => 'BD',
                'country_name' => 'Bangladesh',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 21,
                'country_code' => 'BE',
                'country_name' => 'Belgium',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 22,
                'country_code' => 'BF',
                'country_name' => 'Burkina Faso',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 23,
                'country_code' => 'BG',
                'country_name' => 'Bulgaria',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 24,
                'country_code' => 'BH',
                'country_name' => 'Bahrain',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 25,
                'country_code' => 'BI',
                'country_name' => 'Burundi',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 26,
                'country_code' => 'BJ',
                'country_name' => 'Benin',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 27,
                'country_code' => 'BL',
                'country_name' => 'Saint Barthélemy',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 28,
                'country_code' => 'BM',
                'country_name' => 'Bermuda',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 29,
                'country_code' => 'BN',
                'country_name' => 'Brunei',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 30,
                'country_code' => 'BO',
                'country_name' => 'Bolivia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 31,
                'country_code' => 'BQ',
                'country_name' => 'Bonaire, Saint Eustatius and Saba ',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 32,
                'country_code' => 'BR',
                'country_name' => 'Brazil',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 33,
                'country_code' => 'BS',
                'country_name' => 'Bahamas',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 34,
                'country_code' => 'BT',
                'country_name' => 'Bhutan',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 35,
                'country_code' => 'BV',
                'country_name' => 'Bouvet Island',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 36,
                'country_code' => 'BW',
                'country_name' => 'Botswana',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 37,
                'country_code' => 'BY',
                'country_name' => 'Belarus',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 38,
                'country_code' => 'BZ',
                'country_name' => 'Belize',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 39,
                'country_code' => 'CA',
                'country_name' => 'Canada',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 40,
                'country_code' => 'CC',
                'country_name' => 'Cocos Islands',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 41,
                'country_code' => 'CD',
                'country_name' => 'Democratic Republic of the Congo',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 42,
                'country_code' => 'CF',
                'country_name' => 'Central African Republic',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 43,
                'country_code' => 'CG',
                'country_name' => 'Republic of the Congo',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 44,
                'country_code' => 'CH',
                'country_name' => 'Switzerland',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 45,
                'country_code' => 'CI',
                'country_name' => 'Ivory Coast',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 46,
                'country_code' => 'CK',
                'country_name' => 'Cook Islands',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 47,
                'country_code' => 'CL',
                'country_name' => 'Chile',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 48,
                'country_code' => 'CM',
                'country_name' => 'Cameroon',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 49,
                'country_code' => 'CN',
                'country_name' => 'China',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 50,
                'country_code' => 'CO',
                'country_name' => 'Colombia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 51,
                'country_code' => 'CR',
                'country_name' => 'Costa Rica',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 52,
                'country_code' => 'CS',
                'country_name' => 'Serbia and Montenegro',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 53,
                'country_code' => 'CU',
                'country_name' => 'Cuba',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 54,
                'country_code' => 'CV',
                'country_name' => 'Cape Verde',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 55,
                'country_code' => 'CW',
                'country_name' => 'Curaçao',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 56,
                'country_code' => 'CX',
                'country_name' => 'Christmas Island',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 57,
                'country_code' => 'CY',
                'country_name' => 'Cyprus',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 58,
                'country_code' => 'CZ',
                'country_name' => 'Czech Republic',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 59,
                'country_code' => 'DE',
                'country_name' => 'Germany',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 60,
                'country_code' => 'DJ',
                'country_name' => 'Djibouti',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 61,
                'country_code' => 'DK',
                'country_name' => 'Denmark',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 62,
                'country_code' => 'DM',
                'country_name' => 'Dominica',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 63,
                'country_code' => 'DO',
                'country_name' => 'Dominican Republic',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 64,
                'country_code' => 'DZ',
                'country_name' => 'Algeria',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 65,
                'country_code' => 'EC',
                'country_name' => 'Ecuador',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 66,
                'country_code' => 'EE',
                'country_name' => 'Estonia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 67,
                'country_code' => 'EG',
                'country_name' => 'Egypt',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 68,
                'country_code' => 'EH',
                'country_name' => 'Western Sahara',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 69,
                'country_code' => 'ER',
                'country_name' => 'Eritrea',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 70,
                'country_code' => 'ES',
                'country_name' => 'Spain',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 71,
                'country_code' => 'ET',
                'country_name' => 'Ethiopia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 72,
                'country_code' => 'FI',
                'country_name' => 'Finland',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 73,
                'country_code' => 'FJ',
                'country_name' => 'Fiji',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 74,
                'country_code' => 'FK',
                'country_name' => 'Falkland Islands',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 75,
                'country_code' => 'FM',
                'country_name' => 'Micronesia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 76,
                'country_code' => 'FO',
                'country_name' => 'Faroe Islands',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 77,
                'country_code' => 'FR',
                'country_name' => 'France',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 78,
                'country_code' => 'GA',
                'country_name' => 'Gabon',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 79,
                'country_code' => 'GB',
                'country_name' => 'United Kingdom',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 80,
                'country_code' => 'GD',
                'country_name' => 'Grenada',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 81,
                'country_code' => 'GE',
                'country_name' => 'Georgia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 82,
                'country_code' => 'GF',
                'country_name' => 'French Guiana',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 83,
                'country_code' => 'GG',
                'country_name' => 'Guernsey',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 84,
                'country_code' => 'GH',
                'country_name' => 'Ghana',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 85,
                'country_code' => 'GI',
                'country_name' => 'Gibraltar',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 86,
                'country_code' => 'GL',
                'country_name' => 'Greenland',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 87,
                'country_code' => 'GM',
                'country_name' => 'Gambia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 88,
                'country_code' => 'GN',
                'country_name' => 'Guinea',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 89,
                'country_code' => 'GP',
                'country_name' => 'Guadeloupe',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 90,
                'country_code' => 'GQ',
                'country_name' => 'Equatorial Guinea',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 91,
                'country_code' => 'GR',
                'country_name' => 'Greece',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 92,
                'country_code' => 'GS',
                'country_name' => 'South Georgia and the South Sandwich Islands',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 93,
                'country_code' => 'GT',
                'country_name' => 'Guatemala',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 94,
                'country_code' => 'GU',
                'country_name' => 'Guam',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 95,
                'country_code' => 'GW',
                'country_name' => 'Guinea-Bissau',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 96,
                'country_code' => 'GY',
                'country_name' => 'Guyana',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 97,
                'country_code' => 'HK',
                'country_name' => 'Hong Kong',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 98,
                'country_code' => 'HM',
                'country_name' => 'Heard Island and McDonald Islands',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 99,
                'country_code' => 'HN',
                'country_name' => 'Honduras',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 100,
                'country_code' => 'HR',
                'country_name' => 'Croatia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 101,
                'country_code' => 'HT',
                'country_name' => 'Haiti',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 102,
                'country_code' => 'HU',
                'country_name' => 'Hungary',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 103,
                'country_code' => 'ID',
                'country_name' => 'Indonesia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 104,
                'country_code' => 'IE',
                'country_name' => 'Ireland',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 105,
                'country_code' => 'IL',
                'country_name' => 'Israel',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 106,
                'country_code' => 'IM',
                'country_name' => 'Isle of Man',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 107,
                'country_code' => 'IN',
                'country_name' => 'India',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 108,
                'country_code' => 'IO',
                'country_name' => 'British Indian Ocean Territory',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 109,
                'country_code' => 'IQ',
                'country_name' => 'Iraq',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 110,
                'country_code' => 'IR',
                'country_name' => 'Iran',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 111,
                'country_code' => 'IS',
                'country_name' => 'Iceland',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 112,
                'country_code' => 'IT',
                'country_name' => 'Italy',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 113,
                'country_code' => 'JE',
                'country_name' => 'Jersey',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 114,
                'country_code' => 'JM',
                'country_name' => 'Jamaica',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 115,
                'country_code' => 'JO',
                'country_name' => 'Jordan',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 116,
                'country_code' => 'JP',
                'country_name' => 'Japan',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 117,
                'country_code' => 'KE',
                'country_name' => 'Kenya',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 118,
                'country_code' => 'KG',
                'country_name' => 'Kyrgyzstan',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 119,
                'country_code' => 'KH',
                'country_name' => 'Cambodia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 120,
                'country_code' => 'KI',
                'country_name' => 'Kiribati',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 121,
                'country_code' => 'KM',
                'country_name' => 'Comoros',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 122,
                'country_code' => 'KN',
                'country_name' => 'Saint Kitts and Nevis',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 123,
                'country_code' => 'KP',
                'country_name' => 'North Korea',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 124,
                'country_code' => 'KR',
                'country_name' => 'South Korea',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 125,
                'country_code' => 'KW',
                'country_name' => 'Kuwait',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 126,
                'country_code' => 'KY',
                'country_name' => 'Cayman Islands',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 127,
                'country_code' => 'KZ',
                'country_name' => 'Kazakhstan',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 128,
                'country_code' => 'LA',
                'country_name' => 'Laos',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 129,
                'country_code' => 'LB',
                'country_name' => 'Lebanon',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 130,
                'country_code' => 'LC',
                'country_name' => 'Saint Lucia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 131,
                'country_code' => 'LI',
                'country_name' => 'Liechtenstein',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 132,
                'country_code' => 'LK',
                'country_name' => 'Sri Lanka',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 133,
                'country_code' => 'LR',
                'country_name' => 'Liberia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 134,
                'country_code' => 'LS',
                'country_name' => 'Lesotho',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 135,
                'country_code' => 'LT',
                'country_name' => 'Lithuania',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 136,
                'country_code' => 'LU',
                'country_name' => 'Luxembourg',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 137,
                'country_code' => 'LV',
                'country_name' => 'Latvia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 138,
                'country_code' => 'LY',
                'country_name' => 'Libya',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 139,
                'country_code' => 'MA',
                'country_name' => 'Morocco',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 140,
                'country_code' => 'MC',
                'country_name' => 'Monaco',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 141,
                'country_code' => 'MD',
                'country_name' => 'Moldova',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 142,
                'country_code' => 'ME',
                'country_name' => 'Montenegro',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 143,
                'country_code' => 'MF',
                'country_name' => 'Saint Martin',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 144,
                'country_code' => 'MG',
                'country_name' => 'Madagascar',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 145,
                'country_code' => 'MH',
                'country_name' => 'Marshall Islands',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 146,
                'country_code' => 'MK',
                'country_name' => 'Macedonia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 147,
                'country_code' => 'ML',
                'country_name' => 'Mali',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 148,
                'country_code' => 'MM',
                'country_name' => 'Myanmar',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 149,
                'country_code' => 'MN',
                'country_name' => 'Mongolia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 150,
                'country_code' => 'MO',
                'country_name' => 'Macao',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 151,
                'country_code' => 'MP',
                'country_name' => 'Northern Mariana Islands',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 152,
                'country_code' => 'MQ',
                'country_name' => 'Martinique',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 153,
                'country_code' => 'MR',
                'country_name' => 'Mauritania',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 154,
                'country_code' => 'MS',
                'country_name' => 'Montserrat',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 155,
                'country_code' => 'MT',
                'country_name' => 'Malta',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 156,
                'country_code' => 'MU',
                'country_name' => 'Mauritius',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 157,
                'country_code' => 'MV',
                'country_name' => 'Maldives',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 158,
                'country_code' => 'MW',
                'country_name' => 'Malawi',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 159,
                'country_code' => 'MX',
                'country_name' => 'Mexico',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 160,
                'country_code' => 'MY',
                'country_name' => 'Malaysia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 161,
                'country_code' => 'MZ',
                'country_name' => 'Mozambique',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 162,
                'country_code' => 'NA',
                'country_name' => 'Namibia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 163,
                'country_code' => 'NC',
                'country_name' => 'New Caledonia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 164,
                'country_code' => 'NE',
                'country_name' => 'Niger',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 165,
                'country_code' => 'NF',
                'country_name' => 'Norfolk Island',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 166,
                'country_code' => 'NG',
                'country_name' => 'Nigeria',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 167,
                'country_code' => 'NI',
                'country_name' => 'Nicaragua',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 168,
                'country_code' => 'NL',
                'country_name' => 'Netherlands',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 169,
                'country_code' => 'NO',
                'country_name' => 'Norway',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 170,
                'country_code' => 'NP',
                'country_name' => 'Nepal',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 171,
                'country_code' => 'NR',
                'country_name' => 'Nauru',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 172,
                'country_code' => 'NU',
                'country_name' => 'Niue',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 173,
                'country_code' => 'NZ',
                'country_name' => 'New Zealand',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 174,
                'country_code' => 'OM',
                'country_name' => 'Oman',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 175,
                'country_code' => 'PA',
                'country_name' => 'Panama',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 176,
                'country_code' => 'PE',
                'country_name' => 'Peru',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 177,
                'country_code' => 'PF',
                'country_name' => 'French Polynesia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 178,
                'country_code' => 'PG',
                'country_name' => 'Papua New Guinea',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 179,
                'country_code' => 'PH',
                'country_name' => 'Philippines',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 180,
                'country_code' => 'PK',
                'country_name' => 'Pakistan',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 181,
                'country_code' => 'PL',
                'country_name' => 'Poland',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 182,
                'country_code' => 'PM',
                'country_name' => 'Saint Pierre and Miquelon',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 183,
                'country_code' => 'PN',
                'country_name' => 'Pitcairn',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 184,
                'country_code' => 'PR',
                'country_name' => 'Puerto Rico',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 185,
                'country_code' => 'PS',
                'country_name' => 'Palestinian Territory',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 186,
                'country_code' => 'PT',
                'country_name' => 'Portugal',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 187,
                'country_code' => 'PW',
                'country_name' => 'Palau',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 188,
                'country_code' => 'PY',
                'country_name' => 'Paraguay',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 189,
                'country_code' => 'QA',
                'country_name' => 'Qatar',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 190,
                'country_code' => 'RE',
                'country_name' => 'Reunion',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 191,
                'country_code' => 'RO',
                'country_name' => 'Romania',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 192,
                'country_code' => 'RS',
                'country_name' => 'Serbia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 193,
                'country_code' => 'RU',
                'country_name' => 'Russia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 194,
                'country_code' => 'RW',
                'country_name' => 'Rwanda',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 195,
                'country_code' => 'SA',
                'country_name' => 'Saudi Arabia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 196,
                'country_code' => 'SB',
                'country_name' => 'Solomon Islands',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 197,
                'country_code' => 'SC',
                'country_name' => 'Seychelles',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 198,
                'country_code' => 'SD',
                'country_name' => 'Sudan',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 199,
                'country_code' => 'SE',
                'country_name' => 'Sweden',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 200,
                'country_code' => 'SG',
                'country_name' => 'Singapore',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 201,
                'country_code' => 'SH',
                'country_name' => 'Saint Helena',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 202,
                'country_code' => 'SI',
                'country_name' => 'Slovenia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 203,
                'country_code' => 'SJ',
                'country_name' => 'Svalbard and Jan Mayen',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 204,
                'country_code' => 'SK',
                'country_name' => 'Slovakia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 205,
                'country_code' => 'SL',
                'country_name' => 'Sierra Leone',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 206,
                'country_code' => 'SM',
                'country_name' => 'San Marino',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 207,
                'country_code' => 'SN',
                'country_name' => 'Senegal',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 208,
                'country_code' => 'SO',
                'country_name' => 'Somalia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 209,
                'country_code' => 'SR',
                'country_name' => 'Suriname',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 210,
                'country_code' => 'SS',
                'country_name' => 'South Sudan',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 211,
                'country_code' => 'ST',
                'country_name' => 'Sao Tome and Principe',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 212,
                'country_code' => 'SV',
                'country_name' => 'El Salvador',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 213,
                'country_code' => 'SX',
                'country_name' => 'Sint Maarten',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 214,
                'country_code' => 'SY',
                'country_name' => 'Syria',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 215,
                'country_code' => 'SZ',
                'country_name' => 'Swaziland',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 216,
                'country_code' => 'TC',
                'country_name' => 'Turks and Caicos Islands',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 217,
                'country_code' => 'TD',
                'country_name' => 'Chad',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 218,
                'country_code' => 'TF',
                'country_name' => 'French Southern Territories',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 219,
                'country_code' => 'TG',
                'country_name' => 'Togo',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 220,
                'country_code' => 'TH',
                'country_name' => 'Thailand',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 221,
                'country_code' => 'TJ',
                'country_name' => 'Tajikistan',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 222,
                'country_code' => 'TK',
                'country_name' => 'Tokelau',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 223,
                'country_code' => 'TL',
                'country_name' => 'East Timor',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 224,
                'country_code' => 'TM',
                'country_name' => 'Turkmenistan',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 225,
                'country_code' => 'TN',
                'country_name' => 'Tunisia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 226,
                'country_code' => 'TO',
                'country_name' => 'Tonga',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 227,
                'country_code' => 'TR',
                'country_name' => 'Turkey',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 228,
                'country_code' => 'TT',
                'country_name' => 'Trinidad and Tobago',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 229,
                'country_code' => 'TV',
                'country_name' => 'Tuvalu',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 230,
                'country_code' => 'TW',
                'country_name' => 'Taiwan',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 231,
                'country_code' => 'TZ',
                'country_name' => 'Tanzania',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 232,
                'country_code' => 'UA',
                'country_name' => 'Ukraine',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 233,
                'country_code' => 'UG',
                'country_name' => 'Uganda',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 234,
                'country_code' => 'UM',
                'country_name' => 'United States Minor Outlying Islands',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 235,
                'country_code' => 'US',
                'country_name' => 'United States',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 236,
                'country_code' => 'UY',
                'country_name' => 'Uruguay',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 237,
                'country_code' => 'UZ',
                'country_name' => 'Uzbekistan',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 238,
                'country_code' => 'VA',
                'country_name' => 'Vatican',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 239,
                'country_code' => 'VC',
                'country_name' => 'Saint Vincent and the Grenadines',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 240,
                'country_code' => 'VE',
                'country_name' => 'Venezuela',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 241,
                'country_code' => 'VG',
                'country_name' => 'British Virgin Islands',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 242,
                'country_code' => 'VI',
                'country_name' => 'U.S. Virgin Islands',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 243,
                'country_code' => 'VN',
                'country_name' => 'Vietnam',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 244,
                'country_code' => 'VU',
                'country_name' => 'Vanuatu',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 245,
                'country_code' => 'WF',
                'country_name' => 'Wallis and Futuna',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 246,
                'country_code' => 'WS',
                'country_name' => 'Samoa',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 247,
                'country_code' => 'XK',
                'country_name' => 'Kosovo',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 248,
                'country_code' => 'YE',
                'country_name' => 'Yemen',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 249,
                'country_code' => 'YT',
                'country_name' => 'Mayotte',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 250,
                'country_code' => 'ZA',
                'country_name' => 'South Africa',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 251,
                'country_code' => 'ZM',
                'country_name' => 'Zambia',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],      
            [
                'id' => 252,
                'country_code' => 'ZW',
                'country_name' => 'Zimbabwe',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        ];

        DB::table('countries')->insert($countries);
    }
}
