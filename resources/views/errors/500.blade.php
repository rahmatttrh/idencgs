
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>404</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="{{asset('img/icon.ico')}}" type="image/x-icon"/>
	
	<!-- Fonts and icons -->
	<script src="{{asset('js/plugin/webfont/webfont.min.js')}}"></script>
	<script>
		WebFont.load({
			google: {"families":["Open+Sans:300,400,600,700"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"], urls: ['../assets/css/fonts.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/azzara.min.css')}}">
</head>
<body class="">

      <div class="container">
         <div class=" d-flex justify-content-center">
            <div class="card card-light border text-center mt-4" style="width: 570px">
               <div class="card-header">ERROR</div>
               <div class="card-body">
                  Screenshot halaman ini dan segera informasikan kepada tim IT/HRD, maaf atas kendala yang terjadi.
               </div>
               <div class="card-footer text-muted">
                  <small>{{Request::url()}}</small>
                  <small>{{$exception->getMessage() . ' line: ' . __LINE__}}</small>
               </div>
            </div>
            {{-- <h1>OKE</h1> --}}
         </div>
      </div>
	
	
	<script src="{{asset('js/core/bootstrap.min.js')}}"></script>
</body>
</html>