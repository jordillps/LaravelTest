@extends('layouts.admin')

@section('template_title')
    {{ $title->name ?? 'Show Title' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Title</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('titles.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Page Id:</strong>
                            {{ $title->page_id }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
