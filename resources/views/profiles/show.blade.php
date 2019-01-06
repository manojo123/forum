@extends('layouts.app')

@section('content')
<div class="container">
	<div class="col-sm-8 offset-2">
		<div class="page-header">
			<h1>
				{{ $profileUser->name }}
			</h1>
		</div>

		@forelse($activities as $date => $activity)
			<h3 class="page-header">{{ $date }}</h3>
				
			@foreach($activity as $record)
				@if(view()->exists("profiles.activities.{$record->type}"))
					@include("profiles.activities.{$record->type}", ['activity' => $record])
				@endif
			@endforeach
		@empty
			<p>There is no activity for this user yet.</p>
		@endforelse

	</div>
</div>
@endsection