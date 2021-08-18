<!DOCTYPE html>
<html lang="en">
    @include('errors.layouts.head')
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Error-->
			<div class="d-flex flex-row-fluid flex-column bgi-size-cover bgi-position-center bgi-no-repeat p-10 p-sm-30" style="background-image: url({{asset('metronic/assets/media/error/bg1.jpg')}});">
				<!--begin::Content-->
				@yield('content')
				<!--end::Content-->
			</div>
			<!--end::Error-->
		</div>
		<!--end::Main-->
		@include('errors.layouts.js')
	</body>
	<!--end::Body-->
</html>