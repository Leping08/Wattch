@if(Session::has('success'))
    <div>
        <flash status="success" message="{{ Session::get('success') }}"></flash>
    </div>
@endif

@if(Session::has('error'))
    <div>
        <flash status="error" message="{{ Session::get('error') }}"></flash>
    </div>
@endif

@if(Session::has('warning'))
    <div>
        <flash status="warning" message="{{ Session::get('warning') }}"></flash>
    </div>
@endif

@if(Session::has('info'))
    <div>
        <flash status="info" message="{{ Session::get('info') }}"></flash>
    </div>
@endif