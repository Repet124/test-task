<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	use HasFactory;

	public function creator() {
		return $this->belongsTo(User::class, 'creator');
	}
}
