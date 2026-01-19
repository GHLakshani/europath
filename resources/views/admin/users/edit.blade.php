@extends('layouts.master')

@section('title', 'Update User')

@section('content')
<!-- the #js-page-content id is needed for some plugins to initialize -->
<main id="js-page-content" role="main" class="page-content">

    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-chart-area'></i> Update User <span class='fw-300'></span>
        </h1>

        <div class="row" style="margin-left:auto; margin-right:auto; gap: 12px">
            <a href=" {{ route('create-users') }}">
            <button type="button" class="btn btn-lg btn-primary">
                <span class="fal fa-plus mr-1"></span>
                Add New
            </button>
            </a>
            <a href=" {{ route('users-list') }}">
            <button type="button" class="btn btn-lg btn-primary">
                <span class="fal fa-list mr-1"></span>
                View All
            </button>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        {{-- Update <span class="fw-300"><i>user</i></span> --}}
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">

                        <form action="{{ route('save-user',$user->id) }}" enctype="multipart/form-data" method="post" id="user-form" class="smart-form row" autocomplete="off" data-parsley-validate>
                            @csrf
                            @method('put')
                            <div class="col-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="example-email-2">Name</label>
                                    <input type="text" id="name" name="name" @if(isset($user->name)) value="{{$user->name}}" @endif class="form-control" required>
                                    <div class="invalid-feedback">Name is required, you missed this one.</div>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="example-email-2">Email</label>
                                    <input type="email" id="email" name="email" @if(isset($user->email)) value="{{$user->email}}" @endif class="form-control" required>
                                    <div class="invalid-feedback">Email is required, you missed this one.</div>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="example-email-2">Password</label>
                                    <input type="text" id="password" name="password" class="form-control" >
                                    <div class="invalid-feedback">Password is required, you missed this one.</div>
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="example-email-2">Confirm Password</label>
                                    <input type="text" id="confirm-password" name="confirm-password" class="form-control" >
                                    <div class="invalid-feedback">Confirm Password is required, you missed this one.</div>
                                    @error('confirm-password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-6 mb-3">
                                <label class="form-label" for="roles">Roles</label>
                                <select class="form-control select2"  id="roles" name="roles[]" required>
                                    <option value="" disabled>Select Roles</option> {{-- Remove the selected logic here --}}
                                    @if(count($roles)) {{-- Check if $roles array is not empty --}}
                                        @foreach($roles as $key => $value)
                                            <option 
                                                value="{{ $key }}" 
                                                {{ collect(old('roles'))->contains($key) ? 'selected' : '' }} 
                                                {{ isset($user) && $user->roles->pluck('name')->contains($key) ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback">Roles is required, you missed this one.</div>
                                @error('roles')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <input type="hidden" id="id" name="id" value="{{ $user->id }}">
                                                        
                            <div class="col-12">
                                <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row">
                                    <button id="js-submit-btn" class="btn btn-primary ml-auto" type="submit">Submit form</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@stop
@section('footerScript')
    <script>
           $("#js-submit-btn").click(function(event) {

                // Fetch form to apply custom Bootstrap validation
                var form = $("#user-form")

                if (form[0].checkValidity() === false) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.addClass('was-validated');
                // Perform ajax submit here...
            });
    </script>
@stop
