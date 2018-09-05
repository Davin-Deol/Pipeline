<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('include.head')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('public/js/jquery.ui.touch-punch.js') }}"></script>
    <script>
        
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
            $("#successOrErrorMessageModal").css("display", "block");
            $("#successOrErrorMessageModalContent").css('background-color', '#aaffaa');
            $("#modalMessageSuccess").text(message);
            $("#modalMessageError").text("");
        }
        
        function displayErrorModal(message)
        {
            closeAllModals();
            $("#successOrErrorMessageModal").css("display", "block");
            $("#successOrErrorMessageModalContent").css('background-color', '#ffaaaa');
            $("#modalMessageError").text(message);
            $("#modalMessageSuccess").text("");
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
            
            if ($("#modalMessageError").text().trim().length > 0) {
                $("#successOrErrorMessageModal").css('display', 'inline');
                $("#successOrErrorMessageModalContent").css('background-color', '#ffaaaa');
            } else if ($("#modalMessageSuccess").text().trim().length > 0) {
                $("#successOrErrorMessageModal").css('display', 'inline');
                $("#successOrErrorMessageModalContent").css('background-color', '#aaffaa');
            }
            
            window.onclick = function(event) {
                if ((event.target == document.getElementById('successOrErrorMessageModal'))
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
                        <ul class="nav navbar-nav mr-auto" id="nav">
                            <li><a href="{{ route('user-browseListings') }}">Browse Listings<span class="sr-only"></span></a></li>
                            <li><a href="{{ route('user-savedListings') }}">Saved Listings</a></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">My Listings
                            <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('user-myListings') }}">View Listings</a></li>
                                    <li><a href="{{ route('user-connections') }}">Connections</a></li>
                                    <li><a href="{{ route('user-createListing') }}">Create Listing</a></li>
                                </ul>
                            </li>
                        @if (($user->type == "admin") || ($user->type == "demo-admin"))
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
                                            @if ($user->profileImage)
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
        <div id="successOrErrorMessageModal" class="modal row">
            <!-- Modal content -->
            <div id="successOrErrorMessageModalContent" class="modal-content col-md-6 col-sm-8 col-xs-10">
                <span class="close">&times;</span>
                <span id="modalMessageSuccess">
                    @if (Session::has('success'))
                        {{ Session::get('success') }}
                        {{ Session::forget('success') }}
                    @endif
                </span>
                <span id="modalMessageError">
                    @if (Session::has('error'))
                        <ul>
                        @foreach (Session::get('error') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                        {{ Session::forget('error') }}
                    @endif
                </span>
            </div>
        </div>
    </div>
</body>

</html>
