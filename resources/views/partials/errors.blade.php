@if($errors->any())
    <div class="alert alert-danger">
        <ul class="list-group">
            @foreach($errors->all() as $errors)
                <li class="list-group-item">{{ $errors }}</li>
            @endforeach
        </ul>
    </div>
@endif
