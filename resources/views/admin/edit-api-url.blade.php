<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Blog Admin Panel Edit API URL</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

</head>

<body>

<div class="container mt-5">
    <h2>Edit API URL Setting #{{$data->id}}</h2>
    <form id="edit-setting" method="POST" action="{{ url('admin/edit') }}">
      @csrf

      <input type="hidden" name="id" class="form-control" value="{{ $data->id }}" id="formGroupExampleInput">

      <div class="form-group">
        <label for="formGroupExampleInput">User</label>
        <input class="form-control" disabled value="{{ $data->user->name }}">
      </div>

      <div class="form-group">
        <label for="message">API URL</label>
        <input type="text" name="api_url" class="form-control" id="formGroupExampleInput" placeholder="Please enter API URL" value="{{ $data->api_url }}">
        <span class="text-danger">{{ $errors->first('api_url') }}</span>
      </div>

      <div class="form-group">
        <label for="message">Execute Duration (min)</label>
        <input type="number" name="execute_duration_min" class="form-control" id="formGroupExampleInput" placeholder="Please enter execute duration in minutes" value="{{ $data->execute_duration_min }}">
        <span class="text-danger">{{ $errors->first('execute_duration_min') }}</span>
      </div>

      <div class="form-group">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="active" id="inlineRadio1" value="1" {{$data->active==1 ? 'checked':''}}>
            <label class="form-check-label" for="inlineRadio1">Active</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="active" id="inlineRadio2" value="0" {{$data->active==0 ? 'checked':''}}>
            <label class="form-check-label" for="inlineRadio2">Inactive</label>
        </div>
        <span class="text-danger">{{ $errors->first('active') }}</span>
      </div>

      <div class="form-group">
        <a href="{{url('admin')}}" class="btn btn-default">Cancel</a>
        <button type="submit" class="btn btn-success" id="btn-send">Submit</button>
      </div>
    </form>

</div>
</body>
</html>
