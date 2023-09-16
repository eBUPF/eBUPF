@php
$array = [];
foreach ($loan->loan->LoanApplicationStatus as $status) {
    array_push($array, $status->loan_application_state_id);
}
// add ID of loan states of the loan for checking
@endphp
<div class="modal fade" id="statusModal{{$loan->loan->id}}" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h1 class=" fw-bold fs-5">Edit Status</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="row g-0 mx-3">
        <div class="col-12" >
          Loan ID 
          <span style="color: #0092D1;" class="fw-bold fs-4"> {{$loan->loan->id}}</span>
        </div>
        <div class="col-12 mb-3">
          <div class="row  g-0">
            <div class="col-6">
              <h6 class="fw-bold">
                {{$loan->loan->member->firstname}}
                {{$loan->loan->member->lastname}}
              </h6>
              BU{{$loan->loan->member->units->unit_code}} <br>
              {{ date("F j, Y, g:i A", strtotime($loan->loan->created_at))}}
            </div>
            <div class="col-6 ">
              Php {{number_format($loan->loan->principal_amount, 2, '.',',')}}
            </div>
          </div>
        </div>
        @if (in_array(6, $array)) 
        {{-- if loan is denied --}}
           <i>This loan is denied. Delete the declined status to add other status.</i>
        @elseif(in_array(3, $array) || in_array(4, $array) || in_array(5, $array)) 
         {{-- check if loan is approced then disable those selected and "Denied " loans--}}
           <i>This loan is approved. Delete the "approved by executive director" status to enable 'decline' status.</i>
        @endif
      </div>
      <div class="accordion accordion-flush mx-3 mt-3 border-bottom" id="accordionFlushExample">
      
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed p-1" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
              See status...
            </button>
          </h2>
          <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample" style="">
              <div class="row border g-0 p-2">
                {{-- this sorts from largest id to smallest --}}
                @foreach ($loan->loan->LoanApplicationStatus->sort(function($a, $b) {
                  return $b->LoanApplicationState->id <=> $a->LoanApplicationState->id;
                    }) as $status)
                        <div class="col-12 d-flex gap-1 mb-2">
                            <a class="btn border text-danger grow-on-hover" href="{{route('delete.status', $status->id)}}" onclick="return confirm('Are you sure you want to delete this item?')"><i class="bi bi-trash-fill"></i></a>
                            <p class="ps-1 border w-100 h-100 rounded d-flex align-items-center">
                                {{$status->LoanApplicationState->id}}    {{$status->LoanApplicationState->state_name}}
                            </p>
                        </div>
                @endforeach
              </div>
          </div>
        </div>
      </div>
  
      <div class="modal-body">
        <form method="POST" action="{{route('create.status',$loan->loan->id)}}" >
          @csrf
          <div class="mb-3">
            <label for="statusDropdown" class="col-form-label">Select Satatus</label>
            <select name="loan_application_state_id" id="statusDropdown" class="form-select form-control" required>
             <option value="" selected disabled>...</option>
             @if (in_array(6, $array)) 

             {{-- if loan is denied --}}
                 <option value="" disabled> This Loan is already been declined</option>
             @elseif(in_array(3, $array) || in_array(4, $array) || in_array(5, $array)) 
              {{-- check if loan is approved then disable those selected and "Denied " loans--}}
                  @foreach ($loan_app_states as $state)
                  <option value="{{$state->id}}" {{in_array($state->id, $array) || ($state->id == 6)? 'disabled' : ''}}>
                      {{$state->id}} . {!!in_array($state->id, $array)? '✔️' : ' '!!} {{$state->state_name}}  
                      
                  </option>    
                  @endforeach   
             @else
                  @foreach ($loan_app_states as $state)
                  <option value="{{$state->id}}" {{in_array($state->id, $array)? 'disabled' : ''}}>
                      {{$state->id}} . {!!in_array($state->id, $array)? '✔️' : ' '!!} {{$state->state_name}}  
                      
                  </option>    
                  @endforeach
             @endif
             
            </select>
          </div>
          <div class="mb-2">
            <label for="date_evaluated" class="col-form-label">Date</label>
            <input name="date_evaluated" type="date" class="form-control" id="date_evaluated">
          </div>
          
          <div class="mb-2">
            <label for="message-text" class="col-form-label">Remarks</label>
            <textarea name="remarks" class="form-control" id="message-text"></textarea>
          </div>
        
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn bu-orange text-light">Add Status</button>
          </div>
      </form>
    </div>
  </div>
</div>