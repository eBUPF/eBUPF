<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\User;
use App\Models\LoanLog;
use App\Models\Payment;
use App\Models\Penalty;
use App\Models\Witness;
use App\Models\LoanType;
use App\Models\Adjustment;
use App\Models\CoBorrower;
use GuzzleHttp\Psr7\Query;

use Illuminate\Support\Str;
use App\Models\Amortization;
use Illuminate\Http\Request;
use App\Models\PenaltyPayment;
use App\Models\LoanApplicationState;

use Illuminate\Support\Facades\Auth;
use App\Models\LoanApplicationStatus;
use function PHPUnit\Framework\isNull;

class LoanApplicationController extends Controller
{
    public function getCoBorrower(Request $request){
        $key = $request->input('key');
        $data_raw = User::where('email', $key)->with('member')->first(); // Fetch the user data

        $cb_name = $data_raw->member->firstname.$data_raw->member->lastname;
        return response()->json($cb_name);
    }



    public function showLoanStatus($loan_id){
        $loan = Loan::with('loanType')->where('id',$loan_id)->first();

        // check if loan exist
        if($loan==null){
            abort(403);
        // check loan belongs to member
        }elseif ($loan->member_id != Auth::user()->member->id) {
            abort(403);
        }


        $loan_status=LoanApplicationStatus::with('LoanApplicationState')
        ->where('loan_id', $loan_id)
        ->whereNull('is_deleted') //get status that are not deleted
        ->orderBy('loan_application_state_id', 'desc')
        ->get();

        return view('member-views.loan-applications.loan-application-status', compact('loan_status', 'loan'));
    }

    //SHOW MPL APPLICATION FORM
    public function show(){
        $user = Auth::user();
        $loans = Loan::where('member_id', $user->member->id)->where('is_active', 1)->get();
        //get members additional_loan column
        $additionalLoan = $user->member->additional_loan;

        //get all mpl loans
        $mplLoans = Loan::where('member_id', $user->member->id)->where('loan_type_id', 1)->where('is_active', 1)->get();

        //get all payments for mpl loans, grouped by loan_id
        $mplPayments = Payment::where('member_id', $user->member->id)
        ->whereIn('loan_id', $mplLoans->pluck('id'))
        ->get()
        ->groupBy('loan_id');

        //get total payments for mpl loans, by grouping the payments by loan_id and summing the interest and principal
        $totalPaymentsMPL = $mplPayments->map(function ($payments) {
            $totalInterest = $payments->sum('interest');
            $totalPrincipal = $payments->sum('principal');
            return $totalInterest + $totalPrincipal;
        });

        $inActiveLoan = CoBorrower::with(
            'member.units.campuses',
            'loan.member.units.campuses',
            'loan.loanApplicationStatus.loanApplicationState',
            'loan.loanType'
        )
        ->whereHas('loan', function ($query) {
            $query->where(function ($query) {
                $query->where('member_id', Auth::user()->member->id)
                    ->orWhereNull('member_id')
                    ->orWhere('member_id', 0);
            })
            ->where(function ($query) {
                $query->where('is_active', 0)
                    ->orWhereNull('is_active');
            });
        })->first();

        $mplTotalAmount = 0;

        // Get total amount of all loans
        foreach ($loans as $loan) {
            $mplTotalAmount += ($loan->principal_amount + $loan->interest);
        }

        $mplTotalBalance = $mplTotalAmount;

        // Get total balance of all loans
        foreach ($loans as $loan) {
            if(isset($totalPaymentMPL) && isset($totalPaymentMPL[$loan->id])){
            $mplTotalBalance -= $totalPaymentMPL[$loan->id];
            }
        }

        // Check if all MPL loans have been paid 50%
        $allMPLPaid50Percent = $mplLoans->isEmpty() || $mplLoans->every(function ($loan) use ($totalPaymentsMPL) {
            return isset($totalPaymentsMPL[$loan->id]) && $totalPaymentsMPL[$loan->id] >= 0.5 * ($loan->principal_amount + $loan->interest);
        });

        // MPL is disabled if there is an active loan or if all MPL loans have not been paid 50% and
        $mplDisabled = !empty($inActiveLoan) || !$allMPLPaid50Percent && ($additionalLoan == 0 || $additionalLoan == null || $additionalLoan == 2 && $additionalLoan != 3);

        // if mplDisabled is true, return abort 403
        if($mplDisabled){
            abort(403);
        }

        $members = User::where('user_type', 'member')->with('member')->get();
        $member_emails = [];
        foreach($members as $member){
            array_push($member_emails, $member->email);
        }


        return view('member-views.mpl-application-form.mpl-application-form', compact('member_emails'));
    }

