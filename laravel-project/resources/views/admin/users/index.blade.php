@extends('admin.layouts.app')

@section('title')
Users
@endsection

@section('content')
<div class="row">
    @include('admin.layouts.sidebar')
    <div class="col-md-9">
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h3 class="mt-2">
                        Users({{ $users->count() }})
                    </h3>

                </div>
                <hr>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Profile Image</th>
                                <th>Registred</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                            <tr>
                                <td>{{ $key += 1 }}</td>
                                <td>
                                    {{ $user->name }}
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    <img src="{{ $user->image_path }}" alt="{{ $user->name }}" class="rounded"
                                        width="60" height="60" srcset="">
                                </td>
                                <!-- User สมัครมาแล้วกี่วัน -->
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                                <!-- User สมัครมาแล้วกี่วัน -->
                                <td class="d-flex">
                                    <a href="javascript:void(0);" onclick="deleteItem('{{ $user->id }}')"
                                        class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <form id="{{$user->id}}" action="{{route('admin.users.delete',$user->id)}}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection