<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Member;
use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Loan;
use App\Models\Campus;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PDFController extends controller{

    public function generateMembershipForm($id)
    {

        $member = Member::find($id);
        if ($member) {
            $dateOfBirth = Carbon::parse($member->date_of_birth);
            $currentDate = Carbon::now();
            $age = $currentDate->diffInYears($dateOfBirth);
            $member_unit = Unit::with('campuses')->findOrFail($member->unit_id);
            $memberbene = Member::with('beneficiaries')->findOrFail($id);
            $beneficiaries = $memberbene->beneficiaries;

            $profilePicturePath = 'storage/' . $member->profile_picture;
            $orientedImage = Image::make($profilePicturePath)->orientate();
            $encodedImage = $orientedImage->encode('data-url')->encoded;

            $data = [
                'currentdate' => date('Y-m-d'),
                'firstname' => $member->firstname,
                'lastname' => $member->lastname,
                'middle_initial' => $member->middle_initial,
                'contact_num' => $member->contact_num,
                'address' => $member->address,
                'date_of_birth' => $member->date_of_birth,
                'tin_num' => $member->tin_num,
                'age' => $age,
                'position' => $member->position,
                'employee_num' => $member->employee_num,
                'bu_appointment_date' => $member->bu_appointment_date,
                'place_of_birth' => $member->place_of_birth,
                'civil_status' => $member->civil_status,
                'spouse' => $member->spouse,
                'sex' => $member->sex,
                'monthly_salary' => $member->monthly_salary,
                'monthly_contribution' => $member->monthly_contribution,
                'appointment_status' => $member->appointment_status,
                'profile_picture' => $encodedImage,
                'unit' => $member_unit->unit_code,
                'campus' => $member_unit->campuses->campus_code,
                'beneficiaries' => $beneficiaries,
            ];

            $pdf = PDF::loadView('member-views.generate-pdf-files.generate-membership-form', $data)->setPaper('letter', 'portrait');

            return $pdf->download('Membership Application Form.pdf');

        } else {
            return redirect()->back()->with('error', 'Member not found.');
        }

    }

    public function generateMPL($loanId)
    {
        $id = Auth::user()->member->id;
        $member = Member::find($id);
        $unit = Unit::where('id', $member->unit_id)->first();
        $campus = Campus::where('id', $unit->campus_id)->first();

        //calculate age
        $dateOfBirth = Carbon::parse($member->date_of_birth);
        $currentDate = Carbon::now();
        $age = $currentDate->diffInYears($dateOfBirth);

        //Loan table
        $loan = Loan::find($loanId);
        //Co Borrower details
        $co_borrower = $loan->co_borrower;
        //find the details of the co borrower
        $co_borrower_details = Member::find($co_borrower);

        //co-borrower age
        $co_borrower_dateOfBirth = Carbon::parse($co_borrower_details->first()->date_of_birth);
        $co_borrower_currentDate = Carbon::now();
        $co_borrower_age = $co_borrower_currentDate->diffInYears($co_borrower_dateOfBirth);

        //co-borrower unit
        $co_borrower_unit = Unit::where('id', $co_borrower_details->first()->unit_id)->first();
        //co-borrower campus
        $co_borrower_campus = Campus::where('id', $co_borrower_unit->campus_id)->first();

        $data = [
            'currentdate' => date('Y-m-d'),
            'lastname' => $member->lastname,
            'firstname' => $member->firstname,
            'middle_initial' => $member->middle_initial,
            'date_of_birth' => $member->date_of_birth,
            'age' => $age,
            'tin' => $member->tin_num,
            'address' => $member->address,
            'unit' => $unit->unit_code,
            'contact_number' => $member->contact_num,
            'office' =>     $campus->campus_code,
            'monthly_net_pay' => $member->monthly_salary,
            'amount_requested' => $loan->principal_amount,

            'co_lastname' => $co_borrower_details->first()->lastname,
            'co_firstname' => $co_borrower_details->first()->firstname,
            'co_middle_initial' => $co_borrower_details->first()->middle_initial,
            'co_date_of_birth' => $co_borrower_details->first()->date_of_birth,
            'co_age' => $co_borrower_age,
            'co_tin' => $co_borrower_details->first()->tin_num,
            'co_address' => $co_borrower_details->first()->address,
            'co_unit' => $co_borrower_unit->unit_code,
            'co_contact_number' => $co_borrower_details->first()->contact_num,
            'co_office' => $co_borrower_campus->campus_code,
            'co_monthly_net_pay' => $co_borrower_details->first()->monthly_salary,
            'co_amount_requested' => $loan->principal_amount,

        ];

        $pdf = PDF::loadView('member-views.generate-pdf-files.generate-mpl-app-form', $data)->setPaper('legal', 'portrait');

        return $pdf->download('MPL Application Form.pdf');
    }

    public function generateHSL($loanId){
        $id = Auth::user()->member->id;
        $member = Member::find($id);
        $unit = Unit::where('id', $member->unit_id)->first();
        $campus = Campus::where('id', $unit->campus_id)->first();

        //calculate age
        $dateOfBirth = Carbon::parse($member->date_of_birth);
        $currentDate = Carbon::now();
        $age = $currentDate->diffInYears($dateOfBirth);

        //Loan table
        $loan = Loan::find($loanId);
        //Co Borrower details
        $co_borrower = $loan->co_borrower;
        //find the details of the co borrower
        $co_borrower_details = Member::find($co_borrower);

        //co-borrower age
        $co_borrower_dateOfBirth = Carbon::parse($co_borrower_details->first()->date_of_birth);
        $co_borrower_currentDate = Carbon::now();
        $co_borrower_age = $co_borrower_currentDate->diffInYears($co_borrower_dateOfBirth);

        //co-borrower unit
        $co_borrower_unit = Unit::where('id', $co_borrower_details->first()->unit_id)->first();
        //co-borrower campus
        $co_borrower_campus = Campus::where('id', $co_borrower_unit->campus_id)->first();

        $data = [
            'currentdate' => date('Y-m-d'),
            'lastname' => $member->lastname,
            'firstname' => $member->firstname,
            'middle_initial' => $member->middle_initial,
            'date_of_birth' => $member->date_of_birth,
            'age' => $age,
            'tin' => $member->tin_num,
            'address' => $member->address,
            'unit' => $unit->unit_code,
            'contact_number' => $member->contact_num,
            'office' => $campus->campus_code,
            'monthly_net_pay' => $member->monthly_salary,
            'amount_requested' => $loan->principal_amount,
            'payment_period' => $loan->term_years,

            'co_lastname' => $co_borrower_details->first()->lastname,
            'co_firstname' => $co_borrower_details->first()->firstname,
            'co_middle_initial' => $co_borrower_details->first()->middle_initial,
            'co_date_of_birth' => $co_borrower_details->first()->date_of_birth,
            'co_age' => $co_borrower_age,
            'co_tin' => $co_borrower_details->first()->tin_num,
            'co_address' => $co_borrower_details->first()->address,
            'co_unit' =>  $co_borrower_unit->unit_code,
            'co_contact_number' => $co_borrower_details->first()->contact_num,
            'co_office' => $co_borrower_campus->campus_code,
            'co_monthly_net_pay' => $co_borrower_details->first()->monthly_salary,
            'co_amount_requested' => $loan->principal_amount,
            'co_payment_period' => $loan->term_years,

        ];

        $pdf = PDF::loadView('member-views.generate-pdf-files.generate-hsl-app-form', $data)->setPaper('legal', 'portrait');

        return $pdf->download('HSL Application Form.pdf');
    }

    public function generateInsuranceForm(){

        $data = [
            'Firstname' => 'John',
        ];
        $pdf = PDF::loadView('member-views.generate-pdf-files.generate-insurance-form', $data)->setPaper('legal', 'portrait');

        return $pdf->download('Insurance Form.pdf');
    }

    // Add more methods for generating additional PDFs if needed

}
