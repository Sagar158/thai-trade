@php
    $route = (!isset($user->id) ? route('users.store') : route('users.update',$user->id));
@endphp
<x-app-layout title="{{ $title }}">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <x-page-heading title="{{ __('Create / Update Users') }}"></x-page-heading>
        <x-back-button></x-back-button>

        <div class="container-fluid mt-3">
            <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
                {{ @csrf_field() }}
                <div class="card">
                    <div class="row card-body">
                        <div class="col-lg-4 col-sm-12 col-md-4">
                            <x-text-input id="name" type="text" name="name" :value="old('name', $user->name)" autofocus autocomplete="off" placeholder="User Name" />
                        </div>

                        <div class="col-lg-4 col-sm-12 col-md-4">
                            <x-text-input id="email" type="email" name="email" :value="old('email', $user->email)" autofocus autocomplete="off" placeholder="Email" />
                        </div>
                        <div class="col-lg-4 col-sm-12 col-md-4">
                            <x-text-input id="password" type="password" name="password" autofocus autocomplete="off" placeholder="Password" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12 mt-2">
                        <x-primary-button class="btn btn-primary">
                            {{ __('Save') }}
                        </x-primary-button>
                        <x-back-button></x-back-button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
