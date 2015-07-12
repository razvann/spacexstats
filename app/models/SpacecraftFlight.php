<?php
class SpacecraftFlight extends Eloquent {
    protected $table = 'spacecraft_flights_pivot';
    protected $primaryKey = 'spacecraft_flight_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    public function mission() {
        return $this->belongsTo('Mission');
    }

    public function spacecraft() {
        return $this->belongsTo('Spacecraft');
    }

    public function astronauts() {
        return $this->belongsToMany('Astronaut', 'astronauts_flights_pivot');
    }
}