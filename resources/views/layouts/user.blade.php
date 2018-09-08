<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('include.head')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('public/js/jquery.ui.touch-punch.js') }}"></script>
    <script>
        var fadeDuration = 1000;
        var modalDisplayDuration = 1500;
        
        function closeAllModals()
        {
            $(".modal").css('display', 'none');
        }
        
        function displayLoadingModal(message)
        {
            closeAllModals();
            $("#loadingModal").css("display", "block");
            $("#loadingMessage").text(message);
        }
        
        function displaySuccessModal(message)
        {
            closeAllModals();
            $("#successMessageModal").css("display", "block");
            $("#successMessage").text(message);
            setTimeout(function() {
                $( "#successMessageModal" ).fadeOut(fadeDuration, function() {
                    // Animation complete.
                });
            }, modalDisplayDuration);
        }
        
        function displayErrorModal(message)
        {
            closeAllModals();
            $("#errorMessageModal").css("display", "block");
            $("#errorMessage").text(message);
            setTimeout(function() {
                $( "#errorMessageModal" ).fadeOut(fadeDuration, function() {
                    // Animation complete.
                });
            }, modalDisplayDuration);
        }
        
        $(document).ready(function() {
            $(".squareImage").height($(".squareImage").width());
            
            $( window ).resize(function() {
                $(".squareImage").height($(".squareImage").width());
            });
            
            $( "#searchKey" ).change(function() {
                var searchKey = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('user-changeSearchKey') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        searchKey: searchKey
                    },
                    success: function(response) {
                        // Do nothing...
                    }
                });
            });
            
            window.onclick = function(event) {
                if ((event.target == document.getElementById('successMessageModal'))
                    || (event.target == document.getElementById('errorMessageModal'))
                    || (event.target == document.getElementById('confirmationModal'))) {
                    closeAllModals();
                }
            }
            $(".close").click(function() {
                closeAllModals();
            });
            $("#cancelButton").click(function() {
                closeAllModals();
            });
            
            var numberOfSlides = 4;
            
            $('.slider-nav').slick({
                infinite: true,
                slidesToShow: numberOfSlides,
                slidesToScroll: numberOfSlides,
            });
            
            $(".reviewImageMain").height($(".reviewImageMain").width());
            
            @if (Session::has('success'))
                displaySuccessModal("{{ Session::get('success') }}");
            @elseif (Session::has('error'))
                displayErrorModal("{{ Session::get('error') }}");
            @endif
        });
    </script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="navbar navbar-expand-xl">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#items" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                        <span class="navbar-brand">{{ $data['title'] }}</span>
                    </div>
                    <div class="collapse navbar-collapse" id="items">
                        <ul class="nav navbar-nav" id="nav">
                            <li><a href="{{ route('user-browseListings') }}">Browse Listings<span class="sr-only"></span></a></li>
                            <li><a href="{{ route('user-savedListings') }}">Saved Listings</a></li>
                        </ul>
                        <ul class="nav navbar-nav">
                            <li>
                                <form method="post" action="{{ route('user-browseListings') }}" class="navbar-form navbar-left">
                                    {{ csrf_field() }}
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="searchKey" id="searchKey" 
                                               value=@if (Session::has('searchKey'))
                                                    "{{ Session::get('searchKey') }}"
                                               @endif>
                                        <div class="input-group-btn">
                                            <button class="btn btn-default" type="submit">
                                            <i class="glyphicon glyphicon-search"></i>
                                        </button>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">My Listings
                            <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('user-myListings') }}">View Listings</a></li>
                                    <li><a href="{{ route('user-connections') }}">Connections</a></li>
                                    <li><a href="{{ route('user-listingForm') }}">Create Listing</a></li>
                                </ul>
                            </li>
                            @if ((Auth::user()->type == "admin") || (Auth::user()->type == "demo-admin"))
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                        <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Admin<span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin-listingsPendingReview') }}">Listings Pending Review</a></li>
                                        <li><a href="{{ route('admin-requests') }}">Requests</a></li>
                                        <li><a href="{{ route('admin-ndasPendingReview') }}">NDAs Pending Review</a></li>
                                        <li><a href="{{ route('admin-manageWebsite') }}">Manage Website</a></li>
                                    </ul>
                                </li>
                            @endif
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <table>
                                        <tr>
                                            <td>
                                            @if (Auth::user()->profileImage)
                                                <div class="profileImage" style="background-image: url('{{ asset('public/img/Profile-Images/' . $user->profileImage) }}');"></div>
                                            @else
                                                <div class="profileImage" style="background-image: url('{{ asset('public/img/Profile-Images/Default-User-Profile-Image_White.png') }}');"></div>
                                            @endif
                                            </td>
                                            <td style="vertical-align: middle;">Account<span class="caret"></span></td>
                                        </tr>
                                    </table>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('user-profile') }}">Profile</a></li>
                                    <li><a href="{{ route('user-manageAccount') }}">Manage Account</a></li>
                                    <li>
                                        <a href="{{ route('user-logout') }}">
                                            <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        
        @yield('content')
        <div id="loadingModal" class="modal row">
            <!-- Modal content -->
            <div id="loadingModalContent" class="modal-content col-md-6 col-sm-8 col-xs-10">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4 col-xs-6 col-xs-offset-3">
                        <img src="{{ asset('public/img/Loading.gif') }}" style="width: 100%;"/>
                    </div>
                </div>
                <br />
                <div class="row" style="text-align: center;">
                    <div class="col-xs-12">
                        <b id="loadingMessage"></b>
                    </div>
                </div>
            </div>
        </div>
        <div id="successMessageModal" class="modal row">
            <!-- Modal content -->
            <div id="successModalContent" class="modal-content col-md-6 col-sm-8 col-xs-10">
                <span class="close">&times;</span>
                <div id="modalMessageSuccess">
                    <span class="glyphicon glyphicon-ok-sign"></span> <span id="successMessage"></span>
                </div>
            </div>
        </div>
        <div id="errorMessageModal" class="modal row">
            <!-- Modal content -->
            <div id="errorModalContent" class="modal-content col-md-6 col-sm-8 col-xs-10">
                <span class="close">&times;</span>
                <div id="modalMessageError">
                    <span class="glyphicon glyphicon-remove-sign"></span> <span id="errorMessage"></span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
