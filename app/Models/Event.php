<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	use HasFactory;

	public function creator() {
		return $this->belongsTo(User::class, 'creator_id');
	}

	public function members() {
		return $this->belongsToMany(User::class, 'event_member', 'event_id', 'member_id');
	}
}
