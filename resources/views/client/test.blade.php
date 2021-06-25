<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shopify Demo Test</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<div id="content" class="main-content ">
<div class="layout-px-spacing">
  <div class="row layout-top-spacing">
    <div class="col-lg-12 col-12 layout-spacing">
      <h2>Import Product Data 250 Records</h2>
      <div class="col-md-12">
        <button type="button" class="btn btn-primary" id="import-btnid">Import Product Data 250 Records</button>
        <div class="spinner-border text-primary" role="status" id="loaderid" style="display: none;"> <span class="sr-only">Loading...</span> </div>
      </div>
    </div>
  </div>
</div>
<br>
@if(count($productData)==0)
<div class="alert alert-success" role="alert"> No Data Available </div>
@else
<table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">Shopify Id</th>
      <th scope="col">Product Title</th>
    </tr>
  </thead>
  <tbody>
  
  @foreach($productData as $row)
  <tr>
    <th scope="row">{{ $row->shopify_product_id }}</th>
    <td>{{ $row->title }}</td>
  </tr>
  @endforeach
    </tbody>
 </table>
@endif 
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script> 
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> 
<script type="text/javascript">

  $('body').on('click', '#import-btnid', function(e) {
      $('#loaderid').show();

          $.ajax({
                    url: "{{ env('APP_API_URL') }}get-product-list",
                    data: {
                        _token: '{{ csrf_token() }}',
                        testonly: 1,
                    },
                    type: 'post',
                    dataType: 'json',
                    success: function(data) {
                      $('#loaderid').hide();
                        alert(data.msg);
                    },
                    error: function() {
                      $('#loaderid').hide();
                        alert('Something Went Wrong!');
                    }
          });
  });
</script> 
</script>
</body>
</html>