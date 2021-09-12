<?php

namespace App\Jobs;

use App\Http\Services\RiotService;
use App\Models\Summoner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class FetchSummonerMatchData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $riotService = new RiotService();
        $summoners = Summoner::online()
            ->inMatch()
            ->onFacebook()
            ->select(['id', 'summoner_name', 'summoner_id'])
            ->get();

        Log::info($summoners->pluck('name'));
        $summoners->each(function (Summoner $summoner) use ($riotService) {
            sleep(1);
            if (!$summoner->summoner_id) {
                return true;
            }

            $response = $riotService->getMatchInfo($summoner->summoner_id);

            if ($response) {
                $summoner->update([
                    'in_match' => true
                ]);
            } else {
                $summoner->update([
                    'in_match' => false
                ]);
            }
        });
    }
}
