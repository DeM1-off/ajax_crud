
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Author</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('book.index') }}" title="Go back"> <i class="fas fa-backward "></i> </a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('attribute.store') }}" method="POST"  enctype="multipart/form-data" >
    @csrf
    <div class="form-group">



    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Books:</strong>
                <select name="book_id" id="book_id" style="width: 100%">

                    @foreach($books as $book)
                        <option value="{{$book->book_id}}">{{$book->name}}</option>
                    @endforeach
                </select>

            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Authors:</strong>
                <select name="author_id" id="author_id" style="width: 100%">
                    @foreach($autours as $autour)
                        <option value="{{$autour->author_id}}">{{$autour->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>

</form>
