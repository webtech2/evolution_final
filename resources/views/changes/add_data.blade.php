@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h4>Additional data for change</h4></div>
                <div class="card-body">
                    <p class="card-text">Type: {{ $change->getChangeType()->tp_type }}</p>
                    <p class="card-text">Status: {{ $change->statusType->tp_type }}</p>
                    <p class="card-text">Change of {{ strtolower($object['objectType']) }}: 
                        <a href="{{ url(strtolower($object['objectType']), $object['object']->getID()) }}">{{ $object['objectName'] }}</a>
                    </p>
                    @if ($change->author)
                    <p class="card-text">Author: {{ $change->author->au_username }}</p>
                    @endif
                    <p class="card-text">Date: {{ $change->ch_datetime }}</p>
                    @if ($change->ch_attrname)
                    <p class="card-text">Changed attribute name: {{ $change->ch_attrname }}</p>
                    <p class="card-text">Value before update: {{ $change->ch_oldattrvalue }}</p>
                    <p class="card-text">Value after update: {{ $change->ch_newattrvalue }}</p>
                    @endif  

                    <form id="create" method="POST" enctype="multipart/form-data" 
                          action="{{ action('AdaptationController@storeAdditionalData') }}">
                        @csrf
                        <input type="hidden" value="{{ $change->ch_id}}" name="change">
                        <input type="hidden" value="{{ $object['object']->getID()}}" name="{{strtolower($object['objectType'])}}">

                        <div class="form-group row">
                            <label for="dtype" class="col-md-4 col-form-label text-md-right">Type of additional data</label>
   
                            <div class="col-md-6">
                                <select id="dtype" class="type-select form-control @error('type') is-invalid @enderror" 
                                        name="type" value="{{ old('type') }}" autocomplete="type" autofocus>
                                    @foreach ($dtypes as $type)
                                    <option value="{{ $type->tp_id }}" {{ (old('type') == $type->tp_id ? "selected":"") }}>{{ $type->tp_type}}</option>
                                    @endforeach
                                </select>

                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
