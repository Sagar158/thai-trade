@php
    $route = (!isset($customer->id) ? route('customers.store') : route('customers.update',$customer->id));
@endphp
<x-app-layout title="{{ $title }}">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <x-page-heading title="{{ __('Create / Update Customer') }}"></x-page-heading>
        <x-back-button></x-back-button>

        <div class="container-fluid mt-3">
            <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
                {{ @csrf_field() }}
                <div class="card">
                    <div class="row card-body">
                        <div class="col-lg-4 col-sm-12 col-md-4">
                            <x-text-input id="name" type="text" name="name" :value="old('name', $customer->name)" autofocus autocomplete="off" placeholder="Customer Name" />
                        </div>
                        {{-- <div class="col-lg-4 col-sm-12 col-md-4">
                            <x-text-input id="name" type="text" name="name" :value="old('name', $customer->name)" autofocus autocomplete="off" placeholder="Customer Name" />
                        </div> --}}
                        <div class="col-lg-4 col-sm-12 col-md-4">
                            <x-text-input id="MAITOU" type="text" name="MAITOU" :value="old('MAITOU', $customer->MAITOU)" autofocus autocomplete="off" placeholder="MAITOU" />
                        </div>
                        <div class="col-lg-4 col-sm-12 col-md-4">
                            <x-text-input id="CS" type="text" name="CS" :value="old('CS', $customer->CS)" autofocus autocomplete="off" placeholder="CS DID" />
                        </div>
                        {{-- <div class="col-lg-4 col-sm-12 col-md-4">
                            <x-text-input id="DID" type="text" name="DID" :value="old('DID', $customer->DID)" autofocus autocomplete="off" placeholder="DID" />
                        </div> --}}
                        <div class="col-lg-4 col-sm-12 col-md-4">
                            <x-text-input id="address" type="text" name="address" :value="old('address', $customer->address)" autofocus autocomplete="off" placeholder="Address" />
                        </div>
                        <div class="col-lg-4 col-sm-12 col-md-4">
                            <x-text-input id="sub_district" type="text" name="sub_district" :value="old('sub_district', $customer->sub_district)" autofocus autocomplete="off" placeholder="Sub District" />
                        </div>
                        <div class="col-lg-4 col-sm-12 col-md-4">
                            <x-text-input id="district" type="text" name="district" :value="old('district', $customer->district)" autofocus autocomplete="off" placeholder="District" />
                        </div>
                        <div class="col-lg-4 col-sm-12 col-md-4">
                            <x-text-input id="state" type="text" name="state" :value="old('state', $customer->state)" autofocus autocomplete="off" placeholder="State" />
                        </div>
                        <div class="col-lg-4 col-sm-12 col-md-4">
                            <x-text-input id="post_code" type="text" name="post_code" :value="old('post_code', $customer->post_code)" autofocus autocomplete="off" placeholder="Post Code" />
                        </div>
                        <div class="col-lg-4 col-sm-12 col-md-4">
                            <x-text-input id="telephone1" type="text" name="telephone1" :value="old('telephone1', $customer->telephone1)" autofocus autocomplete="off" placeholder="Telephone #1" />
                        </div>
                        <div class="col-lg-4 col-sm-12 col-md-4">
                            <x-text-input id="telephone2" type="text" name="telephone2" :value="old('telephone2', $customer->telephone2)" autofocus autocomplete="off" placeholder="Telephone #2" />
                        </div>
                        {{-- <div class="col-lg-4 col-sm-12 col-md-4">
                            <x-text-input id="telephone3" type="text" name="telephone3" :value="old('telephone3', $customer->telephone3)" autofocus autocomplete="off" placeholder="Telephone #3" />
                        </div> --}}
                        <div class="col-lg-4 col-sm-12 col-md-4">
                            <x-text-input id="Preferred_WULIU" type="text" name="Preferred_WULIU" :value="old('Preferred_WULIU', $customer->Preferred_WULIU)" autofocus autocomplete="off" placeholder="Preferred WULIU" />
                        </div>
                        <div class="col-lg-4 col-sm-12 col-md-4">
                            <x-text-input id="GOOGLE_MAP" type="text" name="GOOGLE_MAP" :value="old('GOOGLE_MAP', $customer->GOOGLE_MAP)" autofocus autocomplete="off" placeholder="GOOGLE MAP URL" />
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
