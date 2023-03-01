@extends('layouts.app')

@section('content')

    <div class="col-xl-12">
        <div class="card-box">
            <div class="dropdown float-right">
                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-dots-vertical"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    <a href="{{ route('companies.create') }}" class="dropdown-item">{{ __('Create Company')  }}</a>
                </div>
            </div>

            <h4 class="header-title mt-0 mb-3">Companies</h4>

            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Created date</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($companies as $company)
                        <tr>
                            <td>{{ $company->id }}</td>
                            <td>{{ $company->title }}</td>
                            <td>{{ $company->slug }}</td>
                            <td>{{ date_format($company->created_at, 'M jS Y') }}</td>
                            <td>{{ $company->description }}</td>
                            <td>
                                <form action="{{ route('companies.destroy', $company->id) }}" method="POST">
                                    <a href="{{ route('companies.show', $company->id) }}" title="View">
                                        <i class="fas fa-eye text-success  fa-lg"></i>
                                    </a>
                                    <a href="{{ route('companies.edit', $company->id) }}" title="Edit">
                                        <i class="fas fa-edit  fa-lg"></i>
                                    </a>
                                    @role('master-admin')
                                    <a href="{{ route('companies.switch_to', $company->id) }}" title="Browse from this company">
                                        <i class="fas fa-sync-alt  fa-lg"></i>
                                    </a>
                                    @endrole
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Delete" style="border: none; background-color:transparent;" class="confirm_delete">
                                        <i class="fas fa-trash fa-lg text-danger"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if(0)
            <div>
                {!! $company->links() !!}
            </div>
            @endif
        </div>
    </div><!-- end col -->
    <script type="text/javascript">
        jQuery(".confirm_delete").click(function(){
            if(confirm("Are you sure want delete this Company? This action cannot be undone.")){
                //console.log('true');
                return true;
            } else {
                //console.log('false');
                return false;
            }
        });
    </script>
@endsection
