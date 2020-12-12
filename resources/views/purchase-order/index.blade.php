
<br>
<a href="{{ url('create-new') }}"><small><i class="fas fa-plus"></i> Create-new </small></a>
<table class="table table-striped   table-bordered">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">PO Number</th>
        <th scope="col">Date</th>
        <th scope="col">Price</th>
        <th scope="col">Cost</th>
        <th scope="col">Action</th>

      </tr>
    </thead>
    <tbody id="show-data">
      {{--  <tr id="show-data"></tr>  --}}
    </tbody>
</table>

<script>
  var url_get_po = "{{ url('/api/get-po') }}";

  $.ajax({  
      type: "GET",
      url: url_get_po,       
      success: function (responses) {
        var body = '';
        if(responses.data_header.length > 0){
          $.each(responses.data_header, function(index, value) {
            var urledit = "{{ url('update') }}/"+value.id;
            body += '<tr><td>'+(index+1)+'</td>'
                    +'<td>'+value.po_number+'</td>'
                    +'<td>'+value.po_date+'</td>'
                    +'<td>'+value.po_price_total+'</td>'
                    +'<td>'+value.po_cost_total+'</td>'
                    +'<td><a href="'+urledit+'"> Edit</a></td>'
                    +'</tr>'
          });
          $('#show-data').html(body)
        }

      }
  });
</script>