    // SHOW HSL APPLICATION FORM
    public function showHsl(){
        $user = Auth::user();
        $loans = Loan::where('member_id', $user->member->id)->where('is_active', 1)->get();
        //get members additional_loan column
        $additionalLoan = $user->member->additional_loan;

        //get all hsl loans
        $hslLoans = Loan::where('member_id', $user->member->id)->where('loan_type_id', 2)->where('is_active', 1)->get();

        //get all payments for hsl loans, grouped by loan_id
        $hslPayments = Payment::where('member_id', $user->member->id)
        ->whereIn('loan_id', $hslLoans->pluck('id'))
        ->get()
        ->groupBy('loan_id');

        //get total payments for hsl loans, by grouping the payments by loan_id and summing the interest and principal
        $totalPaymentsHSL = $hslPayments->map(function ($payments) {
            $totalInterest = $payments->sum('interest');
            $totalPrincipal = $payments->sum('principal');
            return $totalInterest + $totalPrincipal;
        });

        $inActiveLoan = CoBorrower::with(
            'member.units.campuses',
            'loan.member.units.campuses',
            'loan.loanApplicationStatus.loanApplicationState',
            'loan.loanType'
        )
        ->whereHas('loan', function ($query) {
            $query->where(function ($query) {
                $query->where('member_id', Auth::user()->member->id)
                    ->orWhereNull('member_id')
                    ->orWhere('member_id', 0);
            })
            ->where(function ($query) {
                $query->where('is_active', 0)
                    ->orWhereNull('is_active');
            });
        })->first();

        $hslTotalAmount = 0;

        // Get total amount of all loans
        foreach ($loans as $loan) {
            $hslTotalAmount += ($loan->principal_amount + $loan->interest);
        }

        $hslTotalBalance = $hslTotalAmount;

        // Get total balance of all loans
        foreach ($loans as $loan) {
            if(isset($totalPaymentHSL) && isset($totalPaymentHSL[$loan->id])){
                $hslTotalBalance -= $totalPaymentHSL[$loan->id];
            }
        }

        // Check if all HSL loans have been paid 50%
        $allHSLPaid50Percent = $hslLoans->isEmpty() || $hslLoans->every(function ($loan) use ($totalPaymentsHSL) {
            return isset($totalPaymentsHSL[$loan->id]) && $totalPaymentsHSL[$loan->id] >= 0.5 * ($loan->principal_amount + $loan->interest);
        });

        // HSL is disabled if there is an active loan or if all HSL loans have not been paid 50% and additional loan is not 3 and 2
        $hslDisabled = !empty($inActiveLoan) || !$allHSLPaid50Percent && ($additionalLoan == 0 || $additionalLoan == null || $additionalLoan == 1 && $additionalLoan != 3);

        // if hslDisabled is true, return abort 403
        if($hslDisabled){
            abort(403);
        }

        $members = User::where('user_type', 'member')->get();
        $member_emails = [];
        foreach($members as $member){
            array_push($member_emails, $member->email);
        }

        // $member_names = [];
        // foreach($members as $member){
        //     array_push($member_names, $member->member->firstname.' '.$member->member->lastname);
        // }

        return view('member-views.hsl-application-form.hsl-application-form', compact('member_emails'));
    }



