@extends('layouts.guest')
@section('content')
    <div id="topSection" class="row">
        <span><h1>PIPELINE</h1> <!-- Name of the project -->
    <h2>Deals Made Simple</h2> <!-- Selling line -->
    <h4>Bringing People, Projects, Resources and Capital Together</h4>
    <section id="downButtonSection" class="demo"><!-- Arrow that takes you to the next section (How It Works) -->
        <a href="#howItWorksSection"><span></span></a>
        </section>
        </span>
    </div>
    <div id="howItWorksSection" class="allTextSections textSectionsWithDarkBackground row">
        <!-- Label for the section -->
        <div class="col-lg-4 col-md-6 col-sm-6 fadeIn fadeEnterLeft">
            <img src="{{ asset($data['index_rowOne_image']) }}" style="width:100%;"/>
        </div>
        <div class="col-lg-8 col-md-6 col-sm-6 fadeIn fadeEnterLeft">
            <h3>
                {{ $data['index_rowOne_header'] }}
            </h3>
            {!! $data['index_rowOne_body'] !!}
        </div>
    </div>
    <div id="aboutSection" class="allTextSections textSectionWithLightBackground row">
        <!-- Label for the section -->
        <div class="col-lg-8 col-md-6 col-sm-6 fadeIn fadeEnterRight">
            <h3>
                {{ $data['index_rowTwo_header'] }}
            </h3>
            {!! $data['index_rowTwo_body'] !!}
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 fadeIn fadeEnterRight">
            <img src="{{ asset($data['index_rowTwo_image']) }}" style="width:100%;" />
        </div>
    </div>
    
    <script>
        function fadeInEffectIfValid() {
            $('.fadeIn').each( function(i){

                var bottom_of_object = $(this).offset().top + ($(this).outerHeight() / 4);
                var bottom_of_window = $(window).scrollTop() + $(window).height();

                /* If the object is completely visible in the window, fade it it */
                
                if (bottom_of_window > bottom_of_object)
                {
                    if ($(this).hasClass("fadeEnterLeft"))
                    {
                        $(this).animate({
                            'opacity':'1',
                            left: "5px"
                        }, 500);
                    }
                    else
                    {
                        $(this).animate({
                            'opacity':'1',
                            left: "-5px"
                        }, 500);
                    }
                }
            }); 
        }
        $(document).ready(function () {
            fadeInEffectIfValid();
            $(window).scroll(function() {
                fadeInEffectIfValid();
            });
        });
    </script>
@endsection