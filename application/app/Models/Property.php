<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
	use HasFactory;
	
	protected $table = 'property';
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'address',
        'owner_id',
        'user_id',
		'email_address',
		'start_date',
		'nif',
		'status',
    ];
	
	
	/**
     * Relationship for property and owner
     */
    public function owner(){
        return $this->belongsTo('App\Models\User','owner_id');
	}
	
	
	public function chat(){
		return $this->hasMany('App\Models\Chat','property_id','id');
	}
	
	public function transaction(){
        return $this->hasMany('App\Models\Transaction','property_id','id');
	}
	
 	public function propertyDocuments(){
        return $this->hasMany('App\Models\PropertyDocument','property_id','id');
	} 
	
 	public function propertyGallery(){
        return $this->hasMany('App\Models\PropertyGallery','property_id','id');
	} 
	
 	public function propertyMeta(){
        return $this->belongsTo('App\Models\PropertyMeta','id','property_id');
	} 
}