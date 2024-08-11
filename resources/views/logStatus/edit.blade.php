@php
    $route = (!isset($logStatus->id) ? route('logStatus.store') : route('logStatus.update',$logStatus->id));
@endphp
<x-app-layout title="{{ $title }}">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <x-page-heading title="{{ __('Create / Update Log Status') }}"></x-page-heading>
        <x-back-button></x-back-button>

        <div class="container-fluid mt-3">
            <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
                {{ @csrf_field() }}
                <div class="card">
                    <div class="row card-body">
                        <div class="col-lg-4 col-sm-12 col-md-4">
                            <x-text-input id="name" type="text" name="name" :value="old('name', $logStatus->name)" autofocus autocomplete="off" placeholder="Name" />
                        </div>

                        <div class="col-lg-4 col-sm-12 col-md-4">
                            <x-text-input id="description" type="text" name="description" :value="old('description', $logStatus->description)" autofocus autocomplete="off" placeholder="Description" />
                        </div>
                        <div class="col-lg-4 col-sm-12 col-md-4">
                            <x-text-input id="hours" type="number" name="hours" :value="old('hours', $logStatus->hours)" autofocus autocomplete="off" placeholder="hours" />
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
