@php
    $configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')

@section('title', __('site.users_list'))
@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}"/>
@endsection
@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
@endsection

@section('page-script')
        <script src="{{asset('assets/js/app-user-list.js')}}"></script>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-datatable table-responsive">
            <div class="row me-2">
                <div class="col-md-12 p-3">
                    <button class="dt-button add-new btn btn-primary" tabindex="0" aria-controls="DataTables_Table_0"
                            type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser"><span>
                            <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                            <span class="d-none d-sm-inline-block">{{__('site.add_user')}}</span>
                        </span>
                    </button>
                </div>
            </div>
            <table class="datatables-users table border-top">
                <thead>
                <tr>
                    <th>{{__('site.name')}}</th>
                    <th>{{__('site.status')}}</th>
                    <th>{{__('site.actions')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr class="odd">
                        <td class="sorting_1">
                            <div class="d-flex justify-content-start align-items-center user-name">
                                <div class="avatar-wrapper">
                                    <div class="avatar me-3">
                                        @if($user->image)
                                            <img src="{{$user->image}}" alt="Avatar" class="rounded-circle">
                                        @else
                                            <img src="/assets/img/avatars/3.png" alt="Avatar" class="rounded-circle">
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <a href="users/{{$user->id}}/edit"
                                       class="text-body text-truncate">
                                        <span class="fw-medium">{{$user->name}}</span>
                                    </a>
                                    <small class="text-muted">{{$user->email}}</small>
                                </div>
                            </div>
                        </td>

                        <td><span class="badge bg-label-success" text-capitalized="">Active</span></td>

                        <td>
                            <div class="d-flex align-items-center">
                                <a href="users/{{$user->id}}/edit" class="text-body">
                                    <i class="ti ti-edit ti-sm me-2"></i>
                                </a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button style="border: none;background: inherit;" type="submit" class="text-body delete-record" onclick="return confirm('{{__('site.are')}}')">
                                        <i class="ti ti-trash ti-sm mx-2"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
        <!-- Offcanvas to add new user -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser"
             aria-labelledby="offcanvasAddUserLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasAddUserLabel" class="offcanvas-title">{{__('site.add_user')}}</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
                <form class="add-new-user pt-0" id="addNewUserForm" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="add-user-fullname">{{__('site.full_name')}}</label>
                        <input type="text" class="form-control" id="add-user-fullname" required placeholder="John Doe"
                               name="name" aria-label="John Doe"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-user-email">Email</label>
                        <input type="text" id="add-user-email" class="form-control" placeholder="john.doe@example.com"
                               aria-label="john.doe@example.com" name="userEmail"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-user-contact">{{__('site.phone')}}</label>
                        <input type="text" id="add-user-contact" class="form-control phone-mask"
                               required
                               placeholder="+1 (609) 988-44-11" aria-label="john.doe@example.com" name="phone"/>
                    </div>
                    {{--
                                        <div class="mb-3">
                                            <label class="form-label" for="add-user-company">Company</label>
                                            <input type="text" id="add-user-company" class="form-control" placeholder="Web Developer"
                                                   aria-label="jdoe1" name="companyName"/>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="country">Country</label>
                                            <select id="country" class="select2 form-select">
                                                <option value="">Select</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="Canada">Canada</option>
                                                <option value="China">China</option>
                                                <option value="France">France</option>
                                                <option value="Germany">Germany</option>
                                                <option value="India">India</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="Israel">Israel</option>
                                                <option value="Italy">Italy</option>
                                                <option value="Japan">Japan</option>
                                                <option value="Korea">Korea, Republic of</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Philippines">Philippines</option>
                                                <option value="Russia">Russian Federation</option>
                                                <option value="South Africa">South Africa</option>
                                                <option value="Thailand">Thailand</option>
                                                <option value="Turkey">Turkey</option>
                                                <option value="Ukraine">Ukraine</option>
                                                <option value="United Arab Emirates">United Arab Emirates</option>
                                                <option value="United Kingdom">United Kingdom</option>
                                                <option value="United States">United States</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="user-role">User Role</label>
                                            <select id="user-role" class="form-select">
                                                <option value="subscriber">Subscriber</option>
                                                <option value="editor">Editor</option>
                                                <option value="maintainer">Maintainer</option>
                                                <option value="author">Author</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label" for="user-plan">Select Plan</label>
                                            <select id="user-plan" class="form-select">
                                                <option value="basic">Basic</option>
                                                <option value="enterprise">Enterprise</option>
                                                <option value="company">Company</option>
                                                <option value="team">Team</option>
                                            </select>
                                        </div>
                                      --}}
                    <button type="submit"
                            class="btn btn-primary me-sm-3 me-1 data-submit">{{__('site.Submit')}}</button>
                    {{--                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>--}}
                </form>
            </div>
        </div>
    </div>
@endsection
