<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <title>eBUPF</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/styles.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
</head>

<body class="p-0 m-0 border-0 overflow-x-hidden">



    <!-- AUTOMATICALLY CLOSE OFFCANVAS ON MEDIUM-UP SCREEN -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var offcanvasElement = document.getElementById('offcanvasWithBackdrop');
            var offcanvas = new bootstrap.Offcanvas(offcanvasElement);

            function closeOffcanvasOnLargeScreens() {
                if (offcanvasElement.classList.contains('show') && window.innerWidth >= 768) {
                    offcanvas.hide();
                }
            }

            window.addEventListener('resize', closeOffcanvasOnLargeScreens);
            offcanvasElement.addEventListener('hidden.bs.offcanvas', closeOffcanvasOnLargeScreens);
        });
    </script>
    <!-- AUTOMATICALLY CLOSE OFFCANVAS ON MEDIUM-UP SCREEN -->




    {{-- OFFCANVAS --}}
    <div class="row d-block d-md-none p-3 border-bottom" style="background-color: #ffffff;">
        <div class="nav">
            <div class="col">
                <button class="navbar-toggler ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop">
                    <img src="icons/bars.svg" alt="">
                  </button>

                <a href="#"><img class="img-fluid ps-2" src="assets/bu-provident.svg" alt="BU Provident" style="width: 11rem;"></a>
            </div>

            
        </div>
    </div>
    <div class="offcanvas offcanvas-start d-block d-md-none" tabindex="-1" id="offcanvasWithBackdrop" aria-labelledby="offcanvasWithBackdropLabel" style="width: 320px">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title text-secondary" id="offcanvasWithBackdropLabel">eBUPF</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav flex-column" style="margin-bottom: 0;">

                <li class="nav-items py-3 grow-on-hover ">
                    <div class="row g-0">
                        <div class="col-3 text-center ">
                            <img class="icon img-fluid" src="icons/profile-holder.png" alt="">
                        </div>
                        <div class="col  d-flex align-items-center">
                            <span class="fw-bold fs-7 text-secondary">Profile</span>
                        </div>
                    </div>
                </li>


                <li class="nav-item  py-3 grow-on-hover">
                    <div class="row g-0">
                        <div class="col-3 text-center ">
                            <img class="img-fluid" src="icons/home.svg" alt="">
                        </div>
                        <div class="col ">
                            <span class="fw-bold fs-7 text-secondary">Home</span>
                        </div>
                    </div>
                </li>

                <li class="nav-item  py-3 grow-on-hover">
                    <div class="row g-0">
                        <div class="col-3 text-center ">
                            <i class="ps-1 fa-sharp fa-solid fa-peso-sign fa-lg" style="color: #ff6767;"></i>
                        </div>
                        <div class="col ">
                            <span class="fw-bold fs-7  text-secondary">Loans</span>
                        </div>
                    </div>
                </li>

                <li class="nav-item  py-3 grow-on-hover">
                    <div class="row g-0">
                        <div class="col-3 text-center ">
                            <img class="mb-1 img-fluid" src="icons/calculator.svg" alt="">
                        </div>
                        <div class="col-9  ">
                            <span class=" fw-bold fs-7 text-secondary">Calculator</span>
                        </div>
                    </div>
                </li>


                <li class="nav-item  py-3 grow-on-hover">
                    <div class="row g-0">
                        <div class="col-3 text-center ">
                            <img class="mb-1 img-fluid" src="icons/receipt.svg" alt="">
                        </div>
                        <div class="col-9  ">
                            <span class="fw-bold fs-7  text-secondary">Transactions</span>
                        </div>
                    </div>
                </li>

                <li class="nav-item  py-3 grow-on-hover">
                    <div class="row g-0">
                        <div class="col-3 text-center ">
                            <img class="mb-1 img-fluid" src="icons/envelope.svg" alt="">
                        </div>
                        <div class="col-9  ">
                            <span class="fw-bold fs-7 text-secondary">Requests</span>
                        </div>
                    </div>
                </li>

            </ul>

        </div>
    </div>

    <div class="row">

        <!-- Placeholder to prevent overlapping -->
        <div class="d-none d-md-block" style="width: 20%;"> 
            <span class="placeholder"></span>
        </div>
        <!-- Placeholder to prevent overlapping -->

        <!-- NAVBAR -->
        <div class="   d-none  d-md-block  position-fixed h-100 " style="background-color: #ffffff; width: 20%;">
            <div class="row d-flex   py-3">
                <a href="#">
                    <img class="img-fluid ps-2 pt-2" src="assets/bu-provident.svg" alt="" style="width: 14rem;">
                </a>
            </div>


            <ul class="nav flex-column" style="margin-bottom: 0; scale: 0.9;" >

                <li class="nav-items py-3 grow-on-hover ">
                    <div class="row g-0">
                        <div class="col-3 text-center ">
                            <img class="icon" src="icons/profile-holder.png" alt="">
                        </div>
                        <div class="col  d-flex align-items-center">
                            <span class="fw-bold fs-7 text-secondary">Profile</span>
                        </div>
                    </div>
                </li>


                <li class="nav-item  py-3 grow-on-hover">
                    <div class="row g-0">
                        <div class="col-3 text-center ">
                            <img src="icons/home.svg" alt="">
                        </div>
                        <div class="col ">
                            <span class="fw-bold fs-7 text-secondary">Home</span>
                        </div>
                    </div>
                </li>

                <li class="nav-item  py-3 grow-on-hover">
                    <div class="row g-0">
                        <div class="col-3 text-center ">
                            <i class="ps-1 fa-sharp fa-solid fa-peso-sign fa-lg" style="color: #ff6767;"></i>
                        </div>
                        <div class="col ">
                            <span class="fw-bold fs-7  text-secondary">Loans</span>
                        </div>
                    </div>
                </li>

                <li class="nav-item  py-3 grow-on-hover">
                    <div class="row g-0">
                        <div class="col-3 text-center ">
                            <img class="mb-1 " src="icons/calculator.svg" alt="">
                        </div>
                        <div class="col-9  ">
                            <span class=" fw-bold fs-7 text-secondary">Calculator</span>
                        </div>
                    </div>
                </li>


                <li class="nav-item  py-3 grow-on-hover">
                    <div class="row g-0">
                        <div class="col-3 text-center ">
                            <img class="mb-1" src="icons/receipt.svg" alt="">
                        </div>
                        <div class="col-9  ">
                            <span class="fw-bold fs-7  text-secondary">Transactions</span>
                        </div>
                    </div>
                </li>

                <li class="nav-item  py-3 grow-on-hover">
                    <div class="row g-0">
                        <div class="col-3 text-center ">
                            <img class="mb-1" src="icons/envelope.svg" alt="">
                        </div>
                        <div class="col-9  ">
                            <span class="fw-bold fs-7 text-secondary">Requests</span>
                        </div>
                    </div>
                </li>

            </ul>

        </div>

        <!-- MAIN CONTENT GOES HERE -->
        <div class="col m-0 scrollable-content">
            @yield('content')
        </div> 

    </div>



</body>

</html>