
@if(session('examSubmitted'))

<div class="alert alert-success mt-3 text-center">
{{session('examSubmitted')}} 
</div>


@endif