    // SHOW LIST OF LOAN APPLICATIONS
    public function showLoanApplications(){

        $raw_loans = CoBorrower::with(
            'member.units.campuses',
            'loan.member.units.campuses',
            'loan.loanApplicationStatus.loanApplicationState',
            'loan.loanType',
            //get loans with status
            )
            // ->where('accept_request', '1') //get loans accepted by coBorrower
            ->whereHas('loan', function ($query){
                $query->where('member_id', Auth::user()->member->id)
                        ->whereNull('is_active');
            })->orderBy('id','desc')->get();

            // filter loans - get only applications that are not rejected
            $loans = [];
            foreach ($raw_loans as $raw_loan){
                $array = [];
                foreach($raw_loan->loan->loanApplicationStatus as $status){
                    array_push($array, $status->loan_application_state_id);
                }
                if(!in_array(6,$array)){
                    array_push($loans, $raw_loan);
                }
            }


        return view('member-views.loan-applications.loan-applications', compact('loans'));
    }
    // SHOW LOANS DENIED OR EVALUATED
    public function showLoanApplicationsEvaluated(){
        $raw_loans = CoBorrower::with(
            'member.units.campuses',
            'loan.member.units.campuses',
            'loan.loanApplicationStatus.loanApplicationState',
            'loan.loanType',
            //get loans with status
            )
            ->where('accept_request', '1') //get loans accepted by coBorrower
            ->whereHas('loan', function ($query){
                $query->where('member_id', Auth::user()->member->id);
                        // ->whereNotNull('is_active');
            })->orderBy('id','desc')->get();

            // filter loans - get only applications that are rejected or is_active not nutll
            // in other words get loans that are evaluated
            $loans = [];
            foreach ($raw_loans as $raw_loan){
                $array = [];
                foreach($raw_loan->loan->loanApplicationStatus as $status){
                    array_push($array, $status->loan_application_state_id);
                }
                if(in_array(6,$array) || $raw_loan->loan->is_active != null){
                    array_push($loans, $raw_loan);
                }
            }


        return view('member-views.loan-applications.loan-applications', compact('loans'));
    }


    public function showLoanApplicationsAll(){
        $loans = CoBorrower::with(
            'member.units.campuses',
            'loan.member.units.campuses',
            'loan.loanApplicationStatus.loanApplicationState',
            'loan.loanType',
            //get loans with status
            )
            // ->where('accept_request', '1') //get loans accepted by coBorrower
            ->whereHas('loan', function ($query){
                $query->where('member_id', Auth::user()->member->id);
            })->orderBy('id','desc')->get();


        return view('member-views.loan-applications.loan-applications', compact('loans'));
    }

    // generate unique loan ID
    public function generateId($loanTypeId,$id){
        $loanType = LoanType::find($loanTypeId);
        // do {
            $currentDateTime = now();
            // Format date and time to create a string
            $dateTimeString = $currentDateTime->format('Y-');
            // $randomString = strtoupper(Str::random(3));
            // $randomString1 = strtoupper(Str::random(3));
            // Combine the formatted date/time and the random string to create a unique ID
            // $uniqueId = $loanType->loan_type_name."-". $dateTimeString . $randomString . "-" . $randomString1;
            if($loanType->loan_type_name == 'HSL'){
                $uniqueId = "HL-". $dateTimeString . $id;
            }else{
                $uniqueId = $loanType->loan_type_name."-". $dateTimeString . $id;
            }

        // } while (Loan::where('loan_code', $uniqueId)->exists());

        return($uniqueId);
    }

