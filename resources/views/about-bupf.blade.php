@extends('home-components.home-layout')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="fw-bold my-4 fs-1" style="color: #00638D;">
                        Discover more about our Organization
                    </h1>
                    <div style="border-bottom: 2px solid black;text-align:justify;" class="fs-6 pb-3">
                        The <i><b>Bicol University Provident Fund Inc.</b> </i>is a microfinance  institution established in 2008 by the Bicol University with a mandate to provide BU employees with supplementary benefits. As of 2023, a total of 557 employees teaching and non-teaching staff of BU have become members of BU Provident Fund. With BUPF they offer a comprehensive range of financial solutions, prominently featuring multipurpose and housing loans. Bicol University Provident Fund Inc. stands as a trusted partner in the journey towards financial stability and prosperity.
                    </div>
                    <div class="row mt-4 reveal fade-bottom active">
                        <div class="col-6">
                            <div class="d-flex fw-bold fs-6 my-2 align-items-center">
                                <img src="{{asset('assets/check-icon.svg')}}" alt="Check Icon" width="32px"> &nbsp;
                                Mission
                            </div>
                            <div class="fs-6">
                                The Bicol University shall give professional and technical training, and provide advanced and specialized instruction in literature, philosophy, the sciences and arts, besides providing for the promotion of scientific and technological researches (RA 5521, Sec. 3.0).
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex fw-bold fs-6 my-2 align-items-center">
                                <img src="{{asset('assets/check-icon.svg')}}" alt="Check Icon" width="32px"> &nbsp;
                                Vision
                            </div>
                            <div class="fs-6">
                                A University for Humanity characterized by productive scholarship, transformative leadership, collaborative service, and distinctive character for sustainable societies.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-5">
                    <img src="{{asset('assets/BUBG-new.png')}}" alt="Check Icon" width="100%">
                </div>
            </div>
        </div>
    </section>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <img src="{{asset('assets/about-bupf-man.svg')}}" alt="Check Icon" width="80%">
        </div>
        <div class="col-md-6">
            <p style="color:#00638D;" class="fs-5 fw-bold">Why Choose Us</p>
            <p class="fs-4">BUPF: Your Trusted Partner for Financial Stability and Success</p>
            <div class="row">
                <div class="col-1 text-end">
                    <img src="{{asset('assets/check-icon.svg')}}" alt="check" width="32px">
                </div>
                <div class="col-11 reveal fade-right">
                    BUPF commits to help BU employee maximize their hard-earned salary.
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-1 text-end">
                    <img src="{{asset('assets/check-icon.svg')}}" alt="check" width="32px">
                </div>
                <div class="col-11 reveal fade-right">
                    We empower our members to invest for their future.
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-1 text-end">
                    <img src="{{asset('assets/check-icon.svg')}}" alt="check" width="32px">
                </div>
                <div class="col-11 reveal fade-right">
                    All with the goal of helping BUPF Members achieve a life of financial support.
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-1 text-end">
                    <img src="{{asset('assets/check-icon.svg')}}" alt="check" width="32px">
                </div>
                <div class="col-11 reveal fade-right">
                    Low interest rate and borrow up to ₱50,000
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-1 text-end">
                    <img src="{{asset('assets/check-icon.svg')}}" alt="check" width="32px">
                </div>
                <div class="col-11 reveal fade-right">
                    Be able to re-loan after paying a minimum of three (3) months. MPL  Amortization
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-1 text-end">
                    <img src="{{asset('assets/check-icon.svg')}}" alt="check" width="32px">
                </div>
                <div class="col-11 reveal fade-right">
                    Access to BUPF Loan Products
                </div>
            </div>
        </div>
    </div>
</div>

