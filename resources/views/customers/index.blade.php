<x-app-layout title="{{ $title }}">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <x-page-heading title="{{ __('Customers') }}"></x-page-heading>
        <x-right-side-button link="{{ route('customers.create') }}" title="Create"></x-right-side-button>
        <x-alert></x-alert>
        <div class="container-fluid card mt-3">
            <div class="row card-body">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <div class="table-responsive">
                        <table id="dataTable" class="table">
                          <thead>
                            <tr>
                                <th>Name</th>
                                <th>MAITOU</th>
                                <th>CS DID</th>
                                <th>Address</th>
                                <th>Preferred WULIU</th>
                                <th>Google Map URL</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>

                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable({
                    "pageLength": 50,
                    "lengthMenu": [[50, 100, 150, 200, -1], [50, 100, 150, 200, "All"]],
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route("customers.getCustomersData") }}',
                    columns: [
                        { data: 'name', name: 'name' },
                        { data: 'MAITOU', name: 'MAITOU' },
                        { data: 'CS', name: 'CS' },
                        { data: 'address', name: 'address' },
                        { data: 'Preferred_WULIU', name: 'Preferred_WULIU' },
                        { data: 'GOOGLE_MAP', name: 'GOOGLE_MAP' },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ]
                });
            });
        </script>
    @endpush
</x-app-layout>