<!------------------------------------------------------------------------------------------------------->
                        <fieldset id='CAD0000001'>
                        <div class="form-group row">
                            <label for="ds_name" class="col-md-4 col-form-label text-md-right">Dataset name</label>

                            <div class="col-md-6">
                                <input id="ds_name" type="text" class="form-control @error('ds_name') is-invalid @enderror" name="ds_name" value="{{ old('ds_name') }}" autocomplete="ds_name">

                                @error('ds_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ds_desc" class="col-md-4 col-form-label text-md-right">Description</label>

                            <div class="col-md-6">
                                <textarea id="ds_desc" rows="5" class="form-control @error('ds_desc') is-invalid @enderror" name="ds_desc" autocomplete="ds_desc">{{ old('ds_desc') }}</textarea>

                                @error('ds_desc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="velocity" class="col-md-4 col-form-label text-md-right">Velocity</label>
   
                            <div class="col-md-6">
                                <select id="velocity" class="form-control @error('velocity') is-invalid @enderror" name="velocity" value="{{ old('velocity') }}"  autocomplete="velocity" >
                                    @foreach ($velocities as $velocity)
                                    <option value="{{ $velocity->tp_id }}">{{ $velocity->tp_type}}</option>
                                    @endforeach
                                </select>

                                @error('velocity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="frequency" class="col-md-4 col-form-label text-md-right">Frequency</label>

                            <div class="col-md-6">
                                <textarea id="frequency" rows="5" class="form-control @error('frequency') is-invalid @enderror" name="frequency"  autocomplete="frequency">{{ old('frequency') }}</textarea>

                                @error('frequency')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">Data set type</label>
   
                            <div class="col-md-6">
                                <select id="type" class="type-select form-control @error('type') is-invalid @enderror" value="{{ old('type') }}"  autocomplete="type" autofocus>
                                    @foreach ($types as $type)
                                    <option value="{{ $type->tp_id }}" {{ (old('type') == $type->tp_id ? "selected":"") }}>{{ $type->tp_type}}</option>
                                    @endforeach
                                </select>

                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="format" class="col-md-4 col-form-label text-md-right">Format type</label>
   
                            <div class="col-md-6">
                                <select id="format" data-parent="type" class="sub-type-select form-control @error('format') is-invalid @enderror" name="format"  autocomplete="format">
                                    @foreach ($types as $type)
                                    @foreach ($type->subTypes as $stype)
                                    <option value="{{ $stype->tp_id}}" {{ (old('format') == $stype->tp_id ? "selected":"") }} class="@if (old('type', $types[0]->tp_id)!=$type->tp_id) d-none @endif" parent-type="{{ $type->tp_id }}">{{ $stype->tp_type}}</option>
                                    @endforeach
                                    @endforeach
                                </select>

                                @error('format')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>                        
                        <div class="form-group row">
                            <label for="file" class="col-md-4 col-form-label text-md-right">Data set example</label>

                            <div class="col-md-6">
                                <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" value="{{ old('file') }}" autocomplete="file">

                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="table_name" class="col-md-4 col-form-label text-md-right">Table name</label>

                            <div class="col-md-6">
                                <input id="table_name" type="text" class="form-control @error('table_name') is-invalid @enderror" name="table_name" value="{{ old('table_name') }}" autocomplete="table_name">

                                @error('table_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        </fieldset>
<!------------------------------------------------------------------------------------------------------->
                        <fieldset id='CAD0000007'>
                        <div class="form-group row">
                            <label for="source" class="col-md-4 col-form-label text-md-right">Alternative source</label>
   
                            <div class="col-md-6">
                                <select id="source" class="type-select form-control @error('source') is-invalid @enderror" 
                                        name="source" value="{{ old('source') }}" autocomplete="source" autofocus 
                                        >
                                    @foreach ($sources as $source)
                                    <option value="{{ $source->so_id }}" {{ (old('source') == $source->so_id ? "selected":"") }}>{{ $source->so_name}}</option>
                                    @endforeach
                                </select>

                                @error('source')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dataset" class="col-md-4 col-form-label text-md-right">Alternative data set</label>
   
                            <div class="col-md-6">
                                <select id="dataset" data-parent="source" class="type-select sub-type-select form-control @error('dataset') is-invalid @enderror" 
                                        name="dataset"  autocomplete="dataset" 
                                         >
                                    @foreach ($sources as $source)
                                    @foreach ($source->dataSets()->whereNull('ds_deleted')->orderBy('ds_name')->get() as $dataset)
                                    <option value="{{ $dataset->ds_id}}" {{ (old('dataset') == $dataset->ds_id ? "selected":"") }} class="@if (old('source', $sources[0]->so_id)!=$source->so_id) d-none @endif" parent-type="{{ $source->so_id }}">{{ $dataset->ds_name}}</option>
                                    @endforeach
                                    @endforeach
                                </select>

                                @error('dataset')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dataitem" class="col-md-4 col-form-label text-md-right">Data item</label>
   
                            <div class="col-md-6">
                                <select id="dataitem" data-parent="dataset" class="sub-type-select form-control @error('dataitem') is-invalid @enderror" 
                                        name="dataitem"  autocomplete="dataitem" 
                                        @isset($item) disabled @endisset>
                                    @foreach ($sources as $source)
                                    @foreach ($source->dataSets()->whereNull('ds_deleted')
                                        ->orderBy('ds_name')->get() as $dataset)
                                    @foreach ($dataset->dataItems()->whereNull('di_deleted')
                                        ->where('di_id','<>',$object['object']->getID())->orderBy('di_name')->get() as $dataitem)
                                    <option value="{{ $dataitem->di_id}}" {{ (old('dataitem') == $dataitem->di_id ? "selected":"") }} class="@if (old('dataitem', $sources[0]->dataSets[0]->ds_id)!=$dataset->ds_id) d-none @endif" parent-type="{{ $dataset->ds_id }}">{{ $dataitem->di_name}}</option>
                                    @endforeach
                                    @endforeach
                                    @endforeach
                                </select>

                                @error('dataitem')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        </fieldset>
<!------------------------------------------------------------------------------------------------------->
                        <fieldset id='CAD0000006'>
                        <div class="form-group row">
                            <label for="item" class="col-md-4 col-form-label text-md-right">Alternative source for a data item</label>
   
                            <div class="col-md-6">
                                <select id="item" class="type-select form-control @error('item') is-invalid @enderror" 
                                        name="item" value="{{ old('item') }}" autocomplete="item" autofocus 
                                        >                            
                                    @foreach ($change->dataSource->dataSets()->whereNull('ds_deleted')
                                        ->orderBy('ds_name')->get() as $dataset)
                                    @foreach ($dataset->dataItems()->whereNull('di_deleted')
                                        ->orderBy('di_name')->get() as $dataitem)
                                    <option value="{{ $dataitem->di_id}}" {{ (old('item') == $dataitem->di_id ? "selected":"") }}>
                                        {{ $dataset->ds_name}}.{{ $dataitem->di_name}}
                                    </option>
                                    @endforeach
                                    @endforeach
                                </select>

                                @error('item')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>                                    

                        <div class="form-group row">
                            <label for="operation" class="col-md-4 col-form-label text-md-right">Operation</label>

                            <div class="col-md-6">
                                <textarea id="operation" rows="5" class="form-control @error('operation') is-invalid @enderror" 
                                          name="operation" autocomplete="operation">{{ old('operation') }}</textarea>

                                @error('operation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sources" class="col-md-4 col-form-label text-md-right">Origin source</label>
   
                            <div class="col-md-6">
                                <select id="sources" class="type-select form-control" autocomplete="sources" autofocus >
                                    @foreach ($sources as $source)
                                    <option value="s{{ $source->so_id }}">{{ $source->so_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="origdataset" class="col-md-4 col-form-label text-md-right">Origin data set</label>
   
                            <div class="col-md-6">
                                <select id="origdataset" data-parent="sources" class="type-select sub-type-select form-control 
                                        autocomplete="origdataset">
                                    @foreach ($sources as $source)
                                    @foreach ($source->dataSets()->whereNull('ds_deleted')->orderBy('ds_name')->get() as $dataset)
                                    <option value="{{ $dataset->ds_id}}" class="@if (old('dhls', 's'.$sources[0]->so_id)!='s'.$source->so_id) d-none @endif" parent-type="s{{ $source->so_id }}">{{ $dataset->ds_name}}</option>
                                    @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="origdataitem" class="col-md-4 col-form-label text-md-right">Origin data item</label>
   
                            <div class="col-md-6">
                                <select id="origdataitem" data-parent="origdataset" class="sub-type-select form-control"
                                        autocomplete="origdataitem">
                                    @foreach ($sources as $source)
                                    @foreach ($source->dataSets()->whereNull('ds_deleted')->orderBy('ds_name')->get() as $dataset)
                                    @foreach ($dataset->dataItems()->whereNull('di_deleted')->orderBy('di_name')->get() as $dataitem)
                                    <option value="{{ $dataitem->di_id}}" class="@if (old('origdataitem', $sources[0]->dataSets[0]->ds_id)!=$dataset->ds_id) d-none @endif" parent-type="{{ $dataset->ds_id }}">{{ $dataitem->di_name}}</option>
                                    @endforeach
                                    @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button id="pastebtn" type="button" class="btn btn-secondary">
                                    Paste
                                </button>
                            </div>
                        </div>                        
                            
                        </fieldset>
<!------------------------------------------------------------------------------------------------------->
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Create
                                </button>
                            </div>
                        </div>                        

                    </form>                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function checkFormat () {
        if ($('#format option:selected').val() == 'FMT0000031') {
            $('#file').prop( "disabled", true );
            $('#table_name').prop( "disabled", false );
        } else {
            $('#file').prop( "disabled", false );
            $('#table_name').prop( "disabled", true );            
        }
    }
    
    checkFormat();
    
    $('#format').on('change', checkFormat);
    
    function checkType () {
        $('fieldset').hide();
        $('#'+$('#dtype option:selected').val()).show();            
    }
    
    checkType();
    
    $('#dtype').on('change', checkType);
    
    $('#pastebtn').on('click', function(event) {
        var cursorPosition = $('#operation').prop("selectionStart");
        var dataitem = '[?'+$("#dhls option:selected").text()+'.'+
                $("#origdataset option:selected").text()+'.'+
                $("#origdataitem option:selected").text()+'['+
                $("#origdataitem").val()+']?]';
        
        var v = $('#operation').val();
        var textBefore = v.substring(0,  cursorPosition);
        var textAfter  = v.substring(cursorPosition, v.length);

        $('#operation').val(textBefore + dataitem + textAfter);
    });    
</script>
@endsection
