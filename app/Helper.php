<?php

namespace App;

class Helper {

    protected $cpanel;

    function __construct() {
        $this->cpanel = new \Gufy\CpanelPhp\Cpanel([
            'host'        =>  env('CPANEL_URL'), // required
            'username'    =>  env('CPANEL_USER'), // required
            'auth_type'   =>  'password', // optional, default 'hash'
            'password'    =>  env('CPANEL_PASS'), // required
        ]);
    }

    public function lookup_zone($domain) {
        $line = null;
        $zone_records = $this->cpanel->cpanel('ZoneEdit', 'fetchzone_records', env('CPANEL_USER'), ['domain'=>env('CPANEL_DOMAIN')]);
        $zone_records = json_decode($zone_records);
        foreach($zone_records->cpanelresult->data as $record) {
            if(isset($record->name)) {
                if($record->name == $domain.".".env('CPANEL_DOMAIN')."." && $record->type == 'A') {
                    $line = $record->line;
                }
            }
        }
        return $line;
    }

    public function delete_record($line) {
        $content = [
            'domain' => env('CPANEL_DOMAIN'),
            'line' => $line
        ];
        $data = $this->cpanel->cpanel('ZoneEdit', 'remove_zone_record', env('CPANEL_USER'), $content);
        $data = json_decode($data);
        return $data;
    }

    public function add_record($name,$ip) {
        $line = $this->lookup_zone($name);
        if($line != null) {
            return null;
        }
        $content = [
            'domain' => env('CPANEL_DOMAIN'),
            'name' => $name,
            'type' => 'A',
            'address' => $ip,
            'ttl' => env('CPANEL_TTL'),
            'class' => 'IN',
        ];
        $data = $this->cpanel->cpanel('ZoneEdit', 'add_zone_record', env('CPANEL_USER'), $content);
        $data = json_decode($data);
        return $data;
    }
    public function edit_record($line = null,$domain,$ip) {

        if ($line != null) {
            $content = [
                'line'=>$line,
                'domain' => env('CPANEL_DOMAIN'),
                'name' => $domain,
                'type' => 'A',
                'address' => $ip,
                'ttl' => env('CPANEL_TTL'),
                'class' => 'IN',
            ];
            $zone_records = $this->cpanel->cpanel('ZoneEdit', 'edit_zone_record', env('CPANEL_USER'), $content);
            $status = 'Updated zone entry!';
        }
        else {
            $content = [
                'domain' => env('CPANEL_DOMAIN'),
                'name' => $domain,
                'type' => 'A',
                'address' => $ip,
                'ttl' => env('CPANEL_TTL'),
                'class' => 'IN',
            ];

            $data = $this->cpanel->cpanel('ZoneEdit', 'add_zone_record', env('CPANEL_USER'), $content);
            $status = 'Could not find zone record, added new one!';
        }

    }
}
