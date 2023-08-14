<x-layouts.app>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
        <h5 class="my-0 mr-md-auto font-weight-normal">Post</h5>
        <nav class="my-2 my-md-0 mr-md-3">
        </nav>
        <a href="javascript:void(0)" data-id="" class="btn btn-outline-primary openaddmodal">Add post</a>
    </div>
    <div class="container">
        <table id="datatable" class="table table-hover datatable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">image</th>
                    <th scope="col">name</th>
                    <th scope="col">message</th>
                    <th scope="col">status</th>
                    <th scope="col">action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->image }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->message }}</td>
                        <td>{{ $item->status }}</td>
                        <td>

                            <form action="{{ route('page') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <button type="submit"><i class="fab fa-facebook-square"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade add_modal" id="exampleModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body addbody">
                </div>
            </div>
        </div>
    </div>
    @push('script')
    @endpush

</x-layouts.app>
