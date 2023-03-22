
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}  <a href="{{route('products.create')}}" type="button" style="float: right;" class="btn btn-warning active">Create</a>
        </h2>
       
    </x-slot>
    @section('content')
    <div class="content">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="list-group">
            <ul class="list-group px-2">
                <li class="list-group-item list-group-item-action active"> Product List </li>
                @foreach($products as $product)
                    
                    <li class="list-group-item list-group-item-action"> 
                        <img class="col-md-1" src="{{ asset('uploads/product/' . $product->image) }}">
                        <p>Product Name:- {{$product->name}}</p>
                        <p>Product Price:- {{$product->price}}</p>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('products.edit',$product->id) }}" class="btn btn-primary me-md-2" >Edit</a>
                        <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" href="{{route('products.destroy', $product->id)}}" class="btn btn-danger active" >Delete</button>
                            </div>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endsection

</x-app-layout>


