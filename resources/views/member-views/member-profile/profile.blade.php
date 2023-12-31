@extends('member-components.member-layout')

@section('content')

<main class="m-md-3 mt-2">

    <div class="bg-white rounded pt-3 border">
        @if($member->is_editable == 1)
            <div class="profile-note" style="text-align: justify;">
                <strong>Note:</strong> You will only be allowed to update your profile once. Subsequent changes can only be made in person at the BUPF Office for verification purposes.
            </div>
        @else
            <div class="profile-note" style="text-align: justify;">
                If you want to update your profile, please go to the BUPF Office for verification purposes.
            </div>
        @endif

        <div class="mt-2 mx-3">
            @if (session('fail'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{session('fail')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('message'))
                <div class="alert alert-primary alert-dismissible fade show mt-1" role="alert">
                    {{session('message')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(count($errors) != 0)
                @foreach ($errors->all() as $error )
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{$error}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endforeach
            @endif
        </div>

        {{-- @if (Auth::user()->email_verified_at == null)
            <div class="alert alert-warning mt-3" style="font-size: small">
                Your Email <strong>{{Auth::user()->email}}</strong> is not yet verified. Go to <a href="/verify/email">Verify Email</a>
            </div>
        @endif --}}

        <div style="padding: 10px 15px 0 15px;">
            <div class="col-12 p-2 rounded shadow" style="background-image: url({{ asset('assets/core-feature-bg.png') }}); filter: saturate(130%);">
                <div class="row">
                    <div class="col-lg-3 col-6  text-center">
                        <img src="{{Auth::user()->member->profile_picture != null ? asset('storage/' . Auth::user()->member->profile_picture) : asset('assets/no_profile_picture.jpg')}}" alt="profile picture" class="rounded-circle shadow img-fluid m-2" style="object-fit:cover; width: 8rem; height: 8rem; border: 4px solid white;">
                    </div>
                    <div class="col-lg-9 col-6  my-auto text-white p-2" style="text-shadow: 1px 1px 4px rgb(46, 46, 46);">
                        <span>
                            <div class="fw-bold" style="font-size: 1rem; ">
                                {{ Auth::user()->member->firstname}}
                                @if(Auth::user()->member->middlename != null)
                                    @php
                                        $middle_initial = substr(Auth::user()->member->middlename, 0, 1);
                                    @endphp
                                    {{ $middle_initial}}.
                                @endif
                                {{ Auth::user()->member->lastname}}
                                <a href="#" id="profileOpenModalLink"><i class="bi bi-pencil-square fs-6" style="color: white;"></i></a>
                            </div>
                        </span>
                        <div><i class="bi bi-person-fill"></i>
                            <span style="font-size: 0.9rem">{{ ucfirst($member->position) }}</span>
                        </div>
                        <div><i class="bi bi-building-fill"></i>
                            <span style="font-size: 0.9rem">BU{{$unit->unit_code}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gap-4 profile-row" style="display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;">
            <div class="col-xl-4 border bg-white rounded px-3 pt-2 pb-4 mb-2 shadow-sm">
                <div style="border-bottom: 1px solid #E8E8E8; display: flex;">
                    <img width="30" height="30" src="https://img.icons8.com/ios-filled/50/manager.png" alt="employee" style="margin: 15px 10px; color: #393939;"/>
                    <p class="mt-3 fw-bold " style="color: #393939; font-size: 14px">Employment Information</p>
                </div>

                <div style="margin: 15px 10px 0 10px; ">
                    <p style="color: #393939" class="fs-7"><span class="fw-bold ">Campus :</span> {{$campus->campus_code}}&nbsp;Campus</p>
                    <p style="color: #393939" class="fs-7"><span class="fw-bold ">Unit :</span> BU{{$unit->unit_code}}</p>
                    <p style="color: #393939" class="fs-7"><span class="fw-bold ">Position :</span> {{ ucfirst($member->position) }}</p>
                    <p style="color: #393939" class="fs-7"><span class="fw-bold ">Monthly Salary :</span> Php {{ number_format($member->monthly_salary, '2','.',',') }}</p>
                    <p style="color: #393939" class="fs-7"><span class="fw-bold ">Employee No. :</span> {{ $member->employee_num }}</p>
                    <p style="color: #393939" class="fs-7"><span class="fw-bold ">Date Appointed at BU :</span> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $member->bu_appointment_date)->format('F j, Y') }}</p>
                    <p style="color: #393939" class="fs-7"><span class="fw-bold ">Member Status :</span> <span class="fw-bold"  style="color: {{ $member->disabled_at ? 'red' : 'green' }}">{{ $member->disabled_at ? 'Inactive' : 'Active' }}</span></p>
                    <p style="color: #393939" class="fs-7"><span class="fw-bold ">Approved Date :</span> <span class="fw-bold" style="color: #00145B;">
                        @if ($member->verified_at)
                        {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $member->verified_at)->startOfDay()->format('F j, Y') }}
                        @else
                        Not verified
                    @endif
                    </span></p>

                    <div class="d-flex justify-content-center align-items-center">
                        <button class="btn bu-orange w-100" type="button">
                            <a href="{{ route('generateMembershipForm', ['id' => Auth::user()->member->id]) }}" class="fw-bold fs-7 text-white text-decoration-none">Download Membership Form</a>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 border bg-white rounded px-3 pt-2 pb-4 mb-2 shadow-sm">
                <div style="border-bottom: 1px solid #E8E8E8; display: flex;">
                    <i class="bi bi-person-fill-exclamation" style="margin: 8px 10px; color: #393939; font-size: 30px;"></i>
                    <p class="mt-3 fw-bold" style="color: #393939; font-size: 14px">Personal Information</p>
                </div>

                <div class="row fs-7" style="color: #393939; margin-top: 10px;">
                    <div class="col-5">
                        <p><span class="fw-bold">Name :</span></p>
                    </div>
                    <div class="col-7">
                        <p><span>{{ $member->firstname }}
                            @if(Auth::user()->member->middlename != null)
                                @php
                                    $middle_initial = substr(Auth::user()->member->middlename, 0, 1);
                                @endphp
                                {{ $middle_initial}}.
                            @endif
                            {{ $member->lastname }}</span></p>
                    </div>

                    <div class="col-5">
                        <p><span class="fw-bold">Email :</span></p>
                    </div>
                    <div class="col-7">
                        <p><span>{{ substr($user->email, 0, 1) . str_repeat('*', strpos($user->email, '@') - 2) . substr($user->email, strpos($user->email, '@') - 1) }}</span></p>
                    </div>
                    <div class="col-5">
                        <p><span class="fw-bold">Address :</span></p>
                    </div>
                    <div class="col-7">
                        <p><span>{{ $member->address }}</span></p>
                    </div>
                    <div class="col-5">
                        <p><span class="fw-bold">Contact Number :</span></p>
                    </div>
                    <div class="col-7">
                        <p><span>{{ str_repeat('*', strlen($member->contact_num) - 3) . substr($member->contact_num, -3) }}</span></p>
                    </div>
                    <div class="col-5">
                        <p><span class="fw-bold">Sex :</span></p>
                    </div>
                    <div class="col-7">
                        <p><span>{{ $member->sex }}</span></p>
                    </div>
                    <div class="col-5">
                        <p><span class="fw-bold">Tin :</span></p>
                    </div>
                    <div class="col-7">
                        <p><span>{{ $member->tin_num }}</span></p>
                    </div>
                    <div class="col-5">
                        <p><span class="fw-bold">Birthdate :</span></p>
                    </div>
                    <div class="col-7">
                        <p><span>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $member->date_of_birth)->format('F j, Y') }}</span></p>
                    </div>
                    <div class="col-5">
                        <p><span class="fw-bold">Civil Status :</span></p>
                    </div>
                    <div class="col-7">
                        <p><span>{{$member->civil_status}}</span></p>
                    </div>
                    <div class="col-lg-5 col-12">
                        @if(Auth::user()->password == null)
                            <a href="#edit" class="btn d-flex justify-content-center align-items-center fs-7 text-white" data-bs-toggle="modal" data-bs-target="#createPasswordModal">
                                <span style="border-radius: 5px;background: #0092D1; padding: 8px 15px; width: 100%; font-weight: bold;">Create password</span>
                            </a>
                        @else
                            <a href="#edit" class="btn d-flex justify-content-center align-items-center fs-7 text-white" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                <span style="border-radius: 5px;background: #0092D1; padding: 8px 15px; width: 100%; font-weight: bold;">Change password</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Contains the Modal for editing the Profile --}}
    @include('member-views.member-profile.profile-updateModal')
    @include('member-views.member-profile.create-passwordModal')
    @include('member-views.member-profile.change-passwordModal')

</main>

<script>
    var closeButton = document.getElementById("modal-profile-close-button");

    var modal = document.getElementById("profileMyModal");

    closeButton.addEventListener("click", function () {
        modal.style.display = "none";
    });

    $(document).ready(function () {
    // Function to hide alerts after 3 seconds
    function hideAlerts() {
      $(".alert").delay(15000).slideUp(500, function () {
        $(this).alert("close");
      });
    }

    hideAlerts();
  });
</script>


@endsection
