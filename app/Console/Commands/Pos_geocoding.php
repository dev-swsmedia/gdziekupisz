<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pos;
use Illuminate\Database\Eloquent\Collection;
use App\Library\GeoCoding;

class Pos_geocoding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pos:geocoding';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Geocode POS addresses';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Pos::where('id', '>', 280)->chunk(100, function(Collection $pos) {
            foreach($pos as $p) {
                $geo = GeoCoding::geocode($p->street, $p->city);

                if(is_array($geo) && isset($geo[0])) {
                    Pos::find($p->id)->update([
                       'lat' => $geo[0]->lat,
                       'lng' => $geo[0]->lon
                    ]);
                    
                    $this->info('Updated: '.$p->city.', '.$p->street.' with LAT='.$geo[0]->lat.', LNG='.$geo[0]->lon);
                } else {
                    $geo = (is_array($geo)) ? 'arr' : $geo;
                    $this->error('Error during updating: '.$p->city.', '.$p->street.' ['.$geo.']');
                    
                }
                
                sleep(1);
            }
        });
    }
}
