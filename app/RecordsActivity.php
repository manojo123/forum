<?php

namespace App;

trait RecordsActivity
{
	protected static function bootRecordsActivity(){
		if(auth()->guest()) return;
		foreach (static::getActivitiesToRecord() as $event) {
			static::$event(function($model) use ($event){
				$model->recordActivity($event);
			});
		}

		static::deleting(function($model){
			$model->activity()->delete();
		});

	}


	protected static function getActivitiesToRecord(){
		return ['created'];
	}

	protected function recordActivity($event){
		$this->activity()->create([
			'type' => $this->getActivityType($event),
			'user_id' => auth()->id(),
		]);

	    /*Activity::create([
	        'type' => $this->getActivityType($event),
	        'user_id' => auth()->id(),
	        'subject_id' => $this->id,
	        'subject_type'=> get_class($this)
	    ]);*/
	}

	protected function getActivityType($event){
		$type = strtolower(class_basename($this));
		return "{$event}_{$type}";
	}

	public function activity(){
		return $this->MorphMany('App\Activity', 'subject');
	}
}

?>