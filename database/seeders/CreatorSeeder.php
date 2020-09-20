<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('creators')->insert([
            ['name' => 'Black Mamba', 'url' => 'https://www.youtube.com/channel/UCKZ3NfW9rdr1iUhGNkkG1dg', 'notes' => 'https://swgoh.gg/p/363964994/'],
            ['name' => 'Endall Beall', 'url' => 'https://www.youtube.com/channel/UCuAyEJ2W0V0dfd5R_aNNRCA', 'notes' => ''],
            ['name' => 'Kiaowe', 'url' => 'https://www.youtube.com/channel/UCh_hFsz16WTSXtjXtioIM2A', 'notes' => ''],
            ['name' => 'Indigo SWGOH', 'url' => 'https://www.youtube.com/channel/UCZM4JUHPyrrGEt9rM4D-88g', 'notes' => ''],
            ['name' => 'AhnaldT101', 'url' => 'https://www.youtube.com/channel/UCuKkFu9WVxCRoj2EbWzIj3Q', 'notes' => ''],
            ['name' => 'Its Just Ian', 'url' => 'https://www.youtube.com/channel/UCVhBzQvutgjT-7GF2wvw_KQ', 'notes' => ''],
            ['name' => 'Skelturix', 'url' => 'https://www.youtube.com/channel/UCoDneAJWwL2Rmh5RnptiROg', 'notes' => ''],
            ['name' => 'DBofficial125', 'url' => 'https://www.youtube.com/channel/UCE3OkPN3ATRf8HY9pkezj0w', 'notes' => 'A lot of videos are on twitch'],
            ['name' => "Dylarr's Twi'Lek Tactics", 'url' => 'https://www.youtube.com/channel/UCCALGSkmBWF3BkLK0fYqKkg', 'notes' => ''],
//            ['name' => '', 'url' => '', 'notes' => ''],
            ['name' => 'Wiggensbog', 'url' => 'https://www.youtube.com/channel/UCvR-kW2Ns3GCCfosvAxqnig', 'notes' => ''],

        ]);
    }
}
