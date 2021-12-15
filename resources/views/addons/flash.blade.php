
@if(session('examSubmitted'))

<div class="alert alert-success mt-3 text-center">
{{session('examSubmitted')}} 
</div>


@endif



@if(session('hasTakenExam'))

<div class="alert alert-danger mt-3 text-center">
{{session('hasTakenExam')}} 
</div>


@endif

@if(session('registeredForExam'))

<div class="alert alert-success mt-3 text-center">
{{session('registeredForExam')}} 
</div>

@endif

@if(session('alreadyRegisteredForExam'))

<div class="alert alert-danger mt-3 text-center">
{{session('alreadyRegisteredForExam')}} 
</div>

@endif

@if(session('registerFirst'))

<div class="alert alert-danger mt-3 text-center">
{{session('registerFirst')}} 
</div>

@endif