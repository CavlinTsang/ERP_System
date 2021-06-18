@extends('layout')
@section('content')
<h1>Edit Purchase Request</h1>
</br>
{!! Form::open(['action' => ['PurchaseRequestController@update', $purchaseRequest], 'method' => 'PUT','files'=>true])!!}
    <div class="row">
        <div class="col-4 text-right">{{ Form::label('requestID', 'Request ID') }}</div>
        <div class="col-4">{{ Form::text('requestID', $purchaseRequest->requestID, array('class' => 'form-control','readonly')) }}</div>
    </div>
    <div class="row">
        <div class="col-4 text-right">{{ Form::label('branchID', 'Branch ID') }}</div>
        <div class="col-4">{{ Form::text('branchID', $purchaseRequest->branchID, array('class' => 'form-control','readonly')) }}</div>
    </div>
    <div class="row">
        <div class="col-4 text-right">{{ Form::label('createdDate', 'Created Date') }}</div>
        <div class="col-4">{{ Form::date('createdDate', $purchaseRequest->createdDate, array('class' => 'form-control','readonly')) }}</div>
    </div>
    <div class="row">
        <div class="col-4 text-right">{{ Form::label('expectedDeliveryDate', 'Expected Delivery Date') }}</div>
        <div class="col-4">{{ Form::date('expectedDeliveryDate', $purchaseRequest->expectedDeliveryDate, array('class' => 'form-control')) }}</div>
    </div>
    <div class="row">
        <div class="col-4 text-right">{{ Form::label('remarks', 'Remarks') }}</div>
        <div class="col-4">{{ Form::text('remarks', $purchaseRequest->remarks, array('class' => 'form-control')) }}</div>
    </div>
    
    <!--Search Function Start -->
    
    <div class="card-body">
        <div class="card-header">
            <span>Search</span>
        </div>
        <div class="form-group pull-left">
            <input type="text" class="search form-control" placeholder="Search here..." >
        </div>
        <div style="height: 300px;overflow:scroll;">
            <table class="table table-hover table-bordered results" id="myTable">
                <thead class="thead-light"  >
                    <tr>
                        <th>Virtual Item ID</th>
                        <th>Item Name</th>
                    </tr>
                    <tr class="warning no-result">
                        <td colspan="4"><i class="fa fa-warning"></i>No result</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach(App\Http\Controllers\PurchaseRequestController::searchTable() as $key=>$value)
                        <tr>
                            <td>{{$value->virtualItemID}}</td>
                            <td>{{$value->name}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
        
    <!--Search Function End-->
    
    </br>
    <div class="card">
        <div class="card-header ">
            <span>Purchase Request Item</span>
        </div>
        <div class="card-body">
            <table class="table" id="items_table">
                <thead class="thead-light">
                    <tr>
                        <th>Delete</th>
                        <th>Item Name</th>
                        <th>Required Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="item0">
                        <td><button id="btn-delete_row" class="btn btn-outline-danger delete_row" style="font-size:15x;" onclick=""><i class="fas fa-times" ></i></button></td>
                        <td>{{ Form::select('virtualItemID[]', $virtualItemID,null, array('class' => 'form-control')) }}</td>
                        <td><input type="number" name="requiredQuantity[]" class="form-control" step="10" min="0"/></td>
                    </tr>
                    <tr id="item1"></tr>
                </tbody>
            </table>
            <span>
                <button id="add_row" class="btn pull-left btn-primary"><i class="fas fa-plus"></i></button>
                <button id='delete_row' class="btn pull-right btn-secondary"><i class="fas fa-minus"></i></button>
            </span>
        </div>
    </div>
    </br>
    <div class="row">
        <div class="col-4"></div>
        <div class="col-8 text-right">
            {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
        </div>
        <div class="col-4"></div>
    </div>
{{ Form::close() }}

<hr>

     <div class="card-body">
         <div class="card-header">
            <span>Recent Item Usage</span>
        </div>

        <div style="height: 300px;overflow:scroll;">
            <table class="table table-striped table-bordered table-hover results" id="items_table"  >
                <thead class="thead-light"  >
                    <tr>
                        <th>Virtual ID</th>
                        <th>Item Name</th>
                        <th>Unit Of Measurement</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(App\Http\Controllers\PurchaseRequestController::getRecentItem() as $key)
                        <tr>
                            <td>{{$key->virtualItemID}}</td>
                            <td>{{$key->name}}</td>
                            <td>{{$key->unitOfMeasurement}}</td>
                            <td>{{$key->description}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

        <script>

 
$(".search").keyup(function () {
    var searchTerm = $(".search").val();
    var listItem = $('.results tbody').children('tr');
    var searchSplit = searchTerm.replace(/ /g, "'):containsi('")
    
  $.extend($.expr[':'], {'containsi': function(elem, i, match, array){
        return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
    }
  });
    
  $(".results tbody tr").not(":containsi('" + searchSplit + "')").each(function(e){
    $(this).attr('visible','false');
  });

  $(".results tbody tr:containsi('" + searchSplit + "')").each(function(e){
    $(this).attr('visible','true');
  });

  var jobCount = $('.results tbody tr[visible="true"]').length;
    $('.counter').text(jobCount + ' item');

  if(jobCount == '0') {$('.no-result').show();}
    else {$('.no-result').hide();}
		  });
</script>
@endsection