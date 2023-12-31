@extends('admin-components.admin-layout')

@section('content')

<div class="container-fluid px-2" >
    <div class="row mt-2">
        <div class="container-fluid">
            <div class="adminbox">
                <div class=" d-flex text-dark">
                        <div >
                            <img src="{{asset('assets/admin-icons/magnifying-glass.svg')}}" alt="" width="50px" height="58px">
                        </div>
                        <div class="g-0 ps-2 my-auto">
                            <div class="m-0 fw-bold fs-5" >User Accounts</div>
                            <div style="font-size: small" class="fw-bold">All user accounts in eBUPF</div>
                        </div>
                </div>



                <div class="table-responsive ">
                    <div class="custom-table-for-admin">

                        <table class="table admin-table table-striped border-top" id="myTable">

                            <thead style="border-bottom: 2px solid black">
                                <tr>
                                    <th><h6 class="fw-bold" style="font-size: 12px">MEMBER</h6> ID</th>
                                    <th>Name</th>
                                    <th>Membership Application</th>
                                    <th>Email</th>

                                    <th>Role</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($users as $user)
                                <tr>
                                        <td>{{$user->member->id}}</td>
                                        <td>{{$user->member->firstname}} {{$user->member->lastname}}</td>
                                        <td>
                                            @if($user->member->membershipApplication)
                                            {{$user->member->membershipApplication->created_at}}
                                            @endif
                                        </td>
                                        <td >
                                            {{$user->email}}
                                            <label style="color: #aaaaaa">
                                              verfied: {{$user->email_verified_at}}
                                            </label>
                                        </td>
                                        <td>
                                            <style>
                                                .hidden{
                                                    visibility: hidden;
                                                    font-size: 3px;
                                                }
                                            </style>
                                            <h5>
                                            @if ($user->user_type == 'member')
                                            <a class="text-secondary text-decoration-none" data-bs-toggle="tooltip" data-bs-title="Member" >
                                                <i class="bi bi-person-check-fill"></i>
                                                <h6 class="hidden">2</h6>
                                            </a>
                                            @elseif($user->user_type == 'non-member')
                                            <a class="text-secondary text-decoration-none" data-bs-toggle="tooltip" data-bs-title="Non-member" >
                                                <i class="bi bi-person"></i>
                                                <h6 class="hidden">3</h6>
                                            </a>
                                            @elseif($user->user_type == 'admin')
                                            <a class="text-secondary text-decoration-none" data-bs-toggle="tooltip" data-bs-title="Admin-Staff" >
                                                <i class="bi bi-person-square"></i>
                                                <h6 class="hidden">1</h6>
                                            </a>
                                            @elseif($user->user_type == 'restricted')
                                            <a class="text-secondary text-decoration-none" data-bs-toggle="tooltip" data-bs-title="Restricted" >
                                                <i class="bi bi-slash-circle"></i>
                                                <h6 class="hidden">4</h6>
                                            </a>
                                            @endif
                                            </h5>
                                            {{-- @if ($user->user_type == 'restricted')
                                                <span class="text-danger">{{$user->user_type}}</span>

                                            @else
                                            {{$user->user_type}}

                                            @endif --}}
                                        </td>

                                        <td>
                                            <!-- Button trigger modal -->
                                            <button style="font-size: 12px" type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#{{$user->id}}">
                                                Change Role
                                            </button>
                                        </td>
                                </tr>

                                 <!-- Modal in views/admin-compinents/admin-modalAllUsers -->
                                @include('admin-views.admin-members.modal-change-role')

                            @endforeach
                            </tbody>
                        </table>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>
@include('admin-components.admin-dataTables')
@endsection