    // ============================VALIDATE AND STORE MPL APPLICATION==============================
    public function storeRequest(Request $request, $loanTypeId){
        if($loanTypeId > 2 || $loanTypeId <= 0){
            abort(404);
        }
        // check if there is a pending/inactive loan
        $inActiveLoan = CoBorrower::with(
            'member.units.campuses',
            'loan.member.units.campuses',
            'loan.loanApplicationStatus.loanApplicationState',
            'loan.loanType'
        )
        ->whereHas('loan', function ($query) {
            $query->where(function ($query) {
                $query->where('member_id', Auth::user()->member->id)
                    ->orWhereNull('member_id')
                    ->orWhere('member_id', 0);
            })
            ->where(function ($query) {
                $query->where('is_active', 0)
                    ->orWhereNull('is_active')
                    ->orWhere('is_active', 0);
            });
        })->first();

        // if there is a pending/inactive loan, return abort 403
        if(!empty($inActiveLoan)){
            abort(403);
        }

        $formFields = $request->validate([
            'email_co_borrower' => 'required|email|exists:users,email',
            'principal_amount'=> ['required', 'numeric', 'min:50000', 'max:200000'],
            'term_years'=> ['required', 'numeric', 'min:1', 'max:5'],
            'witness_name_1'=>'nullable',
            'witness_name_2'=>'nullable',

            'payslip'=>'nullable|image|mimes:jpeg,png|max:2048',
            'basic_salary'=> ['required', 'numeric', 'min:1'],

        ]);

        $previous_loan_balance = 0;
        $remaining_penalty = 0;
        $remaining_penalty = 0;
        $service_fee = 0;
        // OTHER CALCULATIONS ============================================
        if($loanTypeId == 1){
            $interestRate = 0.06;
        }elseif($loanTypeId == 2){
            $interestRate = 0.09;
        }

         // Calculate yearly principal balance
         $yearlyPrincipalBalance = $formFields['principal_amount'] / $formFields['term_years'];
         $yearlyBalance = $formFields['principal_amount'];
        // ****************************
         $totalInterest = 0;

         // Calculate and store the yearly balances in the array
         for ($year = 0; $year < $formFields['term_years']; $year++) {
             $yearlyInterest = $yearlyBalance * $interestRate;
             $totalInterest += $yearlyInterest;
             $yearlyBalance -= $yearlyPrincipalBalance;
         }
        //  ***************************
         $mri = $formFields['principal_amount']/1000*0.62*($formFields['term_years']*12);

        //  get loans of member
         $loans = Loan::where('loan_type_id',$loanTypeId)
                    ->where('member_id', Auth::user()->member->id)
                    ->with('loanApplicationStatus')
                    ->get();
        // loans with check picked up
        $loans_picked_up = [];
        foreach($loans as $loan){
            $statuses = [];
            foreach($loan->LoanApplicationStatus as $status){
                array_push($statuses, $status->loan_application_state_id);
            }
            if(in_array(5,$statuses)){
                array_push($loans_picked_up, $loan);
            }
        }
        // get ids of loans picked up
         $loans_picked_up_ids = [];
         foreach($loans_picked_up as $loan_picked_up){
            array_push($loans_picked_up_ids, $loan_picked_up->id);
         }

         $payments = Payment::where('member_id', Auth::user()->member->id)->get();
         $payments_included = [];
         foreach($payments as $payment){
            if(in_array($payment->loan_id,$loans_picked_up_ids)){
                array_push($payments_included,$payment);
            }
         }

        //  ALL INTEREST AND PRINCIPAL
         $all_amount_granted = 0;
         foreach($loans_picked_up as $loan_picked){
            $temp = $loan_picked->principal_amount + $loan_picked->interest;
            $all_amount_granted += $temp;
         }
        // ALL PAYMENTS FILTERED INTESTEST AND PRINCIPAL
        $all_amount_paid = 0;
         foreach($payments_included as $pay){
            $temp_pay = $pay->principal + $pay->interest;
            $all_amount_paid += $temp_pay;
         }

        //  *****************
         $previous_loan_balance = $all_amount_granted - $all_amount_paid;

        //  ************************
        if($loanTypeId == 2){
         $service_fee = 0.01 * $formFields['principal_amount'];
        }

         $penalties = Penalty::all();
         $penalties_filtered = [];
        //  get only penalties associated with picked up loans
        $penalty_total = 0;
         foreach($penalties as $penalty){
            if(in_array($penalty->loan_id,$loans_picked_up_ids)){
                array_push($penalties_filtered,$penalty);
                $penalty_total += $penalty->penalty_total;
            }
         }
         $penalties_filtered_ids = [];
         foreach($penalties_filtered as $penalty_filtered){
            array_push($penalties_filtered_ids, $penalty_filtered->id);
         }
         $penalty_payments = PenaltyPayment::all();
         $penalty_payments_total = 0;
         foreach($penalty_payments as $penalty_pay){
            if(in_array($penalty_pay->id,$penalties_filtered_ids)){
                $penalty_payments_total += $penalty_pay->penalty_payment_amount;
                // array_push($penalty_payments_filtered, $penalty_pay);

            }
         }
        //  ************************************
         $remaining_penalty = $penalty_total-$penalty_payments_total;


         // OTHER CALCULATIONS END LINE ============================================



        // check if co borrower email is the same with user logged in
        // COMMENT OUT FOR TESTING
        if(strtolower($request->email_co_borrower) == Auth::user()->email )
        {
            return back()->with('email_error', 'You cannot enter your own email');
        }

        // check if co borrower is verified and is a member
        $co_borrower = User::where('email', strtolower($request->email_co_borrower))->with('member')->first();

        if(
            !$co_borrower->member->verified_at ||
            $co_borrower->user_type != 'member'
        ){
            return back()->with('email_error', 'Make sure that co-borrower email is a verified eBUPF member');
        }


                // Remove any middle initial
                $witness_1_temp = $formFields['witness_name_1'];
                $witness_2_temp = $formFields['witness_name_2'];

            $same_names = false;
            if( strtolower(str_replace(' ', '',$witness_1_temp)) == strtolower(str_replace(' ', '',$witness_2_temp))){
                $same_names = true;
            }
            if( strtolower(str_replace(' ', '',$witness_1_temp)) == strtolower(str_replace(' ', '',$co_borrower->member->firstname.$co_borrower->member->lastname))){

                $same_names = true;
            }

            if( strtolower(str_replace(' ', '',$witness_1_temp)) == strtolower(str_replace(' ', '',Auth::user()->member->firstname.Auth::user()->member->lastname))  ||
            strtolower(str_replace(' ', '',$witness_2_temp)) == strtolower(str_replace(' ', '',Auth::user()->member->firstname.Auth::user()->member->lastname))
            ){
                $same_names = true;
            }
            if($same_names){
                return redirect()->back()->withInput()->with('witness_error', 'witnesses, co-borrowers and the borrower (you) must not have the same name');
            }
        $adjustment = Adjustment::create([
            'mri'=>$mri,
            'previous_loan_balance'=>$previous_loan_balance,
            'housing_service_fee'=>$service_fee,
            'previous_penalty'=>$remaining_penalty,
        ]);

        $loan = Loan::create([
            // 'loan_code'=> 'temp_code',
            'member_id'=>Auth::user()->id,
            'loan_type_id'=>$loanTypeId,
            'principal_amount'=>$formFields['principal_amount'],
            'interest'=> $totalInterest,
            'original_principal_amount'=>$formFields['principal_amount'],
            'term_years'=>$formFields['term_years'],
            'adjustment_id'=>$adjustment['id'],

            'basic_salary'=>$formFields['basic_salary'],
            // 'payslip'=>$formFields['payslip'],
        ]);

        $parsedDate = Carbon::parse($loan->created_at);
        $parsedDate2 = Carbon::parse($loan->created_at);
        $start_date  = $parsedDate->addMonth();
            $months = $loan->term_years * 12;
            $newEndDate = $parsedDate2->addMonths($months);

            $amortization = Amortization::create([
                'amort_principal' => $loan->principal_amount/($loan->term_years*12),
                'amort_interest' => $loan->interest/($loan->term_years*12),
                'amort_start' => $start_date,
                'amort_end' => $newEndDate,

            ]);

        $loan->loan_code = $this->generateId($loanTypeId, $loan->id);
        $loan->amortization_id = $amortization->id;
        $loan->save();
        // create log
        $loan_type = LoanType::find($loanTypeId);
        LoanLog::create([
            'loan_id_log'=>$loan->id,
            'loan_code_log'=>$loan->loan_code,
            'loan_type_log'=>$loan_type->loan_type_name,
            // 'loan_category_log',
            'principal_amount_log'=>$loan->principal_amount,
            // 'interest_log',
            // 'is_active_log',
            'term_years_log'=>$loan->term_years,
            'create_update_or_delete'=>'create',
            'updated_by'=>Auth::user()->member->id,
        ]);

        CoBorrower::create([
            'member_id'=>$co_borrower->member->id,
            'loan_id'=>$loan->id,
        ]);

        if($formFields['witness_name_1'] != ''){
            Witness::create([
                'witness_name'=>$formFields['witness_name_1'],
                'loan_id'=>$loan->id,
            ]);
        }
        if($formFields['witness_name_2'] != ''){
            Witness::create([
                'witness_name'=>$formFields['witness_name_2'],
                'loan_id'=>$loan->id,
            ]);
        }
        // check for additional loans
        $user = Auth::user();
        if($user->member->additional_loan > 0){
            $user->member->additional_loan = 0;
            $user->member->save();
        }

        if($request->hasFile('payslip')) {
            $formFields['payslip'] = $request->file('payslip')->store('payslip', 'public');

            $loan->payslip = $formFields['payslip'];
            $loan->save();
        }


        return view('member-views.mpl-application-form.confirmation');
    }


