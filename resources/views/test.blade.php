@extends('layouts.main')

@section('content')

<div class="container mt-3">

<div id="deadline" class="alert alert-warning"></div>
    <form action="{{ route('submitExam') }}" method="post">
        {{csrf_field()}}

        <input type="hidden" value="{{$subject_id}}" name="subject_id"/>

        @foreach($questions as $question)
        
        <fieldset class="mt-3" id="{{$question->id}}">
            <h4>{{$question->question}}</h4>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="{{$question->id}}" value="1" id="flexRadioDefault1">
            <label class="form-check-label" for="flexRadioDefault1">
                {{$question->answer1}}
            </label>
            </div>
            
            <div class="form-check">
            <input class="form-check-input" type="radio" name="{{$question->id}}" value="2" id="flexRadioDefault2" >
            <label class="form-check-label" for="flexRadioDefault2">
                {{$question->answer2}}
            </label>
            </div>
            
            <div class="form-check">
            <input class="form-check-input" type="radio" name="{{$question->id}}" value="3" id="flexRadioDefault2" >
            <label class="form-check-label" for="flexRadioDefault2">
                {{$question->answer3}}
            </label>
            </div>

            <div class="form-check">
            <input class="form-check-input" type="radio" name="{{$question->id}}" value="4" id="flexRadioDefault2" >
            <label class="form-check-label" for="flexRadioDefault2">
                {{$question->answer4}}
            </label>
            </div>
        </fieldset>
        @endforeach

        <button id="submitExam" class="btn btn-primary mt-3" type="submit">finish exam</button>

    </form>

</div>

<script>
    var duration = {{$duration}} * 60;
    var time = duration;
    var deadline = document.getElementById('deadline');
    setInterval(function () {
        var counter = time--, min=(counter/60)>>0,sec=(counter-min*60)+'';
        deadline.textContent='Exam closes in '+ min + ':'+(sec.length>1?'':'0')+sec
        // time!=0 || (time=duration);
        // timer.innerHTML = min;
        if(counter == 0 ){
            // submit exam automatically
            document.getElementById('submitExam').click();
        } 
    }, 1000);
</script>
    

@endsection