<div class="text-center mb-5 mt-4">
    <span style="color: #0092D1;" class="fs-2 fw-bold">
        BICOL
    </span>
    <span style="color: #FF6F19;" class="fs-2 fw-bold">
        UNIVERSITY
    </span>
    <div>
        <span style="color: rgb(0, 0, 0); width: 70%;" class="fs-4 fw-bold">
            Provident Fund Inc. Organizational Structure
        </span>
    </div>
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-4 reveal fade-bottom">
                <div class="d-flex align-items-center justify-content-center">
                    <div style="background-image: url('{{ asset('assets/organisation-blue-bg.svg') }}'); width: 220px; height: 339px;">
                        <img src="{{asset('assets/BU-logo.png')}}" alt="BUPF" width="213" height="168" style="background: rgb(230, 230, 230); margin-top: -15px; margin-left: 7px;">
                        <div class="text-start" style="line-height: 1.1; margin: 10px 20px 20px 20px;">
                            <span class="text-white">Executive Director</span><br>
                            <span style="font-size: 12px; color: #FF6F19; font-weight: bold; text-shadow: 1px 1px 2px #000000;">Atty. Loyd P. Casasis</span> <br>
                            <span class="text-white" style="font-size: 12px;">Chief Administrative Officer</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 reveal fade-bottom">
                <div class="d-flex align-items-center justify-content-center">
                    <div style="background-image: url('{{ asset('assets/organisation-blue-bg.svg') }}'); width: 220px; height: 339px;">
                        <img src="{{asset('assets/BU-logo.png')}}" alt="BUPF" width="213" height="168" style="background: rgb(230, 230, 230); margin-top: -15px; margin-left: 7px;">
                        <div class="text-start" style="line-height: 1.1; margin: 10px 20px 20px 20px;">
                            <span class="text-white">Board of Director</span><br>
                            <span style="font-size: 12px; color: #FF6F19; font-weight: bold; text-shadow: 1px 1px 2px #000000;">Atty. Eduardo Loria</span> <br>
                            <span class="text-white" style="font-size: 12px;"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 reveal fade-bottom">
                <div class="d-flex align-items-center justify-content-center">
                    <div style="background-image: url('{{ asset('assets/organisation-blue-bg.svg') }}'); width: 220px; height: 339px;">
                        <img src="{{asset('assets/BU-logo.png')}}" alt="BUPF" width="213" height="168" style="background: rgb(230, 230, 230); margin-top: -15px; margin-left: 7px;">
                        <div class="text-start " style="line-height: 1.1; margin: 10px 20px 20px 20px;">
                            <span class="text-white">Board of Director</span><br>
                            <span style="font-size: 12px; color: #FF6F19; font-weight: bold; text-shadow: 1px 1px 2px #000000;">Cyrus A. Barrameda</span> <br>
                            <span class="text-white" style="font-size: 12px;">Chief, Internal Audit Services
                                Internal Audit Services</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4 reveal fade-bottom">
                <div class="d-flex align-items-center justify-content-center">
                    <div style="background-image: url('{{ asset('assets/organisation-blue-bg.svg') }}'); width: 220px; height: 339px;">
                        <img src="{{asset('assets/BU-logo.png')}}" alt="BUPF" width="213" height="168" style="background: rgb(230, 230, 230); margin-top: -15px; margin-left: 7px;">
                        <div class="text-start " style="line-height: 1.1; margin: 10px 20px 20px 20px;">
                            <span class="text-white">Board of Directors</span><br>
                            <span style="font-size: 12px; color: #FF6F19; font-weight: bold; text-shadow: 1px 1px 2px #000000;">Dr. Arnulfo P. Malinis</span> <br>
                            <span class="text-white" style="font-size: 12px;">Director</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 reveal fade-bottom">
                <div class="d-flex align-items-center justify-content-center">
                    <div style="background-image: url('{{ asset('assets/organisation-blue-bg.svg') }}'); width: 220px; height: 339px;">
                        <img src="{{asset('assets/BU-logo.png')}}" alt="BUPF" width="213" height="168" style="background: rgb(230, 230, 230); margin-top: -15px; margin-left: 7px;">
                        <div class="text-start " style="line-height: 1.1; margin: 10px 20px 20px 20px;">
                            <span class="text-white">Board of Directors</span><br>
                            <span style="font-size: 12px; color: #FF6F19; font-weight: bold; text-shadow: 1px 1px 2px #000000;">Evelyn Q. Mira</span> <br>
                            <span class="text-white" style="font-size: 12px;"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 reveal fade-bottom">
                <div class="d-flex align-items-center justify-content-center">
                    <div style="background-image: url('{{ asset('assets/organisation-blue-bg.svg') }}'); width: 220px; height: 339px;">
                        <img src="{{asset('assets/BU-logo.png')}}" alt="BUPF" width="213" height="168" style="background: rgb(230, 230, 230); margin-top: -15px; margin-left: 7px;">
                        <div class="text-start " style="line-height: 1.1; margin: 10px 20px 20px 20px;">
                            <span class="text-white">Loan Analyst</span><br>
                            <span style="font-size: 12px; color: #FF6F19; font-weight: bold; text-shadow: 1px 1px 2px #000000;">Mary Jane A. Vicuña</span> <br>
                            <span class="text-white" style="font-size: 12px;"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4 reveal fade-bottom">
                <div class="d-flex align-items-center justify-content-center">
                    <div style="background-image: url('{{ asset('assets/organisation-blue-bg.svg') }}'); width: 220px; height: 339px;">
                        <img src="{{asset('assets/BU-logo.png')}}" alt="BUPF" width="213" height="168" style="background: rgb(230, 230, 230); margin-top: -15px; margin-left: 7px;">
                        <div class="text-start " style="line-height: 1.1; margin: 10px 20px 20px 20px;">
                            <span class="text-white">Treasurer</span><br>
                            <span style="font-size: 12px; color: #FF6F19; font-weight: bold; text-shadow: 1px 1px 2px #000000;">Jocelyn L. Corre</span> <br>
                            <span class="text-white" style="font-size: 12px;"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 reveal fade-bottom">
                <div class="d-flex align-items-center justify-content-center">
                    <div style="background-image: url('{{ asset('assets/organisation-blue-bg.svg') }}'); width: 220px; height: 339px;">
                        <img src="{{asset('assets/BU-logo.png')}}" alt="BUPF" width="213" height="168" style="background: rgb(230, 230, 230); margin-top: -15px; margin-left: 7px;">
                        <div class="text-start " style="line-height: 1.1; margin: 10px 20px 20px 20px;">
                            <span class="text-white">Board Secretary</span><br>
                            <span style="font-size: 12px; color: #FF6F19; font-weight: bold; text-shadow: 1px 1px 2px #000000;">Michelle B. Andes</span> <br>
                            <span class="text-white" style="font-size: 12px;">Administrative Officer, BU Cluster II</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 reveal fade-bottom">
                <div class="d-flex align-items-center justify-content-center">
                    <div style="background-image: url('{{ asset('assets/organisation-blue-bg.svg') }}'); width: 220px; height: 339px;">
                        <img src="{{asset('assets/BU-logo.png')}}" alt="BUPF" width="213" height="168" style="background: rgb(230, 230, 230); margin-top: -15px; margin-left: 7px;">
                        <div class="text-start " style="line-height: 1.1; margin: 10px 20px 20px 20px;">
                            <span class="text-white">Accounting Clerk</span><br>
                            <span style="font-size: 12px; color: #FF6F19; font-weight: bold; text-shadow: 1px 1px 2px #000000;">Kathy Mae D. Galicia</span> <br>
                            <span class="text-white" style="font-size: 12px;"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('home-components.contact')

@endsection
