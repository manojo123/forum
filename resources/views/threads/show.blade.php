@extends('layouts.app')

@section('content')
<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <span class="flex">
                                <a href="{{ url('profiles/'.$thread->creator->name) }}">
                                    {{ $thread->creator->name }}
                                </a> posted: {{ $thread->title }}
                            </span>
                            
                            @can('update', $thread)
                            <form method="POST" action="{{ $thread->path() }}">
                                
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                
                                <button type="submit" class="btn btn-link">Delete Thread</button>
                                
                            </form>
                            @endcan
                        </div>
                    </div>  

                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        <p class="text-justify">{{ $thread->body }}</p>
                    </div>
                </div>

                <replies :data="{{ $thread->replies }}" @removed="repliesCount--"></replies>

                {{-- {{ $replies->links() }} --}}

                @if(auth()->check())
                <form method="POST" action="{{ $thread->path('/replies') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <textarea id="body" name="body" placeholder="Have something to say?" rows="5" class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn btn-default">Post</button>
                </form>
                @else
                <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
                @endif

            </div>

            <div class="col-md-4">
                <div class="card">

                    <div class="card-body">
                        This thread was published {{ $thread->created_at->diffForHumans() }} by
                        <a href="#">{{ $thread->creator->name }}</a> and currently has <span v-text="repliesCount"></span> {{ str_plural('comment', $thread->replies_count) }}.
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>  
@endsection