<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Population;
use Illuminate\Support\Facades\Http;

class PopulationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'population:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create population command';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = Http::get('https://datausa.io/api/data?drilldowns=Nation&measures=Population');
        foreach($response->json('data') as $data){
            $population = Population::query()->updateOrCreate([
                'id_nation'     => $data['ID Nation'],
                'nation'        => $data['Nation'],
                'id_year'       => $data['ID Year'],
                'year'          => $data['Year'],
                'population'    => $data['Population'],
                'slug_nation'   => $data['Slug Nation'],
            ]);
            $population->save();
        }

        if($response){
            $this->info('DB updated');
            return true;
        }else{
            $this->warn('No data');
            return false;
        }
    }
}
