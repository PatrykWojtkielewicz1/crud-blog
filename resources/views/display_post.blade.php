@extends('home')

@section('content')
    <div class="container m-auto">
        <div class="container mx-auto flex flex-wrap py-6 flex justify-center items-center">
            <div class="w-3/5">
                <!-- Shows post content -->
                @if(!empty($post->image))
                    <img class="mx-auto p-4 w-full" src="{{ asset('storage/'.$post->image) }}"/>
                @endif
                <h2 class="text-6xl p-4 text-center">{{ $post->title }}</h2>
                <p class="text-xl">@php echo ($post->description); @endphp</p>
                <p class="text-right">{{ $author }}</p>
                @php
                    $created_at = $post->created_at;
                    $date = $created_at->year."-".$created_at->month."-".$created_at->day;
                @endphp
                <p class="text-right">{{ $date }}</p>
                <!-- Comment section -->
                <div class="container p-4">
                    <p class="text-xl text-center bg-gray-200 p-6 rounded-full">
                        Komentarze
                        @if(!Auth::check())
                            (<a href="{{ route('login') }}" class="underline">Zaloguj się</a> aby dodać komentarz)
                        @endif
                        @foreach ($errors->get('content') as $message)
                            <span class="text-red-600">{{ $message }}</span>
                        @endforeach
                    </p>
                    <!-- If logged in, displays form for submitting a comment -->
                    @if(Auth::check())
                        <form action="{{ route('comment.add') }}" method="post" class="pt-4">
                            @csrf
                            <div class="flex">
                                <input type="text" name="content" placeholder="Twój komentarz" class="w-5/6 inline rounded-l-full"/>
                                <input type="submit" name="submit" value="Dodaj komentarz" class="w-1/6 inline rounded-r-full"/>
                                <input type="hidden" class="hidden" name="post_id" value="{{ $post->id }}"/>
                                <input type="hidden" class="hidden" name="author_id" value="{{ Auth::id() }}"/>
                                <input type="hidden" class="hidden" name="slug" value="{{ $post->slug }}"/>
                            </div>
                        </form>
                    @endif
                    <!-- If admin, displays form for deleting comments -->
                    @if($permission == 'admin')
                        <form action="{{ route('comment.delete') }}" method="POST">
                            @csrf
                    @endif
                    @foreach ($comments->reverse() as $comment)
                        @php
                            $created_at = $comment->created_at;
                            $date = $created_at->year."-".$created_at->month."-".$created_at->day;
                            foreach($users as $user){
                                if($comment->user_id == $user->id){
                                    $username = $user->name;
                                }
                            }
                        @endphp
                        <div class="flex p-4">
                            <div class="w-4/6">
                                <p class="capitalize font-bold">{{ $username }}</p>
                                <p class="w-full break-words">{{ $comment->content }}</p>
                            </div>
                            @if($permission == 'admin')
                                <div class="w-1/6 text-right">{{ $date }}</div>
                                <div class="w-1/6 text-right">
                                    <input type="checkbox" name="delete[]" value="{{ $comment->id }}"/>
                                </div>
                            @else
                                <div class="w-2/6 text-right">{{ $date }}</div>
                            @endif
                        </div>
                        <hr/>
                    @endforeach
                    @if($permission == 'admin')
                        <input type="hidden" class="hidden" name="slug" value="{{ $post->slug }}"/>
                        <input class="float-right p-2 my-2 rounded-full" type="submit" name="submit" value="Usuń komentarz"/>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection