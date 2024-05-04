        <!-- JAVASCRIPT -->
        <script src="{{ URL::asset('assets/libs/jquery/jquery.min.js')}}"></script>
        {{-- <script src="{{ URL::asset('assets/libs/bootstrap/js/bootstrap.min.js')}}"></script> --}}
        
        <script src="{{ URL::asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/metismenu/metismenu.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/node-waves/waves.min.js')}}"></script>
        <script src="{{ URL::asset('admin/js/admin.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/parsleyjs/parsley.min.js')}}"></script>
        @yield('script')

        <!-- App js -->
        <script src="{{ URL::asset('assets/js/app.js')}}"></script>
        
        @yield('script-bottom')