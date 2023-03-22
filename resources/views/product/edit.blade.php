<x-app-layout>
    @section('content')
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Error!</strong> <br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form  action="{{ route('products.update',$product->id) }}" Method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input name="name" type="text" class="form-control" id="name" aria-describedby="namehelp" value="{{ $product->name }}">
                <div id="namehelp" class="form-text"></div>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input name="price" type="number" class="form-control" id="price" value="{{ $product->price }}">
            </div>
            <div class="mb-3" >
                <label for="image" class="form-label">Image</label>
                <img id ="image" src="{{ asset('uploads/product/' . $product->image) }}" class="rounded-circle" alt="example placeholder" style="width: 200px;">
                <div class="btn btn-primary btn-rounded" style="margin:10px"    >
                    <label class="form-label text-white m-1" for="customFile2" >Choose file
                    <input  name="image" type="file" class="form-control d-none" id="customFile2" accept=".jpg, .jpeg, .png" onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])"/></label>
                </div>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end" style = "margin: 15px">
                <button type="submit" class="btn btn-success active">Submit</button>
                <button type="button" class="btn btn-secondary active">cancel</button>
            <div>
        </form>
    @endsection
</x-app-layout>




