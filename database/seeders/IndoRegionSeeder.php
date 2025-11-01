<?php

/*
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

namespace Database\Seeders;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Database\Seeder;

class IndoRegionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $array = [

            'Denpasar' => [
                'Denpasar Barat' => [
                    'Pemecutan',
                    'Pemecutan Kaja',
                    'Padangsambian',
                    'Padangsambian Kaja',
                    'Padangsambian Klod',
                    'Tegal Harum',
                    'Tegal Kertha',
                ],
                'Denpasar Timur' => [
                    'Sumerta',
                    'Sumerta Kelod',
                    'Sumerta Klod',
                    'Kesiman',
                    'Kesiman Kertalangu',
                    'Dangin Puri Kangin',
                ],
                'Denpasar Selatan' => [
                    'Sanur',
                    'Sanur Kauh',
                    'Sanur Kaja',
                    'Sesetan',
                    'Pedungan',
                    'Panjer',
                    'Renon',
                ],
                'Denpasar Utara' => [
                    'Dangin Puri Kaja',
                    'Dangin Puri Kangin',
                    'Dangin Puri Kauh',
                    'Peguyangan',
                    'Peguyangan Kangin',
                    'Tonja',
                    'Ubung',
                    'Ubung Kaja',
                ],
            ],

            'Badung' => [
                'Kuta' => [
                    'Kuta',
                    'Legian',
                    'Seminyak',
                ],
                'Kuta Selatan' => [
                    'Jimbaran',
                    'Ungasan',
                    'Kutuh',
                    'Benoa',
                    'Pecatu',
                ],
                'Kuta Utara' => [
                    'Kerobokan',
                    'Kerobokan Kaja',
                    'Kerobokan Kelod',
                    'Tibubeneng',
                    'Canggu',
                    'Dalung',
                ],
                'Mengwi' => [
                    'Mengwi',
                    'Kapal',
                    'Abianbase',
                    'Buduk',
                    'Gulingan',
                    'Sempidi',
                    'Penarungan',
                    'Baha',
                    'Sading',
                ],
                'Abiansemal' => [
                    'Abiansemal',
                    'Angantaka',
                    'Blahkiuh',
                    'Darmasaba',
                    'Jagapati',
                    'Mambal',
                    'Sibang Gede',
                    'Sibang Kaja',
                ],
                'Petang' => [
                    'Petang',
                    'Belok/Sidan',
                    'Pangsan',
                    'Pelaga',
                    'Sulangai',
                    'Getasan',
                ],
            ],

            'Gianyar' => [
                'Ubud' => [
                    'Ubud',
                    'Sayan',
                    'Mas',
                    'Peliatan',
                    'Lodtunduh',
                    'Kedewatan',
                    'Petulu',
                    'Singakerta',
                ],
            ],

            'Tabanan' => [
                'Tabanan' => [
                    'Dajan Peken',
                    'Dauh Peken',
                    'Delod Peken',
                    'Gubug',
                    'Buahan',
                    'Subamia',
                ],
                'Kediri' => [
                    'Kediri',
                    'Abiantuwung',
                    'Belalang',
                    'Banjar Anyar',
                    'Nyitdah',
                    'Pandak Gede',
                    'Pandak Bandung',
                ],
            ],
        ];


        $province = Province::create(['name' => "Bali"]);

        foreach ($array as $regency => $districts) {
            $regencyId = Regency::create([
                'province_id' => $province->id,
                'name' => $regency,
            ]);

            foreach ($districts as $district => $villages) {
                $districtId = District::create([
                    'regency_id' => $regencyId->id,
                    'name' => $district,
                ]);
                foreach ($villages as $key => $village) {
                    // dd($village);
                    Village::create([
                        'district_id' => $districtId->id,
                        'name' => $village,
                    ]);
                }
            }
        }
    }
}
