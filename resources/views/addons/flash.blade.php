
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