@extends('member-components.member-layout')

@section('content')

<div class="row m-3 mx-2 d-flex justify-content-center">
    @if (session('message'))
    <div class="alert alert-primary">
        <i class="bi bi-hand-thumbs-up-fill"></i> {{ session('message') }}
    </div>
    @endif
    @if (session('email_error'))
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-circle"></i> {{ session('email_error') }}
    </div>
    @endif
    @if (session('witness_error'))
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-circle"></i> {{ session('witness_error') }}
    </div>
    @endif
  <div class="card border p-4" style="width: 35rem">
    <div class="row d-flex">
        <div class="col">
            <img class="img-fluid" src="{{asset('assets/HSL-loanapp-logo.png')}}" alt="Logo" style="height: 55px;">
        </div>
        <div class="col-2 d-md-block d-none">
            <img class="img-fluid" src="{{asset('assets/HSL-mini.svg')}}" alt="Mini Logo" style="height: 55px;">
        </div>

         <div class="my-2">
            @include('member-views.mpl-application-form.accordion-entity-definition')
        </div>
        <div class="py-3 border border-primary-subtle rounded col" id="message-div">
            <h6 class="fw-bold">
                Hello, {{Auth::user()->member->firstname}}!
            </h6>
            Your loan request requires a minimum monthly take-home pay of Php 5,000 for approval. Ensure your take-home pay meets this criterion to proceed with your loan application. Please refer to your most recent pay slip.

            <div class="text-end">
                <a class="btn btn-link" onclick="hide()">hide</a>
            </div>
        </div>

        <p class="text1-design mt-2">Loan Details</p>

        <form action="/member/loan-application/2" method="POST" id="submitHLForm" enctype="multipart/form-data">
            @csrf
            <div id="loanForm">


                <div class="form-group">
                    <label for="loanAmount" class="text2-design">Amount Requested</label>

                    <input type="number" class="form-control comma-input {{$errors->has('principal_amount') ? 'invalid' : '' }}" id="loanAmount" name="principal_amount" placeholder="Loanable amount: ₱50,000.00 to ₱200,000.00" value="{{old('principal_amount')}}" min="50000" max="200000">

                    <div id="validationLoanAmountFeedBack" class="invalid-feedback">
                        Loan amount must be at least 50,000 Php or max value of 200,000 Php
                      </div>

                    {{-- min="50000" max="200000" --}}
                    @error('principal_amount')
                        <h6 class="text-danger">{{$message}}</h6>
                    @enderror
                </div>


                <div class="form-group">
                    {{--
                    <input type="number" class="form-control" id="loanTerm" name="term_years" > --}}
                    <label for="loanTerm" class="text2-design">Years to Pay</label>
                    <select class="form-control form-select mt-2 {{ $errors->has('term_years') ? 'invalid' : '' }}" aria-label="Default select example" id="loanTerm" name="term_years" value="{{old('term_years')}}">
                        {{-- <option value="" selected disabled>Choose loan term: 1-5 years</option> --}}
                        @for ($years = 1; $years < 6; $years++)
                            @if ($years == 1)
                                <option value="{{$years}}" {{old('term_years') == $years ? 'selected' : '' }}>{{$years}} year</option>
                            @else
                                <option value="{{$years}}" {{old('term_years') == $years ? 'selected' : '' }}>{{$years}} years</option>
                            @endif
                        @endfor

                      </select>

                      <div id="validationLoanTermFeedBack" class="invalid-feedback">
                        Please choose a loan term
                      </div>

                      @error('term_years')
                        <h6 class="text-danger">{{$message}}</h6>
                      @enderror
                    {{--  min="1" max="5" --}}
                </div>

                <p class="text1-design pt-4">Co-Borrower</p>

                <div class="form-group">
                    <label for="myCoBorrower" style="font-size: 12px">Please enter the BU email of your Co-Borrower. Your co-borrower must be a registered member of BUPF Online</label>
                    <input type="text" class="form-control {{ $errors->has('email_co_borrower') ? 'invalid' : '' }}" id="myCoBorrower" name="email_co_borrower" value="{{old('email_co_borrower')}}" placeholder="ex. juanjose.delacruz@bicol-u.edu.ph">


                    <div style="font-size: 12px" class="ms-1 mt-2" id="result"></div>


                    @error('email_co_borrower')
                        <h6 class="text-danger">{{$message}}</h6>
                    @enderror
                </div>

                <p class="text1-design pt-4">Witnesses</p>
                <p class="text-dark" style="font-size: 14px">You may leave this blank for now, but it will be required in the printed form for submission.</p>
                <p style="font-size: 12px">
                    Note: Names should be at least 2 characters long and contain no numbers.
                </p>

                <div class="form-group">
                    <input type="text" class="form-control  {{ $errors->has('witness_name_1') ? 'is-invalid' : '' }} {{ session('witness_error') ? 'is-invalid' : '' }}" id="myWitness1" name="witness_name_1" placeholder="ex. Jeff Beck M. Lim" value="{{old('witness_name_1')}}" />
                    @error('witness_name_1')
                        <h6 class="text-danger">{{$message}}</h6>
                    @enderror
                    <div id="validationMyWitness1FeedBack" class="invalid-feedback">
                        Witnesses, co-borrowers, and principal borrower (you) must not be the same person. Please Double check the names entered.
                      </div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control mt-2 {{ $errors->has('witness_name_2') ? 'is-invalid' : '' }} {{ session('witness_error') ? 'is-invalid' : '' }}" id="myWitness2" name="witness_name_2" placeholder="ex. Aaron B. Labini" value="{{old('witness_name_2')}}"  />
                    @error('witness_name_2')
                        <h6 class="text-danger">{{$message}}</h6>
                    @enderror
                    <div id="validationMyWitness2FeedBack" class="invalid-feedback">
                        Witnesses, co-borrowers, and principal borrower (you) must not be the same person. Please Double check the names entered.
                      </div>
                </div>


                <p class="text1-design pt-4">Other requirements</p>
                <div class="form-group">
                    <label for="basic_salary">Basic Salary</label>
                    <input type="number" class="form-control mt-2 {{ $errors->has('witness_name_1') ? 'is-invalid' : '' }}" id="basic_salary" name="basic_salary" placeholder="Pleases refer to your latest payslip" value="{{old('basic_salary')}}" />
                    @error('basic_salary')
                        <h6 class="text-danger">{{$message}}</h6>
                    @enderror
                    <div id="validationBasicSalaryFeedBack" class="invalid-feedback">
                        This field is required, please provide a valid value.
                    </div>
                </div>
                <div class="form-group">
                    <label for="payslip">A Clear Photo of your Recent Payslip</label>
                    <input type="file" class="from-upload form-control mt-2" id="payslip" name="payslip"  accept=".png, .jpg, .jpeg" />
                    @error('payslip')
                        <h6 class="text-danger">{{$message}}</h6>
                    @enderror
                    <div id="validationBasicSalaryFeedBack" class="invalid-feedback">
                        This field is required, please provide a valid value.
                    </div>
                </div>

                <div class="row d-flex align-items-center justify-content-center">
                    <p class="warning">Based on the information you have provided in your profile, we will use that as your personal details such as your name, age, and other relevant information.</p>
                </div>
                <button type="button" class="btn bu-orange text-light fw-bold w-100" onclick="validateForm()">Proceed</button>


            </div>


        {{---------------------------------------------------------
            this includes the next tab which has the details of the loan application for members to review and send request to co-borrower.
        --------------------------------------------------------}}
            @include('member-views.hsl-application-form.hsl-details')


        </form>

        <script>
            $(document).ready(function() {
                $('#confirmRequest').click(function() {
                    var $btn = $(this);
                    $btn.prop('disabled', true);
                    $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending Request...');

                    $('#submitHLForm').submit();
                });
            });
        </script>
    </div>
  </div>
</div>
{{-- scripts used in validation --}}
@include('member-views.mpl-application-form.js_in_form_script')

@endsection
<script>
    function hide() {
        const message_div = document.getElementById('message-div');
        message_div.classList.add('d-none');
     }
</script>
