<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyMeta extends Model
{
	use HasFactory;
	
	protected $table = 'property_meta';
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'property_id',
        'floor',
        'apartment_number',
        'user_id',
		'email',
		'phone',
    ];
	
	
	/**
     * Relationship for property doc and owner
     */
    public function owner(){
        return $this->belongsTo('App\Models\User','user_id');
	}
	
}