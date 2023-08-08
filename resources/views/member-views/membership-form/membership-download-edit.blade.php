@extends('home-components.home-layout')

@section('content')
<style>
    label{
        font-size: small !important;
    }
</style>

<main class="container mt-2 ">
    <div class="row d-flex justify-content-center mb-5">
        <div class="col-lg-5 col-sm-12 col-md-8 card shadow-sm p-4 ">
            

            <div class="row justify-content-center pt-3 pb-4 ">
                <div class="col-lg-7 col-md-9 col-sm-9 ">
                    <h5 class="text-center fw-bold fs-5">Provident  Fund, Inc. Membership Form</h5>
                </div>
            </div>
            <div class="row ">
                <div class="col-12 d-flex justify-content-center">
                    <img class="img-fluid" src="{{asset('assets/check.png')}}" alt="check" style="width: 5rem;">
                </div>
                <div class="col-12  text-center">
                    <p class="fw-bolder fs-5">Thank You!</p>
                </div>
                <div class="col-12">
                    <p class="text-center mx-4">Congratulations! Your membership application has been 
                        successfully created. You are now one step closer 
                        to enjoying the benefits of being a official member of 
                        Bicol University Provident Fund.</p>
                </div>
            </div>

            <div class="row mx-5 mt-5">
                <div class="col-12 d-grid mb-3">
                    <a class="btn btn-block  btn-outline-bu fw-bold grow-on-hover" href="#">Edit Submission</a>
                    {{-- <button class="btn btn-outline-bu fw-bold rounded">Edit Submission</button> --}}
                </div>
                <div class="col-12 d-grid">
                    <a class="btn btn-block  bu-orange text-white grow-on-hover" href="{{ route('generateMembershipForm') }}">Download File</a>
                </div>
            </div>

                
            
        </div>
    </div>    
</main>

@endsection