    public function cancelApplication($id){
        $co_borrower = CoBorrower::where('loan_id',$id)->with('loan')->first();

        // abort cancel if loan has status (submitted)
        $statuses_confirm = LoanApplicationStatus::where('loan_id',$co_borrower->loan->id)->get();
        if (count($statuses_confirm) != null) {
            abort(404);
        }

        if($co_borrower == null){
            abort(404);
        }else{
            // if($co_borrower->accept_request == 1){
            //     return back()->with('fail' ,'Cannot be cancelled: Loan is already accepted');
            // }
            // else{
                $loan = Loan::find($id);
                $loan->deleted_at = now();
                $loan->is_active = 2;
                $loan->save();

                // create log
                $loan_type = LoanType::find($loan->loan_type_id);
                LoanLog::create([
                    'loan_id_log'=>$loan->id,
                    'loan_code_log'=>$loan->loan_code,
                    'loan_type_log'=>$loan_type->loan_type_name,
                    // 'loan_category_log',
                    'principal_amount_log'=>$loan->principal_amount,
                    // 'interest_log',
                    'is_active_log'=>$loan->is_active,
                    'term_years_log'=>$loan->term_years,
                    'deleted_at_log'=>$loan->deleted_at,
                    'create_update_or_delete'=>'delete',
                    'updated_by'=>Auth::user()->member->id,
                ]);

                return back()->with('passed' ,'Loan Application Cancelled.');
            }
        // }


    }


    public function cancelSubmittedLoanApp(Request $request, $id){
        $loan = Loan::findOrFail($id);
        $loan->deleted_at = now();
        $loan->is_active = 2;
        $loan->reason_for_cancel = $request->reason_for_cancel;
        $loan->save();
        return back()->with('message', 'Loan Application Cancelled.');
    }

} // THIS IS THE LAST TAG
