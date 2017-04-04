<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/
use App\Meeting;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('build', function(){
    $presentation_dir = storage_path()."/app/presentation";
    if ($handle = opendir($presentation_dir)) {
      while (false !== ($entry = readdir($handle))) {
        if(preg_match('/.+-\\d+/us', $entry)){
            $metadata = sprintf("%s/%s/%s", $presentation_dir, $entry, "metadata.xml");
            $xml = new \SimpleXMLElement(file_get_contents($metadata));
            var_dump((String)$xml->meta->meetingId);
            Meeting::updateOrCreate(
                ['internalid' => (String)$xml->id],
                [
                'internalid' => (String)$xml->id,
                'start_time' => Carbon::createFromTimestamp((String)$xml->start_time/1000),
                'end_time' => Carbon::createFromTimestamp((String)$xml->end_time/1000),
                'meetingId'=> (String)$xml->meta->meetingId,
                'meetingName'=>(String)$xml->meta->meetingName
                ]
                );

            echo $metadata."\n";
        }
    }

    }
})->describe('update meetings table');
