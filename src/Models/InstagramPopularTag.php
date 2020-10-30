<?php

namespace Bendt\Instagram\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class InstagramPopularTag extends Model
{
    protected $table = 'instagram_popular_tag';
    protected $guarded = [];
}
