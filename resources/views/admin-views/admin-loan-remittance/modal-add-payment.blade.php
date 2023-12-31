<div class="modal fade" id="addPayment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold fs-6" id="exampleModalLabel" style="color: #0D3546;">Confirm Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
            <div class="mx-5 my-3">
                <div class="d-flex align-items-center justify-content-center fw-bold">
                    <i class="bi bi-question-circle fs-3"></i>
                </div>
                <div class="mt-2 mb-2 fs-6 text-justify">
                    Confirm payment for Loan ID <span id="loan_id_modal" class="fw-bold"></span> and OR Number <span id="or_number_modal" class="fw-bold"></span>, dated <span id="payment_date_modal" class="fw-bold"></span>?
                    <p class="text-danger fs-7 mt-3">
                       <span class="fw-bold">Note:</span> This action will send an email to the member.
                    </p>
                </div>
                <div class="fs-7 mt-4">
                    Monthly Amortization Details
                </div>
                <div class="row mt-2">
                    <div class="col-8 fs-7">
                        <i class="bi bi-currency-exchange"></i> Principal
                    </div>
                    <div class="col-4 fs-7">
                        Php <span id="principal_modal" class="fw-bold"></span>
                    </div>
                </div>
                <div class="row mt-2 border-bottom border-secondary pb-2">
                    <div class="col-8 fs-7">
                        <i class="bi bi-graph-up-arrow"></i> Interest
                    </div>
                    <div class="col-4 fs-7">
                        Php <span id="interest_modal" class="fw-bold"></span>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-8 fs-7">
                        Total
                    </div>
                    <div class="col-4 fs-7">
                        Php <span id="total_modal" class="fw-bold"></span>
                    </div>
                </div>
            </div>
          </form>
      </div>
      <div class="modal-footer mb-2">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn bu-orange text-light" id="addPaymentNow">Confirm</button>
      </div>
    </div>
  </div>
</div>
