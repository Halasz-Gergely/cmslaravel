@extends('layouts.app')
@section('content')
    <div class="d-flex justify-content-end mb-2">
        <a class="btn btn-success" href="{{ route('posts.create') }}">Add Posts</a>
    </div>
    <div class="card card-default">
        <div class="card-header">
            Posts
        </div>
        <div class="card-body">
        @if($posts->count() > 0)
            <table class="table">
                    <thead>
                    <th>Image</th>
                    <th>Title</th>
                    <th></th>
                    <th></th>
                    </thead>
                    <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td><img src="{{ asset('storage/'.$post->image) }}" alt="image" width="80px" height="60px"></td>
                            <td>{{ $post->title }}</td>
                            @if(!$post->trashed())
                                <td>
                                    <a href="" class="btn btn-info btn-sm float-right">Edit</a>
                                </td>
                            @endif
                            <td>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm ml-2 float-left">{{ $post->trashed() ? 'Delete' : 'Trash' }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
        @else
            <h3 class="text-center">No Posts Yet</h3>
        @endif
        </div>
    </div>
@endsection
