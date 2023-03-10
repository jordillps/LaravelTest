@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
@endpush

<div class="box box-info padding-1">
  <div class="box-body">
      <div class="form-group">
          {{ Form::label('title') }}
          {{ Form::text('title:'.app()->getLocale(), $post->{'title:'. app()->getLocale()}, ['class' => 'form-control' . ($errors->has('title:'.app()->getLocale()) ? ' is-invalid' : ''), 'placeholder' => 'Title']) }}
          {!! $errors->first('title:'.app()->getLocale(), '<div class="invalid-feedback">:message</div>') !!}
      </div>
      <div class="form-group">
          {{ Form::label('excerpt') }}
          {{ Form::text('excerpt:'.app()->getLocale(), $post->{'excerpt:'. app()->getLocale()}, ['class' => 'form-control' . ($errors->has('excerpt:'.app()->getLocale()) ? ' is-invalid' : ''), 'placeholder' => 'Excerpt']) }}
          {!! $errors->first('excerpt:'.app()->getLocale(), '<div class="invalid-feedback">:message</div>') !!}
      </div>
      <div class="form-group">
          {{ Form::label('iframe') }}
          {{ Form::text('iframe:'.app()->getLocale(), $post->{'iframe:'. app()->getLocale()}, ['class' => 'form-control' . ($errors->has('iframe:'.app()->getLocale()) ? ' is-invalid' : ''), 'placeholder' => 'Iframe']) }}
          {!! $errors->first('iframe:'.app()->getLocale(), '<div class="invalid-feedback">:message</div>') !!}
      </div>
      <div class="form-group">
          {{ Form::label('body') }}
          {{ Form::textarea('body:'.app()->getLocale(), $post->{'body:'. app()->getLocale()}, ['id'=> "summernote",'class' => 'form-control' . ($errors->has('body:'.app()->getLocale()) ? ' is-invalid' : ''), 'placeholder' => 'Body']) }}
          {!! $errors->first('body:'.app()->getLocale(), '<div class="invalid-feedback">:message</div>') !!}
      </div>
      <div class="row">
        <div class="col-12 col-md-4">
          <div class="form-group">
            {{ Form::label('published_at') }}
            {{ Form::date('published_at', $post->published_at, ['class' => 'form-control' . ($errors->has('published_at') ? ' is-invalid' : ''), 'placeholder' => 'Published At']) }}
            {!! $errors->first('published_at', '<div class="invalid-feedback">:message</div>') !!}
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group">
              {{ Form::label('user') }}
              @if(Route::is('posts.create'))
                  {!! Form::select('user_id', $users, null, ['class' => 'form-control' . ($errors->has('user_id') ? ' is-invalid' : '')]) !!}
              @else
                  {!! Form::select('user_id', $users, $post->user_id, ['class' => 'form-control' . ($errors->has('user_id') ? ' is-invalid' : '')]) !!}
              @endif
              {!! $errors->first('user_id', '<div class="invalid-feedback">:message</div>') !!}
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group">
              {{ Form::label('category') }}
              @if(Route::is('posts.create'))
                  {!! Form::select('category_id', $categories, null, ['class' => 'form-control' . ($errors->has('category_id') ? ' is-invalid' : '')]) !!}
              @else
                  {!! Form::select('category_id', $categories, $post->category_id, ['class' => 'form-control' . ($errors->has('category_id') ? ' is-invalid' : '')]) !!}
              @endif
              {!! $errors->first('category_id', '<div class="invalid-feedback">:message</div>') !!}
          </div>
        </div>
      </div>
      <div class="form-group">
          <label for="document">Documents</label>
          <div class="needsclick dropzone" id="document-dropzone">
          </div>
      </div>
  </div>
  <div class="box-footer mt20">
      <button type="submit" class="btn btn-primary">Submit</button>
  </div>
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script>
        var uploadedDocumentMap = {}
        Dropzone.options.documentDropzone = {
          url: '{{ route('posts.storeMedia') }}',
          maxFilesize: 2, // MB
          addRemoveLinks: true,
          headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          dictDefaultMessage : 'Arrastrar para subir las fotograf??as',
          success: function (file, response) {
            console.log(response);
            $('form').append('<input type="hidden" name="images[]" value="' + response.name + '">')
            uploadedDocumentMap[file.name] = response.name
          },
          removedfile: function (file) {
            console.log(file);
            file.previewElement.remove()
            var name = ''
            if (typeof file.file_name !== 'undefined') {
              name = file.file_name
            } else {
              name = uploadedDocumentMap[file.name]
            }
            $('form').find('input[name="images[]"][value="' + name + '"]').remove()
          },
          init: function () {
            @if(isset($post) && $post->images)
              var files ={!! json_encode($post->images) !!}
                console.log(files);
              for (var i in files) {
                var file = files[i]
                console.log(file);
                this.options.addedfile.call(this, file)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="images[]" value="' + file.file_name + '">')
              }
            @endif
          }
        }
      </script>
@endpush