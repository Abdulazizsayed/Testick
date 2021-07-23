@extends('layouts.app')

@section('content')
<div class="container edit-profile pt-3 pb-3">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <form class="edit-profile-form" action="{{--route("users.updateProfile")--}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="edit-profile-img text-center">
            <img class="rounded-circle border border-primary" src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image->url) : asset('images/users/default.jpg') }}" width="300px" height="300px" alt="User photo">
            <input type="file" class="form-control-file edit-profile-input" id="profile-image" name="image" hidden>
            <i class="fa fa-pencil select-image"></i>
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" value="{{auth()->user()->name}}" minlength="2" maxlength="30" required>
                @error('name')
                    <strong class="text-danger">{{ $message }}</strong>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" name="email" value="{{auth()->user()->email}}" disabled>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password" placeholder="Password" minlength="8" maxlength="50">
                @error('password')
                    <strong class="text-danger">{{ $message }}</strong>
                @enderror
            </div>
        </div>
        <div class="form-group row justify-content-end">
            <div class="col-sm-10">
                <input type="submit" class="form-control btn btn-success" value="Edit">
            </div>
        </div>
    </form>
</div>
@endsection
