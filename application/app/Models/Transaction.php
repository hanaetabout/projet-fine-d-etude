<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	use HasFactory;
	
	protected $table = 'transaction';
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'property_id',
        'user_id',
        'year',
		'month',
		'price',
		'document',
		'condominium',
		'other',
		'type',
		
    ];
	
	
	/**
     * Relationship for property and owner
     */
     public function transaction(){
        return $this->belongsTo('App\Models\Property','id');
	} 
	
	
}