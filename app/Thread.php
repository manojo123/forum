<?php

namespace App;

use App\Channel;
use App\Reply;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

    use RecordsActivity;

    protected $guarded = [];
    protected $with = ['creator', 'channel'];
	protected $withCount = ['replies'];

    protected static function boot(){
        parent::boot();

        static::deleting(function($thread){
            $thread->replies->each(function($reply){
                $reply->delete();
            });
        });
    }

    public function path($route=""){
    	return url('/threads/'.$this->channel->slug."/".$this->id.$route);
    }

    public function replies(){
    	return $this->hasMany(Reply::class);
    }

    public function creator(){
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function channel(){
        return $this->belongsTo(Channel::class);
    }

    public function addReply($reply){
    	return $this->replies()->create($reply);
    }

    public function scopeFilter($query, $filters){
        return $filters->apply($query);
    }

}
