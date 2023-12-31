<div class="modal fade" id="editLoanModal{{$loan->id}}" tabindex="-1" aria-labelledby="editLoanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header border-0">
          <h1 class="modal-title fs-5 fw-bold" id="editLoanModalLabel">Edit Loan</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            
          @include('admin-views.admin-loan-applications.div-identifier')
      
            <div class="row border bg-light rounded mx-1 p-2 mb-2">
                <p class="m-0" style="font-size: 12px">Any changes will be seen by the member (borrower)</p>
                <p class="m-0 pt-2 ">Php {{$loan->original_principal_amount}}</p>
                <p class="m-0" style="font-size: 12px">Original amount requested</p>
            </div>
        <form action="{{route('update.loan', $loan->id)}}" method="POST">
            @csrf

            <label for="principal_amount">Principal Amount</label>
            <input class="form-control" type="number" name="principal_amount" id="principal_amount" value="{{$loan->principal_amount}}">

            <label for="interest">Interest</label>
            <input class="form-control" type="number" name="interest" id="interest" value="{{$loan->interest}}">
            
            <label for="term_years">Loan Term</label>
            <input class="form-control" type="number" name="term_years" id="term_years" value="{{$loan->term_years}}">
            
            <label for="loan_category">Loan Type</label>
            <select id="loan_category" class="form-select form-control" aria-label="Default select example" name='loan_category'>
              <option value="" {{$loan->loan_category_id == null? 'selected' : ''}}>None</option>
              @foreach ($loan_categories as $loan_category)
                  <option value="{{$loan_category->id}}" {{$loan->loan_category_id == $loan_category->id? 'selected' : ''}}>{{$loan->loan_category_id == $loan_category->id? '✔️' : ''}}{{$loan_category->loan_category_name}}</option>
              @endforeach
            </select>
            {{-- @if ($loan->amortization == null)
              <label class="pt-3"  for="term_years">Start of Amortization</label>
              <h6 style="font-size: x-small">To add 'interest' start of amortization is requried</h6>
              <input class="form-control" type="date" name="amort_start" id="amort_start" value="">    
            @endif --}}
            
            
            {{-- placeholder="current term: {{$loan->term_years}} year(s)" --}}
         
             
        </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn bu-orange text-light">Save changes</button>
            </div>
        </form>
      </div>
    </div>
</div>