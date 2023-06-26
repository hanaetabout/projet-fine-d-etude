<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
	use HasFactory;
	
	protected $table = 'chat';
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'property_id',
        'user_id',
        'text',
		'media'
    ];
	
	
	/**
     * Relationship for property and owner
     */
    public function owner(){
        return $this->belongsTo('App\Models\User','user_id');
	}
}