<?php

namespace App\Console\Commands;

use App\Models\Character;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GetCharacterList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getCharacterList';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets a list of all of the SWGOH charcters (including ships)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = Http::asForm()->post('https://api.swgoh.help/auth/signin/', [
            'username' => env('SWGOH_API_USERNAME', 'oops'),
            'password' => env('SWGOH_API_PASSWORD', 'oops'),
            'grant_type' => 'password',
            'client_id' => 'ICanBeWhateverIWant',
            'client_secret' => 'ABC' . time(),
        ]);
        $bearer = $response->json()['access_token'];

//        $bearer ="18579063a95bf941cfb155d37bcd8a60cc9c18b5";
        $response = Http::withHeaders([
            "method" => "post",
            "content-type" => "application/json",
            'authorization' => "Bearer " . $bearer,
        ])->asJson()->post('https://api.swgoh.help/swgoh/data/', [
            'collection' => "unitsList",
            'language' => 'eng_us',
            'enums' => true,
            'match' => [
                'rarity' => 7,
                'obtainable' => true,
                'obtainableTime' => 0,
            ],
        ]);
        $newToons = $response->json();
        $currentToons = Character::all()->keyBy('swgoh_api_id');
        foreach ($newToons as $toon) {
            if (isset($currentToons[$toon['baseId']])) continue;
            Log::info(date('Y-m-d h:i:s', time()) . "Adding Toon: " . $this->buildName($toon) . PHP_EOL);
            Character::create([
                'name' => $this->buildName($toon),
                'swgoh_api_id' => $toon['baseId'],
                'force_alignment' => $toon['forceAlignment'],
                'category_id_list' => json_encode($toon['categoryIdList']),
                'combat_type' => $toon['combatType'],
                'all_info_dump' => json_encode($toon),
            ]);
        }
        return 0;
    }

    private function buildName($toon) {
        if ($toon['baseId'] == 'CHEWBACCA') {
            $toon['nameKey'] .= ' (Clone Wars)';
        }
        return $toon['nameKey'];
    }
}
